<?php
include "funktionen.php";
ist_eingeloggt();

include "kopf.php";
echo "<h1>Zutat entfernen</h1>";

$sql_id = escape($_GET["id"]);



// hat der benutzer bereits bestätigt?
if(!empty($_GET["doit"])){ //ja
    // zutat löschen
    query("DELETE from zutaten where id={$_GET["id"]}");
    echo "<p>Zutat erfolgreich gelöscht</p>";
    echo "<a href='zutaten_liste.php'>Zurück zu Zutatenliste</a>";

} else {  // Benutzer Fragen ob er die Zutat wirklich löschen will.
    // Zutat holen
    $result = query("SELECT * from zutaten where id={$_GET["id"]}");
    $row=fetch($result);

    // schaun ob es noch eine Verknüpfung zu einem Rezept gibt
    $result2 = query("SELECT * from `bz_rezepte_zutaten` where zutaten_id={$_GET["id"]}");
    $existiert = fetch($result2);

    // dieser fall sollte nie eintreten, aber es könnte sein, daß die $_get variable
    if(empty($row)){ //zutat existiert nicht
        echo "<p>Diese Zutat existiert nicht (mehr)!<br> <a href='zutaten_liste.php'>Zutaten Liste</a></p>";
    } else if($existiert){ //es existiert noch eine verknüpfung von einem Rezept zu dieser zutat
        echo "<p> Die Zutat ".htmlspecialchars($row["name"])." existiert noch in einem anderen Rezept und kann daher nicht gelöscht werden</p>";
    } else { //Benutzer fragen ob wirklich löschen?
        echo "<p> Wollen sie die Zutat ".htmlspecialchars($row["name"])." wirklich endgültig löschen?</p>";
        echo "<p> 
                <a href='zutaten_liste.php'>Nein, abbrechen</a>
                <a href='zutaten_entfernen.php?id={$row["id"]}&amp;doit=1'>Ja, löschen</a>
            </p>";
    } 
}

// prüfen ob das Formular abgeschickt wurde

include "fuss.php";