<?php /** @var HT_Config $config */ ?>
<div class="wrap">
  <h2><?php _e('Humans dot txt settings', 'humans-dot-txt') ?></h2>  
  <?php if ($this->generated === false) : ?>
  
  <div class="error">
    <?php printf(__("It seems like you're not using a .htaccess file to generate user friendly URL:s and the root of your page (%s) isn't writable by the web server user. Please use chmod or chown to change the permissions or ownership of the directory.", 'humans-dot-txt'), ABSPATH) ?>
  </div>
  
  <?php endif; // this generated ?>
  
  <?php if ($this->htaccess === false && MULTISITE === true) : ?> 
  	
  	<div class="error">
  		<?php _e("You're using humans-dot-txt without a .htaccess file on a multisite network install. This is known to cause problems with this version of humans-dot-txt. Please add a .htaccess file for friendly URL:s if you're having more than one site currently active.", 'humans-dot-txt') ?>
	</div>
	
  <?php endif; // htaccess && multisite ?> 
  
  <form method="post" action="" id="humans-dot-txt">
    <?php wp_nonce_field('humans-dot-txt-options'); ?>
    
    <fieldset>
      <legend><label for="humans_template"><?php _e("humans.txt file template", 'humans-dot-txt') ?></label></legend>
      <div class="settings">
        <textarea id="humans_template" name="humans_template" rows="10"><?php echo esc_textarea($config->get_humans_template()) ?></textarea>
      </div>
                
      <div class="help">
        <?php _e("Available variables in the template:", 'humans-dot-txt')?>
        <ul>
          <li>%PHP_VERSION%</li>
          <li>%WP_VERSION%</li>
          <li>%ACTIVE_PLUGINS%</li>
          <li>%AUTHORS%</li>
          <li>%THEME_NAME%</li>
          <li>%THEME_DESCRIPTION%</li>
          <li>%THEME_AUTHOR%</li>
          <li>%THEME_AUTHOR_URI%</li>
          <li>%THEME_VERSION%</li>
          <li>%THEME_PARENT%</li>
          <li>%NUMBER_OF_PUBLISHED_POSTS%</li>
          <li>%NUMBER_OF_FUTURE_POSTS%</li>
          <li>%NUMBER_OF_DRAFT_POSTS%</li>
          <li>%NUMBER_OF_PENDING_POSTS%</li>
          <li>%NUMBER_OF_PRIVATE_POSTS%</li>
          <li>%NUMBER_OF_PUBLISHED_PAGES%</li>
          <li>%NUMBER_OF_FUTURE_PAGES%</li>
          <li>%NUMBER_OF_DRAFT_PAGES%</li>
          <li>%NUMBER_OF_PENDING_PAGES%</li>
          <li>%NUMBER_OF_PRIVATE_PAGES%</li>
        </ul> 
        <a href="javascript:void(0);" id="humans_suggest"><?php _e("The template tag I need isn't available!", 'humans-dot-txt') ?></a>
      </div>
    </fieldset>
    
    <fieldset id="h_plugins">
      <legend><?php _e("Plugins template", 'humans-dot-txt') ?></legend>
      
      <div class="settings">
        <label class="text" for="plugins_template"><?php _e("Template for a single plugin", 'humans-dot-txt') ?></label>
        <input type="text" id="plugins_template" name="plugins_template" value="<?php echo esc_attr($config->get_plugins_template()) ?>" />
        
        <label class="text" for="plugins_separator"><?php _e("Separator between plugins", 'humans-dot-txt') ?></label>
        <input type="text" id="plugins_separator" name="plugins_separator" value="<?php echo esc_attr($config->get_plugins_separator()) ?>" />
        
        <label class="text" for="plugins_prefix"><?php _e("Prefix for each plugin", 'humans-dot-txt') ?></label>
        <input type="text" id="plugins_prefix" name="plugins_prefix" value="<?php echo esc_attr($config->get_plugins_prefix()) ?>" />
        
        <label class="text" for="plugins_suffix"><?php _e("Suffix for each plugin", 'humans-dot-txt') ?></label>
        <input type="text" id="plugins_suffix" name="plugins_suffix" value="<?php echo esc_attr($config->get_plugins_suffix()) ?>" />
      </div>
      
      <div class="help">
        <?php _e("Available variables in this template:", 'humans-dot-txt') ?>
        <ul>
          <li>%PLUGIN_NAME%</li>
          <li>%PLUGIN_URI%</li>
          <li>%PLUGIN_VERSION%</li>
          <li>%PLUGIN_DESCRIPTION%</li>
          <li>%PLUGIN_AUTHOR%</li>
          <li>%PLUGIN_AUTHOR_URI%</li>
        </ul>
      </div>
    </fieldset>
    
    <fieldset id="h_authors">
      <legend><?php _e("Authors template", 'humans-dot-txt') ?></legend>
      <div class="settings">
        <label class="text" for="authors_template"><?php _e("Template for an author", 'humans-dot-txt') ?></label>
        <input type="text" id="authors_template" name="authors_template" value="<?php echo esc_attr($config->get_authors_template()) ?>" />
        
        <label class="text" for="authors_separator"><?php _e("Separator between authors", 'humans-dot-txt') ?></label>
        <input type="text" id="authors_separator" name="authors_separator" value="<?php echo esc_attr($config->get_authors_separator()) ?>" />
        
        <label class="text" for="authors_prefix"><?php _e("Prefix for each author", 'humans-dot-txt') ?></label>
        <input type="text" id="authors_prefix" name="authors_prefix" value="<?php echo esc_attr($config->get_authors_prefix()) ?>" />
        
        <label class="text" for="authors_suffix"><?php _e("Suffix for each author", 'humans-dot-txt') ?></label>
        <input type="text" id="authors_suffix" name="authors_suffix" value="<?php echo esc_attr($config->get_authors_suffix()) ?>" />
      </div>
      <div class="help">
        <?php _e("Available variables in this template:", 'humans-dot-txt') ?>
        <ul>
          <li>%AUTHOR_LOGIN%</li>
          <li>%AUTHOR_DISPLAY_NAME%</li>
          <li>%AUTHOR_EMAIL%</li>
        </ul>
      </div>
    </fieldset>
    
    <fieldset>
      <legend><?php _e("General settings", 'humans-dot-txt') ?></legend>
      
      <input type="checkbox" id="humans_head" name="humans_head" value="1" <?php if ($config->get_head()) echo 'checked="checked"' ?> />
      <label for="humans_head"><?php _e("Include a humans &lt;link&gt;-tag in the &lt;head&gt; section of your page?", 'humans-dot-txt') ?></label>

      <br/>      
      <input type="checkbox" id="humans_obfuscate_email" name="humans_obfuscate_email" value="1" <?php if ($config->get_obfuscate_email()) echo 'checked="checked"' ?> />
      <label for="humans_obfuscate_email"><?php _e("Obfuscate e-mail in the authors template?", 'humans-dot-txt') ?></label>
    
    <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
  </form>
</div>
<div id="humans_modal">
  <a href="javascript:void(0);" id="humans_suggestion_close"><?php _e("Close", 'humans-dot-txt'); ?></a>

  <div id="humans_suggestion_form">
  
    <p><label for="humans_suggestion_text"><?php _e("Please describe what template tag(s) you're missing!", 'humans-dot-txt') ?></label></p>
    <textarea name="humans_suggestion_text" id="humans_suggestion_text" rows="5" cols="55"></textarea>
  
    <br/>  
    <br/>
    <input type="checkbox" name="humans_suggestion_version" id="humans_suggestion_version" value="<?php echo HUMANS_DOT_TXT_VERSION ?>" />
    <label for="humans_suggestion_version"><?php _e("I'm ok with including the plugin version number with the request", 'humans-dot-txt') ?></label>
    <br/>
    <br/>
    <input type="button" name="humans_suggestion_button" id="humans_suggestion_button" value="<?php _e("Submit template tag suggestion", 'humans-dot-txt'); ?>" />
    
    <img id="humans_suggestion_loading" src="<?php echo site_url(); ?>/wp-admin/images/loading.gif" width="16" height="16" alt="<?php _e("Loading ...", 'humans-dot-txt') ?>" />
    
  </div>
  <div id="humans_suggestion_done">
    <p><?php _e("Thank you for your suggestion!", 'humans-dot-txt') ?></p>
  </div>
</div>