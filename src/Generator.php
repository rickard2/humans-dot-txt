<?php

class Generator
{
    protected $template;
    protected $wp_version;
    protected $php_version;

    protected $plugins;
    protected $plugins_separator;
    protected $plugins_template;
    protected $plugins_prefix;
    protected $plugins_suffix;

    protected $authors;
    protected $authors_separator;
    protected $authors_template;
    protected $authors_prefix;
    protected $authors_suffix;

    protected $theme_name;
    protected $theme_description;
    protected $theme_author_name;
    protected $theme_author_uri;
    protected $theme_version;
    protected $theme_parent;

    protected $post_publish_count;
    protected $post_future_count;
    protected $post_draft_count;
    protected $post_pending_count;
    protected $post_private_count;

    protected $page_publish_count;
    protected $page_future_count;
    protected $page_draft_count;
    protected $page_pending_count;
    protected $page_private_count;

    public function __construct(
        $template = '',
        $wp_version = '',
        $php_version = '',
        $plugins = array(),
        $plugins_separator = '',
        $plugins_template = '',
        $plugins_prefix = '',
        $plugins_suffix = '',
        $authors = array(),
        $authors_separator = '',
        $authors_template = '',
        $authors_prefix = '',
        $authors_suffix = '',
        $theme_name = '',
        $theme_description = '',
        $theme_author_name = '',
        $theme_author_uri = '',
        $theme_version = '',
        $theme_parent = '',
        $post_publish_count = 0,
        $post_future_count = 0,
        $post_draft_count = 0,
        $post_pending_count = 0,
        $post_private_count = 0,
        $page_publish_count = 0,
        $page_future_count = 0,
        $page_draft_count = 0,
        $page_pending_count = 0,
        $page_private_count = 0,
        $obfuscate_email = false
    ) {
        $this->template           = $template;
        $this->wp_version         = $wp_version;
        $this->php_version        = $php_version;
        $this->plugins            = $plugins;
        $this->plugins_separator  = $plugins_separator;
        $this->plugins_template   = $plugins_template;
        $this->plugins_prefix     = $plugins_prefix;
        $this->plugins_suffix     = $plugins_suffix;
        $this->authors            = $authors;
        $this->authors_separator  = $authors_separator;
        $this->authors_template   = $authors_template;
        $this->authors_prefix     = $authors_prefix;
        $this->authors_suffix     = $authors_suffix;
        $this->theme_name         = $theme_name;
        $this->theme_description  = $theme_description;
        $this->theme_author_name  = $theme_author_name;
        $this->theme_author_uri   = $theme_author_uri;
        $this->theme_version      = $theme_version;
        $this->theme_parent       = $theme_parent;
        $this->post_publish_count = $post_publish_count;
        $this->post_future_count  = $post_future_count;
        $this->post_draft_count   = $post_draft_count;
        $this->post_pending_count = $post_pending_count;
        $this->post_private_count = $post_private_count;
        $this->page_publish_count = $page_publish_count;
        $this->page_future_count  = $page_future_count;
        $this->page_draft_count   = $page_draft_count;
        $this->page_pending_count = $page_pending_count;
        $this->page_private_count = $page_private_count;
        $this->obfuscate_email    = $obfuscate_email;
    }

    /**
     * This is the main function displaying the humans.txt contents.
     * The filter 'humans_output' will be applied before the output is sent.
     *
     * @since 1.0
     * @return bool
     */
    public function generate()
    {
        if (!$this->template) {
            return '';
        }

        $plugins = $this->generatePlugins();
        $authors = $this->generateAuthors();


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
            $this->php_version,
            $this->wp_version,
            $plugins,
            $authors,
            $this->theme_name,
            $this->theme_description,
            $this->theme_author_name,
            $this->theme_author_uri,
            $this->theme_version,
            $this->theme_parent,
            $this->post_publish_count,
            $this->post_future_count,
            $this->post_draft_count,
            $this->post_pending_count,
            $this->post_private_count,
            $this->page_publish_count,
            $this->page_future_count,
            $this->page_draft_count,
            $this->page_pending_count,
            $this->page_private_count,
        );

        return str_replace($needles, $values, $this->template);
    }

    protected function generatePlugins()
    {
        $plugins = array();

        $plugin_template_needles = array(
            '%PLUGIN_NAME%',
            '%PLUGIN_URI%',
            '%PLUGIN_VERSION%',
            '%PLUGIN_DESCRIPTION%',
            '%PLUGIN_AUTHOR%',
            '%PLUGIN_AUTHOR_URI%',
        );

        foreach ($this->plugins as $plugin) {

            $values = array(
                $plugin['Name'],
                $plugin['PluginURI'],
                $plugin['Version'],
                strip_tags($plugin['Description']),
                strip_tags($plugin['Author']),
                $plugin['AuthorURI']
            );

            $plugin = str_replace($plugin_template_needles, $values, $this->plugins_template);

            $plugins[] = sprintf('%s%s%s', $this->plugins_prefix, $plugin, $this->plugins_suffix);
        }

        return join($this->plugins_separator, $plugins);
    }

    protected function generateAuthors()
    {
        $authors = array();

        $author_template_needles = array(
            '%AUTHOR_LOGIN%',
            '%AUTHOR_DISPLAY_NAME%',
            '%AUTHOR_EMAIL%',
        );

        foreach ($this->authors as $author) {

            $values = array(
                $author->user_login,
                $author->display_name,
                $this->obfuscate_email ? str_replace('@', ' (at) ', $author->user_email) : $author->user_email
            );

            $author = str_replace($author_template_needles, $values, $this->authors_template);

            $authors[] = sprintf('%s%s%s', $this->authors_prefix, $author, $this->authors_suffix);
        }

        return join($this->authors_separator, $authors);
    }
}