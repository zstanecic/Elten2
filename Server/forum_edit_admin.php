﻿<?php
require("header.php");
$zapytanie = "SELECT `name`, `tester`, `moderator`, `media_administrator`, `translator`, `developer` from `privileges`";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1\r\n" . $zapytanie;
die;
}
$suc = false;
while ($wiersz = mysql_fetch_row($idzapytania)){
if($wiersz[0] == $_GET['name']) {
$suc = true;
$name = $wiersz[0];
$tester = $wiersz[1];
$moderator = $wiersz[2];
$media_administrator = $wiersz[3];
$translator = $wiersz[4];
$developer = $wiersz[5];
}
}
if($suc == false) {
$name = $_GET['name'];
$tester = 0;
$moderator = 0;
$media_administrator = 0;
$translator = 0;
$developer = 0;
die;
}
if($moderator == 0) {
echo "-3";
die;
}
$error = 0;
$zapytanie = "SELECT `id` FROM `" . "forum_" . $_GET['forumname'] . "`";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false)
echo "-1\r\n" . $zapytanie;
else
{
$suc = false;
while ($wiersz = mysql_fetch_row($idzapytania)){
if($wiersz[0] == $_GET['threadid'])
$suc = true;
}
$error = 0;
if($suc == false) {
$zapytanie = "SELECT `name`, `id` FROM `forums`";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
$error = "-1";
$error = -1;
echo $error . "\r\n" . $zapytanie;
die;
}
while ($wiersz = mysql_fetch_row($idzapytania)){
if($wiersz[0] == $_GET['forumname']) {
$name = $wiersz[0];
$id = $wiersz[1];
}
}
if($name == null) {
echo "-1";
die;
}
$zapytanie = "CREATE TABLE forum_" . $_GET['forumname'] . "_" . $_GET['threadid'] . " (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(128), author VARCHAR(64), date VARCHAR(32), post VARCHAR(32768))";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1\r\n" . $zapytanie;
die;
}
$zapytanie = "INSERT INTO `forum_" . $_GET['forumname'] . "` (id, name, lastpostdate) VALUES ('" . $_GET['threadid'] . "','" . $_GET['threadname'] . "'," . Time() . ")";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1\r\n" . $zapytanie;
die;
}
$zapytanie = "INSERT INTO `forum_read` (id, owner, forum, thread, posts) VALUES ('','".$_GET['name']."','" . $_GET['forumname'] . "','" . $_GET['threadid'] . "'," . 1 . ")";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
}
$posts = 0;
$zapytanie = "SELECT `forum`, `thread`, `posts` FROM `forum_read` WHERE `owner`='" . $_GET['name'] . "'";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
$suc = false;
while ($wiersz = mysql_fetch_row($idzapytania)){
if($wiersz[0] == $_GET['forumname'] and $wiersz[1] == $_GET['threadid']) {
$suc = true;
$posts = $wiersz[2] + 1;
}
}
if($suc == true) {
$zapytanie = "DELETE FROM `forum_read` WHERE `owner`='" . $_GET['name'] . "' AND `forum`='" . $_GET['forumname'] . "' AND `thread`='" . $_GET['threadid'] . "'";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
else
$posts = 1;
}
$zapytanie = "INSERT INTO `forum_read` (id, owner, forum, thread, posts) VALUES ('','".$_GET['name']."','" . $_GET['forumname'] . "','" . $_GET['threadid'] . "'," . $posts . ")";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
$zapytanie = "SELECT `name`, `id` FROM `forum_" . $_GET['forumname'] . "`";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1\r\n" . $zapytanie;
die;
}
while ($wiersz = mysql_fetch_row($idzapytania)) {
if($wiersz[1] == $_GET['threadid']) {
$name = $wiersz[0];
$id = $wiersz[1];
}
}
$zapytanie = "UPDATE `forum_" . $_GET['forumname'] . "` SET `name` = '" . $name . "', `lastpostdate` = '" . time() . "' WHERE `id`=" . $id;
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1\r\n" . $zapytanie;
die;
}
if($_GET['buffer'] == 0)
$post = $_GET['post'];
else {
$zapytanie = "SELECT `id`, `data`, `owner` FROM `buffers`";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
while($wiersz = mysql_fetch_row($idzapytania)) {
if($wiersz[0] == $_GET['buffer'] and $wiersz[2] == $_GET['name'])
$post = $wiersz[1];
}
if($post == null) {
echo "-1";
die;
}
$post = str_replace("\\","\\\\",$post);
$post = str_replace("'","\\'",$post);
}
$zapytanie = "INSERT INTO `forum_" . $_GET['forumname'] . "_" . $_GET['threadid'] . "` (id, name, author, date, post) VALUES ('','" . $_GET['postname'] . "','" . $_GET['asname'] . "','" . $_GET['asdate'] . "','" . $post . "')";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1\r\n" . $zapytanie;
die;
}
echo "0";
}
//Elten Server
//Copyright (2014-2016) Dawid Pieper
//All rights reserved
?>