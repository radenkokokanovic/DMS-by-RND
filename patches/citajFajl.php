<?php

$ini_array = parse_ini_file("konf.ini");
$putanja= $ini_array['putanjaDoPatches'];

$fajl = $_POST['nazivFajla'];
$niz="";
$pomVar = "";

$pomVar = file_get_contents($putanja.$fajl);
$niz = json_decode($pomVar, true);
$sadrzaj = $niz['sadrzaj'];

echo $sadrzaj;
?>
