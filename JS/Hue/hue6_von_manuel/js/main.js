"use strict";

const MYPASSWORD ='Helmut123';

$('#login').click(function(){
    checkPassword($('#password').val());

});

function checkPassword (pwd){
    if(pwd== MYPASSWORD){
        $('#message').html('Bravo, Richtiges Passwort');
    }else {
        $('#message').html('Oje, Das Passwort ist falsch');
    }
};