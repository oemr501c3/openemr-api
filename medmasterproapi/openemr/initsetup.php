<?php

$ignoreAuth = true;
require_once('classes.php');

$query1 = "CREATE TABLE IF NOT EXISTS `tokens` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `token` varchar(150) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `expire_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ";

$db->query($query1);
$res1 = $db->result;

$query2 = "CREATE TABLE IF NOT EXISTS `medmasterusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(300) DEFAULT NULL,
  `lastname` varchar(300) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `username` varchar(150) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `pin` int(4) DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `secret_key` varchar(96) DEFAULT NULL,
  `greeting` varchar(30) DEFAULT NULL,
  `title` varchar(64) DEFAULT 'Doctor',
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

$db->query($query2);
$res2 = $db->result;


if($res1 && $res2){
    echo "<h1>Database Updated Successfully</h1>";
}else{
    echo "<h1>Database Failed to Update</h1>";
}
?>
