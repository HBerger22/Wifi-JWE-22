
/**
 * 
 * 
 * 
 * 
 * KEINEN CODE HIER ANFASSEN!
 * ZURÜCK IN DEIN JAVSCRIPT FILE! :-)
 * 
 * 
 * 
 * 
 * 
 * 
 *
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */




let points = 0;

let timeout;
let interval;


if(typeof $ != 'undefined') {
    console.info('✔ jQuery erfolgreich eingebunden');
    points++;

    if($('script[src*="main.js"]').length) {
        console.info('✔ Datei main.js wurde erfolgreich eingebunden');
    }

    if(typeof MYCHANNEL != 'undefined') {
        console.info('✔ Konstante MYCHANNEL='+MYCHANNEL+' erfolgreich deklariert.');
    }

    if(typeof checkPassword == 'function') {
        $('<div class="alert alert-success">✔ Funktion <strong>checkPassword()</strong> erfolgreich deklariert</div>').appendTo('#examResult');
        points++;
    }

    if($('#remote button').length && $('#activeLight')) {
        $('#remote button').mousedown(
                function(){
                    
                    $('#activeLight').css('color','red');
                    
                    if( $('#eingabe').length) {
                        clearTimeout(timeout);
                    }

                }
        );
        $('#remote button').mouseup(
                function(){
                    $('#activeLight').css('color','');

                    if( $('#eingabe').length) {
                        
                        clearTimeout(timeout);
                        timeout = window.setTimeout(function(){
                            $('#eingabe').val('');
                        }, 5000);
                    }
                }
        );
        if( $('#eingabe').length) {
            $(window).find('input').on('change', function(e){
                console.log(e);
            });
        }


    }

    

    let checkEingabe__ = function() {
        window.clearInterval(interval);
        interval = window.setInterval(function() {
            const $ein = $('#eingabe');
            if($ein.length && $ein.val().length >= 4 && typeof MYCHANNEL !== 'undefined') {

                console.log($ein.val());

                switch($ein.val()) {
                    case "netflix":
                        console.info('Gratulation! Sie haben den richtigen Code eingegeben: '+$ein.val());
                        window.setTimeout(function(){
                            $('#tv').append('<video src="https://jwe.obinet.at/media/netflix_intro.mp4" autoplay muted>');
                            document.querySelector('video').onended = () => {
                                location.reload();
                            };
                        }, 1000);

                        
                        break;

                    case "disney":
                        console.info('Gratulation! Sie haben den richtigen Code eingegeben: '+$ein.val());
                        window.setTimeout(function(){
                            $('#tv').append('<video src="https://jwe.obinet.at/media/disney_intro.mp4" autoplay muted>');
                            document.querySelector('video').onended = () => {
                                location.reload();
                            };
                        }, 1000);
                        
                        break;

                    case "youtube":
                        console.info('Gratulation! Sie haben den richtigen Code eingegeben: '+$ein.val());
                        window.setTimeout(function(){
                            $('#tv').append('<video src="https://jwe.obinet.at/media/youtube_intro.mp4" autoplay muted>');
                            document.querySelector('video').onended = () => {
                                location.reload();
                            };
                        }, 1000);
                        
                        break;
                        

                    case MYCHANNEL.toString():
                        console.info('Gratulation! Sie haben den richtigen Code eingegeben: '+$ein.val());
                        window.setTimeout(function(){
                            $('#tv').append('<iframe allow="fullscreen" frameBorder="0" height="100%" src="https://giphy.com/embed/tdKwUz6W6TkYZfjqMe/video" width="100%"></iframe>');
                            
                            
                        }, 1000);
                        break;
                }
                
                
                $('#remote').css('opacity', 0);
                $('#tv')
                    .delay(1000)
                    .css('filter','blur(0)')
                ;
                window.clearInterval(interval);
                window.setTimeout(function(){
                    location.reload();
                },10000);

                

            }    
        }, 1000);
    }

    checkEingabe__();


}

