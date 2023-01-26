const ele = $('elevator');

function move('floor'){
    ele.attr('class','floor-'+floor); // mit attr kann man direkt attribute setzen
    // ele.addClass('floor-'+floor);
    window.setTimeout(() => {}, 2000);

};

function checkCode(){
    if($('#code').val()== 8989){
        $('#secret-btn').fadeIn();
    } else {
        $('#secret-btn').fadeOut();
    }
}

$('#code').keyup(checkCode());
// $('#code').on('keyup',function(){checkCode()})