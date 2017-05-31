<?php
/**
 * Admin settings page.
 */

class PDJSettingsPage {
  /**
  * Holds the values to be used in the fields callbacks
  */
  private $options;

  /**
  * Start up
  */
  public function __construct() {
    add_action('admin_menu', array($this, 'pdj_add_setting_page' ));
    add_action('admin_init', array($this, 'pdj_page_init'));
  }

  /**
  * Add options page
  */
  public function pdj_add_setting_page() {
    // This page will be under "Settings"
    add_options_page(
      __('PDJ Theme Setting', 'pdj_theme'),
      __('Theme Setting', 'pdj_theme'),
      'manage_options',
      'pdj-setting-admin',
      array($this, 'pdj_reate_admin_page')
    );
  }

  /**
  * Options page callback
  */
  public function pdj_reate_admin_page() {
    // Set class property
    $this->options = get_option('pdj_board_settings');

    ?>
    <div class="wrap">
      <h1><?php echo __('Theme settings', 'pdj_theme') ?></h1>
      <form method="post" action="options.php">
      <?php
        // This prints out all hidden setting fields
        settings_fields('pdj_option_config');
        do_settings_sections('pdj-setting-admin');
        submit_button();
      ?>
      </form>
    </div>
    <?php
  }

  /**
  * Register and add settings
  */
  public function pdj_page_init() {
    register_setting('pdj_option_config', 'pdj_board_settings');

    // Setting ID
    add_settings_section(
      'pdj_google_api', // ID
      __('Google API', 'pdj_theme'), // Title
      array( $this ), // Callback
      'pdj-setting-admin' // Page
    );

    add_settings_field(
      'pdj_google_api_key',
      __('Google API Key', 'pdj_theme'),
      array( $this, 'pdj_form_textfield' ), // Callback
      'pdj-setting-admin', // Page
      'pdj_google_api',
      'pdj_google_api_key'
    );
  }

  /**
  * Print the Section text
  */
  public function pdj_print_section_info() {
    echo __("Use shortcode [pdj_share_this]", 'pdj_theme');
  }

  /**
  * Get the settings option array and print one of its values
  */
  public function pdj_form_checkbox($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    $checked = "";
    if($value){
      $checked = " checked='checked' ";
    }
    printf('<input type="checkbox" id="form-id-%s" name="pdj_board_settings[%s]" value="1" %s/>', $name, $name, $checked);
  }

  public function pdj_form_textfield($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    printf('<input type="text" size=60 id="form-id-%s" name="pdj_board_settings[%s]" value="%s" />', $name, $name, $value);
  }

  public function pdj_form_textarea($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    printf('<textarea cols="100%%" rows="3" type="textarea" id="form-id-%s" name="pdj_board_settings[%s]">%s</textarea>', $name, $name, $value);
  }
}
