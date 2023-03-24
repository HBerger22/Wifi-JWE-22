<?php 
$laengeSessionSeite=strlen($_SESSION["seite"]);
echo "laenge: ". $laengeSessionSeite. "<br>";
$herkunft=substr($_SESSION["seite"],2,2);
$untermenu=substr($_SESSION["seite"],5,$laengeSessionSeite-1);
echo "laenge: ". $herkunft. "<br>";
echo "laenge: ". $untermenu. "<br>";




if($untermenu=="hinzu"){
    echo "<h2>Speise hinzufügen</h2>";
    if($herkunft=="um"){ //herkunft vom um = Untermenu oder fa=Formular abgeschickt
        formular_s_hinzu();
    } else {
        formular_s_hinzu_in_db_eintragen();
        // eintrag in die db prüfen und vornehmen
    }

}else if($untermenu=="aendern"){
    echo "<h2>Speise ändern</h2>";
}else if($untermenu=="loeschen"){
    echo "<h2>Speise löschen!</h2>";
}else if($untermenu=="ansicht"){
    echo "<h2>Speisenübersicht:</h2>";
    echo '<form action="#" method="post">';
    echo '<button class="sub_buttons" name="seite" value="s_um_hinzu">Speise hinzufügen</button>';
    echo '</form>';
                            
    speise_uebersicht();
}else{
    $fehlermeldung="Es ist ein Fehler bei der Speisenverwaltung aufgetreten";
}
if($fehlermeldung!="")
    echo "<h3>".$fehlermeldung."</h3>";

// echo $fehlermeldung;



?>