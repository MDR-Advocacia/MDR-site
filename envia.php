<?php

/* Valores recebidos do formulário  */
$arquivo = $_FILES['arquivo'];
$nome = $_POST['nome'];
$replyto = $_POST['replyto']; // Email que será respondido
$mensagem_form = $_POST['mensagem'];
$vaga = $_POST['assunto'];
$assunto = "Curriculo enviado via site - $vaga  - $nome";

/* Destinatário e remetente - EDITAR SOMENTE ESTE BLOCO DO CÓDIGO */
$to = "recrutamento@mdradvocacia.com";
$remetente = "rildon@mdradvocacia.com"; // Deve ser um email válido do domínio

/* Verifica se o arquivo é um PDF */
if (!empty($arquivo['name']) && $arquivo['type'] !== 'application/pdf') {
    header("Location: form.php?status=invalid_file");
    exit();
}

/* Cabeçalho da mensagem  */
$boundary = "XYZ-" . date("dmYis") . "-ZYX";
$headers = "MIME-Version: 1.0\n";
$headers .= "From: $remetente\n";
$headers .= "Reply-To: $replyto\n";
$headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
$headers .= "$boundary\n";

/* Layout da mensagem  */
$corpo_mensagem = " 
 <br>Formulário via site
 <br>--------------------------------------------<br>
 <br><strong>Nome:</strong> $nome
 <br><strong>Email:</strong> $replyto
 <br><strong>Assunto:</strong> $assunto
 <br><strong>Mensagem:</strong> $mensagem_form
 <br><br>--------------------------------------------
 ";

/* Função que codifica o anexo para poder ser enviado na mensagem  */
if (!empty($arquivo["tmp_name"])) {
    $fp = fopen($arquivo["tmp_name"], "rb");
    $anexo = fread($fp, filesize($arquivo["tmp_name"]));
    fclose($fp);
    $anexo = chunk_split(base64_encode($anexo));
    
    $mensagem = "--$boundary\n";
    $mensagem .= "Content-Transfer-Encoding: 8bits\n";
    $mensagem .= "Content-Type: text/html; charset=\"utf-8\"\n\n";
    $mensagem .= "$corpo_mensagem\n";
    $mensagem .= "--$boundary\n";
    $mensagem .= "Content-Type: application/pdf\n";
    $mensagem .= "Content-Disposition: attachment; filename=\"" . $arquivo["name"] . "\"\n";
    $mensagem .= "Content-Transfer-Encoding: base64\n\n";
    $mensagem .= "$anexo\n";
    $mensagem .= "--$boundary--\r\n";
} else {
    $mensagem = "--$boundary\n";
    $mensagem .= "Content-Transfer-Encoding: 8bits\n";
    $mensagem .= "Content-Type: text/html; charset=\"utf-8\"\n\n";
    $mensagem .= "$corpo_mensagem\n";
}

/* Função que envia a mensagem  */
if (mail($to, $assunto, $mensagem, $headers)) {
    header("Location: form.php?status=success");
    exit();
} else {
    header("Location: form.php?status=error");
    exit();
}
?>
