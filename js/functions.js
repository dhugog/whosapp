function tBugReport() {
	document.getElementById("secBugReport").addEventListener("click", function(e) {
		var div = $("#formBugReport");
		if (div.has(e.target).length || e.target == div[0]) {
			return;
		} else {
			$("#secBugReport").css('display', 'none');
		}
	});
}

function activePass() {
	document.getElementById("cadPass").disabled = false;
}

function disablePass() {
	document.getElementById("cadPass").disabled = true;
	document.getElementById("cadPass").value = "";
}

$(function($) {	
	$("#formBugReport").submit(function() {			
		var msg = $("#report-msg").val();		
		var assunto = $("#assunto").val();
		
		$.post('reportar-erro.php', {msg: msg, assunto: assunto}, function(response) {		
			$("#report-msg").val("");	
			$("#assunto").val("");
			$("#secBugReport").css('display', 'none');
			alert(response);
		});
		
	});	
});

