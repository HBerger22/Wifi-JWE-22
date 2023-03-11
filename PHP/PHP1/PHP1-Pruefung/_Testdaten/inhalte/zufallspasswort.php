		<div id='journal'>
			<div class='wrapper'>
					<div class='row'>
						<div class='col-xs-12'>
								<h1>Zufallspasswort</h1>
						</div>
					</div>

					<div class='row'>
						<div class='col-xs-12'>
							<div>
							<br><br>
							<?php
								include("zufall.php");

								for ($i=0; $i<10;$i++){
									echo zufallspasswort()."<br>";
									// $zahl= zufallspasswort();
									// echo "Länge: ". strlen($zahl).": ".$zahl. "<br>";
								}

							?>
							</div>
							<br><br>
							
						</div>
					</div>

			</div>
		</div>
