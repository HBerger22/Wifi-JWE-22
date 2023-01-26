const user = 'hans';
const pass = 'asdf1234!';

$('#loginBtn').on('click', function() {
    
    $('#result').load(
        'https://jwe.obinet.at/php/checkpassword.php',
        {
            username: user,
            password: pass
        },
        function() {
            console.log('load completed');
        }
    );
    
});