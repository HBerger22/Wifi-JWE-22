<?php
include "funktionen.php";


include "kopf.php";
echo "<h1>Passagier entfernen</h1>";

$sql_id = escape($_GET["id"]);



// hat der benutzer bereits bestätigt?
if(!empty($_GET["sicher"])){ //ja
    // passagier löschen
    query("DELETE from passagiere where 'passagier_id'={$_GET["id"]}");
    echo "<p>Der Passagier wurde erfolgreich gelöscht</p>";
    echo "<a href='passagier_liste.php'>Zurück zu Passagier Liste</a>";

} else {  // Benutzer Fragen ob er den passagier wirklich löschen will.
    $result = query("SELECT * from passagiere where `passagier_id`={$_GET["id"]}");
    $row=fetch($result);

    // schaun ob es noch eine Verknüpfung zu einem fluege gibt
    $result2 = query("SELECT * from `bz_passagier_zu_fluege` where passagier_id={$_GET["id"]}");
    $existiert = fetch($result2);


    if(empty($row)){ //passagier existiert nicht
        echo "<p>Dieser Passagier existiert nicht (mehr)!<br> <a href='passagier_liste.php'>Passagier Liste</a></p>";
    } else if($existiert){ //es existiert noch eine verknüpfung von einem Flug zu dieser passagier
        echo "<p> Der Passagier ". htmlspecialchars($row["vorname"])." ".htmlspecialchars($row["nachname"])." hat noch einen bestehende Verbindung zu einem Flug und kann daher nicht gelöscht werden</p>";
    } else { //Benutzer fragen ob wirklich löschen?
        echo "<p> Wollen sie den Passagier ". htmlspecialchars($row["vorname"])." ".htmlspecialchars($row["nachname"])." wirklich endgültig löschen?</p>";
        echo "<p> 
                <a href='passagier_liste.php'>Nein, abbrechen</a> <br>
                <a href='passagier_entfernen.php?id={$row["passagier_id"]}&amp;sicher=1'>Ja, löschen</a>
            </p>";
    } 
}

// prüfen ob das Formular abgeschickt wurde

include "fuss.php";