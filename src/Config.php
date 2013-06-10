<?php

class HT_Config
{
    protected $humans_template;

    protected $authors_template;
    protected $authors_separator;
    protected $authors_prefix;
    protected $authors_suffix;

    protected $plugins_template;
    protected $plugins_separator;
    protected $plugins_prefix;
    protected $plugins_suffix;

    protected $humans_head;
    protected $humans_obfuscate_email;

    protected static $instance;

    private function __construct()
    {

    }

    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function get_humans_template()
    {
        return $this->_get('humans_template');
    }

    public function set_humans_template($value)
    {
        return $this->_set('humans_template', $value);
    }

    public function get_authors_template()
    {
        return $this->_get('authors_template');
    }

    public function set_authors_template($value)
    {
        return $this->_set('authors_template', $value);
    }

    public function get_authors_separator()
    {
        return $this->_get('authors_separator');
    }

    public function set_authors_separator($value)
    {
        return $this->_set('authors_separator', $value);
    }

    public function get_authors_prefix()
    {
        return $this->_get('authors_prefix');
    }

    public function set_authors_prefix($value)
    {
        return $this->_set('authors_prefix', $value);
    }

    public function get_authors_suffix()
    {
        return $this->_get('authors_suffix');
    }

    public function set_authors_suffix($value)
    {
        return $this->_set('authors_suffix', $value);
    }

    public function get_plugins_template()
    {
        return $this->_get('plugins_template');
    }

    public function set_plugins_template($value)
    {
        return $this->_set('plugins_template', $value);
    }

    public function get_plugins_separator()
    {
        return $this->_get('plugins_separator');
    }

    public function set_plugins_separator($value)
    {
        return $this->_set('plugins_separator', $value);
    }

    public function get_plugins_prefix()
    {
        return $this->_get('plugins_prefix');
    }

    public function set_plugins_prefix($value)
    {
        return $this->_set('plugins_prefix', $value);
    }

    public function get_plugins_suffix()
    {
        return $this->_get('plugins_suffix');
    }

    public function set_plugins_suffix($value)
    {
        return $this->_set('plugins_suffix', $value);
    }

    public function get_obfuscate_email()
    {
        return $this->_get('humans_obfuscate_email');
    }

    public function set_obfuscate_email($value)
    {
        return $this->_set('humans_obfuscate_email', $value);
    }

    public function get_head()
    {
        return $this->_get('humans_head');
    }

    public function set_head($value)
    {
        return $this->_set('humans_head', $value);
    }

    protected function _get($option)
    {
        if (!$this->$option) {
            $this->$option = get_option($option);
        }

        return $this->$option;
    }

    protected function _set($option, $value)
    {
        $this->$option = $value;

        return update_option($option, $value);
    }
}