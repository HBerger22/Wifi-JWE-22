$('#submit_p').on('click',function(event){
    // alert('user: '+ $('#ben_p').val() +'\n pass: '+ $('#input_p').val());
    const benutzer=$('#ben_p').val();
    const pwd=$('#input_p').val();

    // Prüfen auf mindestlänge
    if(benutzer.length <=3 || pwd.length<=3){
        $('#fehler').html('Die Eingaben sind leider zu kurz. Es müssen mindestens 3 Zeichen sein!');
        event.preventDefault();
        return false;
        // Prüfen auf Leerzeichen \w = A-Za-z0-9_ und \s leerzeichen return
    }else if (benutzer.match(/\w+\s/g)!=null || pwd.match(/\w+\s/g)!=null || benutzer.match(/\W+\s/g)!=null || pwd.match(/\W+\s/g)!=null){
        $('#fehler').html('Es sind keine Leerzeichen erlaubt!');
        event.preventDefault();
    };


    
    $('#fehler').append('test:'+benutzer.match(/\W+\s/g)+':test');
    event.preventDefault();
    return false;
    
});

