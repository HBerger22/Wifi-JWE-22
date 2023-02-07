$('#loginForm').on(
    'submit', 
    function(event){

        const user = $('#username').val();
        const pass = $('#password').val();

        if(user.length > 3 && pass.length > 6) {
            return true;
        } else {
            
        
            if(user.length < 0 || user.match(/^(?=.*[A-Za-z])[A-Za-z]{4,}$/) == null) {
                $('#userHelpBlock').html('mind. 4 Zeichen');
            } else {
                $('#userHelpBlock').html('');
            }

            // Minimum eight characters, at least one letter, one number and one special character:
            console.log(pass.match(/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/));

            if(pass.match(/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/) == null) {
                
                $('#passwordHelpBlock').text('Ihr Passwort entspricht nicht den Kriterien.');

                // Prüfen auf Sonderzeichen: @$!%*#?&
                if(pass.match(/[@$!%*#?&]/) == null) {

                    $('#passwordHelpBlock').html(
                        $('#passwordHelpBlock').html() 
                        + '<br>'
                        + 'mind. 1 Sonderzeichen'
                    );

                    event.preventDefault();
                }

                // Prüfen auf Zeichenlänge, und nur mit ausgewählten Zeichen A-Za-z\d@$!%*#?&
                if(pass.match(/[A-Za-z\d@$!%*#?&]{8,}$/) == null) {
                    $('#passwordHelpBlock').html(
                        $('#passwordHelpBlock').html() 
                        + '<br>'
                        + 'mind. 8 Zeichen lang'
                    );
                    event.preventDefault();
                }

                // Prüfen auf mind. 1 Zahl
                if(pass.match(/.*\d/) == null) {
                    $('#passwordHelpBlock').html(
                        $('#passwordHelpBlock').html() 
                        + '<br>'
                        + 'mind. 1 Zahl'
                    );
                    event.preventDefault();
                }
                
                // Prüfen auf mind. 1 Buchstaben
                if(pass.match(/.*[A-Za-z]/) == null) {
                    $('#passwordHelpBlock').html(
                        $('#passwordHelpBlock').html() 
                        + '<br>'
                        + 'mind. 1 Klein- oder Großbuchstabe'
                    );
                    event.preventDefault();
                }

            } else {
                $('#passwordHelpBlock').text('');
            }
        

            event.preventDefault();
            return false;
        }


    }
);



$('#username').on(
    'keyup', 
    function(event) {
        console.log($(this).val());

        console.log(event.key);

    }
);


// Kein Rechtsklick möglich
// $('body').on('contextmenu', function(event){
//     console.log(event);

//     $('.alert').remove();

//     $('<div class="alert alert-danger">Kein Rechtsklick möglich</div>').appendTo('body').css({
//         'position': 'absolute',
//         'top': event.clientY,
//         'left': event.clientX
//     })

//     event.preventDefault();
// });

