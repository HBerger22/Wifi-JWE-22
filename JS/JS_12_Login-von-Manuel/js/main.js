"use strict";
// <a href="javascript:window.history.back()">zurück</a>

// submit wird entweder durch einen Button Submit oder durch drücken der Enter-Taste ausgelöst
$('#loginform').on('submit', 
    function(event){
        const user=$('#username').val();
        const pwd=$('#password').val();
        
        if(user.length < 4 || pwd.length <= 6 ){
            console.log('Benutzer oder Pass ist zu kurz');
            $('#passwordHelpBlock').removeClass('d-none');
            $('#passwordHelpBlock').text('Benutzername oder Password sind zu kurz!');
        } else {
            
            console.log('Login OK');
            return true;
            
            //event.preventDefault(); // stoppe die anfrage an den server, es wird verhindert, dass die Standardprozedur ausgelöst wird. der Event submit wird vor dem event daten übertragen und neue Seite Laden ausgeführt.
            // return false;}

        // event.preventDefault(); 
        // return false;
        }
    	// event.preventDefault(); 
        return false;
})

$('#username').on('keyup',function(){
    $('#userHelpBlock').addClass('d-none');
})

// $('#username').on('keyup',function(event2){
//     console.log($(this).val()); //this bezieht sich auf die eingangsvariable 'username'
//     console.log(event2);
// })

// rechtsklick vermeiden und alarmmeldung rausgeben nicht vollständig
// $('body').on('contextmenu',function(event){
//     $('<div class="alert alert-danger"> Kein Rechtsklick möglich</div>').appendTo('body').css()
//     event.preventDefault();

// })
