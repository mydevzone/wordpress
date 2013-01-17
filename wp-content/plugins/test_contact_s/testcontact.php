<?php
/**
 * @package test Contact
 */
/*
Plugin Name: test Contact
Plugin URI: http://localhost
Description: My Test plugin.
Version: 0.2
Author: Sumit
Author URI: http://localhost:8010/
License: GPLv2 or later

	*/
function bot_install()
{
    global $wpdb;
    $table = $wpdb->prefix."bot_counter";
    $structure = "CREATE TABLE $table (
        id INT(9) NOT NULL AUTO_INCREMENT,
        bot_name VARCHAR(80) NOT NULL,
        bot_mark VARCHAR(20) NOT NULL,
        bot_visits INT(9) DEFAULT 0,
	UNIQUE KEY id (id)
    );";
    $wpdb->query($structure);
 
    // Populate table
    $wpdb->query("INSERT INTO $table(bot_name, bot_mark)
        VALUES('Google Bot', 'googlebot')");
    $wpdb->query("INSERT INTO $table(bot_name, bot_mark)
        VALUES('Yahoo Slurp', 'yahoo')");
}

add_action('activate_test_contact_s/testcontact.php', 'bot_install');

function testcontact()
{
//echo "in the main function";
   global $wpdb;
    $browser_name = "yahoo";
    $bots = $wpdb->get_results("SELECT * FROM ".
        $wpdb->prefix."bot_counter");
 
 
 foreach($bots as $bot)
    {
        if(eregi($bot->bot_mark, $browser_name))
        {
	    $sql ="UPDATE ".$wpdb->prefix."bot_counter 
                SET bot_visits = bot_visits+1 WHERE id = ".$bot->id;	
            $wpdb->query($sql);
	
 	
         break;
        }
    }
}

add_action('wp_footer', 'testcontact');
function bot_menu()
{
    global $wpdb;
  
    include 'bot-admin.php';
}
 
function bot_admin_actions()
{
    add_options_page("Bot Counter", "Bot Counter", 1,
"Bot-Counter", "bot_menu");
}
 
add_action('admin_menu', 'bot_admin_actions');

    function oscimp_admin1() {  
        include('test.php');  
    }  
    function oscimp_admin_actions1() {  
      add_options_page("OSCommerce Product Display", "OSCommerce Product Display", 1, "OSCommerce Product Display", "oscimp_admin1");  
	
    }  
    add_action('admin_menu', 'oscimp_admin_actions1');  


function front_option_show_sumit(){
echo "Helo World . showing it on frontend";

}

