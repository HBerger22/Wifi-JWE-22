<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Speisekartenverwaltung</title>

</head>
<body>
<div id="innerWrapper">
    <header class="verwaltung" >
        <nav>
            <form method="post">
                <ul >
                    <li>  
<<<<<<< Updated upstream
                        <!-- <button name="seite" value="a_ansicht">Allergene</button> -->
=======
                        

>>>>>>> Stashed changes
                        <button name="seite" value="s_ansicht">Speisen</button> 
                        <button name="seite" value="g_ansicht">Getränke</button>
                        <button name="seite" value="k_ansicht">Kategorie</button>
                        <button name="seite" value="e_ansicht">Einheiten</button>
                        <button name="seite" value="a_ansicht">Allergene</button>
                        <button name="seite" value="logout" >Abmelden</button>

                    </li>
                </ul>
            </form>
        </nav>
        <p> 
            <?php
                if(isset($_SESSION["login"])){
                    echo "Eingeloggter Benutzer: ". $_SESSION["login"];
                }
            ?>

        </p>
    </header>
    <section>


    

<?php


echo'S_Session:';
echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
print_r($_SESSION);
echo "</pre>";
echo'S_post:';
echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
print_r($_POST);
echo "</pre>";





    if(!empty($_POST)){
        if(!empty($_POST["seite"])){
            if($_POST["seite"]=="logout"){
                session_destroy();
                header("location: login.php");
                exit;
            }else if($_POST["seite"]=="a_ansicht"){
                header("location: allergene.php");
                exit;
            }else if($_POST["seite"]=="s_ansicht"){
                header("location: speisen.php");
                exit;
            }else if($_POST["seite"]=="k_ansicht"){
                header("location: kategorie.php");
                exit;
            }else if($_POST["seite"]=="e_ansicht"){
                header("location: einheiten.php");
                exit;
            }
        }
    }        
