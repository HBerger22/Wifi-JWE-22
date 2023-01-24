const username='hans';
const pwd ='asdf1234!';

        console.log(`"$(pwd), irgendein Text"`);

$('#loginBtn').on('click',function(){

    $('result').load(
        'https://jwe.obinet.at/php/checkpassword.php',
        {
            username: username,
            password: pwd
        }, 
        function(){
            console.log('Seite erfolgreich geladen');
        }
    )
})