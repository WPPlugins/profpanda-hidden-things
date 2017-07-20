<?php
/*
Plugin Name: ProfPanda Hidden Things
Plugin URI:  http://profpanda.com.br/profpanda_hidden_things
Description: Este é um plugin para ocultar elementos do admin no wordpress
Version:     1.0.3
Author:      Anderson Profpanda
Author URI:  http://profpanda.com.br
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: profpanda
Domain Path: /languages

ProfPanda Hidden Things is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
ProfPanda Hidden Things is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with ProfPanda Hidden Things. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

/* LOADING TEXTDOMAIN */
add_action( 'plugins_loaded', 'pht_load_plugin_textdomain' );
 
function pht_load_plugin_textdomain() {
    load_plugin_textdomain( 'profpanda', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/* ADDING STYLE AND SCRIPTS THINGS */
function load_custom_wp_admin_style($hook) {
        // Load only on ?page=mypluginname
        if($hook != 'settings_page_pht') {
                return;
        }
        wp_enqueue_style( 'pht-style', plugins_url('/css/pht-style.css', __FILE__) );
        wp_enqueue_script('pht-script', plugins_url('/js/pht-script.js', __FILE__),array('jquery'),'1.11.0', true);
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

/* ACTIVATING PLUGIN */
function profpanda_hidden_things_install()
{
        
}
register_activation_hook( __FILE__, 'profpanda_hidden_things_install' );


/* DEACTIVATING PLUGIN */
function profpanda_hidden_things_deactivation()
{
    function pht_remove_options_page()
	{
    	remove_submenu_page('options-general.php','profpanda_hidden_things');
	}
	add_action('admin_menu', 'pht_remove_options_page', 99);
}
register_deactivation_hook( __FILE__, 'profpanda_hidden_things_deactivation' );

/**
 * @internal    never define functions inside callbacks.
 *              these functions could be run multiple times; this would result in a fatal error.
 */
 
/**
 * custom option and settings
 */
function pht_settings_init()
{

    // register a new setting for "pht" page
    register_setting('pht', 'pht_options');
 
    // register a new section in the "pht" page
    add_settings_section(
        'pht_section_woocommerce',
        __('<span class="woo">Woocommerce</span>', 'profpanda'),
        'pht_section_woocommerce_cb',
        'pht'
    );

    add_settings_section(
        'pht_section_login',
        __('<span class="loginscreen">Login Screen</span>', 'profpanda'),
        'pht_section_login_cb',
        'pht'
    );

    add_settings_section(
        'pht_section_dashboard',
        __('<span class="dash">Dashboard</span>', 'profpanda'),
        'pht_section_dashboard_cb',
        'pht'
    );
 
    // register a new field in the "pht_section_woocommerce" section, inside the "pht" page
    add_settings_field(
        'pht_field_price',
        __('Price', 'profpanda'),
        'pht_field_price_cb',
        'pht',
        'pht_section_woocommerce',
        [
            'label_for'         => 'pht_field_price',
            'class'             => 'pht_row price',
            'pht_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'pht_field_buyb', 
        __('Buy Button', 'profpanda'),
        'pht_field_buyb_cb',
        'pht',
        'pht_section_woocommerce',
        [
            'label_for'         => 'pht_field_buyb',
            'class'             => 'pht_row buyb',
            'pht_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'pht_field_login_logo', 
        __('Login Logo', 'profpanda'),
        'pht_field_login_logo_cb',
        'pht',
        'pht_section_login',
        [
            'label_for'         => 'pht_field_login_logo',
            'class'             => 'pht_row logo',
            'pht_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'pht_field_footer_text', 
        __('Admin Footer Text', 'profpanda'),
        'pht_field_footer_text_cb',
        'pht',
        'pht_section_login',
        [
            'label_for'         => 'pht_field_footer_text',
            'class'             => 'pht_row footext',
            'pht_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'pht_field_dash_plugins', 
        __('Dashboard Plugins', 'profpanda'),
        'pht_field_dash_plugins_cb',
        'pht',
        'pht_section_dashboard',
        [
            'label_for'         => 'pht_field_dash_plugins',
            'class'             => 'pht_row dplugins',
            'pht_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'pht_field_dash_recent_comments', 
        __('Dashboard Recent Comments', 'profpanda'),
        'pht_field_dash_recent_comments_cb',
        'pht',
        'pht_section_dashboard',
        [
            'label_for'         => 'pht_field_dash_recent_comments',
            'class'             => 'pht_row dcomments',
            'pht_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'pht_field_dash_primary', 
        __('Dashboard Primary Area', 'profpanda'),
        'pht_field_dash_primary_cb',
        'pht',
        'pht_section_dashboard',
        [
            'label_for'         => 'pht_field_dash_primary',
            'class'             => 'pht_row dprim',
            'pht_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'pht_field_dash_secondary', 
        __('Dashboard Secondary Area', 'profpanda'),
        'pht_field_dash_secondary_cb',
        'pht',
        'pht_section_dashboard',
        [
            'label_for'         => 'pht_field_dash_secondary',
            'class'             => 'pht_row dsec',
            'pht_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'pht_field_dash_incoming_links', 
        __('Dashboard Incoming Links', 'profpanda'),
        'pht_field_dash_incoming_links_cb',
        'pht',
        'pht_section_dashboard',
        [
            'label_for'         => 'pht_field_dash_incoming_links',
            'class'             => 'pht_row dinc',
            'pht_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'pht_field_dash_right_now', 
        __('Dashboard Right Now', 'profpanda'),
        'pht_field_dash_right_now_cb',
        'pht',
        'pht_section_dashboard',
        [
            'label_for'         => 'pht_field_dash_right_now',
            'class'             => 'pht_row drightn',
            'pht_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'pht_field_dash_quick_press', 
        __('Dashboard Quick Press', 'profpanda'),
        'pht_field_dash_quick_press_cb',
        'pht',
        'pht_section_dashboard',
        [
            'label_for'         => 'pht_field_dash_quick_press',
            'class'             => 'pht_row dquick',
            'pht_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'pht_field_dash_activity', 
        __('Dashboard Activity', 'profpanda'),
        'pht_field_dash_activity_cb',
        'pht',
        'pht_section_dashboard',
        [
            'label_for'         => 'pht_field_dash_activity',
            'class'             => 'pht_row dactivity',
            'pht_custom_data' => 'custom',
        ]
    );

}
 
/**
 * register our pht_settings_init to the admin_init action hook
 */
add_action('admin_init', 'pht_settings_init');
 
/**
 * custom option and settings:
 * callback functions
 */
 
// developers section cb
 
// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function pht_section_woocommerce_cb($args)
{
    ?>
     <p id="<?= esc_attr($args['id']); ?>"><?= esc_html__('Hide price and/or buy button when user are not logged.', 'profpanda'); ?></p>
    <?php
}

function pht_section_login_cb($args)
{
    ?>
    <p id="<?= esc_attr($args['id']); ?>"><?= esc_html__('Change options in Login screen.', 'profpanda'); ?></p>
    <?php
}

function pht_section_dashboard_cb($args)
{
    ?>
    <p id="<?= esc_attr($args['id']); ?>"><?= esc_html__('Hide elements in Dashboard.', 'profpanda'); ?></p>
    <?php
}
 
// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.
function pht_field_price_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('pht_options');
    // output the field
    ?>
    <select id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]"
    >
        <option value="yes" <?= isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'yes', false)) : (''); ?>>
            <?= esc_html__('Hide', 'profpanda'); ?>
        </option>
        <option value="no" <?= isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'no', false)) : (''); ?>>
            <?= esc_html__('Show', 'profpanda'); ?>
        </option>
    </select>
    <p class="description">
        <?= esc_html__('Hide the product price if user are not logged. ', 'profpanda'); ?>
    </p>
    <?php
}

function pht_field_buyb_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('pht_options');
    // output the field
    ?>
    <select id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]"
    >
        <option value="yes" <?= isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'yes', false)) : (''); ?>>
            <?= esc_html__('Hide', 'profpanda'); ?>
        </option>
        <option value="no" <?= isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'no', false)) : (''); ?>>
            <?= esc_html__('Show', 'profpanda'); ?>
        </option>
    </select>
    <p class="description">
        <?= esc_html__('Hide the buy button if user are not logged. ', 'profpanda'); ?>
    </p>
    <?php
}

function pht_field_login_logo_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('pht_options');
    // output the field
    ?>
    <input type="text" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]" 
            size="40" value="<?php echo $options['pht_field_login_logo']; ?>" />
        
    <p class="description">
        <?= esc_html__('Enter the Logo URL you want to use in the Login screen.', 'profpanda'); ?>
    </p>
    <?php
}

function pht_field_footer_text_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('pht_options');
    // output the field
    ?>
    <input type="text" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]" 
            size="40" value="<?php echo $options['pht_field_footer_text']; ?>"/>

    <p class="description">
        <?= esc_html__('Enter the text to be show in the admin footer.', 'profpanda'); ?>
    </p>
    <?php
}

function pht_field_dash_plugins_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('pht_options');
    // output the field
    
    if (isset($options['pht_field_dash_plugins']) and $options['pht_field_dash_plugins']=="on"){
    ?>	
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]" checked="checked">
    <?php
    } else {
    ?>
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]">
    <?php
	}
    ?>
    <p class="description">
        <?= esc_html__('Hide the Dasboard Plugin area. ', 'profpanda'); ?>
    </p>
    <?php
}

function pht_field_dash_recent_comments_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('pht_options');
    // output the field
    
    if (isset($options['pht_field_dash_recent_comments']) and $options['pht_field_dash_recent_comments']=="on"){
    ?>	
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]" checked="checked">
    <?php
    } else {
    ?>
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]">
    <?php
	}
    ?>
    <p class="description">
        <?= esc_html__('Hide the Dasboard Recent Comments area. ', 'profpanda'); ?>
    </p>
    <?php
}

function pht_field_dash_primary_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('pht_options');
    // output the field
    
    if (isset($options['pht_field_dash_primary']) and $options['pht_field_dash_primary']=="on"){
    ?>	
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]" checked="checked">
    <?php
    } else {
    ?>
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]">
    <?php
	}
    ?>
    <p class="description">
        <?= esc_html__('Hide the Dasboard Primary area. ', 'profpanda'); ?>
    </p>
    <?php
}

function pht_field_dash_secondary_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('pht_options');
    // output the field
    
    if (isset($options['pht_field_dash_secondary']) and $options['pht_field_dash_secondary']=="on"){
    ?>	
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]" checked="checked">
    <?php
    } else {
    ?>
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]">
    <?php
	}
    ?>
    <p class="description">
        <?= esc_html__('Hide the Dasboard Secondary area. ', 'profpanda'); ?>
    </p>
    <?php
}

function pht_field_dash_incoming_links_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('pht_options');
    // output the field
    
    if (isset($options['pht_field_dash_incoming_links']) and $options['pht_field_dash_incoming_links']=="on"){
    ?>	
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]" checked="checked">
    <?php
    } else {
    ?>
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]">
    <?php
	}
    ?>
    <p class="description">
        <?= esc_html__('Hide the Dasboard Incoming Links area. ', 'profpanda'); ?>
    </p>
    <?php
}

function pht_field_dash_right_now_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('pht_options');
    // output the field
    
    if (isset($options['pht_field_dash_right_now']) and $options['pht_field_dash_right_now']=="on"){
    ?>	
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]" checked="checked">
    <?php
    } else {
    ?>
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]">
    <?php
	}
    ?>
    <p class="description">
        <?= esc_html__('Hide the Dasboard Right Now area. ', 'profpanda'); ?>
    </p>
    <?php
}

function pht_field_dash_quick_press_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('pht_options');
    // output the field
    
    if (isset($options['pht_field_dash_quick_press']) and $options['pht_field_dash_quick_press']=="on"){
    ?>	
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]" checked="checked">
    <?php
    } else {
    ?>
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]">
    <?php
	}
    ?>
    <p class="description">
        <?= esc_html__('Hide the Dasboard Quick Press area. ', 'profpanda'); ?>
    </p>
    <?php
}

function pht_field_dash_activity_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('pht_options');
    // output the field
    
    if (isset($options['pht_field_dash_activity']) and $options['pht_field_dash_activity']=="on"){
    ?>	
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]" checked="checked">
    <?php
    } else {
    ?>
    <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
            data-custom="<?= esc_attr($args['pht_custom_data']); ?>"
            name="pht_options[<?= esc_attr($args['label_for']); ?>]">
    <?php
	}
    ?>
    <p class="description">
        <?= esc_html__('Hide the Dasboard Activity area. ', 'profpanda'); ?>
    </p>
    <?php
}
 
/**
 * top level menu
 */
function pht_options_page()
{
    // add top level menu page
    add_submenu_page(
    	'options-general.php',
        'ProfPanda Hidden Things',
        'ProfPanda Hidden Things',
        'manage_options',
        'pht',
        'pht_options_page_html'
    );
}
 
/**
 * register our pht_options_page to the admin_menu action hook
 */
add_action('admin_menu', 'pht_options_page');
 
/**
 * sub menu:
 * callback functions
 */
function pht_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
 
    // add error/update messages
 
    // check if the user have submitted the settings
    // wordpress will add the "settings-updated" $_GET parameter to the url
    if (isset($_GET['settings-updated'])) {
        // add settings saved message with the class of "updated"
       // add_settings_error('pht_messages', 'pht_message', __('Settings Saved', 'profpanda'), 'updated');
    }
 
    // show error/update messages
    settings_errors('pht_messages');
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "pht"
            settings_fields('pht');
            // output setting sections and their fields
            // (sections are registered for "pht", each field is registered to a specific section)
            do_settings_sections('pht');
            // output save settings button
            submit_button(__('Save Settings','profpanda'));
            ?>
        </form>
    </div>
    <?php
}

 /*
 * Function - Show the price only after logging
 */
add_filter('woocommerce_get_price_html','show_price_logged');
function show_price_logged($price){
	$priceoption = get_option('pht_options');
	if ($priceoption['pht_field_price']=='yes'){
		if( is_user_logged_in() ){ 
	   		return $price;
		} else {
			return '';
		}
	} else {
		return $price;
	}
}

/*
 * Function - Remove Loop/Single Button Add to Cart
 */
add_action('init','remove_add_to_cart');
function remove_add_to_cart(){
    $priceoption = get_option('pht_options');
	if ($priceoption['pht_field_buyb']=='yes'){
	    if(is_user_logged_in()){}else{
	        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	    }
	} else {
		/* DON'T DO NOTHING */
	}
}

// Apply the new logo to login screen
function pht_new_logo_login()
{
	$logooption_url = get_option('pht_options');
    echo '<style  type="text/css"> h1 a {  background-image:url(' . 
    $logooption_url['pht_field_login_logo']
    . ' )  !important; 
        -webkit-background-size: 100% 100% !important;
        width: auto !important; } </style>';
}
add_action('login_head',  'pht_new_logo_login');

function pht_login_url()
{
    return home_url();
}
add_filter('login_headerurl', 'pht_login_url'); 

function pht_login_title()
{
    return get_option('blogname');
}
add_filter('login_headertitle', 'pht_login_title');

function pht_admin_footer ()
{
	$footeroption_text = get_option('pht_options');
	if (isset($footeroption_text['pht_field_footer_text'])){
    	echo '<span id="footer-thankyou">'. 
    	$footeroption_text['pht_field_footer_text'] 
    	.'</span>';
    } else {
    	echo '<span id="footer-thankyou">Obrigado por criar com <a href="https://br.wordpress.org/">WordPress</a>.</span>';
    }
}
add_filter('admin_footer_text', 'pht_admin_footer');

function pht_del_secoes_painel(){
  	global$wp_meta_boxes;
  
  	$options = get_option('pht_options');
  
  	if (isset($options['pht_field_dash_plugins']) and $options['pht_field_dash_plugins']=="on"){
  		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  	}	

  	if (isset($options['pht_field_dash_recent_comments']) and $options['pht_field_dash_recent_comments']=="on"){
  		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  	}

  	if (isset($options['pht_field_dash_primary']) and $options['pht_field_dash_primary']=="on"){
  		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  	}

  	if (isset($options['pht_field_dash_secondary']) and $options['pht_field_dash_secondary']=="on"){
  		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  	}

  	if (isset($options['pht_field_dash_incoming_links']) and $options['pht_field_dash_incoming_links']=="on"){
  		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  	}

  	if (isset($options['pht_field_dash_right_now']) and $options['pht_field_dash_right_now']=="on"){
  		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  	}

  	if (isset($options['pht_field_dash_quick_press']) and $options['pht_field_dash_quick_press']=="on"){
  		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  	}

	if (isset($options['pht_field_dash_activity']) and $options['pht_field_dash_activity']=="on"){
  		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
  	}  	

}
 
add_action('wp_dashboard_setup', 'pht_del_secoes_painel');

?>