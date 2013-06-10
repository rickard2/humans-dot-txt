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
        $config = HT_Config::get_instance();

        if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'humans-dot-txt-options')) {
            $config->set_humans_template($_POST['humans_template']);
            $config->set_plugins_template($_POST['plugins_template']);
            $config->set_plugins_separator($_POST['plugins_separator']);
            $config->set_plugins_prefix($_POST['plugins_prefix']);
            $config->set_plugins_suffix($_POST['plugins_suffix']);
            $config->set_authors_template($_POST['authors_template']);
            $config->set_authors_separator($_POST['authors_separator']);
            $config->set_authors_prefix($_POST['authors_prefix']);
            $config->set_authors_suffix($_POST['authors_suffix']);
            $config->set_obfuscate_email(
                isset($_POST['humans_obfuscate_email']) ? $_POST['humans_obfuscate_email'] : false
            );
            $config->set_head(isset($_POST['humans_head']) ? $_POST['humans_head'] : false);
        }

        require dirname(__FILE__) . '/../pages/options_page.php';
    }

    static function humans($return)
    {
        $config   = HT_Config::get_instance();
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