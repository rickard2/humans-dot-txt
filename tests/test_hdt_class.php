<?php

if ( ! defined( 'ABSPATH' ) ) die();

class HDT_Test_Class extends WP_UnitTestCase {
	function test_class_exists() {
		$this->assertTrue( class_exists('HumansTxt') );
	}
}