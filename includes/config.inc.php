<?php
error_reporting(0);
ini_set("display_errors", 0);
date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, 'pt_BR');

DEFINE('LIVE', false);

DEFINE('EMAIL_CONTATO', 'contato@whosapp.com.br');
DEFINE('MYSQL', 'includes/mysql.inc.php');	

session_start();

function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars) {
	$message = "Ocorreu um erro no script '$e_file' na linha $e_line: \n$e_message\n";
	$message .= print_r(debug_backtrace(), 1);
	if (!LIVE) {
	    echo "<p style='color: red;'>" . nl2br($message) . "</p>";
	} else {
	    error_log($message, 1, EMAIL_CONTATO, EMAIL_CONTATO);
	}
	return true;
}

set_error_handler('my_error_handler');
?>