const x = $('#elevator');

function move(floor) {
    x.attr('class','floor-' + floor);

    // floor-eg
    // floor-1
    // floor-2
}

function checkCode () {
    if($('#code').val() == 8989) {
        $('#secret-btn').show();
    } else {
        $('#secret-btn').hide();
    }
}

$('#code').keyup(function() {
    checkCode();
    console.log('taste gedrückt');
});