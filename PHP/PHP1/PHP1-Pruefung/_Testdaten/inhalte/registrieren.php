<div class='wrapper'>
	<div class='row'>
		<div class='col-xs-12'>
			<h1>Registrierung</h1>
		</div>
	</div>
</div>


<?php

echo"<pre>";
print_r($_POST);
echo"</pre>";

$formularOk=false;
$fehlermeldungen=array();
if(!empty($_POST)){
	// Benutzernamen überprüfen
	if(empty($_POST["benutzername"])){
		$fehlermeldungen[]= "Bitte geben Sie einen Benutzernamen ein!";
	} else if(mb_strlen($_POST["benutzername"])<4){
		$fehlermeldungen[]= "Der Benutzername muss mindestens 4 Zeichen lang sein";
	}else if(!preg_match("/^[a-zA-Z0-9]+$/", $_POST["benutzername"])){
		$fehlermeldungen[]= "Der Benutzername darf nur Buchstaben und Zahlen beinhalten!";
	}
	// Passwort überprüfen
	if(empty($_POST["passwort"])){
		$fehlermeldungen[]="Bitte geben Sie ein Passwort ein!";
	} else if(mb_strlen($_POST["passwort"])<6){
		$fehlermeldungen[]= "Der Passwort muss mindestens 6 Zeichen lang sein";
	} // mind. 1 Buchstabe 1Zahl und 1Sonderzeichen
	else if(!preg_match("/(?=.*[a-zA-Z]+.*){1,}(?=.*\d+.*){1,}(?=.*[@$!%*#?&]+.*){1,}/", $_POST["passwort"])){
		$text="Das Passwort muss mind. -";
		if(!preg_match("/(?=.*[a-zA-Z]+.*){1,}/",$_POST["passwort"])){
			$text .= "1 Buchstaben -";
		}
		if(!preg_match("/(?=.*\d+.*){1,}/",$_POST["passwort"])){
			$text .= "1 Zahl - ";
		}
		if(!preg_match("/(?=.*[@$!%*#?&]+.*){1,}/",$_POST["passwort"])){
			$text .= "1 Sonderzeichen - ";
		}
		$fehlermeldungen[]= $text." enthalten sein.";
	}
	// E-Mail überprüfen
	$pattern = '/\b[\w.-]+@[\w.-]+\.[A-Za-z0-9]{2,6}\b/';
	if(empty($_POST["email"])){
		$fehlermeldungen[]="Bitte geben Sie eine E-Mail ein!";
	} else if(!preg_match($pattern, $_POST["email"])){
		$fehlermeldungen[]= "Bitte geben Sie eine gültige E-Mail Adresse ein";
	}

	// AGB überprüfen
	if(empty($_POST["agb"])){
		$fehlermeldungen[]="Bitte bestätigen Sie die AGB!";
	}

	if(empty($fehlermeldungen)){
		$formularOk=true;
	}

}

// $pattern = '/\b[\w.-]+@[\w.-]+\.[A-Za-z0-9]{2,6}\b/';
// if(!preg_match($pattern, $email))
// { $email = NULL; echo 'Email address is incorrect format'; }

echo "<div class='wrapper'>";

if( !empty($_POST)){
	if(!empty($fehlermeldungen)){
		echo "<ul>";
		foreach ($fehlermeldungen as $fehler){
			echo "<li style='color:red; margin-left: 20px'> ". $fehler ."</li>";
		}
		echo "</ul>";
	}
}


echo "</div>";

if($formularOk){
	echo "<div class='wrapper'><h3 style='color:green; margin-left: 20px'> Das Formular wurde erfolgreich abgeschickt! <br>Besten Dank für Ihre Registrierung </h3></div> ";
	$dateiname="Kontaktformularanfrage_".date("y.m.d_H.i.s").".txt";
	$inhalt="Registrierungsformular:
Benutzername: ".$_POST["benutzername"]."
Passwort: ".$_POST["passwort"]."
E-Mail: ".$_POST["email"]."
AGB akzeptiert: ".$_POST["agb"];
	
	file_put_contents("registrierungen/".$dateiname,$inhalt);

} else {
?>


<form id='register-form' method="post" action="index.php?seite=registrieren">
	<div class="wrapper">
		<div class='row'>
			<div class='col-xs-12 col-sm-12'>
				<label for='username'>Benutzername</label>
				<input type='text' id='username' name='benutzername' value="<?php
					if( !empty($_POST)){echo $_POST["benutzername"];}
				?>" />
			</div>
			<div class='col-xs-12 col-sm-12'>
				<label for='password'>Passwort</label>
				<input type='password' id='password' name='passwort' value="<?php
					if( !empty($_POST)){echo $_POST["passwort"];}
				?>"/>
			</div>
			<div class='col-xs-12 col-sm-12'>
				<label for='email'>E-Mail</label>
				<input type='text' id='email' name='email' value="<?php
					if( !empty($_POST)){echo $_POST["email"];}
				?>"/>
			</div>
			<div class='col-xs-12 col-sm-12'>
				<input type='checkbox' id='toc' name='agb' <?php
					if( !empty($_POST) && !empty($_POST["agb"])){echo "checked";}
				?>/>
				<label for='toc'>Ich akzeptiere die AGB.</label>
			</div>
			<div class='col-xs-12'>
				<input type='submit' value='Registrieren' />
			</div>
		</div>
	</div>
</form>
<?php 
}
?>
