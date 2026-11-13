"""Prepare independent item/page clips only when their content changes.

No live renderer or continuous encoder. Audio changes remux cached video.
Run in the separate, resource-limited preparation service.
"""
from pathlib import Path
from PIL import Image,ImageDraw,ImageFont,ImageOps
import hashlib,json,os,subprocess,time,math

STATE=Path(os.environ.get('STATE_DIRECTORY','/var/lib/mdr-tv-mvp'))
OUT=STATE/'clips';OUT.mkdir(exist_ok=True)
FONT='/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
BOLD='/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
Image.MAX_IMAGE_PIXELS=24000000

def atomic(path,data):
    tmp=path.with_suffix(path.suffix+'.tmp');tmp.write_bytes(data);tmp.chmod(0o600);tmp.replace(path)
def run(args):
    if sum(p.stat().st_size for p in OUT.iterdir() if p.is_file())>512*1024*1024:
        raise RuntimeError('Quota de derivados atingida; programação anterior preservada')
    r=subprocess.run(args,stdout=subprocess.DEVNULL,stderr=subprocess.PIPE,timeout=180)
    if r.returncode:raise RuntimeError('Preparação de mídia falhou: '+r.stderr.decode(errors='replace')[-180:])
def digest(data):return hashlib.sha256(json.dumps(data,sort_keys=True,ensure_ascii=False).encode()).hexdigest()
def wrap(text,font,width):
    draw=ImageDraw.Draw(Image.new('RGB',(1,1)));lines=[]
    for paragraph in text.split('\n'):
        current=''
        for word in paragraph.split():
            # Break very long URLs/tokens as well; never omit source words.
            parts=[];piece=''
            for char in word:
                if draw.textlength(piece+char,font=font)>width and piece:parts.append(piece);piece=char
                else:piece+=char
            if piece:parts.append(piece)
            for part in parts:
                s=current+(' ' if current else '')+part
                if draw.textlength(s,font=font)>width and current:lines.append(current);current=part
                else:current=s
        lines.append(current)
    return lines
def pages(item):
    title=item['title'];body=item['text'];head=wrap(title,ImageFont.truetype(BOLD,42),790)
    if len(head)>4:body=title+'\n\n'+body;head=['MDR em pauta']
    elif body.startswith(title):body=body[len(title):].lstrip()
    lines=wrap(body,ImageFont.truetype(FONT,31),790)
    per_page=max(7,math.floor((680-len(head)*54)/45))
    return head,[lines[i:i+per_page] for i in range(0,len(lines),per_page)] or [[]]
def frame(item,asset,head,lines,page,total,target):
    image=Image.new('RGB',(1920,1080),(20,39,59));d=ImageDraw.Draw(image)
    try:
        logo=Image.open('/opt/mdr-tv-mvp/public/assets/mdr-logo.png').convert('RGBA');logo.thumbnail((255,100));image.paste(logo,(65,35),logo)
    except OSError:pass
    d.text((410,70),'EM PAUTA · MDR ADVOCACIA',font=ImageFont.truetype(FONT,25),fill='#ddc58a')
    d.line((60,160,1860,160),fill='#526372',width=1)
    if asset and asset['mime'].startswith('image/'):
        with Image.open(STATE/'cache'/asset['hash']) as source:
            source=ImageOps.exif_transpose(source).convert('RGB');source.thumbnail((900,770))
            image.paste(source,(60+(900-source.width)//2,200+(770-source.height)//2))
    else:
        d.text((280,490),'MDR',font=ImageFont.truetype(BOLD,130),fill='#ddc58a')
    x=1025;y=210;d.text((x,y),item.get('source','Material MDR')[:65],font=ImageFont.truetype(FONT,22),fill='#ddc58a');y+=55
    for line in head:d.text((x,y),line,font=ImageFont.truetype(BOLD,42),fill='white');y+=54
    y+=28
    for line in lines:d.text((x,y),line,font=ImageFont.truetype(FONT,31),fill='#e1e8ee');y+=45
    d.text((x,990),item.get('credit','MDR Advocacia')[:55],font=ImageFont.truetype(FONT,20),fill='#b9c8d3')
    d.text((1730,990),str(page+1)+' / '+str(total),font=ImageFont.truetype(FONT,20),fill='#b9c8d3')
    image.save(target,'JPEG',quality=92)
def duration(path):
    r=subprocess.run(['ffprobe','-v','error','-show_entries','format=duration','-of','default=noprint_wrappers=1:nokey=1',str(path)],capture_output=True,text=True,timeout=10)
    return max(.1,float(r.stdout.strip()))
def prepare(program):
    clips=[];keep=set();offset=0;settings=program.get('settings',{});tracks=program.get('playlist',[])
    music=[(STATE/'cache'/a['hash']) for a in tracks] or [Path('/opt/mdr-tv-mvp/public/assets/ambiente-mdr.wav')]
    lengths=[duration(p) for p in music] if settings.get('music') else []
    ff=['ffmpeg','-nostdin','-hide_banner','-loglevel','error','-threads','1','-filter_threads','1','-y']
    for item in program['items']:
        if item.get('end') and item['end']<=time.time():continue
        assets=item.get('assets') or [None];head,text_pages=pages(item)
        for asset in assets:
            # Real video is handled by the HTML player until its normalization is tested.
            for n,lines in enumerate(text_pages):
                secs=item['seconds'];key=digest(['frame-v1',item['title'],head,lines,asset['hash'] if asset else '',secs,item.get('credit'),item.get('source')])
                base=OUT/(key+'-base.mp4')
                keep.add(base.name)
                if not base.exists():
                    jpg=OUT/(key+'.jpg');frame(item,asset,head,lines,n,len(text_pages),jpg)
                    tmp=OUT/(key+'-base.tmp.mp4')
                    run(ff+['-loop','1','-framerate','1','-i',str(jpg),'-t',str(secs),'-vf','format=yuv420p','-r','5','-c:v','libx264','-threads','1','-preset','veryfast','-tune','stillimage','-an','-movflags','+faststart',str(tmp)])
                    tmp.replace(base)
                output=base;audio=False
                if lengths:
                    audio_offset=offset%sum(lengths);track=0
                    while audio_offset>=lengths[track]:audio_offset-=lengths[track];track=(track+1)%len(music)
                    mixkey=digest(['mix-v1',key,str(music[track]),round(audio_offset,3),settings.get('volume',14)])
                    output=OUT/(mixkey+'.mp4')
                    if not output.exists():
                        tmp=OUT/(mixkey+'.tmp.mp4')
                        run(ff+['-i',str(base),'-stream_loop','-1','-ss',str(audio_offset),'-i',str(music[track]),'-t',str(secs),'-map','0:v:0','-map','1:a:0','-c:v','copy','-af','volume='+str(min(.3,settings.get('volume',14)/100)),'-c:a','aac','-b:a','96k','-ar','44100','-movflags','+faststart',str(tmp)])
                        tmp.replace(output)
                    audio=True
                clips.append({'id':item['id'],'item_version':digest(item),'file':output.name,'seconds':secs,'end':item.get('end',0),'audio':audio})
                offset+=secs
                atomic(STATE/'preparation.json',json.dumps({'state':'preparing','prepared':len(clips),'source_version':program['version'],'at':time.time()}).encode())
    atomic(STATE/'clips.json',json.dumps({'version':program['version'],'clips':clips,'prepared_at':time.time()}).encode())
    # Remove obsolete derivatives only after atomically publishing the ready queue.
    keep.update(c['file'] for c in clips)
    for path in OUT.iterdir():
        if path.name not in keep and path.is_file() and time.time()-path.stat().st_mtime>3600:path.unlink()
    atomic(STATE/'preparation.json',json.dumps({'state':'ready','prepared':len(clips),'source_version':program['version'],'at':time.time()}).encode())
def main():
    while True:
        try:
            p=json.loads((STATE/'program.json').read_text())
            try:previous=json.loads((STATE/'clips.json').read_text())['version']
            except (OSError,ValueError,KeyError):previous=None
            if p['version']!=previous:prepare(p)
        except Exception as exc:atomic(STATE/'preparation.json',json.dumps({'state':'error','error':type(exc).__name__,'at':time.time()}).encode())
        time.sleep(15)
if __name__=='__main__':main()
