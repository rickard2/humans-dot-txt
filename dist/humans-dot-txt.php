<?php
/*
Plugin Name: Humans dot txt 
Plugin URI: http://www.0x539.se/wordpress/humans-dot-txt
Description: Auto generate a humans.txt file for your wordpress site(s)!
Version: 1.0.3
Author: Rickard Andersson
Author URI: http://www.0x539.se
License: GPLv2
*/

/**
 * The current version of the plugin
 */
DEFINE('HUMANS_DOT_TXT_VERSION', '1.0.3');



add_action(
    "init",
    create_function(
        '',
        '
       if (substr($_SERVER["REDIRECT_URL"], -11, 11) == "/humans.txt")
         HumansTxt::humans(false);
       else
         $ht = new HumansTxt();'
    )
);