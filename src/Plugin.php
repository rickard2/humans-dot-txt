<?php

/**
 *
 * @author  Rickard Andersson <rickard@0x539.se>
 * @package Humans-dot-txt
 */
class HumansTxt
{
    /**
     * Stores the result from generateFile(); call
     */
    private $generated = null;
    private $settings = array(
        'humans_template',
        'plugins_template',
        'authors_template',
        'humans_head',
        'humans_obfuscate_email'
    );

    /**
     * When the class is loaded, all the neccessary hooks are added
     *
     * @since 1.0
     */
    function __construct()
    {

        // If .htaccess file doesn't exist, try to create the file on disk instead.
        if (!file_exists(ABSPATH . '.htaccess')) {
            $this->generated = $this->generateFile();
            $this->htaccess  = false;
        } else {
            $this->htaccess = true;
        }

        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_init', array($this, 'admin_init'));

        // If the user has chosen, wp_head will be hooked in as well
        if (get_option('humans_head')) {
            add_action('wp_head', array($this, 'wp_head'));
        }
    }

    /**
     * Try to write the humans.txt file to disk
     *
     * @since 1.0
     * @return bool
     */
    function generateFile()
    {
        if (is_writable(ABSPATH) || file_exists(ABSPATH . 'humans.txt') && is_writable(ABSPATH . 'humans.txt')) {
            $result = file_put_contents(ABSPATH . 'humans.txt', HumansTxt::humans(true));

            return $result !== false;
        } else {
            return false;
        }
    }

    /**
     * wp_head will add a link to the humans.txt file in the <head> section of the page.
     * Hooked into the 'wp_head' WP action.
     *
     * @since 1.0
     * @return void
     */
    function wp_head()
    {
        ?>
        <link href="<?php echo site_url(); ?>/humans.txt" rel="author" type="text/plain"><?php
    }

    /**
     * Adds a menu entry for configuring the plugin, hooked into the "admin_menu" WP action.
     *
     * @since 1.0
     * @return void
     */
    function admin_menu()
    {
        add_options_page(
            __('Humans dot txt', 'humans-dot-txt'),
            __('Humans dot txt', 'humans-dot-txt'),
            'manage_options',
            'humans-dot-txt',
            array($this, 'options_page')
        );
    }

    /**
     * Enqueues scripts, styles and registers settings with callback functions.
     * Hooked into the "admin_init" WP action.
     *
     * @since 1.0
     * @return void
     */
    function admin_init()
    {

        wp_enqueue_script(
            'jquery.autogrow',
            plugins_url() . '/humans-dot-txt/js/jquery.autogrow.js',
            array('jquery'),
            1,
            false
        );
        wp_enqueue_script('humans-dot-txt', plugins_url() . '/humans-dot-txt/js/main.js', array('jquery'), 1, true);

        wp_enqueue_style('humans-dot-txt', plugins_url() . '/humans-dot-txt/css/main.css');

        // To perserve heading or trailing spaces from these settings, just return the raw value since
        // WordPress does some trimming of its own. This is needed so that you could have ", " as plugins
        // or authors separator.
        register_setting(
            'humans-dot-txt',
            'plugins_separator',
            create_function('$a', 'return $_POST["plugins_separator"];')
        );
        register_setting('humans-dot-txt', 'plugins_prefix', create_function('$a', 'return $_POST["plugins_prefix"];'));
        register_setting('humans-dot-txt', 'plugins_suffix', create_function('$a', 'return $_POST["plugins_suffix"];'));

        register_setting(
            'humans-dot-txt',
            'authors_separator',
            create_function('$a', 'return $_POST["authors_separator"];')
        );
        register_setting('humans-dot-txt', 'authors_prefix', create_function('$a', 'return $_POST["authors_prefix"];'));
        register_setting('humans-dot-txt', 'authors_suffix', create_function('$a', 'return $_POST["authors_suffix"];'));

        foreach ($this->settings as $setting) {
            register_setting('humans-dot-txt', $setting);
        }

    }

    /**
     * Includes the options page template from another file. This page is displayed when the user selects the
     * menu item for this plugin in the admin menu.
     *
     * @todo  Ajax preview would be nice
     * @since 1.0
     * @return void
     */
    function options_page()
    {
        require "options_page.php";
    }

    static function humans($return)
    {
        $config   = new HT_Config();
        $provider = new HT_Provider();

        $humans_template = $config->get_humans_template();

        $plugins_template  = $config->get_plugins_template();
        $plugins_separator = $config->get_plugins_separator();
        $plugins_prefix    = $config->get_plugins_prefix();
        $plugins_suffix    = $config->get_plugins_suffix();

        $authors_template  = $config->get_authors_template();
        $authors_separator = $config->get_authors_separator();
        $authors_prefix    = $config->get_authors_prefix();
        $authors_suffix    = $config->get_authors_suffix();

        $obfuscate_email = $config->get_obfuscate_email();

        $php_version = $provider->get_php_version();
        $wp_version  = $provider->get_wp_version();

        $plugins = $provider->get_plugins();
        $authors = $provider->get_authors();

        $theme_name        = $provider->get_theme_name();
        $theme_description = $provider->get_theme_description();
        $theme_author_name = $provider->get_theme_author_name();
        $theme_author_uri  = $provider->get_theme_author_uri();
        $theme_version     = $provider->get_theme_version();
        $theme_parent      = $provider->get_theme_parent();

        $post_publish_count = $provider->get_post_publish_count();
        $post_future_count  = $provider->get_post_future_count();
        $post_draft_count   = $provider->get_post_draft_count();
        $post_pending_count = $provider->get_post_pending_count();
        $post_private_count = $provider->get_post_private_count();
        $page_publish_count = $provider->get_page_publish_count();
        $page_future_count  = $provider->get_page_future_count();
        $page_draft_count   = $provider->get_page_draft_count();
        $page_pending_count = $provider->get_page_pending_count();
        $page_private_count = $provider->get_page_private_count();

        $generator = new Generator(
            $humans_template,
            $wp_version,
            $php_version,
            $plugins,
            $plugins_separator,
            $plugins_template,
            $plugins_prefix,
            $plugins_suffix,
            $authors,
            $authors_separator,
            $authors_template,
            $authors_prefix,
            $authors_suffix,
            $theme_name,
            $theme_description,
            $theme_author_name,
            $theme_author_uri,
            $theme_version,
            $theme_parent,
            $post_publish_count,
            $post_future_count,
            $post_draft_count,
            $post_pending_count,
            $post_private_count,
            $page_publish_count,
            $page_future_count,
            $page_draft_count,
            $page_pending_count,
            $page_private_count,
            $obfuscate_email
        );

        $result = $generator->generate();
        $result = apply_filters('humans_output', $result);

        if (!$return) {

            header("Content-type: text/plain; charset=utf-8");
            echo html_entity_decode($result);
            exit;
        } else {
            return $result;
        }
    }
}