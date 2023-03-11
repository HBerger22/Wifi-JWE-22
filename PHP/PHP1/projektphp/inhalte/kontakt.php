<?php

// inhalt von: $post:
// [name] => Name
// [email] => E-Mail
// [message] => Ihre Nachricht
// [submit] => 

$fehlermeldungen=array();
$erfolgreich=false;
if( !empty($_POST)){  
               // ist die Variable $post nicht leer?
    if( empty($_POST["name"])){    //ist der Wert vom Key"name" leer
        $fehlermeldungen[]="Bitte geben sie ihren Namen ein!";
    }else if(strlen($_POST["name"]) <=2){
        $fehlermeldungen[]="Ihr Name ist bestimmt länger als";
    };
    if(empty($_POST["email"])||preg_match("/[A-Za-z][A-Za-z0-9]+\@[A-Za-z][A-Za-z0-9]+\\.[A-Za-z]+/i", $_POST["email"])){
        $fehlermeldungen[]="Bitte geben sie eine E-Mail ein!";
    };
    if(empty($_POST["message"])){
        $fehlermeldungen[]="Bitte geben sie eine Nachricht ein!";
    };
 
    if(empty($fehlermeldungen)){
        $erfolgreich=true; //es sind keine Fehlermeldungen aufgetreten wird weiter untern verwendet

        // Informationen aus dem Formular als Datei speichern
        $inhalt= "Anfrage über Kontaktformular: \nName: {$_POST['name']}
E-Mail: {$_POST['email']}
Nachricht: {$_POST['message']}";
            $dateiname="Kontaktformularanfrage_".date("y-m-d_H-i-s");
            file_put_contents("kontaktformulareingaben/".$dateiname.".txt",$inhalt);
            echo "datei erstellt";
    };
};

// if(!empty($_POST) && !array_key_exists("0", $fehlermeldungen)){
//          $erfolgreich=true;
// }
?>

<div class="text">
                <h1>Kontakt</h1>
                <div class="left">
                    <h2>Wifi Salzburg</h2>
                    <p>
                        Musterhausstraße 13<br />
                        5020 Salzburg<br />
                        Österreich<br />
                        <br />
                        0043-662-12345<br />
                        <a href="mailto:rainer.christian@gmx.at">rainer.christian@gmx.at</a><br />
                        <a href="http://www.wifisalzburg.at" target="_blank">www.wifisalzburg.at</a><br />
                        <br />
                        <br />
                        Oder einfach Formular ausfüllen, abschicken, fertig!<br />
                        Wir werden uns umgehend um Ihr Anliegen bemühen.
                    </p>
                </div>
                <div class="contact right">
                    <?php 
                    // Aufgetretene Fehlermeldungen der reihe nach ausgeben.
                    if(!empty($fehlermeldungen)){
                        echo "<h3>Es sind folgende Fehler aufgetreten: </h3>";
                        echo "<ul>";
                        foreach($fehlermeldungen as $fehler){
                            echo "<li style='color:orange; font-size:14px'>";
                            echo $fehler;
                            echo "</li>";
                        }
                        echo "</ul>";
                    }

                    if($erfolgreich){
                        echo "<h3 style='color:orange'>Vielen Dank für Ihre Anfrage! </h3>";
                    } else {
                    ?>
            
                    <form  method="post">
                        <div>
                            <input type="text" id="name" name="name" value="<?php 
                            if(!empty($_POST)){
                                echo $_POST["name"];
                                } 
                            ?>" placeholder="Name" />
                        </div>
                        <div>
                            <input type="text" id="email" name="email" value="<?php 
                            if(!empty($_POST)){
                                echo $_POST["email"];
                                } 
                            ?>" placeholder="E-Mail"/>
                        </div>
                        <div>
                            <textarea id="message" name="message" placeholder="Ihre Nachricht"><?php 
                            if(!empty($_POST)){
                                echo $_POST["message"];
                                } 
                            ?></textarea>
                        </div>
                        <div style="text-align: right;">
                            <button type="submit" id="submit" name="submit">Absenden</button>
                        </div>
                    </form>
                    <?php
                        };
                    ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
