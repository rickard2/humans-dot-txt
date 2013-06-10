<?php


class HDT_Test_Constants extends PHPUnit_Framework_TestCase
{
    public function test_version()
    {
        $this->assertTrue(defined('HUMANS_DOT_TXT_VERSION'));
    }

    public function test_dev()
    {
        $this->assertFalse(constant('HUMANS_DEV'));
    }
}