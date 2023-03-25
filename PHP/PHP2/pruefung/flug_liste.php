<?php
include "funktionen.php";
include "kopf.php";
?>
    <h1>Alle Flüge</h1>
    <p>
        <!-- <a href="flug_anlegen.php">Neuen flug anlegen</a> -->
    </p>

    <div class='row font-weight-bold border-bottom text-center'>
      <div class='col-2'>Flugnummer</div>
      <div class='col-3'>Abflug</div>
      <div class='col-3'>Ankunft</div>
      <div class='col-2'>Startflughafen</div>
      <div class='col-2'>Zielflughafen</div>
    </div>
    
    <?php
      $datum = date('Y-m-d H:i:s');
      $sql= "SELECT * from fluege where `ankunft`>= '{$datum}' order by abflug asc ";
      $result=query($sql);
      while ($row=fetch($result)){
        echo "<div class='row text-center'>";
          echo "<div class='col-2'>{$row["flugnr"]}</div>";
          echo "<div class='col-3'>{$row["abflug"]}</div>";
          echo "<div class='col-3'>{$row["ankunft"]}</div>";
          echo "<div class='col-2'>{$row["start_flgh"]}</div>";
          echo "<div class='col-2'>{$row["ziel_flgh"]}</div>";
        echo "</div>";
      }
    ?>


    <!-- <div class='row text-center'>
      <div class='col-2'>XY 123</div>
      <div class='col-3'>12.02.2000, 12:34</div>
      <div class='col-3'>12.02.2000, 13:34</div>
      <div class='col-2'>SZG</div>
      <div class='col-2'>VIE</div>
    </div>
    <div class='row text-center'>
      <div class='col-2'>AB 456</div>
      <div class='col-3'>25.11.2044, 12:34</div>
      <div class='col-3'>26.11.2045, 11:34</div>
      <div class='col-2'>ABC</div>
      <div class='col-2'>XYZ</div>
    </div>
    <div class='row text-center'>
      <div class='col-2'>AZ 789</div>
      <div class='col-3'>11.02.2033, 05:05</div>
      <div class='col-3'>12.02.2033, 06:06</div>
      <div class='col-2'>OPQ</div>
      <div class='col-2'>RST</div>
    </div> -->
<?php
include "fuss.php";
?>
