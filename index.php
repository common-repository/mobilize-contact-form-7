<?php
/*
Plugin Name: Mobilize Contact Form 7
Description: Auto update Contact Form 7 to look better on desktop and mobile devices.
Author: Plamen Marinov
Version: 1.0
Author URI: https://www.webwapstudio.com/mobilize_contact_form_7.html
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'Mobilize_CF7' ) ):
/**
* Main The Mobilize CF7 class
*/
class Mobilize_CF7 {
   public function __construct() {}
   public function set_default_options() {
      $defaults = array(
		'excluded_pages'       => '',
		'color'                => '#2196F3',
		'on_select'            => '1',
		'on_multi'             => '1',
		'on_radio'             => '1',
		'on_checkbox'          => '1',
		'on_textarea'          => '1',
		'on_color'             => '1',
		'on_date'              => '1',
		'on_datetime'          => '1',
		'on_email'             => '1',
		'on_file'              => '1',
		'on_month'             => '1',
		'on_number'            => '1',
		'on_password'          => '1',
		'on_search'            => '1',
		'on_tel'               => '1',
		'on_text'              => '1',
		'on_time'              => '1',
		'on_url'               => '1',
		'on_week'              => '1'
     );
	 return $defaults;
  }
   public function load_plugin() {
      if (get_option('ptmbg_mobilize_cf7_options')==false) {
         add_option('ptmbg_mobilize_cf7_options', $this->set_default_options());
      }
      if (is_admin()){
         add_action('admin_menu', array( $this,'menu_options'));
         add_action( 'admin_bar_menu', array( $this,'link_to_settings'),1000 );
         add_action('admin_notices', array($this,'my_admin_notice'));
         add_action('admin_init', array($this,'admin_init'));
      } else {
         add_action('wp_footer', array($this,'update_form'));
      }
   }
   
   public function admin_init() {
      register_setting('ptmbg_mobilize_cf7_options','ptmbg_mobilize_cf7_options',array( $this,'options_validate'));
   }
   public function options_validate($input) {
      return $input;
   }
   public function menu_options() {
      add_options_page('Mobilize Contact Form 7', 'Mobilize Contact Form 7', 'manage_options', 'ptmbg_mobilize_cf7', array( $this,'admin_options_page'));
  }

  public function link_to_settings( $wp_admin_bar ) {
	$args = array(
		'id'    => 'ptmbg_mobilize_cf7',
		'title' => '<div class="wp-menu-image dashicons-before dashicons-smartphone" style="display:inline-block !important"></div><span class="ab-label">Mobilize Contact Form 7</span>',
        'href'  => admin_url( 'admin.php?page=ptmbg_mobilize_cf7' ),
        'meta'  => array( 'class' => 'menupop' )
	);
	$wp_admin_bar->add_node( $args );
   }
   
   public function my_admin_notice() {
      global $pagenow;
      if ( isset($_GET['page']) ) {
         if (sanitize_text_field($_GET['page']) == 'ptmbg_mobilize_cf7') {
            return;
         }
      }
   ?>
     <div class="notice notice-info is-dismissible"><div style="padding:20px;font-size:1.2em">
     <strong><?php echo __( 'Thank you for installing "Mobilize Contact Form 7" plugin!', 'mobilize-cf7' );?></strong>
     <br><?php echo __( "Let's get started:", 'wp-recaptcha-pro' );?>
     <a href="/wp-admin/admin.php?page=ptmbg_mobilize_cf7"><?php echo __( "Settings", 'mobilize-cf7' );?></a>
     </div></div>
   <?php
   }
   
   public function admin_options_page() {
     if ( !current_user_can( 'manage_options' ) )  {
         wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
     }
     $options=get_option('ptmbg_mobilize_cf7_options');
     $fields=array();
     $fields[]='on_select';
     $fields[]='on_multi';
     $fields[]='on_radio';
     $fields[]='on_checkbox';
     $fields[]='on_textarea';
     $fields[]='on_color';
     $fields[]='on_date';
     $fields[]='on_datetime';
     $fields[]='on_email';
     $fields[]='on_file';
     $fields[]='on_month';
     $fields[]='on_number';
     $fields[]='on_password';
     $fields[]='on_search';
     $fields[]='on_tel';
     $fields[]='on_text';
     $fields[]='on_time';
     $fields[]='on_url';
     $fields[]='on_week';
     foreach ($fields as $field) {
        if (!isset($options[$field])) {
           $options[$field]=0;
        }
     }
?>
<style>
.ptmbg-settings {min-width:300px;border:1px solid #aaa;border-top:none;border-left:none}
.ptmbg-settings th, .ptmbg-settings td {border-top:1px solid #aaa;border-left:1px solid #aaa;padding:5px}
.ptmbg-settings th {text-align:left}
.radio-color, .checkbox-color, .select-color, .select-color-m {display:none}

</style>
<h2>Mobilize Contact Form 7 Settings</h2>
<form action="options.php" method="post">
<?php settings_fields('ptmbg_mobilize_cf7_options'); ?>
<h3>Select fields type to update:</h2>
<table class="table_clean" cellpadding="0" cellspacing="0">
<tr>
<td style="vertical-align:top;padding-right:30px !important" width="33%">
<input type="checkbox" id="on_select" name="ptmbg_mobilize_cf7_options[on_select]" <?php checked( true, $options['on_select'] ); ?> value="1" />
<label for="on_select">Select</label><br/>

<input type="checkbox" id="on_multi" name="ptmbg_mobilize_cf7_options[on_multi]" <?php checked( true, $options['on_multi'] ); ?> value="1" />
<label for="on_multi">Multiple Select</label><br/>

<input type="checkbox" id="on_radio" name="ptmbg_mobilize_cf7_options[on_radio]" <?php checked( true, $options['on_radio'] ); ?> value="1" />
<label for="on_radio">Radio</label><br/>

<input type="checkbox" id="on_checkbox" name="ptmbg_mobilize_cf7_options[on_checkbox]" <?php checked( true, $options['on_checkbox'] ); ?> value="1" />
<label for="on_checkbox">Checkbox</label><br/>

<input type="checkbox" id="on_textarea" name="ptmbg_mobilize_cf7_options[on_textarea]" <?php checked( true, $options['on_textarea'] ); ?> value="1" />
<label for="on_textarea">Textarea</label><br/>

<input type="checkbox" id="on_color" name="ptmbg_mobilize_cf7_options[on_color]" <?php checked( true, $options['on_color'] ); ?> value="1" />
<label for="on_color">input[type="color"]</label><br/>

<input type="checkbox" id="on_date" name="ptmbg_mobilize_cf7_options[on_date]" <?php checked( true, $options['on_date'] ); ?> value="1" />
<label for="on_date">input[type="date"]</label><br/>

</td><td style="vertical-align:top;padding-right:30px !important" width="33%">

<input type="checkbox" id="on_datetime" name="ptmbg_mobilize_cf7_options[on_datetime]" <?php checked( true, $options['on_datetime'] ); ?> value="1" />
<label for="on_datetime">input[type="datetime-local"]</label><br/>

<input type="checkbox" id="on_email" name="ptmbg_mobilize_cf7_options[on_email]" <?php checked( true, $options['on_email'] ); ?> value="1" />
<label for="on_email">input[type="email"]</label><br/>

<input type="checkbox" id="on_file" name="ptmbg_mobilize_cf7_options[on_file]" <?php checked( true, $options['on_file'] ); ?> value="1" />
<label for="on_file">input[type="file"]</label><br/>


<input type="checkbox" id="on_month" name="ptmbg_mobilize_cf7_options[on_month]" <?php checked( true, $options['on_month'] ); ?> value="1" />
<label for="on_month">input[type="month"]</label><br/>

<input type="checkbox" id="on_number" name="ptmbg_mobilize_cf7_options[on_number]" <?php checked( true, $options['on_number'] ); ?> value="1" />
<label for="on_number">input[type="number"]</label><br/>

<input type="checkbox" id="on_password" name="ptmbg_mobilize_cf7_options[on_password]" <?php checked( true, $options['on_password'] ); ?> value="1" />
<label for="on_password">input[type="password"]</label><br/>

<input type="checkbox" id="on_search" name="ptmbg_mobilize_cf7_options[on_search]" <?php checked( true, $options['on_search'] ); ?> value="1" />
<label for="on_search">input[type="search"]</label><br/>

</td><td style="vertical-align:top" width="33%">

<input type="checkbox" id="on_tel" name="ptmbg_mobilize_cf7_options[on_tel]" <?php checked( true, $options['on_tel'] ); ?> value="1" />
<label for="on_tel">input[type="tel"]</label><br/>

<input type="checkbox" id="on_text" name="ptmbg_mobilize_cf7_options[on_text]" <?php checked( true, $options['on_text'] ); ?> value="1" />
<label for="on_text">input[type="text"]</label><br/>

<input type="checkbox" id="on_time" name="ptmbg_mobilize_cf7_options[on_time]" <?php checked( true, $options['on_time'] ); ?> value="1" />
<label for="on_time">input[type="time"]</label><br/>

<input type="checkbox" id="on_url" name="ptmbg_mobilize_cf7_options[on_url]" <?php checked( true, $options['on_url'] ); ?> value="1" />
<label for="on_url">input[type="url"]</label><br/>

<input type="checkbox" id="on_week" name="ptmbg_mobilize_cf7_options[on_week]" <?php checked( true, $options['on_week'] ); ?> value="1" />
<label for="on_week">input[type="week"]</label><br/>

</td><tr></table>
<p><label for="color">Radio and Checkboxes Color</label><br>
<input id="color" type="color" name="ptmbg_mobilize_cf7_options[color]" value="<?php echo $options['color']; ?>"></p>
<p><label for="excluded-pages">Excluded pages</label><br>
<input id="excluded-pages" type="text" name="ptmbg_mobilize_cf7_options[excluded_pages]" value="<?php echo $options['excluded_pages']; ?>">
<p class="description">One or more pages IDs, separated by commas</p>
</p>
<?php submit_button(); ?>

</form>

<?php
  }

   public function update_form() {
   global $post;
   $options=get_option('ptmbg_mobilize_cf7_options');
   $excluded=trim($options['excluded_pages']);
   if ($excluded != '') {
      $pages=preg_split("/\,/",$excluded);
      $excl=array();
      foreach ($pages as $page) {
         $page=trim($page);
         $excl[$page]=1;
      }
      $id=$post->ID;
      if (isset($excl[$id])) {
         return;
      }
   }
   $color=trim($options['color']);
?>
<style>
.ptm-corner-all {
    border-radius: .3125em;
    background-clip: padding-box;
}
.ptm-shadow {
    box-shadow: 0 1px 3px rgba(0,0,0,.15);
}
.ptm-sel-btn {
    margin: 0;
    padding: .3em 0.5em;
    padding-right: 1em;
    display: block;
    position: relative;
    text-align: center;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    cursor: pointer;
    box-sizing: border-box;
    width: 100%;
    background-color: #f6f6f6;
    text-decoration: none !important;
}
.ptm-sel-btn-nr {
    border-bottom-left-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
    border-bottom: none !important;
}

.ptm-sel-btn:hover {
    background-color: #ededed;
}
.ptm-border-all {
    border: 1px solid #ddd;
}
.ptm-left {
    text-align: left;
}
.ptm-btn-icon-right {
    padding-right: 2.5em;
}
.ptm-collapsible-content {
    background-color: #ffe;
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    text-shadow: 0 1px 0 #f3f3f3;
    margin: 0;
    position: relative;
    display: none;
}
.ptm-corner-bottom {
    border-bottom-right-radius: .3125em;
    border-bottom-left-radius: .3125em;
    border: 1px solid #ddd;
}
.ptm-btn-icon-right::after {
    right: .5625em;
}

.ptm-btn-icon-left::after, .ptm-btn-icon-right::after, .ptm-btn-icon-top::after, .ptm-btn-icon-bottom::after, .ptm-btn-icon-notext::after {
    background-color: rgba(0,0,0,.3);
    background-position: center center;
    background-repeat: no-repeat;
    border-radius: 1em;
}
.ptm-btn-icon-left::after, .ptm-btn-icon-right::after, .ptm-btn-icon-top::after, .ptm-btn-icon-bottom::after, .ptm-btn-icon-notext::after {
    content: "";
    position: absolute;
    display: block;
    width: 18px !important;
    height: 18px !important;
}
.ptm-btn-icon-notext::after, .ptm-btn-icon-left::after, .ptm-btn-icon-right::after {
    top: 50%;
    margin-top: -9px;
}
.ptm-btn-icon-right::after {
    right: .5625em;
}
.ptm-btn-icon-left {
    padding-left: 2.5em !important;
}
.ptm-btn-radio, .ptm-btn-checkbox {
    margin: 0;
    margin-top: 0px;
    text-align: left;
    white-space: normal;
    display: block;
    border-bottom: 1px solid #ddd;
    cursor: pointer;
    position: relative;
    font-size: 16px;
    background-color: #ffd;
    padding:10px 0;
}

.ptm-checkbox-off::after, .ptm-radio-off::after {
    opacity: .3 !important;
}
.ptm-btn-icon-left::after {
    left: .5625em;
}

.ptm-icon-carat-d::after {background-image: url("data:image/svg+xml;charset=US-ASCII,%3C%3Fxml%20version%3D%221.0%22%20encoding%3D%22iso-8859-1%22%3F%3E%3C!DOCTYPE%20svg%20PUBLIC%20%22-%2F%2FW3C%2F%2FDTD%20SVG%201.1%2F%2FEN%22%20%22http%3A%2F%2Fwww.w3.org%2FGraphics%2FSVG%2F1.1%2FDTD%2Fsvg11.dtd%22%3E%3Csvg%20version%3D%221.1%22%20id%3D%22Layer_1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20x%3D%220px%22%20y%3D%220px%22%20%20width%3D%2214px%22%20height%3D%2214px%22%20viewBox%3D%220%200%2014%2014%22%20style%3D%22enable-background%3Anew%200%200%2014%2014%3B%22%20xml%3Aspace%3D%22preserve%22%3E%3Cpolygon%20style%3D%22fill%3A%23FFFFFF%3B%22%20points%3D%2211.949%2C3.404%207%2C8.354%202.05%2C3.404%20-0.071%2C5.525%207%2C12.596%2014.07%2C5.525%20%22%2F%3E%3C%2Fsvg%3E");
}
.ptm-icon-carat-u::after {background-image: url("data:image/svg+xml;charset=US-ASCII,%3C%3Fxml%20version%3D%221.0%22%20encoding%3D%22iso-8859-1%22%3F%3E%3C!DOCTYPE%20svg%20PUBLIC%20%22-%2F%2FW3C%2F%2FDTD%20SVG%201.1%2F%2FEN%22%20%22http%3A%2F%2Fwww.w3.org%2FGraphics%2FSVG%2F1.1%2FDTD%2Fsvg11.dtd%22%3E%3Csvg%20version%3D%221.1%22%20id%3D%22Layer_1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20x%3D%220px%22%20y%3D%220px%22%20%20width%3D%2214px%22%20height%3D%2214px%22%20viewBox%3D%220%200%2014%2014%22%20style%3D%22enable-background%3Anew%200%200%2014%2014%3B%22%20xml%3Aspace%3D%22preserve%22%3E%3Cpolygon%20style%3D%22fill%3A%23FFFFFF%3B%22%20points%3D%222.051%2C10.596%207%2C5.646%2011.95%2C10.596%2014.07%2C8.475%207%2C1.404%20-0.071%2C8.475%20%22%2F%3E%3C%2Fsvg%3E");
}
.ptm-checkbox-on::after {background-image: url("data:image/svg+xml;charset=US-ASCII,%3C%3Fxml%20version%3D%221.0%22%20encoding%3D%22iso-8859-1%22%3F%3E%3C!DOCTYPE%20svg%20PUBLIC%20%22-%2F%2FW3C%2F%2FDTD%20SVG%201.1%2F%2FEN%22%20%22http%3A%2F%2Fwww.w3.org%2FGraphics%2FSVG%2F1.1%2FDTD%2Fsvg11.dtd%22%3E%3Csvg%20version%3D%221.1%22%20id%3D%22Layer_1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20x%3D%220px%22%20y%3D%220px%22%20%20width%3D%2214px%22%20height%3D%2214px%22%20viewBox%3D%220%200%2014%2014%22%20style%3D%22enable-background%3Anew%200%200%2014%2014%3B%22%20xml%3Aspace%3D%22preserve%22%3E%3Cpolygon%20style%3D%22fill%3A%23FFFFFF%3B%22%20points%3D%2214%2C4%2011%2C1%205.003%2C6.997%203%2C5%200%2C8%204.966%2C13%204.983%2C12.982%205%2C13%20%22%2F%3E%3C%2Fsvg%3E");
}
.ptm-radio-on::after {
    background-image: none;
    background-color: #fff;
    border-width: 5px;
    border-style: solid;
    border-color: <?php echo $color;?>;
}

.ptm-pointer {cursor:pointer}

.ptm-checkbox-off::after, .ptm-checkbox-on::after {
    border-radius: .1875em;
}
.ptm-checkbox-on::after {
    background-color: <?php echo $color;?> !important;
    border-color: <?php echo $color;?> !important;
    color: #fff !important;
    text-shadow: 0 1px 0 #059 !important;
}
<?php if (isset( $options['on_color'] ) && $options['on_color'] == "1") { ?>
input[type="color"],
<?php } ?>
<?php if (isset( $options['on_date'] ) && $options['on_date'] == "1") { ?>
input[type="date"],
<?php } ?>
<?php if (isset( $options['on_datetime'] ) && $options['on_datetime'] == "1") { ?>
input[type="datetime-local"],
<?php } ?>
<?php if (isset( $options['on_email'] ) && $options['on_email'] == "1") { ?>
input[type="email"],
<?php } ?>
<?php if (isset( $options['on_file'] ) && $options['on_file'] == "1") { ?>
input[type="file"],
<?php } ?>
<?php if (isset( $options['on_month'] ) && $options['on_month'] == "1") { ?>
input[type="month"],
<?php } ?>
<?php if (isset( $options['on_number'] ) && $options['on_number'] == "1") { ?>
input[type="number"],
<?php } ?>
<?php if (isset( $options['on_password'] ) && $options['on_password'] == "1") { ?>
input[type="password"],
<?php } ?>
<?php if (isset( $options['on_search'] ) && $options['on_search'] == "1") { ?>
input[type="search"],
<?php } ?>
<?php if (isset( $options['on_tel'] ) && $options['on_tel'] == "1") { ?>
input[type="tel"],
<?php } ?>
<?php if (isset( $options['on_text'] ) && $options['on_text'] == "1") { ?>
input[type="text"],
<?php } ?>
<?php if (isset( $options['on_time'] ) && $options['on_time'] == "1") { ?>
input[type="time"],
<?php } ?>
<?php if (isset( $options['on_url'] ) && $options['on_url'] == "1") { ?>
input[type="url"],
<?php } ?>
<?php if (isset( $options['on_week'] ) && $options['on_week'] == "1") { ?>
input[type="week"],
<?php } ?>
<?php if (isset( $options['on_textarea'] ) && $options['on_textarea'] == "1") { ?>
textarea,
<?php } ?>
.ptm-other {
    box-sizing: border-box;
    width: 100%;
    border-radius: .3125em;
    box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.18) inset;
    border-width: 1px;
    border-right-width: 1px;
    border-style: solid;
    border-right-style: solid;
    border-right: 1px solid #BBB;
    border-right-color: rgb(187, 187, 187);
    border-color: #999 #BBB #BBB;
    border-image: none;
    font-size: 16px;
    margin-top: 0.5em;
    background-color: #ffd;
    min-height: 2.2em;
    padding: .4em;
    padding-right: 0.4em;
    line-height: 1.4em;
}

/* The Radio Button */
.ptm-radio-btn {
  display: inline-block;
  position: relative;
  top:6px;
  cursor: pointer;
  font-size: 18px;
  width:18px;
  height:18px;
}

/* Hide the browser's default radio button */
.ptm-radio-btn input {
  position: absolute;
  left:0;
  top:0;
  opacity: 0;
}

.ptm-radio-btn .checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 18px;
  width: 18px;
  background-color: #ccc;
  border-radius: 50%;
}

.ptm-radio-btn:hover input ~ .checkmark {
  background-color: #aaa;
}

.ptm-radio-btn input:checked ~ .checkmark {
  background-color: #fff;
  border:5px solid <?php echo $color;?>;
  background-color:#fff;
}

/* The Checkbox */
.ptm-checkbox {
  display: inline-block !important;
  position: relative !important;
  top:6px !important;
  cursor: pointer !important;
  font-size: 20px !important;
  width:20px !important;
  height:20px !important;
}

/* Hide the browser's default radio button */
.ptm-checkbox input {
  position: absolute !important;
  left:0;
  top:0;
  opacity: 0;
}

.ptm-checkbox .checkmark1 {
  position: absolute !important;
  top: 0 !important;
  left: 0 !important;
  height: 20px !important;
  width: 20px !important;
  background-color: #ccc !important;
  border-radius: 3px !important;
  font-size:16px !important;
  color: #aaa !important;
  font-weight:bold !important;
}

.ptm-checkbox .checkmark1:after {
  content: "" !important;
  position: absolute !important;
  display: none !important;
}

/* Show the checkmark when checked */
.ptm-checkbox input:checked ~ .checkmark1:after {
  display: block !important;
}

.ptm-checkbox:hover input ~ .checkmark1:after {
  display: block !important;
}

.ptm-checkbox input:disabled ~ .checkmark1:after {
  display: block !important;
}
.ptm-checkbox input:disabled ~ .checkmark1 {
  opacity:0.5 !important;
  background-color: #aaa !important;
  cursor:default !important;
}

/* Style the checkmark/indicator */
.ptm-checkbox .checkmark1:after {
  left: 6px !important;
  top: 4px !important;
  width: 8px !important;
  height: 10px !important;
  border: solid white !important;
  border-width: 0 4px 4px 0 !important;
  -webkit-transform: rotate(45deg) !important;
  -ms-transform: rotate(45deg) !important;
  transform: rotate(45deg) !important;
}

.ptm-checkbox:hover input ~ .checkmark1 {
  background-color: #aaa !important;
}

.ptm-checkbox input:checked ~ .checkmark1 {
  background-color: <?php echo $color;?> !important;
}

</style>
<script>
var wrap;
window.onload = function() {
   wrap = document.createElement('div');
   var forms=document.querySelectorAll('.wpcf7-form');
   for (var i=0;i<forms.length;i++) {
       updateForm(forms[i]);
   }
}

function hasClass(element, className) {return (' ' + element.className + ' ').indexOf(' ' + className+ ' ') > -1;}

function updateForm(form) {
   var elements = form.getElementsByTagName("select");
   for (var i=0;i<elements.length;i++) {
       if (elements[i].hasAttribute('multiple')) {
<?php if (isset( $options['on_multi'] ) && $options['on_multi'] == "1") { ?>
          updateMultiSelect(elements[i],i);
<?php } ?>
       } else {
<?php if (isset( $options['on_select'] ) && $options['on_select'] == "1") { ?>
          updateSelect(elements[i],i);
<?php } ?>
       }
   }

   elements = form.getElementsByTagName("input");
   for (var i=0;i<elements.length;i++) {
       if (elements[i].type=='radio') {
<?php if (isset( $options['on_radio'] ) && $options['on_radio'] == "1") { ?>
          updateRadio(elements[i]);
<?php } ?>
       } else if (elements[i].type=='checkbox') {
<?php if (isset( $options['on_checkbox'] ) && $options['on_checkbox'] == "1") { ?>
          updateCheckbox(elements[i],i);
<?php } ?>
       }
   }

}
function getElementAsHTML(el) {
   wrap.innerHTML='';
   wrap.appendChild(el.cloneNode(true));
   return wrap.innerHTML;
}

<?php if (isset( $options['on_select'] ) && $options['on_select'] == "1") { ?>
function updateSelect(el,id) {
   var val='';
   var html='<div id="ptm-sel-box-'+id+'" class="ptm-collapsible ptm-corner-all ptm-shadow">';
   html+='<div id="sel-'+id+'" onClick="openSelect('+"'"+id+"'"+')" ';
   html+='class="ptm-sel-btn ptm-border-all ptm-corner-all ptm-btn-icon-right ptm-left ptm-icon-carat-d">';
   if (el.value === "") {
      if (el.options[0].text=='') {
         html+='&nbsp';
      } else {
         html+=el.options[0].text;
      }
   } else {
      if (el.options[el.selectedIndex].text=='') {
         html+='&nbsp';
      } else {
         html+=el.options[el.selectedIndex].text;
      }
      val=el.options[el.selectedIndex].value;
   }
   html+='</div>';
   html+='<div id="sel-list-'+id+'" class="ptm-collapsible-content ptm-corner-bottom">';
   for (var i=0; i < el.options.length;i++) {
       html+='<div class="ptm-btn-radio ptm-btn-icon-left ';
       if (val==el.options[i].value) {
          html+='ptm-radio-on';
       } else {
          html+='ptm-radio-off';
       }
       text=el.options[i].text;
       if (text=='') {
          text='&nbsp;';
       }
       html+='" onClick="selectOption('+"'"+id+"','"+el.options[i].value+"'"+')">'+text+'</div>'
   }

   html+="</div>";
   el.insertAdjacentHTML('afterend',html);
   el.style.display='none';
}

function selectOption(id,val) {
   var sel=document.getElementById('sel-'+id).parentElement.previousElementSibling;
   var text='';
   for (var i=0;i<sel.options.length;i++) {
       if (sel.options[i].value==val) {
          sel.selectedIndex=i;
          text=sel.options[i].text;
          if (text=='') {
             text='&nbsp;';
          }
       }
   }
   document.getElementById('sel-'+id).innerHTML=text;
   var els=document.querySelectorAll('#sel-list-'+id+' .ptm-btn-radio');
   for (var i=0; i < els.length;i++) {
       if (hasClass(els[i],"ptm-radio-on")) {
          els[i].classList.remove('ptm-radio-on');
          els[i].classList.add('ptm-radio-off');
       }
       if (els[i].innerHTML==text) {
          els[i].classList.remove('ptm-radio-off');
          els[i].classList.add('ptm-radio-on');
       }
   }
   closeAllSelect();
}

<?php } ?>

function openSelect(id) {
   if (hasClass(document.getElementById('sel-'+id),'ptm-icon-carat-d')) {
      closeAllSelect();
      document.getElementById('sel-'+id).classList.remove('ptm-icon-carat-d');
      document.getElementById('sel-'+id).classList.add('ptm-icon-carat-u');
      document.getElementById('sel-'+id).classList.add('ptm-sel-btn-nr');
      document.getElementById('sel-list-'+id).style.display='block';
   } else {
      document.getElementById('sel-'+id).classList.remove('ptm-icon-carat-u');
      document.getElementById('sel-'+id).classList.remove('ptm-sel-btn-nr');
      document.getElementById('sel-'+id).classList.add('ptm-icon-carat-d');
      document.getElementById('sel-list-'+id).style.display='none';
   }
}

function closeAllSelect() {
   var els=document.querySelectorAll('.ptm-sel-btn');
   for (var i=0; i<els.length;i++) {
       if (hasClass(els[i],'ptm-icon-carat-u')) {
          els[i].classList.remove('ptm-icon-carat-u');
          els[i].classList.remove('ptm-sel-btn-nr');
          els[i].classList.add('ptm-icon-carat-d');
          els[i].nextElementSibling.style.display='none';
       }
   }
}

<?php if (isset( $options['on_multi'] ) && $options['on_multi'] == "1") { ?>

function updateMultiSelect(el,id) {
   var val='';
   var options=el.options;
   var html='<div id="ptm-sel-box-'+id+'" class="ptm-collapsible ptm-corner-all ptm-shadow">';
   html+='<div id="sel-'+id+'" onClick="openSelect('+"'"+id+"'"+')" ';
   html+='class="ptm-sel-btn ptm-border-all ptm-corner-all ptm-btn-icon-right ptm-left ptm-icon-carat-d">';
   var arrtext=[];
   for (var i=0; i < options.length;i++) {
       if (options[i].selected) {
          arrtext.push(options[i].text);
       }
   }
   var text=arrtext.join();
   if (text=='') {
      text='&nbsp;';
   }
   html+=text;
   html+='</div>';
   html+='<div id="sel-list-'+id+'" class="ptm-collapsible-content ptm-corner-bottom">';
   for (var i=0; i < options.length;i++) {
       html+='<div class="ptm-btn-checkbox ptm-btn-icon-left ';
       if (options[i].selected) {
          html+='ptm-checkbox-on';
       } else {
          html+='ptm-checkbox-off';
       }
       text=options[i].text;
       if (text=='') {
          text='&nbsp;';
       }
       html+='" onClick="selectMultipleOption('+"'"+id+"','"+i+"'"+')">'+text+'</div>'
   }

   html+="</div>";
   el.insertAdjacentHTML('afterend',html);
   el.style.display='none';
}


function selectMultipleOption(id,i) {
   var sel=document.getElementById('sel-'+id).parentElement.previousElementSibling;
   if (sel.options[i].selected) {
      sel.options[i].selected=false;
   } else {
      sel.options[i].selected=true;
   }
   document.getElementById('sel-'+id).innerHTML=text;
   var els=document.querySelectorAll('#sel-list-'+id+' .ptm-btn-checkbox');
   var arrtext=[];
   for (var i=0; i < els.length;i++) {
       if (sel.options[i].selected) {
          els[i].classList.remove('ptm-checkbox-off');
          els[i].classList.add('ptm-checkbox-on');
          arrtext.push(sel.options[i].text);
       } else {
          els[i].classList.remove('ptm-checkbox-on');
          els[i].classList.add('ptm-checkbox-off');
       }
   }
   var text=arrtext.join();
   if (text=='') {
      text='&nbsp;';
   }
   document.getElementById('sel-'+id).innerHTML=text;
}

<?php } ?>

<?php if (isset( $options['on_radio'] ) && $options['on_radio'] == "1") { ?>

function updateRadio(el) {
   var new_el = document.createElement('div');
   var html=getElementAsHTML(el) + '<span class="checkmark" onClick="this.parentNode.firstChild.click()"></span>';
   new_el.innerHTML = html;
   new_el.classList.add('ptm-radio-btn');
   el.parentNode.replaceChild(new_el,el);
}
<?php } ?>
<?php if (isset( $options['on_checkbox'] ) && $options['on_checkbox'] == "1") { ?>

function updateCheckbox(el) {
   var new_el = document.createElement('div');
   var html=getElementAsHTML(el) + '<span class="checkmark1">';
   html+='</span>';
   new_el.innerHTML = html;
   new_el.classList.add('ptm-checkbox');
   new_el.addEventListener("click", function() {
      if (this.firstChild.checked) {
         this.firstChild.checked=false;
      } else {
         this.firstChild.checked=true;
      }
   });
   el.parentNode.replaceChild(new_el,el);
}
<?php } ?>

</script>
<?php

   }
}
endif; // End If class exists check.

$mobilize_cf7=new Mobilize_CF7;
add_action( 'plugins_loaded', array( $mobilize_cf7, 'load_plugin' ) );

