const ele = $('#elevator');

function move(floor){
    console.log('bin da: ' +floor)
    ele.attr('class','floor-'+floor); // mit attr kann man direkt attribute setzen
    ele.addClass('floor-'+floor);
    // window.setTimeout(() => {}, 2000);

};

function checkCode(){
    if($('#code').val()== 8989){
        $('#secret-btn').show();
        console.log('ddd');
    } else {
        $('#secret-btn').hide();
        console.log('keine Ahnung was falsch ...');
    };
};

$('#code').keyup(function(){checkCode()});
// $('#code').on('keyup',function(){checkCode()})