<?php
require("header.php");
$moderator=getprivileges($_GET['name'])[1];
$dmoderator=getprivileges($_GET['searchname'])[1];
if($moderator <= 0) {
echo "-3";
die;
}
if($_GET['ban'] == 1) {
if($dmoderator <= 0) {
$q = mquery("SELECT `name` FROM `banned`");
$suc = false;
while ($r = mysql_fetch_row($q)){
if($r[0] == $_GET['searchname']) {
$suc = true;
$searchname = $r[0];
}
}
if($suc == true)
mquery("DELETE FROM `banned` WHERE name='" . $searchname . "'");
$reason=$_GET['reason'];
$info=buffer_get($_GET['info']);
mquery("INSERT INTO `banned` (name, totime, reason) VALUES ('" . $_GET['searchname'] . "'," . $_GET['totime'] . ",'".$reason."')");
mquery("INSERT INTO `messages` (`id`, `sender`, `receiver`, `subject`, `message`, `date`, deletedfromreceived, deletedfromsent) VALUES ('', 'elten', '".$_GET['searchname']."', 'You have been banned', 'You have been banned.\r\nReason: ".$reason."\r\nBanned until: ".date("Y-m-d H:i:s",$_GET['totime'])."\r\n\r\n".$info."', '" . date("d.m.Y H:i") . "',0,0)");
$q=mquery("SELECT name from privileges where administrator=1");
while($r=mysql_fetch_row($q))
mquery("INSERT INTO `messages` (`id`, `sender`, `receiver`, `subject`, `message`, `date`, deletedfromreceived, deletedfromsent) VALUES ('', 'elten', '".$r[0]."', 'User ".$_GET['searchname']." has been banned by ".$_GET['name']."', 'User ".$_GET['searchname']." has been banned by ".$_GET['name'].".\r\nReason: ".$reason."\r\nBanned until: ".date("Y-m-d H:i:s",$_GET['totime'])."\r\nRegards,\r\nElten Support', '" . date("d.m.Y H:i") . "',0,0)");
echo "0";
}
else {
echo "-3";
die;
}
}
if($_GET['unban'] == 1) {
$q = mquery("SELECT `name` FROM `banned`");
$suc = false;
while ($r = mysql_fetch_row($q)){
if($r[0] == $_GET['searchname']) {
$suc = true;
$searchname = $r[0];
}
}
if($suc == true) {
$reason=$_GET['reason'];
mquery("DELETE FROM `banned` WHERE name='" . $searchname . "'");
mquery("INSERT INTO `messages` (`id`, `sender`, `receiver`, `subject`, `message`, `date`, deletedfromreceived, deletedfromsent) VALUES ('', 'elten', '".$_GET['searchname']."', 'You have been unbanned', 'Your ban has been cancelled.\r\nReason: ".$reason."\r\n\r\nRegards,\r\nElten Support', '" . date("d.m.Y H:i") . "',0,0)");
$q=mquery("SELECT name from privileges where administrator=1");
while($r=mysql_fetch_row($q))
mquery("INSERT INTO `messages` (`id`, `sender`, `receiver`, `subject`, `message`, `date`, deletedfromreceived, deletedfromsent) VALUES ('', 'elten', '".$r[0]."', 'User ".$_GET['searchname']." has been unbanned by ".$_GET['name']."', 'The ban of user ".$_GET['searchname']." has been cancelled by ".$_GET['name'].".\r\nReason: ".$reason."\r\nRegards,\r\nElten Support', '" . date("d.m.Y H:i") . "',0,0)");
echo "0";
}
else {
echo "-4";
die;
}
}
?>