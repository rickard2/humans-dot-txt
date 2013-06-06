<?php
/*
Plugin Name: Humans dot txt 
Plugin URI: http://www.0x539.se/wordpress/humans-dot-txt
Description: Auto generate a humans.txt file for your wordpress site(s)!
Version: 1.0.3
Author: Rickard Andersson
Author URI: http://www.0x539.se
License: GPLv2
*/

/**
 * Humans-dot-txt takes care of generating your humans.txt file!
 *
 * @author  Rickard Andersson <rickard@0x539.se>
 * @package Humans-dot-txt
 * @todo    Translation
 * @todo    Default template
 */

/**
 * The current version of the plugin
 */
DEFINE('HUMANS_DOT_TXT_VERSION', '1.0.3');

/**
 * This is the main class that does all the magic
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
     * @return void
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
        <link href="<?php echo site_url(); ?>/humans.txt" rel="author" type="text/plain">
    <?php
    }

    /**
     * Adds a menu entry for configurating the plugin, hooked into the "admin_menu" WP action.
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

    /**
     * Get an array of currently enabled plugins
     *
     * @since 1.0
     * @return array
     * @uses  ABSPATH
     * @uses  WP_PLUGIN_DIR
     */
    static function getPlugins()
    {

        $plugins_template = get_option('plugins_template');

        if (strlen($plugins_template) == 0) {
            return array();
        }

        $plugins_prefix = get_option('plugins_prefix');
        $plugins_suffix = get_option('plugins_suffix');

        require ABSPATH . 'wp-admin/includes/plugin.php';

        $dir = getcwd();
        chdir(WP_PLUGIN_DIR);

        $needles = array(
            '%PLUGIN_NAME%',
            '%PLUGIN_URI%',
            '%PLUGIN_VERSION%',
            '%PLUGIN_DESCRIPTION%',
            '%PLUGIN_AUTHOR%',
            '%PLUGIN_AUTHOR_URI%',
        );

        foreach (get_option('active_plugins', array()) as $plugin) {
            $plugin_data = get_plugin_data($plugin);

            $values = array(
                $plugin_data['Name'],
                $plugin_data['PluginUri'],
                $plugin_data['Version'],
                strip_tags($plugin_data['Description']),
                strip_tags($plugin_data['Author']),
                $plugin_data['AuthorUri']
            );

            $plugin_string = "";

            if (strlen($plugins_prefix) > 0) {
                $plugin_string = $plugins_prefix;
            }

            $plugin_string .= str_replace($needles, $values, $plugins_template);

            if (strlen($plugins_suffix) > 0) {
                $plugin_string .= $plugins_suffix;
            }

            $plugins[] = $plugin_string;
        }

        chdir($dir);

        return is_array($plugins) ? $plugins : array();
    }

    /**
     * Get an array of authors on this blog
     *
     * @return array
     * @since 1.0
     */
    static function getAuthors()
    {

        $authors_template = get_option('authors_template');

        if (strlen($authors_template) == 0) {
            return array();
        }

        $authors_prefix = get_option('authors_prefix');
        $authors_suffix = get_option('authors_suffix');

        $needles = array(
            '%AUTHOR_LOGIN%',
            '%AUTHOR_DISPLAY_NAME%',
            '%AUTHOR_EMAIL%'
        );

        $obfuscate_email = get_option('humans_obfuscate_email');

        foreach (get_users_of_blog() as $author) {

            $values = array(
                $author->user_login,
                $author->display_name,
                $obfuscate_email == 1 ? str_replace('@', ' (at) ', $author->user_email) : $author->user_email
            );

            $author_string = "";

            if (strlen($authors_prefix) > 0) {
                $author_string = $authors_prefix;
            }

            $author_string .= str_replace($needles, $values, $authors_template);

            if (strlen($authors_suffix) > 0) {
                $author_string .= $authors_suffix;
            }

            $authors[] = $author_string;
        }

        return is_array($authors) ? $authors : array();
    }

    /**
     * This is the main function displaying the humans.txt contents.
     * The filter 'humans_output' will be applied before the output is sent.
     *
     * @since 1.0
     * @return bool
     * @uses  $wp_version
     * @uses  PHP_VERSION
     */
    static function humans($return)
    {

        global $wp_version;

        $humans_template = get_option('humans_template');

        if (strlen($humans_template) == 0) {
            return false;
        }

        // Get plugins data
        $plugins           = HumansTxt::getPlugins();
        $plugins_separator = get_option('plugins_separator');

        // Get authors data
        $authors          = HumansTxt::getAuthors();
        $authors_template = get_option('authors_template');

        // Get theme data
        $theme_data = get_theme(get_current_theme());

        // Get post and pages data
        $count_posts          = wp_count_posts();
        $count_pages->publish = count(get_pages());
        $count_pages->future  = count(get_pages(array('post_status' => 'future')));
        $count_pages->draft   = count(get_pages(array('post_status' => 'draft')));
        $count_pages->pending = count(get_pages(array('post_status' => 'pending')));
        $count_pages->private = count(get_pages(array('post_status' => 'private')));

        // Array containing all template tags
        $needles = array(
            '%PHP_VERSION%',
            '%WP_VERSION%',
            '%ACTIVE_PLUGINS%',
            '%AUTHORS%',
            '%THEME_NAME%',
            '%THEME_DESCRIPTION%',
            '%THEME_AUTHOR%',
            '%THEME_AUTHOR_URI%',
            '%THEME_VERSION%',
            '%THEME_PARENT%',
            '%NUMBER_OF_PUBLISHED_POSTS%',
            '%NUMBER_OF_FUTURE_POSTS%',
            '%NUMBER_OF_DRAFT_POSTS%',
            '%NUMBER_OF_PENDING_POSTS%',
            '%NUMBER_OF_PRIVATE_POSTS%',
            '%NUMBER_OF_PUBLISHED_PAGES%',
            '%NUMBER_OF_FUTURE_PAGES%',
            '%NUMBER_OF_DRAFT_PAGES%',
            '%NUMBER_OF_PENDING_PAGES%',
            '%NUMBER_OF_PRIVATE_PAGES%',
        );

        // Corresponding value to replace them with
        $values = array(
            PHP_VERSION,
            $wp_version,
            implode($plugins_separator, $plugins),
            implode($authors_separator, $authors),
            $theme_data['Name'],
            $theme_data['Description'],
            $theme_data['Author Name'],
            $theme_data['Author Uri'],
            $theme_data['Version'],
            $theme_data['Parent Theme'],
            $count_posts->publish,
            $count_posts->future,
            $count_posts->draft,
            $count_posts->pending,
            $count_posts->private,
            $count_pages->publish,
            $count_pages->future,
            $count_pages->draft,
            $count_pages->pending,
            $count_pages->private,
        );

        $output = str_replace($needles, $values, $humans_template);
        $output = apply_filters('humans_output', $output);

        if (!$return) {

            header("Content-type: text/plain; charset=utf-8");
            echo html_entity_decode($output);
            exit;
        } else {
            return $output;
        }
    }
}

add_action(
    "init",
    create_function(
        '',
        '
       if (substr($_SERVER["REDIRECT_URL"], -11, 11) == "/humans.txt")
         HumansTxt::humans(false);
       else
         $ht = new HumansTxt();'
    )
);