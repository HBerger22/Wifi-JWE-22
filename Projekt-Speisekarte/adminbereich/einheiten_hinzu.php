<?php
include "funktionen.php";

include "kopf.php";

echo "<h1>Einheiten hinzufügen</h1>";
echo "<p>Bitte geben sie den vollständigen Namen sowie das Kürzel für die neue Einheit ein.</p>";

if(!empty($_SESSION["erfolg"])){
    echo "<p style='color:green'>".$_SESSION["erfolg"]."</p>";
    unset($_SESSION["erfolg"]);
}

// echo'S_Session:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($_SESSION);
// echo "</pre>";
// echo'S_post:';
// echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
// print_r($_POST);
// echo "</pre>";

if(!empty($_POST)){
    if(empty($_POST["name"]) || $_POST["kuerzel"]==""){
        $fehlermeldung="Bitte alle Felder ausfüllen !";
    } else {
        $sql_name=escape($_POST["name"]);
        $sql_kuerzel=escape($_POST["kuerzel"]);
        $sql = "SELECT * from einheit where `name` ='{$sql_name}' or `kuerzel` ='{$sql_kuerzel}'";
        if($result=$con->query($sql)){ 
            if($result->num_rows != 0){//abfragen ob die EInheit existiert
                $fehlermeldung="Diese Einheit existiert bereits!";
            } else {
                
                
                $sql="INSERT into einheit (`name`, `kuerzel`)
                    VALUES ('$sql_name','$sql_kuerzel') ";
                $result=$con->query($sql);
                $erfolg="Die Einheit wurde erfolgreich hinzugefügt.";
                unset($_POST["name"]);
                unset($_POST["kuerzel"]);
            }
            $con->close();
        }
    }
}

if(!empty($fehlermeldung)){
    echo "<p style='color:red'>".$fehlermeldung."</p>";

}

if(!empty($erfolg)){
    echo "<p style='color:green'>".$erfolg."</p>";

}
?>

<form method='post'>
    <div>
        <label class="form_beschriftung" for="name">Einheit ausgeschrieben: </label>
        <input type="text" name="name" id="name" value="<?php if(!empty($_POST["name"])){ echo $_POST["name"];} ?>">
    </div>
    <div>
        <label class="form_beschriftung" for="kuerzel">Einheit Kürzel: </label>
        <input type="text" name="kuerzel" id="kuerzel" value="<?php if(!empty($_POST["kuerzel"])){ echo $_POST["kuerzel"];} ?>">
    </div>
    <button type="submit">Einheit hinzufügen</button>
</form>

<?php

include "fuss.php";
