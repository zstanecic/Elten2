﻿<?php
require("header.php");
$date = date("d.m.Y H:i");
$zapytanie = "SELECT `id`, `sender`, `subject`, `message`, `date` FROM `messages` where receiver=" . $_GET['name'] . "'";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1\r\n" . $zapytanie;
die;
}
$ile = 0;
$text = "";
while ($wiersz = mysql_fetch_row($idzapytania)){
$ile = $ile + 1;
$text .= $wiersz[2] . "\r\n" . $wiersz[1] . "\r\n" . $wiersz[0] . "\r\n" . $wiersz[3] . "\r\n" . $wiersz[4] . "\r\nEND\r\n";
}
echo "0\r\n" . $ile . "\r\n" . $text;
//Elten Server
//Copyright (2014-2016) Dawid Pieper
//All rights reserved
?>