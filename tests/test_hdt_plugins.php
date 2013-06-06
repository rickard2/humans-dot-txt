<?php

if (!defined('ABSPATH')) {
    die();
}

class HDT_Test_Plugins extends WP_UnitTestCase
{
    function test_plugins()
    {
        $hdt = new HumansTxt();
        $hdt->getPlugins();
    }
}