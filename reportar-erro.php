<?php
	require_once 'includes/config.inc.php';
	
	$msg = FILTER_INPUT(INPUT_POST, 'msg', FILTER_SANITIZE_STRING);
	$msg .= "<br>" . date('d/m/Y - H:i');
	$msg = nl2br($msg);
	$assunto = FILTER_INPUT(INPUT_POST, 'assunto', FILTER_SANITIZE_STRING);

	$email = EMAIL_CONTATO;

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: WhosApp <$email>';

	$sendEmail = mail($email, $assunto, $msg, $headers);
	if($sendEmail) {
		echo "Mensagem enviada com sucesso!\r\nAgradecemos o contato!";
	} else {
		echo "Erro ao entrar em contato. Desculpe-nos a inconveniência";
	}
?>
