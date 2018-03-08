<?php
$fajl = $_POST['fajl'];
$ini_array = parse_ini_file("konf.ini");
$putanja = $ini_array['putanjaDoPatches'];

unlink($putanja.$fajl)
 ?>
