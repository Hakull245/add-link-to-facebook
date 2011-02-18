<?php

/*
	Support class Add Link to Facebook Plugin
	Copyright (c) 2011 by Marcel Bokhorst
*/

// Define constants
define('c_al2fb_text_domain', 'add-link-to-facebook');
define('c_al2fb_nonce_form', 'al2fb-nonce-form');

// Shared app
define('c_al2fb_app_id', '191927664162191');
define('c_al2fb_app_url', 'http://wp-al2fb.appspot.com/');
define('c_al2fb_app_version', '1');

// Global options
define('c_al2fb_option_version', 'al2fb_version');
define('c_al2fb_option_timeout', 'al2fb_timeout');
define('c_al2fb_option_nonotice', 'al2fb_nonotice');
define('c_al2fb_option_min_cap', 'al2fb_min_cap');
define('c_al2fb_option_msg_refresh', 'al2fb_comment_refresh');
define('c_al2fb_option_siteurl', 'al2fb_siteurl');
define('c_al2fb_option_nocurl', 'al2fb_nocurl');

// User meta
define('c_al2fb_meta_shared', 'al2fb_shared');
define('c_al2fb_meta_client_id', 'al2fb_client_id');
define('c_al2fb_meta_app_secret', 'al2fb_app_secret');
define('c_al2fb_meta_access_token', 'al2fb_access_token');
define('c_al2fb_meta_picture_type', 'al2fb_picture_type');
define('c_al2fb_meta_picture', 'al2fb_picture');
define('c_al2fb_meta_page', 'al2fb_page');
define('c_al2fb_meta_page_owner', 'al2fb_page_owner');
define('c_al2fb_meta_caption', 'al2fb_caption');
define('c_al2fb_meta_msg', 'al2fb_msg');
define('c_al2fb_meta_shortlink', 'al2fb_shortlink');
define('c_al2fb_meta_sentences', 'al2fb_sentences');
define('c_al2fb_meta_integrate', 'al2fb_integrate');
define('c_al2fb_meta_clean', 'al2fb_clean');
define('c_al2fb_meta_donated', 'al2fb_donated');

// Post meta
define('c_al2fb_meta_link_id', 'al2fb_facebook_link_id');
define('c_al2fb_meta_link_time', 'al2fb_facebook_link_time');
define('c_al2fb_meta_link_picture', 'al2fb_facebook_link_picture');
define('c_al2fb_meta_exclude', 'al2fb_facebook_exclude');
define('c_al2fb_meta_error', 'al2fb_facebook_error');
define('c_al2fb_meta_image_id', 'al2fb_facebook_image_id');

// Logging
define('c_al2fb_log_redir_init', 'al2fb_redir_init');
define('c_al2fb_log_redir_check', 'al2fb_redir_check');
define('c_al2fb_log_redir_time', 'al2fb_redir_time');
define('c_al2fb_log_redir_ref', 'al2fb_redir_ref');
define('c_al2fb_log_redir_from', 'al2fb_redir_from');
define('c_al2fb_log_redir_to', 'al2fb_redir_to');
define('c_al2fb_last_error', 'al2fb_last_error');
define('c_al2fb_last_error_time', 'al2fb_last_error_time');

// Mail
define('c_al2fb_mail_name', 'al2fb_debug_name');
define('c_al2fb_mail_email', 'al2fb_debug_email');
define('c_al2fb_mail_msg', 'al2fb_debug_msg');

// To Do
// - target="_blank"? how to do?
// - Check app permissions? not possible :-(
// - Check min image size
// - Embed WordPress icon
// - Update meta box after update media gallery?
// - Admin dashboard? how to get links to messages?
// - Use tage line?
// - Check auto (future) posting
// - Custom post types
// - Read more
// - Links in text

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

			add_filter('comments_array', array(&$this, 'Comments_array'), 10, 2);
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
				delete_user_meta($user_ID, c_al2fb_meta_shared);
				delete_user_meta($user_ID, c_al2fb_meta_client_id);
				delete_user_meta($user_ID, c_al2fb_meta_app_secret);
				delete_user_meta($user_ID, c_al2fb_meta_access_token);
				delete_user_meta($user_ID, c_al2fb_meta_picture_type);
				delete_user_meta($user_ID, c_al2fb_meta_picture);
				delete_user_meta($user_ID, c_al2fb_meta_page);
				delete_user_meta($user_ID, c_al2fb_meta_page_owner);
				delete_user_meta($user_ID, c_al2fb_meta_caption);
				delete_user_meta($user_ID, c_al2fb_meta_msg);
				delete_user_meta($user_ID, c_al2fb_meta_shortlink);
				delete_user_meta($user_ID, c_al2fb_meta_sentences);
				delete_user_meta($user_ID, c_al2fb_meta_integrate);
				delete_user_meta($user_ID, c_al2fb_meta_clean);
				delete_user_meta($user_ID, c_al2fb_meta_donated);
			}
		}

		// Initialization
		function Init() {
			// Secret request
			if (isset($_REQUEST['al2fb_check'])) {
				if ($_REQUEST['al2fb_check'] == self::Authorize_secret())
					echo 'OK';
				exit();
			}

			// Set default capability
			if (!get_option(c_al2fb_option_min_cap))
				update_option(c_al2fb_option_min_cap, 'edit_posts');

			// I18n
			load_plugin_textdomain(c_al2fb_text_domain, false, dirname(plugin_basename(__FILE__)) . '/language/');

			// Check user capability
			if (current_user_can(get_option(c_al2fb_option_min_cap))) {
				if (is_admin()) {
					// Enqueue script
					wp_enqueue_script('jquery');

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

					// Initiate Facebook authorization
					if (isset($_REQUEST['al2fb_action']) && $_REQUEST['al2fb_action'] == 'init') {
						// Debug info
						update_option(c_al2fb_log_redir_init, date('c'));

						// Redirect
						$auth_url = self::Authorize_url();
						try {
							// Check
							if (ini_get('safe_mode') || ini_get('open_basedir'))
								update_option(c_al2fb_log_redir_check, 'No');
							else {
								$response = self::Request($auth_url, '', 'GET');
								update_option(c_al2fb_log_redir_check, date('c'));
							}
							// Redirect
							wp_redirect($auth_url);
							exit();
						}
						catch (Exception $e) {
							// Register error
							update_option(c_al2fb_log_redir_check, $e->getMessage());
							// Redirect
							$error_url = admin_url('tools.php?page=' . plugin_basename($this->main_file));
							$error_url .= '&al2fb_action=error';
							$error_url .= '&error=' . urlencode($e->getMessage());
							wp_redirect($error_url);
							exit();
						}
					}
				}

				// Handle Facebook authorization
				self::Authorize();
			}
		}

		// Display admin messages
		function Admin_notices() {
			// Check user capability
			if (current_user_can(get_option(c_al2fb_option_min_cap))) {
				// Get current user
				global $user_ID;
				get_currentuserinfo();

				// Check actions
				if (isset($_REQUEST['al2fb_action'])) {
					// Configuration
					if ($_REQUEST['al2fb_action'] == 'config')
						self::Action_config();

					// Authorization
					else if ($_REQUEST['al2fb_action'] == 'authorize')
						self::Action_authorize();

					// Mail debug info
					else if ($_REQUEST['al2fb_action'] == 'mail')
						self::Action_mail();
				}

				self::Check_config();
			}
		}

		// Save settings
		function Action_config() {
			// Security check
			check_admin_referer(c_al2fb_nonce_form);

			// Get current user
			global $user_ID;
			get_currentuserinfo();

			// Default values
			if (empty($_POST[c_al2fb_meta_shared]))
				$_POST[c_al2fb_meta_shared] = null;
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
			if (empty($_POST[c_al2fb_meta_shortlink]))
				$_POST[c_al2fb_meta_shortlink] = null;
			if (empty($_POST[c_al2fb_meta_sentences]))
				$_POST[c_al2fb_meta_sentences] = null;
			if (empty($_POST[c_al2fb_meta_integrate]))
				$_POST[c_al2fb_meta_integrate] = null;
			if (empty($_POST[c_al2fb_meta_clean]))
				$_POST[c_al2fb_meta_clean] = null;
			if (empty($_POST[c_al2fb_meta_donated]))
				$_POST[c_al2fb_meta_donated] = null;

			$_POST[c_al2fb_meta_client_id] = trim($_POST[c_al2fb_meta_client_id]);
			$_POST[c_al2fb_meta_app_secret] = trim($_POST[c_al2fb_meta_app_secret]);
			$_POST[c_al2fb_meta_picture] = trim(stripslashes($_POST[c_al2fb_meta_picture]));
			$_POST[c_al2fb_meta_sentences] = trim($_POST[c_al2fb_meta_sentences]);

			// Shared changed
			if ($_POST[c_al2fb_meta_shared] != get_user_meta($user_ID, c_al2fb_meta_shared, true))
					delete_user_meta($user_ID, c_al2fb_meta_access_token);

			// App ID or secret changed
			if (!$_POST[c_al2fb_meta_shared])
				if (get_user_meta($user_ID, c_al2fb_meta_client_id, true) != $_POST[c_al2fb_meta_client_id] ||
					get_user_meta($user_ID, c_al2fb_meta_app_secret, true) != $_POST[c_al2fb_meta_app_secret])
					delete_user_meta($user_ID, c_al2fb_meta_access_token);

			// Page owner changed
			if ($_POST[c_al2fb_meta_page_owner] && !get_user_meta($user_ID, c_al2fb_meta_page_owner, true))
				delete_user_meta($user_ID, c_al2fb_meta_access_token);

			// Update user options
			update_user_meta($user_ID, c_al2fb_meta_shared, $_POST[c_al2fb_meta_shared]);
			update_user_meta($user_ID, c_al2fb_meta_client_id, $_POST[c_al2fb_meta_client_id]);
			update_user_meta($user_ID, c_al2fb_meta_app_secret, $_POST[c_al2fb_meta_app_secret]);
			update_user_meta($user_ID, c_al2fb_meta_picture_type, $_POST[c_al2fb_meta_picture_type]);
			update_user_meta($user_ID, c_al2fb_meta_picture, $_POST[c_al2fb_meta_picture]);
			update_user_meta($user_ID, c_al2fb_meta_page, $_POST[c_al2fb_meta_page]);
			update_user_meta($user_ID, c_al2fb_meta_page_owner, $_POST[c_al2fb_meta_page_owner]);
			update_user_meta($user_ID, c_al2fb_meta_caption, $_POST[c_al2fb_meta_caption]);
			update_user_meta($user_ID, c_al2fb_meta_msg, $_POST[c_al2fb_meta_msg]);
			update_user_meta($user_ID, c_al2fb_meta_shortlink, $_POST[c_al2fb_meta_shortlink]);
			update_user_meta($user_ID, c_al2fb_meta_sentences, $_POST[c_al2fb_meta_sentences]);
			update_user_meta($user_ID, c_al2fb_meta_integrate, $_POST[c_al2fb_meta_integrate]);
			update_user_meta($user_ID, c_al2fb_meta_clean, $_POST[c_al2fb_meta_clean]);
			update_user_meta($user_ID, c_al2fb_meta_donated, $_POST[c_al2fb_meta_donated]);

			// Update admin options
			if (current_user_can('manage_options')) {
				if (empty($_POST[c_al2fb_option_nonotice]))
					$_POST[c_al2fb_option_nonotice] = null;
				if (empty($_POST[c_al2fb_option_min_cap]))
					$_POST[c_al2fb_option_min_cap] = null;
				if (empty($_POST[c_al2fb_option_msg_refresh]))
					$_POST[c_al2fb_option_msg_refresh] = null;

				update_option(c_al2fb_option_nonotice, $_POST[c_al2fb_option_nonotice]);
				update_option(c_al2fb_option_min_cap, $_POST[c_al2fb_option_min_cap]);
				update_option(c_al2fb_option_msg_refresh, $_POST[c_al2fb_option_msg_refresh]);

				if (isset($_REQUEST['debug'])) {
					if (empty($_POST[c_al2fb_option_siteurl]))
						$_POST[c_al2fb_option_siteurl] = null;
					if (empty($_POST[c_al2fb_option_nocurl]))
						$_POST[c_al2fb_option_nocurl] = null;

					update_option(c_al2fb_option_siteurl, $_POST[c_al2fb_option_siteurl]);
					update_option(c_al2fb_option_nocurl, $_POST[c_al2fb_option_nocurl]);
				}
			}

			// Show result
			echo '<div id="message" class="updated fade al2fb_notice"><p>' . __('Settings updated', c_al2fb_text_domain) . '</p></div>';
		}

		// Get token
		function Action_authorize() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			// Client-side flow authorization
			if (get_user_meta($user_ID, c_al2fb_meta_shared, true) && isset($_REQUEST['access_token'])) {
				update_user_meta($user_ID, c_al2fb_meta_access_token, $_REQUEST['access_token']);
				echo '<div id="message" class="updated fade al2fb_notice"><p>' . __('Authorized, go posting!', c_al2fb_text_domain) . '</p></div>';
			}

			// Server-side flow authorization
			if (isset($_REQUEST['code'])) {
				try {
					// Get & store token
					$access_token = self::Get_token();
					update_user_meta($user_ID, c_al2fb_meta_access_token, $access_token);
					echo '<div id="message" class="updated fade al2fb_notice"><p>' . __('Authorized, go posting!', c_al2fb_text_domain) . '</p></div>';
				}
				catch (Exception $e) {
					delete_user_meta($user_ID, c_al2fb_meta_access_token);
					echo '<div id="message" class="error fade al2fb_error"><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, get_bloginfo('charset')) . '</p></div>';
				}
			}

			// Authorization error
			else if (isset($_REQUEST['error'])) {
				$msg = $_REQUEST['error_description'];
				$msg .= ' reason=' . $_REQUEST['error_reason'];
				$msg .= ' error=' . $_REQUEST['error'];
				update_option(c_al2fb_last_error, $msg);
				update_option(c_al2fb_last_error_time, date('c'));
				echo '<div id="message" class="error fade al2fb_error"><p>' . $_REQUEST['error_description'] . '</p></div>';
			}
		}

		// Send debug info
		function Action_mail() {
			// Check security
			check_admin_referer(c_al2fb_nonce_form);

			// Build headers
			$headers = 'From: ' . stripslashes($_POST[c_al2fb_mail_name]) . '<' . stripslashes($_POST[c_al2fb_mail_email]) . '>' . "\r\n";
			$headers .= 'X-Mailer: AL2FB' . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=' . get_bloginfo('charset') . "\r\n";

			// Build message
			$message = '<html><head><title>Add Link to Facebook</title></head><body>';
			$message .= '<p>' . nl2br(htmlspecialchars(stripslashes($_POST[c_al2fb_mail_msg]))) . '</p>';
			$message .= '<hr />';
			$message .= self::Debug_info();
			$message .= '</body></html>';
			if (mail('marcel@bokhorst.biz', '[Add Link to Facebook] Debug information', $message, $headers))
				echo '<div id="message" class="updated fade al2fb_notice"><p>' . __('Debug information sent', c_al2fb_text_domain) . '</p></div>';
			else
				echo '<div id="message" class="error fade al2fb_error"><p>' . __('Sending debug information failed', c_al2fb_text_domain) . '</p></div>';
		}

		// Display notices
		function Check_config() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			// Check config/authorization
			$uri = $_SERVER['REQUEST_URI'];
			$url = 'tools.php?page=' . plugin_basename($this->main_file);
			if (get_option(c_al2fb_option_nonotice) ? strpos($uri, $url) !== false : true) {
				if (!get_user_meta($user_ID, c_al2fb_meta_shared, true) &&
					(!get_user_meta($user_ID, c_al2fb_meta_client_id, true) ||
					!get_user_meta($user_ID, c_al2fb_meta_app_secret, true))) {
					$notice = __('needs configuration', c_al2fb_text_domain);
					$anchor = 'configure';
				}
				else if (!get_user_meta($user_ID, c_al2fb_meta_access_token, true)) {
					$notice = __('needs authorization', c_al2fb_text_domain);
					$anchor = 'authorize';
				}
				if (!empty($notice)) {
					$url .= '#' . $anchor;
					echo '<div class="error fade al2fb_error"><p>';
					_e('Add Link to Facebook', c_al2fb_text_domain);
					echo ' <a href="' . $url . '">' . $notice . '</a></p></div>';
				}
			}

			// Check for error
			if (isset($_REQUEST['al2fb_action']) && $_REQUEST['al2fb_action'] == 'error') {
					echo '<div id="message" class="error fade al2fb_error"><p>';
					echo htmlspecialchars(stripslashes($_REQUEST['error'])) . '</p></div>';
			}

			// Check for post errors
			$posts = new WP_Query(array('meta_key' => c_al2fb_meta_error, 'posts_per_page' => 5));
			while ($posts->have_posts()) {
				$posts->next_post();
				$error = get_post_meta($posts->post->ID, c_al2fb_meta_error, true);
				if (!empty($error)) {
					echo '<div id="message" class="error fade al2fb_error"><p>';
					echo __('Add Link to Facebook', c_al2fb_text_domain) . ' - ';
					edit_post_link($posts->post->post_title, null, null, $posts->post->ID);
					echo ': ' . htmlspecialchars($error) . '</p></div>';
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
			if (!current_user_can(get_option(c_al2fb_option_min_cap)))
				die('Unauthorized');

			// Get current user
			global $user_ID;
			get_currentuserinfo();

			$charset = get_bloginfo('charset');
			$access_token = get_user_meta($user_ID, c_al2fb_meta_access_token, true);
			$config_url = admin_url('tools.php?page=' . plugin_basename($this->main_file));
			if (isset($_REQUEST['debug']))
				$config_url .= '&debug';

			// Decode picture type
			$pic_type = get_user_meta($user_ID, c_al2fb_meta_picture_type, true);
			$pic_wordpress = ($pic_type == 'wordpress' ? ' checked' : '');
			$pic_media = ($pic_type == 'media' ? ' checked' : '');
			$pic_featured = ($pic_type == 'featured' ? ' checked' : '');
			$pic_facebook = ($pic_type == 'facebook' ? ' checked' : '');
			$pic_custom = ($pic_type == 'custom' ? ' checked' : '');
			if (!current_theme_supports('post-thumbnails') ||
				!function_exists('get_post_thumbnail_id') ||
				!function_exists('wp_get_attachment_image_src'))
				$pic_featured .= ' disabled';

			// Sustainable Plugins Sponsorship Network
			self::Render_sponsorship();
?>
			<div class="wrap">
			<h2><?php _e('Add Link to Facebook', c_al2fb_text_domain); ?></h2>
<?php
			// Check connectivity
			if (!ini_get('allow_url_fopen') && !function_exists('curl_init'))
				echo '<div id="message" class="error fade al2fb_error"><p>' . __('Your server may not allow external connections', c_al2fb_text_domain) . '</p></div>';

			self::Render_debug_info();
			self::Render_resources();
?>
			<div class="al2fb_options">

<?php		if (get_user_meta($user_ID, c_al2fb_meta_shared, true) ||
				(get_user_meta($user_ID, c_al2fb_meta_client_id, true) &&
				get_user_meta($user_ID, c_al2fb_meta_app_secret, true))) {
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

			<form method="post" action="<?php echo $config_url; ?>">
			<input type="hidden" name="al2fb_action" value="config">
			<?php wp_nonce_field(c_al2fb_nonce_form); ?>

<?php		if (self::Client_side_flow_available()) { ?>
				<table class="form-table">
				<tr valign="top"><th scope="row">
					<label for="al2fb_app_shared"><strong><?php _e('Use shared Facebook application:', c_al2fb_text_domain); ?></strong></label>
				</th><td>
					<input id="al2fb_app_shared" name="<?php echo c_al2fb_meta_shared; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_shared, true)) echo ' checked="checked"'; ?> />
					<strong>Beta!</strong>
					<br /><span class="al2fb_explanation"><?php _e('Simple, but less secure', c_al2fb_text_domain); ?></span>
				</td></tr>
				</table>
<?php		} ?>

			<div id="al2fb_app_private" style="display: none;">
			<div class="al2fb_instructions">
			<h4><?php _e('To get an App ID and App Secret you have to create a Facebook application', c_al2fb_text_domain); ?></h4>
			<span><strong><?php _e('You have to fill in the following:', c_al2fb_text_domain); ?></strong></span>
			<table>
				<tr>
					<td><span class="al2fb_label"><strong><?php _e('App Name:', c_al2fb_text_domain); ?></strong></span></td>
					<td><span class="al2fb_data"><?php _e('Anything you like, will appear as "via ..." below the message', c_al2fb_text_domain); ?></span></td>
				</tr>
				<tr>
					<td><span class="al2fb_label"><strong><?php _e('Web Site > Site URL:', c_al2fb_text_domain); ?></strong></span></td>
					<td><span class="al2fb_data"><?php echo htmlspecialchars(self::Redirect_uri(), ENT_QUOTES, $charset); ?></span></td>
				</tr>
			</table>
			<a href="http://www.facebook.com/developers/createapp.php" target="_blank">	<?php _e('Click here to create', c_al2fb_text_domain); ?></a>
			</div>

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
			</table>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function($) {
					if ($('#al2fb_app_shared:checked').length)
						$('#al2fb_app_private').hide();
					else
						$('#al2fb_app_private').show();

					$('#al2fb_app_shared').click(function() {
						if ($('#al2fb_app_shared:checked').length)
							$('#al2fb_app_private').hide();
						else
							$('#al2fb_app_private').show();
					});
				});
			</script>

			<table class="form-table">
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
				<input type="radio" name="<?php echo c_al2fb_meta_picture_type; ?>" value="media"<?php echo $pic_media; ?>><?php _e('First attached image', c_al2fb_text_domain); ?><br>
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
				<label for="al2fb_shortlink"><?php _e('Use short URL:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_shortlink" name="<?php echo c_al2fb_meta_shortlink; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_shortlink, true)) echo ' checked="checked"'; ?> />
				<br /><span class="al2fb_explanation"><?php _e('If available', c_al2fb_text_domain); ?></span>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_sentence"><?php _e('Number of sentences to use:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input class="al2fb_numeric" id="al2fb_sentence" name="<?php echo c_al2fb_meta_sentences; ?>" text="text" value="<?php  echo get_user_meta($user_ID, c_al2fb_meta_sentences, true); ?>" />
				<br /><span class="al2fb_explanation"><?php _e('Leave blank to let Facebook choose', c_al2fb_text_domain); ?></span>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_integrate"><?php _e('Integrate comments from Facebook:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_integrate" name="<?php echo c_al2fb_meta_integrate; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_integrate, true)) echo ' checked="checked"'; ?> />
				<strong>Beta!</strong>
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

				<tr valign="top"><th scope="row">
					<label for="al2fb_cache"><?php _e('Refresh Facebook comments every:', c_al2fb_text_domain); ?></label>
				</th><td>
					<input class="al2fb_numeric" id="al2fb_cache" name="<?php echo c_al2fb_option_msg_refresh; ?>" text="text" value="<?php  echo get_option(c_al2fb_option_msg_refresh); ?>" />
					<span><?php _e('Minutes', c_al2fb_text_domain); ?></span>
					<br /><span class="al2fb_explanation"><?php _e('Default every 10 minutes', c_al2fb_text_domain); ?></span>
				</td></tr>
				</table>

<?php		   if (isset($_REQUEST['debug'])) { ?>
					<h3><?php _e('Debug options', c_al2fb_text_domain); ?></h3>
					<table class="form-table">
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
					</table>
<?php		   } ?>
<?php	   } ?>

			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save', c_al2fb_text_domain) ?>" />
			</p>
			</form>

			</div>
			</div>
<?php
		}

		function Render_sponsorship() {
			global $user_ID;
			get_currentuserinfo();
			if (!get_user_meta($user_ID, c_al2fb_meta_donated, true)) {
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

		function Render_resources() {
			global $user_ID;
			get_currentuserinfo();
?>
			<div class="al2fb_resources">
			<h3><?php _e('Resources', c_al2fb_text_domain); ?></h3>
			<ul>
			<li><a href="http://wordpress.org/extend/plugins/add-link-to-facebook/faq/" target="_blank"><?php _e('Frequently asked questions', c_al2fb_text_domain); ?></a></li>
			<li><a href="http://blog.bokhorst.biz/5018/computers-en-internet/wordpress-plugin-add-link-to-facebook/" target="_blank"><?php _e('Support page', c_al2fb_text_domain); ?></a></li>
			<li><a href="<?php echo 'tools.php?page=' . plugin_basename($this->main_file) . '&debug'; ?>"><?php _e('Debug information', c_al2fb_text_domain); ?></a></li>
			<li><a href="http://blog.bokhorst.biz/about/" target="_blank"><?php _e('About the author', c_al2fb_text_domain); ?></a></li>
			<li><a href="http://wordpress.org/extend/plugins/profile/m66b" target="_blank"><?php _e('Other plugins', c_al2fb_text_domain); ?></a></li>
			</ul>
<?php	   if (!get_user_meta($user_ID, c_al2fb_meta_donated, true)) { ?>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			</form>
<?php	   } ?>
			</div>
<?php
		}

		function Render_debug_info() {
			// Debug information
			if (isset($_REQUEST['debug'])) {
				global $user_identity, $user_email;
				get_currentuserinfo();
?>
				<hr />
				<h3><?php _e('Debug information', c_al2fb_text_domain) ?></h3>
				<form method="post" action="">
				<input type="hidden" name="al2fb_action" value="mail">
				<?php wp_nonce_field(c_al2fb_nonce_form); ?>

				<table class="form-table">
				<tr valign="top"><th scope="row">
					<label for="al2fb_debug_name"><strong><?php _e('Name:', c_al2fb_text_domain); ?></strong></label>
				</th><td>
					<input id="al2fb_debug_name" class="" name="<?php echo c_al2fb_mail_name; ?>" type="text" value="<?php echo $user_identity; ?>" />
				</td></tr>

				<tr valign="top"><th scope="row">
					<label for="al2fb_debug_email"><strong><?php _e('E-mail:', c_al2fb_text_domain); ?></strong></label>
				</th><td>
					<input id="al2fb_debug_email" class="" name="<?php echo c_al2fb_mail_email; ?>" type="text" value="<?php echo $user_email; ?>" />
				</td></tr>

				<tr valign="top"><th scope="row">
					<label for="al2fb_debug_msg"><strong><?php _e('Message:', c_al2fb_text_domain); ?></strong></label>
				</th><td>
					<textarea id="al2fb_debug_msg" name="<?php echo c_al2fb_mail_msg; ?>" rows="10" cols="50"></textarea>
				</td></tr>
				</table>

				<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Send', c_al2fb_text_domain) ?>" />
				</p>
				</form>
<?php
				echo self::Debug_info();
			}
		}

		function Client_side_flow_available() {
			try {
				return self::Request(c_al2fb_app_url, 'available=' . c_al2fb_app_version, 'GET');
			}
			catch (Exception $e) {
				return false;
			}
		}

		// Get Facebook authorize addess
		function Authorize_url() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			// http://developers.facebook.com/docs/authentication/permissions
			$url = 'https://graph.facebook.com/oauth/authorize';

			$shared = get_user_meta($user_ID, c_al2fb_meta_shared, true);
			if ($shared) {
				$url .= '?client_id=' . c_al2fb_app_id;
				$url .= '&redirect_uri=' . urlencode(c_al2fb_app_url);
			}
			else {
				$url .= '?client_id=' . get_user_meta($user_ID, c_al2fb_meta_client_id, true);
				$url .= '&redirect_uri=' . urlencode(self::Redirect_uri());
			}

			$url .= '&scope=publish_stream,offline_access';
			if (get_user_meta($user_ID, c_al2fb_meta_page_owner, true))
				$url .= ',manage_pages';

			$url .= '&state=' . self::Authorize_secret();
			if ($shared) {
				$url .= ',' . urlencode(self::Redirect_uri());
				$url .= ',' . c_al2fb_app_version;
				$url .= '&response_type=token';
			}
			return $url;
		}

		// Get Facebook return addess
		function Redirect_uri() {
			// WordPress Address -> get_site_url() -> WordPress folder
			// Blog Address -> get_home_url() -> Home page
			if (get_option(c_al2fb_option_siteurl))
				return get_site_url(null, '/');
			else
				return get_home_url(null, '/');
		}

		// Generate authorization secret
		function Authorize_secret() {
			return 'al2fb_auth_' . substr(md5(AUTH_KEY ? AUTH_KEY : get_bloginfo('url')), 0, 10);
		}

		// Handle Facebook authorization
		function Authorize() {
			parse_str($_SERVER['QUERY_STRING'], $query);
			if (isset($query['state']) && strpos($query['state'], self::Authorize_secret()) !== false) {
				// Build new url
				$query['state'] = '';
				$query['al2fb_action'] = 'authorize';
				$url = admin_url('tools.php?page=' . plugin_basename($this->main_file));
				$url .= '&' . http_build_query($query);

				// Debug info
				update_option(c_al2fb_log_redir_time, date('c'));
				update_option(c_al2fb_log_redir_ref, (empty($_SERVER['HTTP_REFERER']) ? null : $_SERVER['HTTP_REFERER']));
				update_option(c_al2fb_log_redir_from, $_SERVER['REQUEST_URI']);
				update_option(c_al2fb_log_redir_to, $url);

				// Redirect
				wp_redirect($url);
				exit();
			}
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

		// Get application properties
		function Get_application() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			if (get_user_meta($user_ID, c_al2fb_meta_shared, true))
				$app_id = c_al2fb_app_id;
			else
				$app_id = get_user_meta($user_ID, c_al2fb_meta_client_id, true);
			$url = 'https://graph.facebook.com/' . $app_id;
			$query = http_build_query(array(
				'access_token' => get_user_meta($user_ID, c_al2fb_meta_access_token, true)
			));
			$response = self::Request($url, $query, 'GET');
			$app = json_decode($response);
			return $app;
		}

		// Get wall or page name
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

		// Get page list
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

		// Get comments
		function Get_comments($id) {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			$url = 'https://graph.facebook.com/' . $id . '/comments';
			$query = http_build_query(array(
				'access_token' => get_user_meta($user_ID, c_al2fb_meta_access_token, true)
			));
			$response = self::Request($url, $query, 'GET');
			$comments = json_decode($response);
			return $comments;
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
				<input id="al2fb_exclude" type="checkbox" name="<?php echo c_al2fb_meta_exclude; ?>" <?php echo $chk_exclude; ?> />
				<label for="al2fb_exclude"><?php _e('Do not add link to Facebook', c_al2fb_text_domain); ?></label>
<?php
				$link_id = get_post_meta($post->ID, c_al2fb_meta_link_id, true);
				if (!empty($link_id)) {
?>
					<br />
					<input id="al2fb_delete" type="checkbox" name="al2fb_delete"/>
					<label for="al2fb_delete"><?php _e('Delete existing Facebook link', c_al2fb_text_domain); ?></label>
<?php
				}
?>
				</div>
<?php
			}
		}

		// Add post Facebook column
		function Manage_posts_columns($posts_columns) {
			if (current_user_can(get_option(c_al2fb_option_min_cap)))
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
			if (current_user_can(get_option(c_al2fb_option_min_cap)))
				add_meta_box(
					'al2fb_meta',
					__('Add Link to Facebook', c_al2fb_text_domain),
					array(&$this,  'Meta_box'),
					'post');
		}

		// Modify comment list
		function Comments_array($comments, $post_ID) {
			// Check if feature enabled
			$post = get_post($post_ID);
			if (get_user_meta($post->post_author, c_al2fb_meta_integrate, true)) {
				$link_id = get_post_meta($post_ID, c_al2fb_meta_link_id, true);
				if ($link_id) {
					try {
						// Check cache
						$duration = intval(get_option(c_al2fb_option_msg_refresh));
						if (!$duration)
							$duration = 10;
						$fb_key = 'al2fb_cache_' . $link_id;
						$fb_comments = get_transient($fb_key);
						if ($fb_comments === false) {
							$fb_comments = self::Get_comments($link_id);
							set_transient($fb_key, $fb_comments, $duration * 60);
						}
						// Check if comments
						if ($fb_comments) {
							foreach ($fb_comments->data as $fb_comment) {
								// Create new virtual comment
								$new = null;
								$new->comment_ID = $fb_comment->id;
								$new->comment_post_ID = $post_ID;
								$new->comment_author = $fb_comment->from->name . ' ' . __('on Facebook', c_al2fb_text_domain);
								$new->comment_author_email = '';
								$new->comment_author_url = 'http://www.facebook.com/profile.php?id=' . $fb_comment->from->id;
								$new->comment_author_ip = '';
								$new->comment_date = date('Y-m-d H:i:s', strtotime($fb_comment->created_time));
								$new->comment_date_gmt = $new->comment_date;
								$new->comment_content = $fb_comment->message;
								$new->comment_karma = 0;
								$new->comment_approved = 1;
								$new->comment_agent = 'Add Link to Facebook';
								$new->comment_type = ''; // pingback|trackback
								$new->comment_parent = 0;
								$new->user_id = 0;
								$comments[] = $new;
							}

							// Sort comments by time
							usort($comments, array(&$this, 'Comment_compare'));
							if (get_option('comment_order') == 'desc')
								array_reverse($comments);
						}
					}
					catch (Exception $e) {
						// Todo: what?
					}
				}
			}
			return $comments;
		}

		function Comment_compare($a, $b) {
			return strcmp($a->comment_date_gmt, $b->comment_date_gmt);
		}

		// Display attached image selector
		function Meta_box() {
			// Security
			wp_nonce_field(plugin_basename(__FILE__), c_al2fb_nonce_form);

			if (function_exists('wp_get_attachment_image_src')) {
				// Get attached images
				global $post;
				$images = &get_children('post_type=attachment&post_mime_type=image&order=ASC&post_parent=' . $post->ID);
				if (empty($images))
					echo '<span>' . __('No images in the media library for this post', c_al2fb_text_domain) . '</span>';
				else {
					// Display image selector
					$disabled = get_post_meta($post->ID, c_al2fb_meta_link_id, true);
					$disabled = (empty($disabled) ? '' : ' disabled');
					$image_id = get_post_meta($post->ID, c_al2fb_meta_image_id, true);

					// Header
					echo '<h4>' . __('Select link image:', c_al2fb_text_domain) . '</h4>';
					echo '<div class="al2fb_images">';

					// None
					echo '<div class="al2fb_image">';
					echo '<input type="radio" name="al2fb_image_id" id="al2fb_image_0"';
					if (empty($image_id))
						echo ' checked';
					echo $disabled;
					echo ' value="0">';
					echo '<br />';
					echo '<label for="al2fb_image_0">';
					echo __('None', c_al2fb_text_domain) . '</label>';
					echo '</div>';

					// Images
					foreach ($images as $attachment_id => $attachment) {
						$picture = wp_get_attachment_image_src($attachment_id, 'thumbnail');

						echo '<div class="al2fb_image">';
						echo '<input type="radio" name="al2fb_image_id" id="al2fb_image_' . $attachment_id . '"';
						if ($attachment_id == $image_id)
							echo ' checked';
						echo $disabled;
						echo ' value="' . $attachment_id . '">';
						echo '<br />';
						echo '<label for="al2fb_image_' . $attachment_id . '">';
						echo '<img src="' . $picture[0] . '" alt=""></label>';
						echo '<br />';
						echo '<span>' . $picture[1] . ' x ' . $picture[2] . '</span>';
						echo '</div>';
					}
					echo '</div>';
				}
			}
			else
				echo 'wp_get_attachment_image_src does not exist';
		}

		// Save selected attached image
		function Save_post($post_id) {
			// Security checks
			$nonce = (isset($_POST[c_al2fb_nonce_form]) ? $_POST[c_al2fb_nonce_form] : null);
			if (!wp_verify_nonce($nonce, plugin_basename(__FILE__)))
				return $post_id;
			if (!current_user_can('edit_post', $post_id))
				return $post_id;
			if (!current_user_can(get_option(c_al2fb_option_min_cap)))
				return $post_id;

			// Skip auto save
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return $post_id;

			// Persist data
			if (current_user_can(get_option(c_al2fb_option_min_cap))) {
				if (isset($_POST['al2fb_image_id']) && $_POST['al2fb_image_id'])
					update_post_meta($post_id, c_al2fb_meta_image_id, $_POST['al2fb_image_id']);
				else
					delete_post_meta($post_id, c_al2fb_meta_image_id);
			}
		}

		// Handle post status change
		function Transition_post_status($new_status, $old_status, $post) {
			if (current_user_can(get_option(c_al2fb_option_min_cap))) {
				// Process exclude flag
				$prev_exclude = (empty($_POST[c_al2fb_meta_exclude . '_prev']) ? null : $_POST[c_al2fb_meta_exclude . '_prev']);
				$exclude = (empty($_POST[c_al2fb_meta_exclude]) ? null : $_POST[c_al2fb_meta_exclude]);
				if ($exclude)
					update_post_meta($post->ID, c_al2fb_meta_exclude, $exclude);
				else
					delete_post_meta($post->ID, c_al2fb_meta_exclude);

				// Add or delete link
				if (empty($_POST['al2fb_delete']) || !$_POST['al2fb_delete']) {
					// Check post status
					if ($new_status == 'publish' &&
						($new_status != $old_status ||
						(!$exclude && $prev_exclude) ||
						get_post_meta($post->ID, c_al2fb_meta_error, true)))
						self::Publish_post($post->ID);
				}
				else {
					$link_id = get_post_meta($post->ID, c_al2fb_meta_link_id, true);
					if (!empty($link_id) &&
						get_user_meta($post->post_author, c_al2fb_meta_access_token, true))
						self::Delete_link($post);
				}
			}
		}

		// Handle publish post / XML-RPC publish post
		function Publish_post($post_ID) {
			if (current_user_can(get_option(c_al2fb_option_min_cap))) {
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
		}

		// Add Link to Facebook
		function Add_link($post) {
			// Get url
			if (get_user_meta($post->post_author, c_al2fb_meta_shortlink, true))
				$link = wp_get_shortlink($post->ID);
			if (empty($link))
				$link = get_permalink($post->ID);

			// Get plain texts
			$excerpt = preg_replace('/<[^>]*>/', '', do_shortcode($post->post_excerpt));
			$content = preg_replace('/<[^>]*>/', '', do_shortcode($post->post_content));

			// Get number of configured sentences
			$sentences = intval(get_user_meta($post->post_author, c_al2fb_meta_sentences, true));
			if ($sentences) {
				$lines = explode('.', $content);
				if ($lines) {
					$count = 0;
					$content = '';
					foreach ($lines as $sentence) {
						$content .= $sentence;
						if ($count + 1 < count($lines))
							$content .= '.';
						if ($sentence)
							$count++;
						if ($count >= $sentences)
							break;
					}
				}
			}

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
				if ($picture_type == 'media') {
					$images = array_values(get_children('post_type=attachment&post_mime_type=image&order=ASC&post_parent=' . $post->ID));
					if (!empty($images) && function_exists('wp_get_attachment_image_src')) {
						$picture = wp_get_attachment_image_src($images[0]->ID, 'thumbnail');
						if ($picture && $picture[0])
							$picture = $picture[0];
					}
				}
				else if ($picture_type == 'featured') {
					if (current_theme_supports('post-thumbnails') &&
						function_exists('get_post_thumbnail_id') &&
						function_exists('wp_get_attachment_image_src')) {
						$picture_id = get_post_thumbnail_id($post->ID);
						if ($picture_id) {
							$picture = wp_get_attachment_image_src($picture_id, 'thumbnail');
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
				// Build request
				// http://developers.facebook.com/docs/reference/api/link/
				$page_id = get_user_meta($post->post_author, c_al2fb_meta_page, true);
				if (empty($page_id))
					$page_id = 'me';
				$url = 'https://graph.facebook.com/' . $page_id . '/feed';
				$query = http_build_query(array(
					'access_token' => self::Get_access_token($post),
					'link' => $link,
					'name' => $post->post_title,
					'caption' => $caption,
					'description' => $description,
					'picture' => $picture,
					'message' => $message
				));

				// Execute request
				$response = self::Request($url, $query, 'POST');
				$fb_link = json_decode($response);

				// Register link/date
				add_post_meta($post->ID, c_al2fb_meta_link_id, $fb_link->id);
				update_post_meta($post->ID, c_al2fb_meta_link_time, date('c'));
				update_post_meta($post->ID, c_al2fb_meta_link_picture, $picture_type . '=' . $picture);
				delete_post_meta($post->ID, c_al2fb_meta_error);
			}
			catch (Exception $e) {
				add_post_meta($post->ID, c_al2fb_meta_error, $e->getMessage());
				update_post_meta($post->ID, c_al2fb_meta_link_time, date('c'));
				update_post_meta($post->ID, c_al2fb_meta_link_picture, $picture_type . '=' . $picture);
			}
		}

		// Add Link to Facebook
		function Delete_link($post) {
			// Do not disturb WordPress
			try {
				// Build request
				// http://developers.facebook.com/docs/reference/api/link/
				$link_id = get_post_meta($post->ID, c_al2fb_meta_link_id, true);
				$url = 'https://graph.facebook.com/' . $link_id;
				$query = http_build_query(array(
					'access_token' => self::Get_access_token($post),
					'method' => 'delete'
				));

				// Execute request
				$response = self::Request($url, $query, 'POST');

				// Delete meta data
				delete_post_meta($post->ID, c_al2fb_meta_link_id);
				delete_post_meta($post->ID, c_al2fb_meta_link_time);
				delete_post_meta($post->ID, c_al2fb_meta_link_picture);
				delete_post_meta($post->ID, c_al2fb_meta_error);
			}
			catch (Exception $e) {
				add_post_meta($post->ID, c_al2fb_meta_error, $e->getMessage());
				update_post_meta($post->ID, c_al2fb_meta_link_time, date('c'));
			}
		}

		// Get correct access token
		function Get_access_token($post) {
			$page_id = get_user_meta($post->post_author, c_al2fb_meta_page, true);
			$access_token = get_user_meta($post->post_author, c_al2fb_meta_access_token, true);
			if ($page_id &&
				get_user_meta($post->post_author, c_al2fb_meta_page_owner, true)) {
				$found = false;
				$pages = self::Get_pages();
				foreach ($pages->data as $page)
					if ($page->id == $page_id) {
						$found = true;
						$access_token = $page->access_token;
					}
				if (!$found)
					throw new Exception('Page token not found id=' . $page_id);
			}

			return $access_token;
		}

		// Generic http request
		function Request($url, $query, $type) {
			// Get timeout
			$timeout = get_option(c_al2fb_option_timeout);
			if (!$timeout)
				$timeout = 30;

			// Use cURL if available
			if (function_exists('curl_init') && !get_option(c_al2fb_option_nocurl))
				return self::Request_cURL($url, $query, $type, $timeout);

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
				$content = file_get_contents($url . ($query ? '?' . $query : ''), false, $context);
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
			$auth_error = '';
			if (!empty($http_response_header))
				foreach ($http_response_header as $h)
					if (strpos($h, 'HTTP/') === 0) {
						$status = explode(' ', $h);
						$status = intval($status[1]);
					}
					else if (strpos($h, 'WWW-Authenticate:') === 0)
						$auth_error = $h;

			if ($status == 200)
				return $content;
			else {
				if ($auth_error)
					$msg = 'Error ' . $status . ': ' . $auth_error;
				else
					$msg = 'Error ' . $status . ': ' . $this->php_error . ' ' . print_r($http_response_header, true);
				update_option(c_al2fb_last_error, $msg);
				update_option(c_al2fb_last_error_time, date('c'));
				throw new Exception($msg);
			}
		}

		// Persist PHP errors
		function PHP_error_handler($errno, $errstr) {
			$this->php_error = $errstr;
		}

		// cURL http request
		function Request_cURL($url, $query, $type, $timeout) {
			$c = curl_init();
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

			if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
				curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($c, CURLOPT_MAXREDIRS, 10);
			}
			curl_setopt($c, CURLOPT_TIMEOUT, $timeout);

			if ($type == 'GET')
				curl_setopt($c, CURLOPT_URL, $url . ($query ? '?' . $query : ''));
			else {
				curl_setopt($c, CURLOPT_URL, $url);
				curl_setopt($c, CURLOPT_POST, true);
				curl_setopt($c, CURLOPT_POSTFIELDS, $query);
			}
			$content = curl_exec($c);
			$errno = curl_errno($c);
			$info = curl_getinfo($c);
			curl_close($c);

			if ($errno === 0 && $info['http_code'] == 200)
				return $content;
			else {
				$error = json_decode($content);
				$error = empty($error->error->message) ? $content : $error->error->message;
				if ($errno || !$error)
					$msg = 'cURL error ' . $errno . ': ' . $error . ' ' . print_r($info, true);
				else
					$msg = $error;
				update_option(c_al2fb_last_error, $msg);
				update_option(c_al2fb_last_error_time, date('c'));
				throw new Exception($msg);
			}
		}

		// Generate debug info
		function Debug_info() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			// Get versions
			global $wp_version;
			$plugin_folder = get_plugins('/' . plugin_basename(dirname(__FILE__)));
			$plugin_version = $plugin_folder[basename($this->main_file)]['Version'];

			// Get charset, token
			$charset = get_bloginfo('charset');
			$access_token = get_user_meta($user_ID, c_al2fb_meta_access_token, true);

			$info = '<div class="al2fb_debug"><table border="1">';
			$info .= '<tr><td>Time:</td><td>' . date('c') . '</td></tr>';
			$info .= '<tr><td>Server software:</td><td>' . htmlspecialchars($_SERVER['SERVER_SOFTWARE']) . '</td></tr>';
			$info .= '<tr><td>SAPI:</td><td>' . htmlspecialchars(php_sapi_name()) . '</td></tr>';
			$info .= '<tr><td>PHP version:</td><td>' . PHP_VERSION . '</td></tr>';
			$info .= '<tr><td>safe_mode:</td><td>' . (ini_get('safe_mode') ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>open_basedir:</td><td>' . ini_get('open_basedir') . '</td></tr>';
			$info .= '<tr><td>User agent:</td><td>' . htmlspecialchars($_SERVER['HTTP_USER_AGENT']) . '</td></tr>';
			$info .= '<tr><td>WordPress version:</td><td>' . $wp_version . '</td></tr>';
			$info .= '<tr><td>Plugin version:</td><td>' . $plugin_version . '</td></tr>';
			$info .= '<tr><td>Multi site:</td><td>' . (is_multisite() ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Blog address (home):</td><td>' . htmlspecialchars(get_home_url(), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>WordPress address (site):</td><td>' . htmlspecialchars(get_site_url(), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Redirect URI:</td><td>' . htmlspecialchars(self::Redirect_uri(), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Authorize URL:</td><td>' . htmlspecialchars(self::Authorize_url()) . '</td></tr>';
			$info .= '<tr><td>Authorization init:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_init)) . '</td></tr>';
			$info .= '<tr><td>Authorization check:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_check)) . '</td></tr>';
			$info .= '<tr><td>Redirect time:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_time)) . '</td></tr>';
			$info .= '<tr><td>Redirect referer:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_ref)) . '</td></tr>';
			$info .= '<tr><td>Redirect from:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_from)) . '</td></tr>';
			$info .= '<tr><td>Redirect to:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_to)) . '</td></tr>';
			$info .= '<tr><td>Authorized:</td><td>' . ($access_token ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>allow_url_fopen:</td><td>' . (ini_get('allow_url_fopen') ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>cURL:</td><td>' . (function_exists('curl_init') ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>SSL:</td><td>' . (function_exists('openssl_sign') ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Do not use cURL:</td><td>' . (get_option('c_al2fb_option_nocurl') ? 'Yes' : 'No') . '</td></tr>';

			$posts = new WP_Query(array('meta_key' => c_al2fb_meta_error, 'posts_per_page' => 5));
			while ($posts->have_posts()) {
				$posts->next_post();
				$error = get_post_meta($posts->post->ID, c_al2fb_meta_error, true);
				if (!empty($error)) {
					$info .= '<tr><td>Error:</td>';
					$info .= '<td>' . htmlspecialchars($error) . '</td></tr>';
					$info .= '<tr><td>Error time:</td>';
					$info .= '<td>' . htmlspecialchars(get_post_meta($posts->post->ID, c_al2fb_meta_link_time, true)) . '</td></tr>';
				}
			}

			$info .= '<tr><td>Last error:</td><td>' . htmlspecialchars(get_option(c_al2fb_last_error)) . '</td></tr>';
			$info .= '<tr><td>Last error time:</td><td>' . htmlspecialchars(get_option(c_al2fb_last_error_time)) . '</td></tr>';
			$info .= '</table></div>';
			return $info;
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
