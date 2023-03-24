<?php


    $con= @new mysqli("","root","","speisekarte"); //Das @ bedeutet silent und unterdrückt die ausgabe von Fehlermeldungen (notwendig gegen Hackerangriffe die sonst eine Info zur DB bekommen würden)
        if($con->connect_error){
            exit("Fehler beim Verbindungsaufbau");
        };


function escape ($wort){
    global $con;
    return mysqli_real_escape_string($con, $wort);
}

// einfache funktion ohne grossartige überprüfung um in einer Zahl das komma gegen einen Punkt zu tauschen.
function punkt_statt_komma($zahl){
    if(stripos($zahl,","))
        $zahl[stripos($zahl,",")]=".";
    return $zahl;
}

function speise_uebersicht(){
    // $con=db_con();
    global $con;
    $sql="SELECT * FROM speisen";
    if($result=$con->query($sql)){ 
        if($result->num_rows == 0){//abfragen ob der Benutzer existiert
            $fehlermeldung="Keine Speisen vorhanden!";
        } else{
            echo "<div id='tabelle'>
                    <div class='reihe'>
                        <div class='spalte center'> bearbeiten </div> 
                        <div class='spalte center'> löschen </div> 
                        <div class='spalte center'> ID </div> 
                        <div class='spalte center'> Name </div> 
                        <div class='spalte center'> Beschreibung </div> 
                        <div class='spalte center'> Preis </div> 
                    </div>";
            while ($daten_satz = $result->fetch_assoc()){
                echo "<div class='reihe'>
                        <div class='spalte center' > <button class='mini_buttons' name='seite' value='s_um_aendern'>b</button> </div> 
                        <div class='spalte center'> <button class='mini_buttons' name='seite' value='s_um_aendern'>l</button> </div>
                        <div class='spalte'> {$daten_satz['id']} </div> 
                        <div class='spalte'> {$daten_satz['name']} </div> 
                        <div class='spalte'> {$daten_satz["beschreibung"]} </div> 
                        <div class='spalte'> {$daten_satz["preis"]} </div> 
                    </div>";
            }
            echo "</div>";
                
            $result->close();
        }
    }
    $con->close();
}


function formular_s_hinzu_in_db_eintragen(){
    global $con;
    $sql_name = escape($_POST["name"]);
    $sql_beschr = escape($_POST["beschreibung"]);
    $sql_preis = escape($_POST["preis"]);
    $sql_preis= punkt_statt_komma($sql_preis);
    
    
    $sql="SELECT * FROM speisen where name = '{$sql_name}'";
    if($result=$con->query($sql)){ 
        if($result->num_rows == 0){//abfragen ob der Benutzer existiert
            $sql="INSERT INTO `speisen`(`name`, `beschreibung`, `preis`) VALUES ('{$sql_name}','{$sql_beschr}','{$sql_preis}')";
            if($result=$con->query($sql)){ 
                $fehlermeldung="Speise erfolgreich eingetragen.";
            } else {
                $fehlermeldung="Es ist ein Fehler aufgetreten!";
            }
        } else{
            $fehlermeldung = "Speise existiert bereits";
        }
    }

};

function formular_s_hinzu(){
    echo" Bitte füllen sie alle Felder ordnungsgemäß aus.<br>";
?>
    <form action="" method="post">
    <label for="name">Titel eingeben:</label>
    <input type="text" name="name" maxlength="80"><br>

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
