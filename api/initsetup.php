<?php

$ignoreAuth = true;
require_once('classes.php');

$query1 = "CREATE TABLE IF NOT EXISTS `api_tokens` (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `user_id` bigint(20) DEFAULT NULL,
            `token` varchar(150) DEFAULT NULL,
            `device_token` varchar(200) NOT NULL,
            `create_datetime` datetime DEFAULT NULL,
            `expire_datetime` datetime DEFAULT NULL,
            `message_badge` int(5) NOT NULL,
            `appointment_badge` int(5) NOT NULL,
            `labreports_badge` int(5) NOT NULL,
            `prescription_badge` int(5) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

$db->query($query1);
$res1 = $db->result;

$query2 = "ALTER TABLE `users` ADD `create_date` DATE NOT NULL ,
            ADD `secret_key` VARCHAR( 100 ) NULL ,
            ADD `ip_address` VARCHAR( 20 ) NULL ,
            ADD `country_code` VARCHAR( 10 ) NULL ,
            ADD `country_name` INT( 50 ) NULL ,
            ADD `latidute` VARCHAR( 20 ) NULL ,
            ADD `longitude` VARCHAR( 20 ) NULL ,
            ADD `time_zone` VARCHAR( 10 ) NULL";

$db->query($query2);
$res2 = $db->result;


if ($res1 && $res2) {
    echo "<h1>Database Updated Successfully</h1>";
} else {
    echo "<h1>Database Failed to Update</h1>";
}
?>
