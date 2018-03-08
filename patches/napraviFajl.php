<?php

$imeFajla = $_POST["imeFajla"];
$content = $_POST["sadrzaj"];

echo $imeFajla . " " . $content;
$putanja = "/var/www/html/patches/patchNotes/" . $imeFajla;
$myfile = fopen($putanja, "w") or die("Unable to open file!");
fwrite($myfile, $content);
fclose($myfile);


?>
