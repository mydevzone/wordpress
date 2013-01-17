<?php
/*
Plugin Name: Contact us 
Plugin Uri: http://localhost:8010/research/wordpress
Description: My Contact form
Version:0.2
Author:Sumit Grover
Author Uri: http://localhost:8010/research/wordpress
License: GPLv2 or later
*/

function contact_install()
{
    global $wpdb;
    $table = $wpdb->prefix."contact_me";
    $structure = "CREATE TABLE $table (
        id INT(9) NOT NULL AUTO_INCREMENT,
        name VARCHAR(80) NOT NULL,
        email VARCHAR(120) NOT NULL,
        comment text NOT NULL,
	UNIQUE KEY id (id)
    );";
    $wpdb->query($structure);
 
}

add_action('activate_contactus/contactus.php', 'contact_install');


function contactme(){
include("contactme.php");
}

add_shortcode("contactme","contactme");



?>
