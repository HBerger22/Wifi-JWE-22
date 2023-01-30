const username='hans';
const pwd ='asdf1234!';

        console.log(`"$(pwd), irgendein Text"`);

$('#loginBtn').on('click',function(){
    $('#result').load(
        'https://jwe.obinet.at/php/checkpassword.php',
        {
            username: username,
            password: pwd
        }, 
        function(){
            console.log('Seite erfolgreich geladen');
        }
    );
});


https://api.openweathermap.org/data/2.5/weather?lat={lat}&lon={lon}&appid={API key}