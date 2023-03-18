<?php
include "funktionen.php";
ist_eingeloggt();

$errors=array();
$erfolg=false;


$sql_id = escape($_GET["id"]);
// prüfen ob das Formular abgeschickt wurde

if(!empty($_POST)){
    $sql_name= escape($_POST["name"]);
    $sql_kcal= escape($_POST["kcal"]);

    if ( empty($sql_name)){
        $errors[] = "Bitte geben sie einen Namen für die Zutat ein";
    } else {
        $result = query("SELECT * FROM zutaten WHERE name ='{$sql_name}' and id !='{$sql_id}' ");
        $row = fetch($result);
        if($row){
            $errors[] ="Diese Zutat existiert bereits!";
        } 

    }
    if(empty($errors)){
        if(empty($sql_kcal)){
            $sql_kcal="NULL";
        }
    echo " wieso";
    query("UPDATE zutaten SET `kcal_pro_100` = '{$sql_kcal}', `name`='{$sql_name}'  WHERE `zutaten`.`id` = {$sql_id};");
}
}




include "kopf.php";
?>


    <h1>Zutat bearbeiten</h1>
<?php
    if( $erfolg ){
       
    }     
    
    if( !empty($errors) ){
        echo "<ul>";
        foreach ($errors as $key => $e){
            echo "<li> {$e} </li>";
        }
        echo "</ul>";
        // echo "<p style='color:red'> $error </p>";
    }

    // DB nach Zutat-Datensatz fragen zur vorbefüllung
    $result = query("SELECT * FROM zutaten where id='{$sql_id}'");
    $row = fetch($result);
    

?>

    <form method="post">
        <div>
            <label for="name"> Name: </label>
            <input type="text" name="name" id="name" value=" <?php if(!empty($_post["name"])) {
                    echo htmlspecialchars($_POST['name']);
                } else{
                    echo htmlspecialchars($row['name']);
                } ?>">
        </div>
        <div>
            <label for="kcal"> kcal/100: </label>
            <input type="text" name="kcal" id="kcal" value=" <?php if(!empty($_post["name"])) {
                echo htmlspecialchars($_POST['kcal']);
                } else{
                    echo htmlspecialchars($row['kcal_pro_100']);
                } ?>">
        </div>
        <div>
            <button type="submit">Zutat speichern</button>
        </div>
    
    </form>

<?php
include "fuss.php";