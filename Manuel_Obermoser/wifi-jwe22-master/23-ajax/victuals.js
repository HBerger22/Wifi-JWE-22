$.getJSON(
    "https://jwe.obinet.at/api/victuals.php?apiKey=r5oS3YYSsnGX47UBrbl7Nm1MkZOsrg8uDbJKIQG5oyNMDbI7R68wPAcug8Wcxkjr",

    function (data, xhr, status) {

        console.log(data);

        if(status.statusText === 'success' && typeof data == 'object') {

            console.log('api call successful');


            let items = [];

            $.each( data, function( key, val ) {
                items.push( `<li id="product_${val.uid}">${val.title} [${val.price}]</li>` );
            });


            $( "<ul/>", {
                "class": "artikel-liste",
                html: items.join( "" )
            }).appendTo( "body" );


        } else {
            console.log('api call not successful');
        }


    }
);
