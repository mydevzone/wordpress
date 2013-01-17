<?php

/*
Plugin Name: Text Replacer
Plugin Uri: http://localhost
Description: My Test plugin.
Version: 0.2
Author: Sumit Grover
Author URI: http://localhost:8010/
License: GPLv2 or later

*/


function text_add($str){

if(is_page('contact')){
$str = "";
}else{
$str .= "";
}
return $str;

}

add_filter("the_title","text_add");


