let points = 0;

if(typeof $ != 'undefined') {
    $('body').append($('<div id="examResult" class="my-5"></div>'))
    $('<div class="alert alert-success">✔ jQuery erfolgreich eingebunden</div>').appendTo('#examResult');
    points++;

    if($('script[src*="main.js"]').length) {
        $('<div class="alert alert-success">✔ Datei main.js wurde erfolgreich eingebunden</div>').appendTo('#examResult');
        points++;
    }

    if(typeof MYPASSWORD != 'undefined') {
        $('<div class="alert alert-success">✔ Konstante <strong>MYPASSWORD='+MYPASSWORD+'</strong> erfolgreich deklariert</div>').appendTo('#examResult');
        points++;
    }

    if(typeof checkPassword == 'function') {
        $('<div class="alert alert-success">✔ Funktion <strong>checkPassword()</strong> erfolgreich deklariert</div>').appendTo('#examResult');
        points++;
    }

    $(`<div id="points" class="alert alert-info">${points} / 30 Punkte</div>`).appendTo('body');
}
