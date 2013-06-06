<?php

if (!defined('ABSPATH')) {
    die();
}

class HDT_Test_Humans extends WP_UnitTestCase
{
    function test_humans()
    {
        $hdt = new HumansTxt();
        $hdt->humans(true);
    }
}