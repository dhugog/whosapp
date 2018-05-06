var loop, loopScroll;
var submited;
var mensagemDenunciada;
var msgsId = [];

$(function($) {	
	$("#chatForm").submit(function() {			
		var msg = $("#msg").val();		
		$("#msg").val("");
		
		$.post('enviar-msg.php', {msg: msg}, function() {		
			trackScroll();
		});
		
	});	
});

function trackScroll() { // Set scroll to bottom of main-sec and loop every 0.5s
	var mainSec = document.getElementById('main-sec');		
	mainSec.scrollTop = mainSec.scrollHeight;	
	loopScroll = setTimeout(trackScroll, 500);
}


function populaSecao() { // Populate main-sec; loop every 0.5s
	$.ajax({
		type:'post',
		dataType: 'json',
		url: 'listar-mensagens.php',
		success: function(dados){
			// Data populate
			var els = [];
			for(var i = 0; i < dados.length; i++){		
				els[i] = '<div class="msgDiv"><p class="mensagem"><span class="usuario">Anônimo <b>' + dados[i].id_usuario + '</b> diz:</span><br><span class="texto">' + dados[i].mensagem + "</span><sub>" + dados[i].data_envio + '</sub></p></div>';	
				
				msgsId[i] = dados[i].id_mensagem;
			}
			//
			
			// Max users span
			var totUsers = dados[0].total_usuarios;
			var maxUsers = dados[0].max_usuarios;
			var spanUsers = document.getElementById("totUsers");
			spanUsers.innerHTML = totUsers + " / " + maxUsers;	
			if(totUsers == maxUsers) {
				spanUsers.style.color = "red";
			} else {
				spanUsers.style.color = "#222";
			}
			// 
			
			
			// Scrolling manager
			var mainSec = document.getElementById('main-sec');			
			var mainSecHeight = mainSec.offsetHeight;
			var scrollTop = mainSec.scrollTop;			
			var scrollHeight = mainSec.scrollHeight;
			var msgs = document.getElementsByClassName("msgDiv");
						
			
			if(els.length > msgs.length) {	
				$("#main-sec").html(els); // Data populating
				if(scrollTop == (scrollHeight - mainSecHeight)) {					
					trackScroll();
				} else {					
					clearTimeout(loopScroll);					
				}		
				
				// Setting onClick event to toggleOptions for each element .mensagem
				var msgs = document.getElementsByClassName("mensagem");
				for(var c = 0; c < msgs.length; c++) {														
					msgs[c].addEventListener("mouseup", toggleOptions);
					msgs[c].addEventListener("mouseout", toggleOptionsOut);
					msgs[c].id = "mensagem" + msgsId[c];
				}			
			}	
			//
		}
	});
	loop = setTimeout(populaSecao, 700);
}

// Toggle options in mensagem
function toggleOptions(e) {	
	mensagemDenunciada = this.id;		
	var opts = document.getElementById("options");			
		
	opts.style.display = "inline-block";
	opts.style.top = e.clientY + "px";
	opts.style.left = e.clientX - opts.offsetWidth + "px";	
	
	opts.addEventListener("mouseover", function(){this.style.display = "inline-block"});
	opts.addEventListener("mouseout", function(){this.style.display = "none"});
}

function toggleOptionsOut() {
	var opts = document.getElementById("options");
	opts.style.display = "none";
}
//

// Denunciar mensagem
$(function($) {	
	$("#li_denunciar").click(function() {						
		var idMsg = mensagemDenunciada.replace("mensagem", "");		
		
		$.post('enviar-denuncia.php', {idMsg: idMsg}, function(resposta) {		
			toggleOptionsOut();		
			alert(resposta);
		});
		
	});	
});
//

$(document).ready(function(){		 
	populaSecao();		

	document.getElementById("btnSair").addEventListener("click", function(){clearTimeout(loop)}); 			
	document.getElementById("main-sec").addEventListener("scroll", function(){clearTimeout(loopScroll)});
	document.getElementById("secBugReport").addEventListener("click", tBugReport);
	document.body.getElementsByTagName("div")[4].style.display = "none";

	document.body.addEventListener("click", function(e) {
		var target = $(e.target);
		if (target.closest('p').attr('class') == "mensagem") {
			return;
		} else {
			$("#options").css('display', 'none');
		}
	});
});

window.onunload = window.onbeforeunload = function() {
	$.ajax({
		url : "logout.php",
		type : "GET",
		async: false,
		success: function() {
			window.location.href = "index.php";
		}
	});
	return null;
}

$(document).keydown(function (e) {	
    if ((e.which || e.keyCode) == 116) {
        e.preventDefault(); // Prevent user from refresh page
    } else if(e.ctrlKey && (e.which || e.keyCode) == 82) {
		e.preventDefault(); // Prevent user from refresh page
	}
});
