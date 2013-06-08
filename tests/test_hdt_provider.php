<?php

class HDT_Test_Provider extends PHPUnit_Framework_TestCase
{
    public function test_wp_version()
    {
        $provider = new HT_Provider();
        $this->assertNotEmpty($provider->get_wp_version());
    }

    public function test_php_version()
    {
        $provider = new HT_Provider();
        $this->assertNotEmpty($provider->get_php_version());
    }

    public function test_plugins()
    {
        $provider = new HT_Provider();
        $this->assertNotNull($provider->get_plugins());
    }

    public function test_authors()
    {
        $provider = new HT_Provider();
        $this->assertNotEmpty($provider->get_authors());
    }

    public function test_theme_name()
    {
        $provider = new HT_Provider();
        $this->assertNotEmpty($provider->get_theme_name());
    }

    public function test_theme_description()
    {
        $provider = new HT_Provider();
        $this->assertNotEmpty($provider->get_theme_description());
    }

    public function test_theme_author_name()
    {
        $provider = new HT_Provider();
        $this->assertNotEmpty($provider->get_theme_author_name());
    }

    public function test_theme_author_uri()
    {
        $provider = new HT_Provider();
        $this->assertNotEmpty($provider->get_theme_author_uri());
    }

    public function test_theme_version()
    {
        $provider = new HT_Provider();
        $this->assertNotEmpty($provider->get_theme_version());
    }

    public function test_theme_parent()
    {
        $provider = new HT_Provider();
        $this->assertNotNull($provider->get_theme_parent());
    }

    public function test_post_publish_count()
    {
        $provider = new HT_Provider();
        $this->assertNotNull($provider->get_post_publish_count());
    }

    public function test_post_future_count()
    {
        $provider = new HT_Provider();
        $this->assertNotNull($provider->get_post_future_count());
    }

    public function test_post_draft_count()
    {
        $provider = new HT_Provider();
        $this->assertNotNull($provider->get_post_draft_count());
    }

    public function test_post_pending_count()
    {
        $provider = new HT_Provider();
        $this->assertNotNull($provider->get_post_pending_count());
    }

    public function test_post_private_count()
    {
        $provider = new HT_Provider();
        $this->assertNotNull($provider->get_post_private_count());
    }

    public function test_page_publish_count()
    {
        $provider = new HT_Provider();
        $this->assertNotNull($provider->get_page_publish_count());
    }

    public function test_page_future_count()
    {
        $provider = new HT_Provider();
        $this->assertNotNull($provider->get_page_publish_count());
    }

    public function test_page_draft_count()
    {
        $provider = new HT_Provider();
        $this->assertNotNull($provider->get_page_draft_count());
    }

    public function test_page_pending_count()
    {
        $provider = new HT_Provider();
        $this->assertNotNull($provider->get_page_pending_count());
    }

    public function test_page_private_count()
    {
        $provider = new HT_Provider();
        $this->assertNotNull($provider->get_page_private_count());
    }
}