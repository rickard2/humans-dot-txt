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
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');

        $res = activate_plugin('hello.php');

        $this->assertNull($res, 'Unable to activate plugin');

        $provider = new HT_Provider();
        $plugins  = $provider->get_plugins();

        deactivate_plugins('hello');

        $this->assertNotEmpty($plugins, 'get_plugins should return an array of active plugins');
        $this->assertCount(1, $plugins, 'get_plugins should only return the currently active plugins');

        $plugin = $plugins[0];

        $this->assertNotEmpty($plugin['Name'], 'Plugin data should contain Name');
        $this->assertNotEmpty($plugin['PluginURI'], 'Plugin data should contain PluginURI');
        $this->assertNotEmpty($plugin['Version'], 'Plugin data should contain Version');
        $this->assertNotEmpty($plugin['Description'], 'Plugin data should contain Description');
        $this->assertNotEmpty($plugin['Author'], 'Plugin data should contain Author');
        $this->assertNotEmpty($plugin['AuthorURI'], 'Plugin data should contain AuthorURI');

        $this->assertEquals(
            strip_tags($plugin['Description']),
            $plugin['Description'],
            'Description should not contain HTML'
        );
        $this->assertEquals(strip_tags($plugin['Author']), $plugin['Author'], 'Author should not contain HTML');

    }

    public function test_authors()
    {
        $provider = new HT_Provider();
        $authors  = $provider->get_authors();

        $this->assertNotEmpty($authors, 'get_authors should return an array of authors');
        $this->assertCount(1, $authors, 'get_authors should return an array of authors');

        $author = $authors[0];

        $this->assertNotEmpty($author->user_login, 'Author data should contain user_login');
        $this->assertNotEmpty($author->display_name, 'Author data should contain display_name');
        $this->assertNotEmpty($author->user_email, 'Author data should contain user_email');
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