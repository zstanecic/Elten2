<?php
require("header.php");
if($_GET['add'] == 1){
$postid=1;
$zapytanie = "SELECT `postid` FROM `blog_posts` WHERE `owner`='".$_GET['name']."'";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
while($wiersz = mysql_fetch_row($idzapytania)) {
if($wiersz[0]>=$postid)
$postid = $wiersz[0]+1;
}
$post = $_GET['post'];
if($_GET['buffer'] != null) {
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
$zapytanie = "INSERT INTO `blog_posts` (`id`,`owner`,`author`,`postid`,`posttype`,`name`,`post`) VALUES ('','" . $_GET['name'] . "','".$_GET['name']."'," . $postid . ",0,'".$_GET['postname']."','" . $post . "\r\n\r\n" . date("Y-m-d H:i:s") . "')";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
$cats = explode(",",$_GET['categoryid']);
$i = 0;
while($i<count($cats)) {
if($cats[$i]>0 AND $cats[$i] != NULL) {
$zapytanie = "INSERT INTO `blog_assigning` (id,owner,categoryid,postid) VALUES ('','".$_GET['name']."',".$cats[$i].",".$postid.")";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
}
$i=$i+1;
}
$zapytanie = "UPDATE `blogs` SET `lastupdate`=".time()." WHERE `owner`='".$_GET['name']."'";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
}
if($_GET['del'] == 1){
$zapytanie = "DELETE FROM `blog_posts` WHERE `postid`=" . $_GET['postid'] . " AND `owner`='".$_GET['name']."'";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
$zapytanie = "DELETE FROM `blog_assigning` WHERE `owner`='".$_GET['name']."' AND `postid`=".$_GET['postid'];
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
}
if($_GET['mod'] == 1){
$post = $_GET['post'];
if($_GET['buffer'] != null) {
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
$zapytanie = "UPDATE `blog_posts` SET `post`='" . $post . "\r\n\r\n" . date("Y-m-d H:i:s") . "' WHERE `postid`=".$_GET['postid']." AND `posttype`=0 AND `owner`='".$_GET['name']."'";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
}
if($_GET['addassigning'] == 1) {
$zapytanie = "SELECT `postid` FROM `blog_assigning` WHERE `postid`=".$_GET['postid']." AND `categoryid`=".$_GET['categoryid']." AND `owner`='".$_GET['name']."'";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
if(mysql_num_rows($idzapytania)>0) {
echo "-3";
die;
}
$zapytanie = "SELECT `postid` FROM `blog_posts` WHERE `owner`='".$_GET['name']."' AND `postid`=".$_GET['postid'];
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
if(mysql_num_row($idzapytania)==0) {
echo "-4";
die;
}
$zapytanie = "INSERT INTO `blog_assigning` (id, owner, postid, categoryid) VALUES ('','".$_GET['name']."',".$_GET['postid'].",".$_GET['categoryid'].")";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
}
if($_GET['removeassigning']==1) {
$zapytanie = "DELETE FROM `blog_assigning` WHERE `postid`=".$_GET['postid']." AND `categoryid`=".$_GET['categoryid']." AND `owner`='".$_GET['name']."'";
if($idzapytania == false) {
echo "-1";
die;
}
}
if($_GET['edit'] == 1) {
$post = $_GET['post'];
if($_GET['buffer'] != null) {
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
$zapytanie = "UPDATE `blog_posts` SET `post`='" . $post . "\r\n\r\n" . date("Y-m-d H:i:s") . "', `name`='".$_GET['postname']."' WHERE `postid`=".$_GET['postid']." AND `posttype`=0 AND `owner`='".$_GET['name']."'";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
$categories = [];
$cats = explode(",",$_GET['categoryid']);
$zapytanie = "DELETE FROM `blog_assigning` WHERE `postid`=".$_GET['postid']." AND `owner`='".$_GET['name']."'";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
$i = 0;
while($i<count($cats)) {
if($cats[$i]>0 AND $cats[$i] != NULL) {
$zapytanie = "INSERT INTO `blog_assigning` (id,owner,categoryid,postid) VALUES ('','".$_GET['name']."',".$cats[$i].",".$_GET['postid'].")";
$idzapytania = mysql_query($zapytanie);
if($idzapytania == false) {
echo "-1";
die;
}
}
$i=$i+1;
}
}
echo "0";
//Elten Server
//Copyright (2014-2016) Dawid Pieper
//All rights reserved
?>