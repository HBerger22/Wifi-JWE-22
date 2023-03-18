<!DOCTYPE html>
<html lang="en">
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
    <h1>Willkommen im Verwaltungsbereich</h1>
    <?php 
        if($fehlermeldung!=""){
            echo "<h3 class='erfolg'> $fehlermeldung </h3>";
            $fehlermeldung="";
        }
        if($_SESSION["login"]==1){
    ?>
    <section class="verwaltung" >
        <nav>
            <!-- <form action="#" method="post"> -->
                <button >Allergene</button>
                <button id="m1" >Speisen</button> 
                <form action="#" method="post"> 
                    <ul id="m1u">
                        <li> 
                            <button class="sub_buttons" name="seite" value="s_um_hinzu">Speise hinzufügen</button>
                            <!-- <a class="sub_a" href="?seite=speisen&punkt=hinzu">Speise hinzufügen</a> -->
                        </li>
                        <li> 
                            <button class="sub_buttons" name="seite" value="s_um_aendern">Speise ändern</button>
                            <!-- <a class="sub_a" href="?seite=speisen&punkt=hinzu">Speise hinzufügen</a> -->
                        </li>
                        <li>
                            <button class="sub_buttons" name="seite" value="s_um_loeschen">Speise löschen</button>
                            <!-- <a class="sub_a" href="?seite=speisen&punkt=hinzu">Speise hinzufügen</a> -->
                        </li>
                    </ul> 
                </form>                  
                <button id="m2" value="getraenke" name="seite">Getränke</button>
                <form action="#" method="post"> 
                    <ul id="m2u">
                        <li> <!-- der Wert Value ist aufgeschlüsselt auf "s_= speisen oder g_ = Getränke" "um_ = untermenu" und "hinzu=auswahl" des Formulars  -->
                            <button class="sub_buttons" name="seite" value="g_um_hinzu">Neue Speise hinzufügen</button>
                        </li>
                        <li> 
                            <button class="sub_buttons" name="seite" value="g_um_aendern">Speise ändern</button>
                    
                        </li>
                        <li>
                            <button class="sub_buttons" name="seite" value="g_um_loeschen">Speise löschen</button>
                        </li>
                    </ul> 
                </form>     
                <!-- <button id="m3">Alkoholfrei - Offen</button>
                <button id="m4">Heiße Getränke</button>
                <button id="m5">Spirituosen</button> -->
                <form action="#" method="post">
                    <button type="submit" name="seite" value="login" >Abmelden</button>
                </form>
            <!-- </form> -->
        </nav>
        <section>
        
    <?php
    }

    ?>


            