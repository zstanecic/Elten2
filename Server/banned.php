<?php
require("header.php");
$error = 0;
$zapytanie = "SELECT `name`, `todate` FROM `banned`";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1\r\n" . $zapytanie;
die;
}
echo "0";
while ($wiersz = mysql_fetch_row($idzapytania)){
$name = $wiersz[0];
$date = $wiersz[1];
if($date > $cdate) {
echo "\r\n" . $name;
}
}
?>