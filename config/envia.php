<?php
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = isset($_POST['nome']) ? $_POST['nome'] : 'Não informado';
    $replyto = isset($_POST['replyto']) ? $_POST['replyto'] : 'nao-responda@mdradvocacia.com';
    $mensagem_form = isset($_POST['mensagem']) ? $_POST['mensagem'] : '';
    $vaga = isset($_POST['assunto']) ? $_POST['assunto'] : 'Geral';
    $arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : null;

    $assunto = "Curriculo enviado via site - $vaga - $nome";
    $to = "recrutamento@mdradvocacia.com";
    $remetente = "rildon@mdradvocacia.com"; 

    // Validação de PDF
    if ($arquivo && !empty($arquivo['name']) && $arquivo['type'] !== 'application/pdf') {
        // Salva o erro na sessão
        $_SESSION['mensagem_tipo'] = 'danger';
        $_SESSION['mensagem_texto'] = 'Formato inválido. Apenas arquivos PDF são permitidos.';
        header("Location: /pages/trabalhe-conosco");
        exit();
    }

    $boundary = "XYZ-" . date("dmYis") . "-ZYX";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "From: $remetente\r\n";
    $headers .= "Reply-To: $replyto\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    $corpo_mensagem = " 
    <br>Formulário via site
    <br>--------------------------------------------<br>
    <br><strong>Nome:</strong> $nome
    <br><strong>Email:</strong> $replyto
    <br><strong>Vaga:</strong> $vaga
    <br><strong>Mensagem:</strong> $mensagem_form
    <br><br>--------------------------------------------
    ";

    $mensagem = "--$boundary\r\n";
    $mensagem .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
    $mensagem .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $mensagem .= "$corpo_mensagem\r\n";

    if ($arquivo && !empty($arquivo["tmp_name"]) && file_exists($arquivo["tmp_name"])) {
        $fp = fopen($arquivo["tmp_name"], "rb");
        $anexo_conteudo = fread($fp, filesize($arquivo["tmp_name"]));
        fclose($fp);
        $anexo_codificado = chunk_split(base64_encode($anexo_conteudo));

        $mensagem .= "--$boundary\r\n";
        $mensagem .= "Content-Type: application/pdf; name=\"" . $arquivo["name"] . "\"\r\n";
        $mensagem .= "Content-Disposition: attachment; filename=\"" . $arquivo["name"] . "\"\r\n";
        $mensagem .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $mensagem .= "$anexo_codificado\r\n";
    }

    $mensagem .= "--$boundary--\r\n";

    // ... (código do envio de email) ...

    if (mail($to, $assunto, $mensagem, $headers)) {
        $_SESSION['mensagem_tipo'] = 'success';
        $_SESSION['mensagem_texto'] = 'Mensagem enviada com sucesso! Agradecemos o seu contato.';
        header("Location: /pages/trabalhe-conosco");
        exit();
    } else {
        $_SESSION['mensagem_tipo'] = 'danger';
        $_SESSION['mensagem_texto'] = 'Ocorreu um erro ao enviar. Tente novamente.';
        header("Location: /pages/trabalhe-conosco");
        exit();
    }

} else {
    // Acesso direto
    header("Location: /pages/trabalhe-conosco");
    exit();
}
?>