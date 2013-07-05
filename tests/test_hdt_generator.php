<?php

class HDT_Test_Generator extends PHPUnit_Framework_TestCase
{
    public function test_wp_version()
    {
        $generator = new HT_Generator('foo %WP_VERSION% bar', '1.2.3');
        $this->assertEquals('foo 1.2.3 bar', $generator->generate());
    }

    public function test_php_version()
    {
        $generator = new HT_Generator('foo %PHP_VERSION% bar', null, '1.2.3');
        $this->assertEquals('foo 1.2.3 bar', $generator->generate());
    }

    public function test_plugins()
    {
        $plugins_template  = 'name: %PLUGIN_NAME%, uri: %PLUGIN_URI%, version: %PLUGIN_VERSION%, description: %PLUGIN_DESCRIPTION%, author: %PLUGIN_AUTHOR%, author uri: %PLUGIN_AUTHOR_URI%';
        $plugins_separator = '; ';
        $plugins_prefix    = '(';
        $plugins_suffix    = ')';

        $plugins = array(
            array(
                'Name'        => 'name1',
                'PluginURI'   => 'uri1',
                'Version'     => 'version1',
                'Description' => 'description1',
                'Author'      => 'author1',
                'AuthorURI'   => 'author uri1',
            ),
            array(
                'Name'        => 'name2',
                'PluginURI'   => 'uri2',
                'Version'     => 'version2',
                'Description' => 'description2',
                'Author'      => 'author2',
                'AuthorURI'   => 'author uri2',
            )
        );

        $expected = 'foo (name: name1, uri: uri1, version: version1, description: description1, author: author1, author uri: author uri1); (name: name2, uri: uri2, version: version2, description: description2, author: author2, author uri: author uri2) bar';

        $generator = new HT_Generator('foo %ACTIVE_PLUGINS% bar', null, null, $plugins, $plugins_separator, $plugins_template, $plugins_prefix, $plugins_suffix);

        $this->assertEquals($expected, $generator->generate());
    }

    public function test_authors()
    {
        $authors_template  = 'login: %AUTHOR_LOGIN%, display name: %AUTHOR_DISPLAY_NAME%, email: %AUTHOR_EMAIL%';
        $authors_separator = '; ';
        $authors_prefix    = '(';
        $authors_suffix    = ')';

        $author1               = new stdClass;
        $author1->user_login   = 'author1';
        $author1->display_name = 'Author One';
        $author1->user_email   = 'author1@example.com';

        $author2               = new stdClass;
        $author2->user_login   = 'author2';
        $author2->display_name = 'Author Two';
        $author2->user_email   = 'author2@example.com';

        $authors = array($author1, $author2);

        $template = 'foo %AUTHORS% bar';
        $expected = 'foo (login: author1, display name: Author One, email: author1@example.com); (login: author2, display name: Author Two, email: author2@example.com) bar';

        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, $authors, $authors_separator, $authors_template, $authors_prefix, $authors_suffix);
        $this->assertEquals($expected, $generator->generate());
    }

    public function test_obfuscate_email()
    {
        $authors_template = '%AUTHOR_EMAIL%';

        $author1               = new stdClass;
        $author1->user_login   = 'author1';
        $author1->display_name = 'Author One';
        $author1->user_email   = 'author1@example.com';

        $authors = array($author1);

        $template = '%AUTHORS%';
        $expected = 'author1 (at) example.com';

        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, $authors, null, $authors_template, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, true);
        $this->assertEquals($expected, $generator->generate());
    }

    public function test_theme_name()
    {
        $template  = 'foo %THEME_NAME% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, 'Theme Name');

        $this->assertEquals('foo Theme Name bar', $generator->generate());
    }

    public function test_theme_description()
    {
        $template  = 'foo %THEME_DESCRIPTION% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, 'Theme Description');

        $this->assertEquals('foo Theme Description bar', $generator->generate());
    }

    public function test_theme_author_name()
    {
        $template  = 'foo %THEME_AUTHOR% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, 'Theme Author');

        $this->assertEquals('foo Theme Author bar', $generator->generate());
    }

    public function test_theme_author_uri()
    {
        $template  = 'foo %THEME_AUTHOR_URI% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, 'Theme Author Uri');

        $this->assertEquals('foo Theme Author Uri bar', $generator->generate());
    }

    public function test_theme_version()
    {
        $template  = 'foo %THEME_VERSION% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, null, 'Theme Version');

        $this->assertEquals('foo Theme Version bar', $generator->generate());
    }

    public function test_theme_parent()
    {
        $template  = 'foo %THEME_PARENT% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, null, null, 'Theme Parent');

        $this->assertEquals('foo Theme Parent bar', $generator->generate());
    }

    public function test_post_publish_count()
    {
        $template  = 'foo %NUMBER_OF_PUBLISHED_POSTS% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, null, null, null, 1337);

        $this->assertEquals('foo 1337 bar', $generator->generate());
    }

    public function test_post_future_count()
    {
        $template  = 'foo %NUMBER_OF_FUTURE_POSTS% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, null, null, null, null, 1337);

        $this->assertEquals('foo 1337 bar', $generator->generate());
    }

    public function test_post_draft_count()
    {
        $template  = 'foo %NUMBER_OF_DRAFT_POSTS% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, null, null, null, null, null, 1337);

        $this->assertEquals('foo 1337 bar', $generator->generate());
    }

    public function test_post_pending_count()
    {
        $template  = 'foo %NUMBER_OF_PENDING_POSTS% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, null, null, null, null, null, null, 1337);

        $this->assertEquals('foo 1337 bar', $generator->generate());
    }

    public function test_post_private_count()
    {
        $template  = 'foo %NUMBER_OF_PRIVATE_POSTS% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1337);

        $this->assertEquals('foo 1337 bar', $generator->generate());
    }

    public function test_page_publish_count()
    {
        $template  = 'foo %NUMBER_OF_PUBLISHED_PAGES% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1337);

        $this->assertEquals('foo 1337 bar', $generator->generate());
    }

    public function test_page_future_count()
    {
        $template  = 'foo %NUMBER_OF_FUTURE_PAGES% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1337);

        $this->assertEquals('foo 1337 bar', $generator->generate());
    }

    public function test_page_draft_count()
    {
        $template  = 'foo %NUMBER_OF_DRAFT_PAGES% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1337);

        $this->assertEquals('foo 1337 bar', $generator->generate());
    }

    public function test_page_pending_count()
    {
        $template  = 'foo %NUMBER_OF_PENDING_PAGES% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1337);

        $this->assertEquals('foo 1337 bar', $generator->generate());
    }

    public function test_page_private_count()
    {
        $template  = 'foo %NUMBER_OF_PRIVATE_PAGES% bar';
        $generator = new HT_Generator($template, null, null, array(), null, null, null, null, array(), null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 1337);

        $this->assertEquals('foo 1337 bar', $generator->generate());
    }
}