<?php
/*
Plugin Name: Humans dot txt 
Plugin URI: http://www.0x539.se/wordpress/humans-dot-txt
Description: Auto generate a humans.txt file for your wordpress site(s)!
Version: 1.1 beta 2
Author: Rickard Andersson
Author URI: http://www.0x539.se
License: GPLv2
*/

/**
 * The current version of the plugin
 */
define('HUMANS_DOT_TXT_VERSION', '1.1 beta 2');


/**
 * Development mode?
 */
define('HUMANS_DEV', false);


$__prefix = HUMANS_DEV ? '/www/humans-dot-txt/' : '';


require $__prefix . 'src/Config.php';
require $__prefix . 'src/Generator.php';
require $__prefix . 'src/Plugin.php';
require $__prefix . 'src/Provider.php';

function _humans_init()
{
    if (isset($_SERVER['REDIRECT_URL']) && substr($_SERVER['REDIRECT_URL'], -11, 11) == '/humans.txt') {
        HumansTxt::humans(false);
    } else {
        new HumansTxt();
    }
}

add_action('init', '_humans_init');
