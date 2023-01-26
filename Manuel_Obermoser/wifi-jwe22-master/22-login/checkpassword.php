<html>
    <head></head>
    <body>
    
    <?php

        if($_POST['username'] == 'hans' && $_POST['password'] == 'asdf1234!') {
            echo 'Login korrekt';
        } else {
            echo 'Entweder Benutzername oder Passwort ist falsch.';
        }

    ?>

    <p>
        <a href="javascript:window.history.back()">zurück</a>
    </p>

    </body>
</html>
