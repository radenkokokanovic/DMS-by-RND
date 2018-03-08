<?php

$ini_array = parse_ini_file("konf.ini");
$putanja= $ini_array['putanjaDoPatches'];
$a = scandir($putanja);
$files = array_diff($a, array('.', '..'));

$pomNiz = array();
$brojac = 0;
foreach($files as $v){
    $pomNiz[] = $v;
 }

$nizZaTabelu = array();
$niz="";
$pomVar = "";
foreach ($pomNiz as $key) {
  $pomVar = file_get_contents($putanja.$key);
  $niz = json_decode($pomVar, true);
  $nizZaTabelu[] = array(fajl=>$niz['imeFajla'],faza=>$niz['faza'],korisnik=>$niz['korisnik'],datum=>$niz['datum']);
  }

echo json_encode(array(data=>$nizZaTabelu));
?>
