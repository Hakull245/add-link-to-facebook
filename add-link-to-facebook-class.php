<?php

/*
	Support class Add Link to Facebook Plugin
	Copyright (c) 2011 by Marcel Bokhorst
*/

// Define constants
define('c_al2fb_text_domain', 'add-link-to-facebook');
define('c_al2fb_nonce_form', 'al2fb-nonce-form');

define('c_al2fb_option_version', 'al2fb_version');
define('c_al2fb_option_timeout', 'al2fb_timeout');
define('c_al2fb_option_nonotice', 'al2fb_nonotice');
define('c_al2fb_option_min_cap', 'al2fb_min_cap');
define('c_al2fb_option_siteurl', 'al2fb_siteurl');
define('c_al2fb_option_nocurl', 'al2fb_nocurl');

define('c_al2fb_meta_client_id', 'al2fb_client_id');
define('c_al2fb_meta_app_secret', 'al2fb_app_secret');
define('c_al2fb_meta_access_token', 'al2fb_access_token');
define('c_al2fb_meta_picture_type', 'al2fb_picture_type');
define('c_al2fb_meta_picture', 'al2fb_picture');
define('c_al2fb_meta_page', 'al2fb_page');
define('c_al2fb_meta_page_owner', 'al2fb_page_owner');
define('c_al2fb_meta_caption', 'al2fb_caption');
define('c_al2fb_meta_msg', 'al2fb_msg');
define('c_al2fb_meta_clean', 'al2fb_clean');
define('c_al2fb_meta_donated', 'al2fb_donated');

define('c_al2fb_meta_link_id', 'al2fb_facebook_link_id');
define('c_al2fb_meta_link_time', 'al2fb_facebook_link_time');
define('c_al2fb_meta_exclude', 'al2fb_facebook_exclude');
define('c_al2fb_meta_error', 'al2fb_facebook_error');
define('c_al2fb_meta_image_id', 'al2fb_facebook_image_id');

define('c_al2fb_log_redir_init', 'al2fb_redir_init');
define('c_al2fb_log_redir_time', 'al2fb_redir_time');
define('c_al2fb_log_redir_ref', 'al2fb_redir_ref');
define('c_al2fb_log_redir_from', 'al2fb_redir_from');
define('c_al2fb_log_redir_to', 'al2fb_redir_to');

// To Do
// - icon?
// - target="_blank"?
// - Check app permissions
// - debug info mail
// - display post errors

// Define class
if (!class_exists('WPAL2Facebook')) {
	class WPAL2Facebook {
		// Class variables
		var $main_file = null;
		var $plugin_url = null;
		var $php_error = null;

		// Constructor
		function __construct() {
			global $wp_version;

			// Get main file name
			$bt = debug_backtrace();
			$this->main_file = $bt[0]['file'];

			// Get plugin url
			$this->plugin_url = WP_PLUGIN_URL . '/' . basename(dirname($this->main_file));
			if (strpos($this->plugin_url, 'http') === 0 && is_ssl())
				$this->plugin_url = str_replace('http://', 'https://', $this->plugin_url);

			// register activation actions
			register_activation_hook($this->main_file, array(&$this, 'Activate'));
			register_deactivation_hook($this->main_file, array(&$this, 'Deactivate'));

			// Register actions
			add_action('init', array(&$this, 'Init'), 0);
			if (is_admin()) {
				add_action('admin_menu', array(&$this, 'Admin_menu'));
				add_action('admin_notices', array(&$this, 'Admin_notices'));
				add_action('post_submitbox_start', array(&$this, 'Post_submitbox'));
				add_action('transition_post_status', array(&$this, 'Transition_post_status'), 10, 3);
				add_filter('manage_posts_columns', array(&$this, 'Manage_posts_columns'));
				add_action('manage_posts_custom_column', array(&$this, 'Manage_posts_custom_column'), 10, 2);
				add_action('add_meta_boxes', array(&$this, 'Add_meta_boxes'));
				add_action('save_post', array(&$this, 'Save_post'));
			}
			add_action('xmlrpc_publish_post', array(&$this, 'Publish_post'));
			add_action('app_publish_post', array(&$this, 'Publish_post'));
		}

		// Handle plugin activation
		function Activate() {
			$version = get_option(c_al2fb_option_version);
			if ($version == 1) {
				delete_option(c_al2fb_meta_client_id);
				delete_option(c_al2fb_meta_app_secret);
				delete_option(c_al2fb_meta_access_token);
				delete_option(c_al2fb_meta_picture_type);
				delete_option(c_al2fb_meta_picture);
				delete_option(c_al2fb_meta_page);
				delete_option(c_al2fb_meta_clean);
				delete_option(c_al2fb_meta_donated);
			}
			update_option(c_al2fb_option_version, 2);
		}

		// Handle plugin deactivation
		function Deactivate() {
			global $user_ID;
			get_currentuserinfo();

			// Cleanup if requested
			if (get_user_meta($user_ID, c_al2fb_meta_clean, true)) {
				delete_user_meta($user_ID, c_al2fb_meta_client_id);
				delete_user_meta($user_ID, c_al2fb_meta_app_secret);
				delete_user_meta($user_ID, c_al2fb_meta_access_token);
				delete_user_meta($user_ID, c_al2fb_meta_picture_type);
				delete_user_meta($user_ID, c_al2fb_meta_picture);
				delete_user_meta($user_ID, c_al2fb_meta_page);
				delete_user_meta($user_ID, c_al2fb_meta_page_owner);
				delete_user_meta($user_ID, c_al2fb_meta_caption);
				delete_user_meta($user_ID, c_al2fb_meta_msg);
				delete_user_meta($user_ID, c_al2fb_meta_clean);
				delete_user_meta($user_ID, c_al2fb_meta_donated);
			}
		}

		function Init() {
			if (is_admin()) {
				// I18n
				load_plugin_textdomain(c_al2fb_text_domain, false, dirname(plugin_basename(__FILE__)));

				// Enqueue style sheet
				$css_name = $this->Change_extension(basename($this->main_file), '.css');
				if (file_exists(WP_CONTENT_DIR . '/uploads/' . $css_name))
					$css_url = WP_CONTENT_URL . '/uploads/' . $css_name;
				else if (file_exists(TEMPLATEPATH . '/' . $css_name))
					$css_url = get_bloginfo('template_directory') . '/' . $css_name;
				else
					$css_url = $this->plugin_url . '/' . $css_name;
				wp_register_style('al2fb_style', $css_url);
				wp_enqueue_style('al2fb_style');
			}

			// Initiate Facebook authorization
			if (isset($_REQUEST['al2fb_action']) && $_REQUEST['al2fb_action'] == 'init') {
				// Debug info
				update_option(c_al2fb_log_redir_init, date('r'));

				// Redirect
				wp_redirect(self::Authorize_url());
				exit();
			}


			// Handle Facebook authorization
			parse_str($_SERVER['QUERY_STRING'], $query);
			if (isset($query['state']) &&
				strpos($query['state'], 'al2fb_authorize') !== false) {
				// Build new url
				$query['state'] = '';
				$query['al2fb_action'] = 'authorize';
				$url = admin_url('tools.php?page=' . plugin_basename($this->main_file));
				$url .= '&' . http_build_query($query);

				// Debug info
				update_option(c_al2fb_log_redir_time, date('r'));
				update_option(c_al2fb_log_redir_ref, (empty($_SERVER['HTTP_REFERER']) ? null : $_SERVER['HTTP_REFERER']));
				update_option(c_al2fb_log_redir_from, $_SERVER['REQUEST_URI']);
				update_option(c_al2fb_log_redir_to, $url);

				// Redirect
				wp_redirect($url);
				exit();
			}

			// Set default capability
			if (!get_option(c_al2fb_option_min_cap))
				update_option(c_al2fb_option_min_cap, 'edit_posts');
		}

		// Display admin messages
		function Admin_notices() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			// Check if action
			if (isset($_REQUEST['al2fb_action'])) {
				// Configuration
				if ($_REQUEST['al2fb_action'] == 'config') {
					// Check security
					check_admin_referer(c_al2fb_nonce_form);

					// Default values
					if (empty($_POST[c_al2fb_meta_picture_type]))
						$_POST[c_al2fb_meta_picture_type] = 'wordpress';
					if (empty($_POST[c_al2fb_meta_page]))
						$_POST[c_al2fb_meta_page] = null;
					if (empty($_POST[c_al2fb_meta_page_owner]))
						$_POST[c_al2fb_meta_page_owner] = null;
					if (empty($_POST[c_al2fb_meta_caption]))
						$_POST[c_al2fb_meta_caption] = null;
					if (empty($_POST[c_al2fb_meta_msg]))
						$_POST[c_al2fb_meta_msg] = null;
					if (empty($_POST[c_al2fb_meta_clean]))
						$_POST[c_al2fb_meta_clean] = null;
					if (empty($_POST[c_al2fb_meta_donated]))
						$_POST[c_al2fb_meta_donated] = null;

					// Invalidate access token
					if (get_user_meta($user_ID, c_al2fb_meta_client_id, true) != $_POST[c_al2fb_meta_client_id] ||
						get_user_meta($user_ID, c_al2fb_meta_app_secret, true) != $_POST[c_al2fb_meta_app_secret])
						delete_user_meta($user_ID, c_al2fb_meta_access_token);
					if ($_POST[c_al2fb_meta_page_owner] && !get_user_meta($user_ID, c_al2fb_meta_page_owner, true))
						delete_user_meta($user_ID, c_al2fb_meta_access_token);

					// Update user options
					update_user_meta($user_ID, c_al2fb_meta_client_id, $_POST[c_al2fb_meta_client_id]);
					update_user_meta($user_ID, c_al2fb_meta_app_secret, $_POST[c_al2fb_meta_app_secret]);
					update_user_meta($user_ID, c_al2fb_meta_picture_type, $_POST[c_al2fb_meta_picture_type]);
					update_user_meta($user_ID, c_al2fb_meta_picture, $_POST[c_al2fb_meta_picture]);
					update_user_meta($user_ID, c_al2fb_meta_page, $_POST[c_al2fb_meta_page]);
					update_user_meta($user_ID, c_al2fb_meta_page_owner, $_POST[c_al2fb_meta_page_owner]);
					update_user_meta($user_ID, c_al2fb_meta_caption, $_POST[c_al2fb_meta_caption]);
					update_user_meta($user_ID, c_al2fb_meta_msg, $_POST[c_al2fb_meta_msg]);
					update_user_meta($user_ID, c_al2fb_meta_clean, $_POST[c_al2fb_meta_clean]);
					update_user_meta($user_ID, c_al2fb_meta_donated, $_POST[c_al2fb_meta_donated]);

					// Update admin options
					if (current_user_can('manage_options')) {
						if (empty($_POST[c_al2fb_option_nonotice]))
							$_POST[c_al2fb_option_nonotice] = null;
						if (empty($_POST[c_al2fb_option_min_cap]))
							$_POST[c_al2fb_option_min_cap] = null;

						update_option(c_al2fb_option_nonotice, $_POST[c_al2fb_option_nonotice]);
						update_option(c_al2fb_option_min_cap, $_POST[c_al2fb_option_min_cap]);

						if (isset($_REQUEST['debug'])) {
							update_option(c_al2fb_option_siteurl, $_POST[c_al2fb_option_siteurl]);
							update_option(c_al2fb_option_nocurl, $_POST[c_al2fb_option_nocurl]);
						}
					}

					// Show result
					echo '<div id="message" class="updated fade al2fb_notice"><p>' . __('Settings updated', c_al2fb_text_domain) . '</p></div>';
				}

				// Authorization
				else if ($_REQUEST['al2fb_action'] == 'authorize') {
					if (isset($_REQUEST['code'])) {
						try {
							$access_token = self::Get_token();
							update_user_meta($user_ID, c_al2fb_meta_access_token, $access_token);
							echo '<div id="message" class="updated fade al2fb_notice"><p>' . __('Authorized, go posting!', c_al2fb_text_domain) . '</p></div>';
						}
						catch (Exception $e) {
							delete_user_meta($user_ID, c_al2fb_meta_access_token);
							echo '<div id="message" class="error fade al2fb_error"><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, get_bloginfo('charset')) . '</p></div>';
						}
					}
					else if (isset($_REQUEST['error'])) {
						// error_reason, error, error_description
						echo '<div id="message" class="error fade al2fb_error"><p>' . $_REQUEST['error_description'] . '</p></div>';
					}
				}
			}

			// Check config/authorization
			$uri = $_SERVER['REQUEST_URI'];
			$url = 'tools.php?page=' . plugin_basename($this->main_file);
			if (get_option(c_al2fb_option_nonotice) ? strpos($uri, $url) !== false : true) {
				if (!get_user_meta($user_ID, c_al2fb_meta_client_id, true) ||
					!get_user_meta($user_ID, c_al2fb_meta_app_secret, true)) {
					$msg = __('needs configuration', c_al2fb_text_domain);
					$anchor = 'configure';
				}
				else if (!get_user_meta($user_ID, c_al2fb_meta_access_token, true)) {
					$msg = __('needs authorization', c_al2fb_text_domain);
					$anchor = 'authorize';
				}
				if (!empty($msg)) {
					$url .= '#' . $anchor;
					echo '<div class="error fade al2fb_error"><p>';
					_e('Add Link to Facebook', c_al2fb_text_domain);
					echo ' <a href="' . $url . '">' . $msg . '</a></p></div>';
				}
			}
		}

		// Register options page
		function Admin_menu() {
			if (function_exists('add_management_page'))
				add_management_page(
					__('Add Link to Facebook', c_al2fb_text_domain) . ' ' . __('Administration', c_al2fb_text_domain),
					__('Add Link to Facebook', c_al2fb_text_domain),
					get_option(c_al2fb_option_min_cap),
					$this->main_file,
					array(&$this, 'Administration'));
		}

		// Handle option page
		function Administration() {
			// Security check
			$min_cap = get_option(c_al2fb_option_min_cap);
			if (!current_user_can($min_cap))
				die('Unauthorized: ' . $min_cap);

			// Get current user
			global $user_ID;
			get_currentuserinfo();
			$charset = get_bloginfo('charset');
			$access_token = get_user_meta($user_ID, c_al2fb_meta_access_token, true);

			self::Sponsorship();

			$pic_type = get_user_meta($user_ID, c_al2fb_meta_picture_type, true);
			$pic_wordpress = ($pic_type == 'wordpress' ? ' checked' : '');
			$pic_featured = ($pic_type == 'featured' ? ' checked' : '');
			$pic_facebook = ($pic_type == 'facebook' ? ' checked' : '');
			$pic_custom = ($pic_type == 'custom' ? ' checked' : '');
			if (!current_theme_supports('post-thumbnails'))
				$pic_featured .= ' disabled';
?>
			<div class="wrap">
			<h2><?php _e('Add Link to Facebook', c_al2fb_text_domain); ?></h2>
<?php
			// Check connectivity
			if (!ini_get('allow_url_fopen') && !function_exists('curl_init'))
				echo '<div id="message" class="error fade al2fb_error"><p>' . __('Your server may not allow external connections', c_al2fb_text_domain) . '</p></div>';

			if (isset($_REQUEST['debug'])) {
				global $wp_version;

				$plugin_folder = get_plugins('/' . plugin_basename(dirname(__FILE__)));
				$plugin_version = $plugin_folder[basename($this->main_file)]['Version'];

				echo '<hr />';
				echo '<h3>' . __('Debug information', c_al2fb_text_domain) . '</h3>';
				echo '<div class="al2fb_debug"><table>';
				echo '<tr><td>Time:</td><td>' . date('r') . '</td></tr>';
				echo '<tr><td>Server software:</td><td>' . htmlspecialchars($_SERVER['SERVER_SOFTWARE']) . '</td></tr>';
				echo '<tr><td>SAPI:</td><td>' . htmlspecialchars(php_sapi_name()) . '</td></tr>';
				echo '<tr><td>PHP version:</td><td>' . PHP_VERSION . '</td></tr>';
				echo '<tr><td>User agent:</td><td>' . htmlspecialchars($_SERVER['HTTP_USER_AGENT']) . '</td></tr>';
				echo '<tr><td>WordPress version:</td><td>' . $wp_version . '</td></tr>';
				echo '<tr><td>Plugin version:</td><td>' . $plugin_version . '</td></tr>';
				echo '<tr><td>Multi site:</td><td>' . (is_multisite() ? 'Yes' : 'No') . '</td></tr>';
				echo '<tr><td>Blog address (home):</td><td>' . htmlspecialchars(get_home_url(), ENT_QUOTES, $charset) . '</td></tr>';
				echo '<tr><td>WordPress address (site):</td><td>' . htmlspecialchars(get_site_url(), ENT_QUOTES, $charset) . '</td></tr>';
				echo '<tr><td>Redirect URI:</td><td>' . htmlspecialchars(self::Redirect_uri(), ENT_QUOTES, $charset) . '</td></tr>';
				echo '<tr><td>Authorize URL:</td><td>' . htmlspecialchars(self::Authorize_url()) . '</td></tr>';
				echo '<tr><td>Authorization start:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_init)) . '</td></tr>';
				echo '<tr><td>Redirect time:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_time)) . '</td></tr>';
				echo '<tr><td>Redirect referer:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_ref)) . '</td></tr>';
				echo '<tr><td>Redirect from:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_from)) . '</td></tr>';
				echo '<tr><td>Redirect to:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_to)) . '</td></tr>';
				echo '<tr><td>Authorized:</td><td>' . ($access_token ? 'Yes' : 'No') . '</td></tr>';
				echo '<tr><td>allow_url_fopen:</td><td>' . (ini_get('allow_url_fopen') ? 'Yes' : 'No') . '</td></tr>';
				echo '<tr><td>cURL:</td><td>' . (function_exists('curl_init') ? 'Yes' : 'No') . '</td></tr>';
				echo '</table></div>';
			}
?>
			<?php self::Resources(); ?>

			<div class="al2fb_options">

<?php	   if (get_user_meta($user_ID, c_al2fb_meta_client_id, true) &&
				get_user_meta($user_ID, c_al2fb_meta_app_secret, true)) {
?>
				<hr />
				<a name="authorize"></a>
				<h3><?php _e('Authorization', c_al2fb_text_domain); ?></h3>
<?php
				if ($access_token) {
					// Get page name
					try {
						$me = self::Get_me(false);
						_e('Links will be added to', c_al2fb_text_domain);
						echo ' <a href="' . $me->link . '" target="_blank">' . htmlspecialchars($me->name, ENT_QUOTES, $charset);
						if (!empty($me->category))
							echo ' - ' . htmlspecialchars($me->category, ENT_QUOTES, $charset);
						echo '</a>';
					}
					catch (Exception $e) {
						echo '<div id="message" class="error fade al2fb_error"><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, $charset) . '</p></div>';
					}
				}
?>
				<table>
				<tr><td>
				<form method="get" action="<?php echo admin_url('tools.php?page=' . plugin_basename($this->main_file)); ?>">
				<input type="hidden" name="al2fb_action" value="init">
				<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Authorize', c_al2fb_text_domain) ?>" />
				</p>
				</form>
				</td>

<?php		   if (!get_user_meta($user_ID, c_al2fb_meta_donated, true)) { ?>
				<td>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
				<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				</form>
				</td>
<?php		   } ?>
				</tr>
				</table>
<?php	   } ?>

			<hr />
			<a name="configure"></a>
			<h3><?php _e('Easy setup', c_al2fb_text_domain); ?></h3>
			<div class="al2fb_instructions">
			<h4><?php _e('To get an App ID and App Secret you have to create a Facebook application', c_al2fb_text_domain); ?></h4>
			<span><a href="http://www.facebook.com/developers/createapp.php" target="_blank">
			<?php _e('Click here to create', c_al2fb_text_domain); ?></a></span><br />
			<table>
				<tr>
					<td><span class="al2fb_label"><strong><?php _e('App Name:', c_al2fb_text_domain); ?></span></td>
					<td><span class="al2fb_data"><?php _e('Anything you like, will appear as "via ..." below the message', c_al2fb_text_domain); ?></span></td>
				</tr>
				<tr>
					<td><span class="al2fb_label"><strong><?php _e('Web Site > Site URL:', c_al2fb_text_domain); ?></span></td>
					<td><span class="al2fb_data"><?php echo htmlspecialchars(self::Redirect_uri(), ENT_QUOTES, $charset); ?></span></td>
				</tr>
			</table>
			</div>

			<form method="post" action="<?php echo admin_url('tools.php?page=' . plugin_basename($this->main_file)); ?>">
			<input type="hidden" name="al2fb_action" value="config">
			<?php wp_nonce_field(c_al2fb_nonce_form); ?>

			<table class="form-table">
			<tr valign="top"><th scope="row">
				<label for="al2fb_client_id"><strong><?php _e('App ID:', c_al2fb_text_domain); ?></strong></label>
			</th><td>
				<input id="al2fb_client_id" class="al2fb_client_id" name="<?php echo c_al2fb_meta_client_id; ?>" type="text" value="<?php echo get_user_meta($user_ID, c_al2fb_meta_client_id, true); ?>" />
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_app_secret"><strong><?php _e('App Secret:', c_al2fb_text_domain); ?></strong></label>
			</th><td>
				<input id="al2fb_app_secret" class="al2fb_app_secret" name="<?php echo c_al2fb_meta_app_secret; ?>" type="text" value="<?php echo get_user_meta($user_ID, c_al2fb_meta_app_secret, true); ?>" />
			</td></tr>
<?php
			if ($access_token)
				try {
					$app = self::Get_application();
?>
					<tr valign="top"><th scope="row">
						<label for="al2fb_app_name"><?php _e('App Name:', c_al2fb_text_domain); ?></label>
					</th><td>
						<a id="al2fb_app_name" href="<?php echo $app->link; ?>" target="_blank"><?php echo htmlspecialchars($app->name, ENT_QUOTES, $charset, $charset); ?></a>
					</td></tr>
<?php
				}
				catch (Exception $e) {
					echo '<div id="message" class="error fade al2fb_error"><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, $charset) . '</p></div>';
				}
?>
			</table>

			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save', c_al2fb_text_domain) ?>" />
			</p>

			<hr />
			<h3><?php _e('Additional settings', c_al2fb_text_domain); ?></h3>

			<table class="form-table">
			<tr valign="top"><th scope="row">
				<label for="al2fb_picture_type"><?php _e('Link picture:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input type="radio" name="<?php echo c_al2fb_meta_picture_type; ?>" value="wordpress"<?php echo $pic_wordpress; ?>><?php _e('WordPress logo', c_al2fb_text_domain); ?><br>
				<input type="radio" name="<?php echo c_al2fb_meta_picture_type; ?>" value="featured"<?php echo $pic_featured; ?>><?php _e('Featured post image', c_al2fb_text_domain); ?><br>
				<input type="radio" name="<?php echo c_al2fb_meta_picture_type; ?>" value="facebook"<?php echo $pic_facebook; ?>><?php _e('Let Facebook select', c_al2fb_text_domain); ?><br>
				<input type="radio" name="<?php echo c_al2fb_meta_picture_type; ?>" value="custom"<?php echo $pic_custom; ?>><?php _e('Custom picture below', c_al2fb_text_domain); ?><br>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_picture"><?php _e('Custom picture URL:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_picture" class="al2fb_picture" name="<?php echo c_al2fb_meta_picture; ?>" type="text" value="<?php echo get_user_meta($user_ID, c_al2fb_meta_picture, true); ?>" />
				<br /><span class="al2fb_explanation"><?php _e('At least 50 x 50 pixels', c_al2fb_text_domain); ?></span>
			</td></tr>

<?php
			if ($access_token)
				try {
					$me = self::Get_me(true);
					$pages = self::Get_pages();
					$selected_page = get_user_meta($user_ID, c_al2fb_meta_page, true);
?>
					<tr valign="top"><th scope="row">
						<label for="al2fb_page"><?php _e('Add to page:', c_al2fb_text_domain); ?></label>
					</th><td>
						<select id="al2fb_page" name="<?php echo c_al2fb_meta_page; ?>">
<?php
						echo '<option value=""' . ($selected_page ? '' : ' selected') . '>' . htmlspecialchars($me->name, ENT_QUOTES, $charset) . '</option>';
						foreach ($pages->data as $page) {
							echo '<option value="' . $page->id . '"';
							if ($page->id == $selected_page)
								echo ' selected';
							echo '>' . htmlspecialchars($page->name, ENT_QUOTES, $charset) . ' - ' . htmlspecialchars($page->category, ENT_QUOTES, $charset) . '</option>';
						}
?>
						</select>
					</td></tr>

					<tr valign="top"><th scope="row">
						<label for="al2fb_page_owner"><?php _e('Add as page owner:', c_al2fb_text_domain); ?></label>
					</th><td>
						<input id="al2fb_page_owner" name="<?php echo c_al2fb_meta_page_owner; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_page_owner, true)) echo ' checked="checked"'; ?> />
						<br /><span class="al2fb_explanation"><?php _e('Requires manage pages permission', c_al2fb_text_domain); ?></span>
					</td></tr>
<?php
				}
				catch (Exception $e) {
					echo '<div id="message" class="error fade al2fb_error"><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, $charset) . '</p></div>';
				}
?>
			<tr valign="top"><th scope="row">
				<label for="al2fb_caption"><?php _e('Use site title as caption:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_caption" name="<?php echo c_al2fb_meta_caption; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_caption, true)) echo ' checked="checked"'; ?> />
				<br /><span class="al2fb_explanation"><?php echo htmlspecialchars(html_entity_decode(get_bloginfo('title'), ENT_QUOTES, $charset)); ?></span>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_msg"><?php _e('Use excerpt as message:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_msg" name="<?php echo c_al2fb_meta_msg; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_msg, true)) echo ' checked="checked"'; ?> />
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_clean"><?php _e('Clean on deactivate:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_clean" name="<?php echo c_al2fb_meta_clean; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_clean, true)) echo ' checked="checked"'; ?> />
				<br /><span class="al2fb_explanation"><?php _e('All data, except link id\'s', c_al2fb_text_domain); ?></span>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_donated"><?php _e('I have donated to this plugin:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_donated" name="<?php echo c_al2fb_meta_donated; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_donated, true)) echo ' checked="checked"'; ?> />
			</td></tr>
			</table>

<?php	   if (current_user_can('manage_options')) { ?>
				<h3><?php _e('Administrator options', c_al2fb_text_domain); ?></h3>

				<table class="form-table">
				<tr valign="top"><th scope="row">
					<label for="al2fb_nonotice"><?php _e('Do not display notices:', c_al2fb_text_domain); ?></label>
				</th><td>
					<input id="al2fb_nonotice" name="<?php echo c_al2fb_option_nonotice; ?>" type="checkbox"<?php if (get_option(c_al2fb_option_nonotice)) echo ' checked="checked"'; ?> />
				<br /><span class="al2fb_explanation"><?php _e('Except on this page', c_al2fb_text_domain); ?></span>
				</td></tr>

				<tr valign="top"><th scope="row">
					<label for="al2fb_min_cap"><?php _e('Required capability to use plugin:', c_al2fb_text_domain); ?></label>
				</th><td>
					<select id="al2fb_min_cap" name="<?php echo c_al2fb_option_min_cap; ?>">
<?php
					// Get list of capabilities
					global $wp_roles;
					$capabilities = array();
					foreach ($wp_roles->role_objects as $key => $role)
						if (is_array($role->capabilities))
							foreach ($role->capabilities as $cap => $grant)
								$capabilities[$cap] = $cap;
					sort($capabilities);

					// List capabilities and select current
					$min_cap = get_option(c_al2fb_option_min_cap);
					foreach ($capabilities as $cap) {
						echo '<option value="' . $cap . '"';
						if ($cap == $min_cap)
							echo ' selected';
						echo '>' . $cap . '</option>';
					}
?>
					</select>
				</td></tr>

<?php		   if (isset($_REQUEST['debug'])) { ?>
					<tr valign="top"><th scope="row">
						<label for="al2fb_siteurl"><?php _e('Use site URL as request URI:', c_al2fb_text_domain); ?></label>
					</th><td>
						<input id="al2fb_siteurl" name="<?php echo c_al2fb_option_siteurl; ?>" type="checkbox"<?php if (get_option(c_al2fb_option_siteurl)) echo ' checked="checked"'; ?> />
					</td></tr>

					<tr valign="top"><th scope="row">
						<label for="al2fb_nocurl"><?php _e('Do not use cURL:', c_al2fb_text_domain); ?></label>
					</th><td>
						<input id="al2fb_nocurl" name="<?php echo c_al2fb_option_nocurl; ?>" type="checkbox"<?php if (get_option(c_al2fb_option_nocurl)) echo ' checked="checked"'; ?> />
					</td></tr>
<?php		   } ?>
				</table>
<?php	   } ?>

			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save', c_al2fb_text_domain) ?>" />
			</p>
			</form>

			<hr />
			<a class="al2fb_debug" href="<?php echo 'tools.php?page=' . plugin_basename($this->main_file) . '&debug'; ?>"><?php _e('Debug information', c_al2fb_text_domain); ?></a>

			</div>
			</div>
<?php
		}

		function Sponsorship() {
			global $user_ID;
			get_currentuserinfo();
			if (!get_user_meta($userID, c_al2fb_meta_donated, true)) {
?>
				<script type="text/javascript">
				var psHost = (("https:" == document.location.protocol) ? "https://" : "http://");
				document.write(unescape("%3Cscript src='" + psHost + "pluginsponsors.com/direct/spsn/display.php?client=add-link-to-facebook&spot=' type='text/javascript'%3E%3C/script%3E"));
				</script>
				<a class="al2fb_sponsorship" href="http://pluginsponsors.com/privacy.html" target=_blank">
				<?php _e('Privacy in the Sustainable Plugins Sponsorship Network', c_al2fb_text_domain); ?></a>
<?php
			}
		}

		function Resources() {
			global $user_ID;
			get_currentuserinfo();
?>
			<div class="al2fb_resources">
			<h3><?php _e('Resources', c_al2fb_text_domain); ?></h3>
			<ul>
			<li><a href="http://wordpress.org/extend/plugins/add-link-to-facebook/faq/" target="_blank"><?php _e('Frequently asked questions', c_al2fb_text_domain); ?></a></li>
			<li><a href="http://blog.bokhorst.biz/5018/computers-en-internet/wordpress-plugin-add-link-to-facebook/" target="_blank"><?php _e('Support page', c_al2fb_text_domain); ?></a></li>
			<li><a href="http://blog.bokhorst.biz/about/" target="_blank"><?php _e('About the author', c_al2fb_text_domain); ?></a></li>
			<li><a href="http://wordpress.org/extend/plugins/profile/m66b" target="_blank"><?php _e('Other plugins', c_al2fb_text_domain); ?></a></li>
			</ul>
<?php	   if (!get_user_meta($user_ID, c_al2fb_meta_donated, true)) { ?>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHZwYJKoZIhvcNAQcEoIIHWDCCB1QCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYApWh+oUn2CtY+7zwU5zu5XKj096Mj0sxBhri5/lYV7i7B+JwhAC1ta7kkj2tXAbR3kcjVyNA9n5kKBUND+5Lu7HiNlnn53eFpl3wtPBBvPZjPricLI144ZRNdaaAVtY32pWX7tzyWJaHgClKWp5uHaerSZ70MqUK8yqzt0V2KKDjELMAkGBSsOAwIaBQAwgeQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIn3eeOKy6QZGAgcDKPGjy/6+i9RXscvkaHQqjbFI1bE36XYcrttae+aXmkeicJpsm+Se3NCBtY9yt6nxwwmxhqNTDNRwL98t8EXNkLg6XxvuOql0UnWlfEvRo+/66fqImq2jsro31xtNKyqJ1Qhx+vsf552j3xmdqdbg1C9IHNYQ7yfc6Bhx914ur8UPKYjy66KIuZBCXWge8PeYjuiswpOToRN8BU6tV4OW1ndrUO9EKZd5UHW/AOX0mjXc2HFwRoD22nrapVFIsjt2gggOHMIIDgzCCAuygAwIBAgIBADANBgkqhkiG9w0BAQUFADCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wHhcNMDQwMjEzMTAxMzE1WhcNMzUwMjEzMTAxMzE1WjCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBAMFHTt38RMxLXJyO2SmS+Ndl72T7oKJ4u4uw+6awntALWh03PewmIJuzbALScsTS4sZoS1fKciBGoh11gIfHzylvkdNe/hJl66/RGqrj5rFb08sAABNTzDTiqqNpJeBsYs/c2aiGozptX2RlnBktH+SUNpAajW724Nv2Wvhif6sFAgMBAAGjge4wgeswHQYDVR0OBBYEFJaffLvGbxe9WT9S1wob7BDWZJRrMIG7BgNVHSMEgbMwgbCAFJaffLvGbxe9WT9S1wob7BDWZJRroYGUpIGRMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbYIBADAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBBQUAA4GBAIFfOlaagFrl71+jq6OKidbWFSE+Q4FqROvdgIONth+8kSK//Y/4ihuE4Ymvzn5ceE3S/iBSQQMjyvb+s2TWbQYDwcp129OPIbD9epdr4tJOUNiSojw7BHwYRiPh58S1xGlFgHFXwrEBb3dgNbMUa+u4qectsMAXpVHnD9wIyfmHMYIBmjCCAZYCAQEwgZQwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tAgEAMAkGBSsOAwIaBQCgXTAYBgkqhkiG9w0BCQMxCwYJKoZIhvcNAQcBMBwGCSqGSIb3DQEJBTEPFw0xMTAyMDcwOTQ4MTlaMCMGCSqGSIb3DQEJBDEWBBQOOy+JroeRlZL7jGU/azSibWz1fjANBgkqhkiG9w0BAQEFAASBgCUXDO9KLIuy/XJwBa6kMWi0U1KFarbN9568i14mmZCFDvBmexRKhnSfqx+QLzdpNENBHKON8vNKanmL9jxgtyc88WAtrP/LqN4tmSrr0VB5wrds/viLxWZfu4Spb+YOTpo+z2hjXCJzVSV3EDvoxzHEN1Haxrvr1gWNhWzvVN3q-----END PKCS7-----">
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			</form>
<?php	   } ?>
			</div>
<?php
		}

		// Generate authorization URL
		function Authorize_url() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			// http://developers.facebook.com/docs/authentication/permissions
			$url = 'https://graph.facebook.com/oauth/authorize';
			$url .= '&client_id=' . get_user_meta($user_ID, c_al2fb_meta_client_id, true);
			$url .= '&redirect_uri=' . urlencode(self::Redirect_uri());
			$url .= '&scope=publish_stream,offline_access';
			$url .= '&state=al2fb_authorize';
			if (get_user_meta($user_ID, c_al2fb_meta_page_owner, true))
				$url .= ',manage_pages';
			return $url;
		}

		// Temporary workaround
		function Redirect_uri() {
			// WordPress Address -> get_site_url() -> WordPress folder
			// Blog Address -> get_home_url() -> Home page
			if (get_option(c_al2fb_option_siteurl))
				return get_site_url(null, '/');
			else
				return get_home_url(null, '/');
		}

		// Request token
		function Get_token() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			$url = 'https://graph.facebook.com/oauth/access_token';
			$query = http_build_query(array(
				'client_id' => get_user_meta($user_ID, c_al2fb_meta_client_id, true),
				'redirect_uri' => self::Redirect_uri(),
				'client_secret' => get_user_meta($user_ID, c_al2fb_meta_app_secret, true),
				'code' => $_REQUEST['code']
			));
			$response = self::Request($url, $query, 'GET');
			$key = 'access_token=';
			$access_token = substr($response, strpos($response, $key) + strlen($key));
			$access_token = explode('&', $access_token);
			$access_token = $access_token[0];
			return $access_token;
		}

		function Get_application() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			$app_id = get_user_meta($user_ID, c_al2fb_meta_client_id, true);
			$url = 'https://graph.facebook.com/' . $app_id;
			$query = http_build_query(array(
				'access_token' => get_user_meta($user_ID, c_al2fb_meta_access_token, true)
			));
			$response = self::Request($url, $query, 'GET');
			$app = json_decode($response);
			return $app;
		}

		// Get profile data
		function Get_me($self) {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			$page = get_user_meta($user_ID, c_al2fb_meta_page, true);
			if ($self | empty($page))
				$page = 'me';
			$url = 'https://graph.facebook.com/' . $page;
			$query = http_build_query(array(
				'access_token' => get_user_meta($user_ID, c_al2fb_meta_access_token, true)
			));
			$response = self::Request($url, $query, 'GET');
			$me = json_decode($response);
			return $me;
		}

		function Get_pages() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			$url = 'https://graph.facebook.com/me/accounts';
			$query = http_build_query(array(
				'access_token' => get_user_meta($user_ID, c_al2fb_meta_access_token, true)
			));
			$response = self::Request($url, $query, 'GET');
			$accounts = json_decode($response);
			return $accounts;
		}

		// Add exclude checkbox
		function Post_submitbox() {
			if (current_user_can(get_option(c_al2fb_option_min_cap))) {
				global $post;
				$exclude = get_post_meta($post->ID, c_al2fb_meta_exclude, true);
				$chk_exclude = $exclude ? 'checked' : '';
?>
				<div class="al2fb_post_submit">
				<input type="hidden" name="<?php echo c_al2fb_meta_exclude . '_prev'; ?>" value="<?php echo $exclude; ?>" />
				<input type="checkbox" name="<?php echo c_al2fb_meta_exclude; ?>" <?php echo $chk_exclude; ?> />
				<span><?php _e('Do not add link to Facebook', c_al2fb_text_domain); ?></span>
				</div>
<?php
			}
		}

		// Add post Facebook column
		function Manage_posts_columns($posts_columns) {
			$posts_columns['al2fb'] = __('Facebook', c_al2fb_text_domain);
			return $posts_columns;
		}

		// Populate post facebook column
		function Manage_posts_custom_column($column_name, $post_id) {
			if ($column_name == 'al2fb') {
				$link_id = get_post_meta($post_id, c_al2fb_meta_link_id, true);
				echo '<span>' . ($link_id ? __('Yes', c_al2fb_text_domain) : __('No', c_al2fb_text_domain)) . '</span>';
			}
		}

		// Add post meta box
		function Add_meta_boxes() {
			if (function_exists('wp_get_attachment_thumb_url'))
				add_meta_box(
					'al2fb_meta',
					__('Add Link to Facebook', c_al2fb_text_domain),
					array(&$this,  'Generate_meta_box'),
					'post');
		}

		// Display attached image selector
		function Generate_meta_box() {
			// Security
			wp_nonce_field(plugin_basename(__FILE__), c_al2fb_nonce_form);

			// Get attached images
			global $post;
			$images = &get_children('post_type=attachment&post_mime_type=image&post_parent=' . $post->ID);
			if (empty($images))
				echo '<span>' . __('No images in the media library for this post', c_al2fb_text_domain) . '</span>';
			else {
				// Display image selector
				$image_id = get_post_meta($post->ID, c_al2fb_meta_image_id, true);

				echo '<h4>' . __('Select link image:', c_al2fb_text_domain) . '</h4>';

				echo '<input type="radio" name="al2fb_image_id" id="al2fb_image_0"';
				if (empty($image_id))
					echo ' checked';
				echo ' value="0">';
				echo '<label for="al2fb_image_0">';
				echo __('None', c_al2fb_text_domain) . '</label>';

				foreach ($images as $attachment_id => $attachment) {
					echo '<input type="radio" name="al2fb_image_id" id="al2fb_image_' . $attachment_id . '"';
					if ($attachment_id == $image_id)
						echo ' checked';
					echo ' value="' . $attachment_id . '">';
					echo '<label for="al2fb_image_' . $attachment_id . '">';
					echo '<img src="' . wp_get_attachment_thumb_url($attachment_id) . '" alt="al2fb"></label>';
				}
			}
		}

		// Save selected attached image
		function Save_post($post_id) {
			// Security checks
			if (!wp_verify_nonce($_POST[c_al2fb_nonce_form], plugin_basename(__FILE__)))
				return $post_id;
			if (!current_user_can('edit_post', $post_id))
				return $post_id;

			// Skip auto save
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return $post_id;

			// Persist data
			$image_id = $_POST['al2fb_image_id'];
			if (empty($image_id))
				delete_post_meta($post_id, c_al2fb_meta_image_id);
			else
				update_post_meta($post_id, c_al2fb_meta_image_id, $image_id);
		}

		// Handle post status change
		function Transition_post_status($new_status, $old_status, $post) {
			// Process exclude flag
			$prev_exclude = $_POST[c_al2fb_meta_exclude . '_prev'];
			$exclude = (empty($_POST[c_al2fb_meta_exclude]) ? null : $_POST[c_al2fb_meta_exclude]);
			if ($exclude)
				update_post_meta($post->ID, c_al2fb_meta_exclude, $exclude);
			else
				delete_post_meta($post->ID, c_al2fb_meta_exclude);

			// Check post status
			if ($new_status == 'publish' &&
				($new_status != $old_status ||
				(!$exclude && $prev_exclude) ||
				get_post_meta($post->ID, c_al2fb_meta_error, true)))
				self::Publish_post($post->ID);
		}

		// Handle publish post / XML-RPC publish post
		function Publish_post($post_ID) {
			$post = get_post($post_ID);

			// Check if not added
			if (get_user_meta($post->post_author, c_al2fb_meta_access_token, true) &&
				!get_post_meta($post->ID, c_al2fb_meta_link_id, true) &&
				!get_post_meta($post->ID, c_al2fb_meta_exclude, true)) {

				// Check if public
				if ($post->post_status == 'publish' && empty($post->post_password))
					self::Add_link($post);
			}
		}

		function Add_link($post) {
			// Get plain texts
			$excerpt = preg_replace('/<[^>]*>/', '', do_shortcode($post->post_excerpt));
			$content = preg_replace('/<[^>]*>/', '', do_shortcode($post->post_content));

			// Get caption
			$caption = '';
			if (get_user_meta($post->post_author, c_al2fb_meta_caption, true))
				$caption = html_entity_decode(get_bloginfo('title'), ENT_QUOTES, get_bloginfo('charset'));

			// Get body
			$description = '';
			if (get_user_meta($post->post_author, c_al2fb_meta_msg, true))
				$description = $content;
			else
				$description = ($excerpt ? $excerpt : $content);

			// Get link picture
			$image_id = get_post_meta($post->ID, c_al2fb_meta_image_id, true);
			if (!empty($image_id) && function_exists('wp_get_attachment_thumb_url'))
				$picture = wp_get_attachment_thumb_url($image_id);

			if (empty($picture)) {
				// Default picture
				$picture = 'http://s.wordpress.org/about/images/logo-blue/blue-s.png';

				// Check picture type
				$picture_type = get_user_meta($post->post_author, c_al2fb_meta_picture_type, true);
				if ($picture_type == 'featured') {
					if (current_theme_supports('post-thumbnails') &&
						function_exists('get_post_thumbnail_id')) {
						$picture_id = get_post_thumbnail_id($post->ID);
						if ($picture_id) {
							$picture = wp_get_attachment_image_src($picture_id, 'medium');
							if ($picture && $picture[0])
								$picture = $picture[0];
						}
					}
				}
				else if ($picture_type == 'facebook')
					$picture = '';
				else if ($picture_type == 'custom') {
					$custom = get_user_meta($post->post_author, c_al2fb_meta_picture, true);
					if ($custom)
						$picture = $custom;
				}
			}

			// Get user note
			$message = '';
			if (get_user_meta($post->post_author, c_al2fb_meta_msg, true))
				$message = $excerpt;

			// Do not disturb WordPress
			try {
				// Select page
				$page_id = get_user_meta($post->post_author, c_al2fb_meta_page, true);
				if (empty($page_id))
					$page_id = 'me';

				// Get access token
				$access_token = get_user_meta($post->post_author, c_al2fb_meta_access_token, true);
				if ($page_id != 'me' && get_user_meta($post->post_author, c_al2fb_meta_page_owner, true)) {
					$pages = self::Get_pages();
					foreach ($pages->data as $page)
					   if($page->id == $page_id)
						  $access_token = $page->access_token;
				}

				// Build rquest
				// http://developers.facebook.com/docs/reference/api/link/
				$url = 'https://graph.facebook.com/' . $page_id . '/feed';
				$query = http_build_query(array(
					'access_token' => $access_token,
					'link' => get_permalink($post->ID),
					'name' => $post->post_title,
					'caption' => $caption,
					'description' => $description,
					'picture' => $picture,
					'message' => $message
				));

				// Execute request
				$response = self::Request($url, $query, 'POST');
				$link = json_decode($response);

				// Register link/date
				add_post_meta($post->ID, c_al2fb_meta_link_id, $link->id);
				update_post_meta($post->ID, c_al2fb_meta_link_time, date('c'));
				delete_post_meta($post->ID, c_al2fb_meta_error);
			}
			catch (Exception $e) {
				add_post_meta($post->ID, c_al2fb_meta_error, $e->getMessage());
				update_post_meta($post->ID, c_al2fb_meta_link_time, date('c'));
			}
		}

		// Generic http request
		function Request($url, $query, $type) {
			// Get timeout
			$timeout = get_option(c_al2fb_option_timeout);
			if (!$timeout)
				$timeout = 30;

			// Use cURL if available
			if (function_exists('curl_init') && !get_option(c_al2fb_option_nocurl))
				return self::curl_file_get_contents($url, $query, $type, $timeout);

			if (version_compare(PHP_VERSION, '5.2.1') < 0)
				ini_set('default_socket_timeout', $timeout);

			$this->php_error = '';
			set_error_handler(array(&$this, 'PHP_error_handler'));
			if ($type == 'GET') {
				$context = stream_context_create(array(
				'http' => array(
					'method'  => 'GET',
					'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					'timeout' => $timeout
					)
				));
				$content = file_get_contents($url . '?' . $query, false, $context);
			}
			else {
				$context = stream_context_create(array(
					'http' => array(
						'method'  => 'POST',
						'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						'timeout' => $timeout,
						'content' => $query
					)
				));
				$content = file_get_contents($url, false, $context);
			}
			restore_error_handler();

			// Check for errors
			$status = false;
			if (!empty($http_response_header))
				foreach ($http_response_header as $h)
					if (strpos($h, 'HTTP/') === 0) {
						$status = explode(' ', $h);
						$status = intval($status[1]);
					}
			if ($status == 200)
				return $content;
			else
				throw new Exception('Error ' . $status . ': ' . $this->php_error . ' ' . print_r($http_response_header, true));
		}

		// Persist PHP errors
		function PHP_error_handler($errno, $errstr) {
			$this->php_error = $errstr;
		}

		// cURL http request
		function curl_file_get_contents($url, $query, $type, $timeout) {
			$c = curl_init();
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c, CURLOPT_TIMEOUT, $timeout);
			if ($type == 'GET')
				curl_setopt($c, CURLOPT_URL, $url . '?' . $query);
			else {
				curl_setopt($c, CURLOPT_URL, $url);
				curl_setopt($c, CURLOPT_POST, true);
				curl_setopt($c, CURLOPT_POSTFIELDS, $query);
			}
			$content = curl_exec($c);
			$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
			curl_close($c);

			if ($status == 200)
				return $content;
			else {
				$error = json_decode($content);
				$error = empty($error->error->message) ? $content : $error->error->message;
				throw new Exception('cURL error ' . $status . ': ' . $error);
			}
		}

		// Check environment
		function Check_prerequisites() {
			// Check WordPress version
			global $wp_version;
			if (version_compare($wp_version, '3.0') < 0)
				die('Add Link to Facebook requires at least WordPress 3.0');

			// Check basic prerequisities
			self::Check_function('add_action');
			self::Check_function('add_filter');
			self::Check_function('wp_register_style');
			self::Check_function('wp_enqueue_style');
			self::Check_function('file_get_contents');
			self::Check_function('json_decode');
		}

		function Check_function($name) {
			if (!function_exists($name))
				die('Required WordPress function "' . $name . '" does not exist');
		}

		// Change file extension
		function Change_extension($filename, $new_extension) {
			return preg_replace('/\..+$/', $new_extension, $filename);
		}
	}
}

?>
