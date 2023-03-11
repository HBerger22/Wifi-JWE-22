<?php 

$nav_punkte = array(
    "home" => "startseite",
    "leistungen" => "Leistungen",
    "oeffnungszeiten" => "Öffnungszeiten",
    "kontakt" => "Kontakt"
);


echo "<nav><ul>";
foreach ($nav_punkte as $href => $nav_punkt){
    echo "<li";
    if ($seite== $href){
        echo " class='active'";
    }
    
    echo ">";
    echo "<a href='?seite=" . $href . "'>" . $nav_punkt ."</a>";
    echo "</li>";
    
    
    //  echo `<li><a href="{$href}">{$nav_punkt}</a></li>`;
};



echo "</ul></nav>";


?>
<!-- 
    <nav>
                <ul>
                    <li class="active"><a href="index.php?ziel=ind">Home</a></li>
                    <li><a href="index.php?ziel=leistungen">Leistungen</a></li>
                    <li><a href="index.php?ziel=oeffnungszeiten">Öffnungszeiten</a></li>
                    <li><a href="index.php?ziel=kontakt">Kontakt</a></li>
                </ul>
            </nav>
 -->