<?php
require("header.php");
$error = 0;
$zapytanie = "SELECT `name`, `date` FROM `chat_actived` ORDER BY `name`";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1\r\n" . $zapytanie;
die;
}
echo "0";
while ($wiersz = mysql_fetch_row($idzapytania)){
$name = $wiersz[0];
$date = $wiersz[1];
if($date + 5 >= $cdate) {
echo "\r\n" . $name;
}
}
?>