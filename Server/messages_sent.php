﻿<?php
require("header.php");
$date = date("d.m.Y H:i");
$zapytanie = "SELECT `id`, `receiver`, `subject`, `message`, `date`, `read` FROM `messages` where sender='" . $_GET['name'] . "' and deletedfromsent=0";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1\r\n" . $zapytanie;
die;
}
$ile = 0;
$text = "";
while ($wiersz = mysql_fetch_row($idzapytania)){
$ile = $ile + 1;
if($wiersz[5] == NULL)
$wiersz[5] = "0";
$text .= $wiersz[5]."\r\n".$wiersz[2] . "\r\n" . $wiersz[1] . "\r\n" . $wiersz[0] . "\r\n" . $wiersz[3] . "\r\n" . date("Y-m-d H:i",$wiersz[4]) . "\r\nEND\r\n";
}
echo "0\r\n" . $ile . "\r\n" . $text;
?>