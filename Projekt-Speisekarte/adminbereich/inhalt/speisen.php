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
}else {
    $fehlermeldung="Es ist ein Fehler bei der Speisenverwaltung aufgetreten";
}

// echo $fehlermeldung;

function formular_s_hinzu_in_db_eintragen(){
    echo " Formular wurde abgeschickt und muss jetzt noch geprüft und in die DB eingetragen werden.";
};

function formular_s_hinzu(){
    echo" Bitte füllen sie alle Felder ordnungsgemäß aus.<br>";
?>
    <form action="" method="post">
    <label for="titel">Titel eingeben:</label>
    <input type="text" name="titel" maxlength="80"><br>

    <label for="beschreibung">Beschreibung eingeben:</label>
    <input type="text" name="beschreibung" maxlength="120"><br>
    
    <div>Bitte kreuzen sie die Allergene an die sich in den Speisen befinden.</div>
    <label class="allergene a1"> Gluten
        <input class="all" type="checkbox" id="al_1" name="Allergene" value="al-AGluten">
        <span class="checkmark"></span>
    </label>
    <label class="allergene a2"> Krebstiere  
        <input class="all" type="checkbox" id="al_2" name="Allergene" value="al-B">
        <span class="checkmark"></span>
    </label><br>
    <label class="allergene a3"> Eier
        <input class="all" type="checkbox" id="al_3" name="Allergene" value="al-C">
        <span class="checkmark"></span>
    </label>
    <label class="allergene a4"> Fische
        <input class="all" type="checkbox" id="al_4" name="Allergene" value="al-D">
        <span class="checkmark"></span>
    </label><br>
    <label class="allergene a5"> Erdnüsse
        <input class="all" type="checkbox" id="al_5" name="Allergene" value="al-E">
        <span class="checkmark"></span>
    </label>
    <label class="allergene a6"> Sojabohnen
        <input class="all" type="checkbox" id="al_6" name="Allergene" value="al-F">
        <span class="checkmark"></span>
    </label><br>
    <label class="allergene a7"> Milch
        <input class="all" type="checkbox" id="al_7" name="Allergene" value="al-G">
        <span class="checkmark"></span>
    </label>
    <label class="allergene a8"> Schalenfrüchte
        <input class="all" type="checkbox" id="al_8" name="Allergene" value="al-H">
        <span class="checkmark"></span>
    </label><br>
    <label class="allergene a9"> Sellerie
        <input class="all" type="checkbox" id="al-9" name="Allergene" value="al-L">
        <span class="checkmark"></span>
    </label>
    <label class="allergene a10"> Senf
        <input class="all" type="checkbox" id="al-10" name="Allergene" value="al-M">
        <span class="checkmark"></span>
    </label><br>
    <label class="allergene a11"> Sesamsamen
        <input class="all" type="checkbox" id="al-11" name="Allergene" value="al-N">
        <span class="checkmark"></span>
    </label>
    <label class="allergene a12"> Schwefeld. / Sul.
        <input class="all" type="checkbox" id="al-12" name="Allergene" value="al-O">
        <span class="checkmark"></span>
    </label><br>
    <label class="allergene a13"> Lupinen
        <input class="all" type="checkbox" id="al-13" name="Allergene" value="al-P">
        <span class="checkmark"></span>
    </label>
    <label class="allergene a14"> Weichtiere
        <input class="all" type="checkbox" id="al-14" name="Allergene" value="al-R">
        <span class="checkmark"></span>
    </label><br>

    <label for="preis">Preis eingeben:</label>
    <input type="zahl" name="preis" maxlength="7"><br>


    <button class="sub_buttons" name="seite" value="s_fa_hinzu">Speise hinzufügen</button>

</form>

<?php 
};


?>