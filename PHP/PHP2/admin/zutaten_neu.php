<?php
include "funktionen.php";
ist_eingeloggt();
$erfolg=false;

if(!empty($_POST)){
    if(empty($_POST["name"])){
        $error = "Name darf nicht leer sein!";
    } else {
        $sql_name = escape($_POST["name"]);
        $sql_kcal = escape($_POST["kcal"]);

        $result = query("SELECT * FROM zutaten WHERE name ='{$sql_name}'");
        $row =fetch($result);
        if($row){
            $error ="Diese Zutat existiert bereits!";
            
        }
    }
// var_dump($error);
    if (empty($error)){
        if(empty($sql_kcal)){
            $sql_kcal="NULL";
        }
        query("INSERT into zutaten ( name , kcal_pro_100) VALUES ('{$sql_name}', {$sql_kcal})");
        $erfolg=true;
    }
}




    // $error = "nicht leer";


include "kopf.php";
?>


    <h1>Neue Zutat anlegen</h1>
<?php
    if( !empty($error) ){
        echo "<p style='color:red'> $error </p>";
    }
    if( $erfolg ){
        echo "<p style='color:green'> Zutat erfolgreich eingetragen <br> 
            <a href='zutaten_liste.php'>Zutaten Liste</a> </p>";
    } 
?>

    <form method="post">
        <div>
            <label for="name"> Name: </label>
            <input type="text" name="name" id="name" value="<?php if(!empty($_post["name"])) {
                echo htmlspecialchars($_POST['name']);
                } ?>">
        </div>
        <div>
            <label for="kcal"> kcal/100: </label>
            <input type="text" name="kcal" id="kcal" value="<?php if(isset($_post["kcal"])) {
                echo htmlspecialchars($_POST['kcal']);
                } ?>">
        </div>
        <div>
            <button type="submit">Zutat hinzufügen</button>
        </div>
    
    </form>

<?php
include "fuss.php";