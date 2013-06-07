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

    protected $humans_obfuscate_email;

    public function get_humans_template()
    {
        return $this->_get('humans_template');
    }

    public function get_authors_template()
    {
        return $this->_get('authors_template');
    }

    public function get_authors_separator()
    {
        return $this->_get('authors_separator');
    }

    public function get_authors_prefix()
    {
        return $this->_get('authors_prefix');
    }

    public function get_authors_suffix()
    {
        return $this->_get('authors_suffix');
    }

    public function get_plugins_template()
    {
        return $this->_get('plugins_template');
    }

    public function get_plugins_separator()
    {
        return $this->_get('plugins_separator');
    }

    public function get_plugins_prefix()
    {
        return $this->_get('plugins_prefix');
    }

    public function get_plugins_suffix()
    {
        return $this->_get('plugins_suffix');
    }

    public function get_obfuscate_email()
    {
        return $this->_get('humans_obfuscate_email');
    }

    protected function _get($option)
    {
        if (!$this->$option) {
            $this->$option = get_option($option);
        }

        return $this->$option;
    }
}