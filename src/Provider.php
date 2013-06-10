<?php

class HT_Provider
{
    /**
     * @var WP_Theme
     */
    protected $theme_data;
    protected $post_count_data;
    protected $page_count_data;

    public function __construct()
    {
        $this->load_post_count_data();
        $this->load_page_count_data();
    }

    public function get_wp_version()
    {
        global $wp_version;

        return $wp_version;
    }

    public function get_php_version()
    {
        return PHP_VERSION;
    }

    public function get_plugins()
    {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';

        $plugins = get_option('active_plugins', array());

        $dir = getcwd();
        chdir(WP_PLUGIN_DIR);

        $plugins = array_map(array($this, '_plugin_data_mapper'), $plugins);

        chdir($dir);

        return $plugins;
    }

    protected function _plugin_data_mapper($plugin)
    {
        $data                = get_plugin_data($plugin);
        $data['Author']      = strip_tags($data['Author']);
        $data['Description'] = strip_tags($data['Description']);

        return $data;
    }

    public function get_authors()
    {
        global $wp_version;

        if ((float)$wp_version < 3.1) {
            return get_users_of_blog();
        } else {
            return get_users();
        }
    }

    public function get_theme_name()
    {
        return $this->get_theme_data('Name');
    }

    public function get_theme_description()
    {
        return $this->get_theme_data('Description');
    }

    public function get_theme_author_name()
    {
        return $this->get_theme_data('Author');
    }

    public function get_theme_author_uri()
    {
        return $this->get_theme_data('AuthorURI');
    }

    public function get_theme_version()
    {
        return $this->get_theme_data('Version');
    }

    public function get_theme_parent()
    {
        return $this->get_theme_data('Parent Theme');
    }

    public function get_post_publish_count()
    {
        return $this->post_count_data->publish;
    }

    public function get_post_future_count()
    {
        return $this->post_count_data->future;
    }

    public function get_post_draft_count()
    {
        return $this->post_count_data->draft;
    }

    public function get_post_pending_count()
    {
        return $this->post_count_data->pending;
    }

    public function get_post_private_count()
    {
        return $this->post_count_data->private;
    }

    public function get_page_publish_count()
    {
        return $this->page_count_data->publish;
    }

    public function get_page_future_count()
    {
        return $this->page_count_data->future;
    }

    public function get_page_draft_count()
    {
        return $this->page_count_data->draft;
    }

    public function get_page_pending_count()
    {
        return $this->page_count_data->pending;
    }

    public function get_page_private_count()
    {
        return $this->page_count_data->private;
    }

    protected function get_theme_data($key)
    {
        global $wp_version;

        if (!$this->theme_data) {
            $this->load_theme_data();
        }

        $pre34KeyMap = array(
            'Name'         => 'Name',
            'Description'  => 'Description',
            'Author'       => 'Author Name',
            'AuthorUri'    => 'Author Uri',
            'Version'      => 'Version',
            'Parent Theme' => 'Parent Theme',
        );

        if ((float)$wp_version < 3.4) {
            return $this->theme_data[$pre34KeyMap[$key]];
        } else {
            return $this->theme_data->get($key);
        }
    }

    protected function load_theme_data()
    {
        global $wp_version;

        if ((float)$wp_version < 3.4) {
            $this->theme_data = get_theme(get_current_theme());
        } else {
            $this->theme_data = wp_get_theme();
        }
    }

    protected function load_post_count_data()
    {
        $this->post_count_data = wp_count_posts();
    }

    protected function load_page_count_data()
    {
        $this->page_count_data = wp_count_posts('page');
    }
}