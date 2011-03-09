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
define('c_al2fb_option_max_descr', 'al2fb_max_msg');
define('c_al2fb_option_exclude_type', 'al2fb_exclude_type');
define('c_al2fb_option_siteurl', 'al2fb_siteurl');
define('c_al2fb_option_nocurl', 'al2fb_nocurl');
define('c_al2fb_option_use_pp', 'al2fb_use_pp');
define('c_al2fb_option_debug', 'al2fb_debug');

// Site options
define('c_al2fb_option_app_share', 'al2fb_app_share');

// Transient options
define('c_al2fb_transient_cache', 'al2fb_cache_');
define('c_al2fb_transient_available', 'al2fb_available');

// User meta
define('c_al2fb_meta_shared', 'al2fb_shared');
define('c_al2fb_meta_client_id', 'al2fb_client_id');
define('c_al2fb_meta_app_secret', 'al2fb_app_secret');
define('c_al2fb_meta_access_token', 'al2fb_access_token');
define('c_al2fb_meta_picture_type', 'al2fb_picture_type');
define('c_al2fb_meta_picture', 'al2fb_picture');
define('c_al2fb_meta_picture_default', 'al2fb_picture_default');
define('c_al2fb_meta_page', 'al2fb_page');
define('c_al2fb_meta_page_owner', 'al2fb_page_owner');
define('c_al2fb_meta_use_groups', 'al2fb_use_groups');
define('c_al2fb_meta_group', 'al2fb_group');
define('c_al2fb_meta_caption', 'al2fb_caption');
define('c_al2fb_meta_msg', 'al2fb_msg');
define('c_al2fb_meta_shortlink', 'al2fb_shortlink');
define('c_al2fb_meta_trailer', 'al2fb_trailer');
define('c_al2fb_meta_hyperlink', 'al2fb_hyperlink');
define('c_al2fb_meta_share_link', 'al2fb_share_link');
define('c_al2fb_meta_fb_comments', 'al2fb_fb_comments');
define('c_al2fb_meta_fb_likes', 'al2fb_fb_likes');
define('c_al2fb_meta_post_likers', 'al2fb_post_likers');
define('c_al2fb_meta_post_like_button', 'al2fb_post_like_button');
define('c_al2fb_meta_like_nohome', 'al2fb_like_nohome');
define('c_al2fb_meta_like_noposts', 'al2fb_like_noposts');
define('c_al2fb_meta_like_nopages', 'al2fb_like_nopages');
define('c_al2fb_meta_like_layout', 'al2fb_like_layout');
define('c_al2fb_meta_like_faces', 'al2fb_like_faces');
define('c_al2fb_meta_like_width', 'al2fb_like_width');
define('c_al2fb_meta_like_action', 'al2fb_like_action');
define('c_al2fb_meta_like_font', 'al2fb_like_font');
define('c_al2fb_meta_like_colorscheme', 'al2fb_like_colorscheme');
define('c_al2fb_meta_like_link', 'al2fb_like_link');
define('c_al2fb_meta_open_graph', 'al2fb_open_graph');
define('c_al2fb_meta_clean', 'al2fb_clean');
define('c_al2fb_meta_donated', 'al2fb_donated');

// Post meta
define('c_al2fb_meta_link_id', 'al2fb_facebook_link_id');
define('c_al2fb_meta_link_time', 'al2fb_facebook_link_time');
define('c_al2fb_meta_link_picture', 'al2fb_facebook_link_picture');
define('c_al2fb_meta_exclude', 'al2fb_facebook_exclude');
define('c_al2fb_meta_error', 'al2fb_facebook_error');
define('c_al2fb_meta_image_id', 'al2fb_facebook_image_id');
define('c_al2fb_meta_log', 'al2fb_log');

// Logging
define('c_al2fb_log_redir_init', 'al2fb_redir_init');
define('c_al2fb_log_redir_check', 'al2fb_redir_check');
define('c_al2fb_log_redir_time', 'al2fb_redir_time');
define('c_al2fb_log_redir_ref', 'al2fb_redir_ref');
define('c_al2fb_log_redir_from', 'al2fb_redir_from');
define('c_al2fb_log_redir_to', 'al2fb_redir_to');
define('c_al2fb_log_auth_time', 'al2fb_auth_time');
define('c_al2fb_last_error', 'al2fb_last_error');
define('c_al2fb_last_error_time', 'al2fb_last_error_time');

// Mail
define('c_al2fb_mail_name', 'al2fb_debug_name');
define('c_al2fb_mail_email', 'al2fb_debug_email');
define('c_al2fb_mail_msg', 'al2fb_debug_msg');

// To Do
// - Check app permissions? not possible :-(
// - target="_blank"? how to do?
// - Admin dashboard? how to get links to messages?

// - Update meta box after update media gallery?
// - Use tage line?
// - Tags, categories?
// - Meta boxes if authorized?

// - Check min image size: what is it?

// Integration:
// - RSS
// - Comment replies
// - Recent comments
// - Edit link
// - Avatars
// - Like count

// Use link instead of feed?
// Add link to multiple walls
// Audio in Facebook?

// Define class
if (!class_exists('WPAL2Facebook')) {
	class WPAL2Facebook {
		// Class variables
		var $main_file = null;
		var $plugin_url = null;
		var $php_error = null;
		var $debug = null;

		// Constructor
		function __construct() {
			global $wp_version;

			// Get main file name
			$this->main_file = str_replace('-class', '', __FILE__);

			// Get plugin url
			$this->plugin_url = WP_PLUGIN_URL . '/' . basename(dirname($this->main_file));
			if (strpos($this->plugin_url, 'http') === 0 && is_ssl())
				$this->plugin_url = str_replace('http://', 'https://', $this->plugin_url);

			// Log
			$this->debug = get_option(c_al2fb_option_debug);

			// register activation actions
			register_activation_hook($this->main_file, array(&$this, 'Activate'));
			register_deactivation_hook($this->main_file, array(&$this, 'Deactivate'));

			// Register actions
			add_action('init', array(&$this, 'Init'), 0);
			if (is_admin()) {
				add_action('admin_menu', array(&$this, 'Admin_menu'));
				add_action('admin_notices', array(&$this, 'Admin_notices'));
				add_action('post_submitbox_start', array(&$this, 'Post_submitbox'));
				add_filter('manage_posts_columns', array(&$this, 'Manage_posts_columns'));
				add_action('manage_posts_custom_column', array(&$this, 'Manage_posts_custom_column'), 10, 2);
				add_action('add_meta_boxes', array(&$this, 'Add_meta_boxes'));
				add_action('save_post', array(&$this, 'Save_post'));
			}

			add_action('transition_post_status', array(&$this, 'Transition_post_status'), 10, 3);
			add_action('xmlrpc_publish_post', array(&$this, 'Remote_publish'));
			add_action('app_publish_post', array(&$this, 'Remote_publish'));
			add_action('future_to_publish', array(&$this, 'Future_to_publish'));
			add_action('al2fb_publish', array(&$this, 'Remote_publish'));

			if (get_option(c_al2fb_option_use_pp))
				add_action('publish_post', array(&$this, 'Remote_publish'));

			// Content
			add_action('wp_head', array(&$this, 'WP_head'));
			add_filter('the_content', array(&$this, 'The_content'), 999);
			//add_filter('the_posts', array(&$this, 'The_posts'), 10, 2);
			add_filter('comments_array', array(&$this, 'Comments_array'), 10, 2);
			add_filter('get_comments_number', array(&$this, 'Get_comments_number'), 10, 2);
		}

		// Handle plugin activation
		function Activate() {
			global $wpdb;
			$version = get_option(c_al2fb_option_version);
			if ($version <= 1) {
				delete_option(c_al2fb_meta_client_id);
				delete_option(c_al2fb_meta_app_secret);
				delete_option(c_al2fb_meta_access_token);
				delete_option(c_al2fb_meta_picture_type);
				delete_option(c_al2fb_meta_picture);
				delete_option(c_al2fb_meta_page);
				delete_option(c_al2fb_meta_clean);
				delete_option(c_al2fb_meta_donated);
			}
			if ($version <= 2) {
				$rows = $wpdb->get_results("SELECT user_id, meta_value FROM " . $wpdb->usermeta . " WHERE meta_key='al2fb_integrate'");
				foreach ($rows as $row) {
					update_user_meta($row->user_id, c_al2fb_meta_fb_comments, $row->meta_value);
					update_user_meta($row->user_id, c_al2fb_meta_fb_likes, $row->meta_value);
					delete_user_meta($row->user_id, 'al2fb_integrate');
				}
			}
			if ($version <= 3) {
				global $wpdb;
				$rows = $wpdb->get_results("SELECT ID FROM " . $wpdb->users);
				foreach ($rows as $row)
					update_user_meta($row->ID, c_al2fb_meta_like_faces, true);
			}
			if ($version <= 4) {
				$rows = $wpdb->get_results("SELECT user_id, meta_value FROM " . $wpdb->usermeta . " WHERE meta_key='" . c_al2fb_meta_trailer . "'");
				foreach ($rows as $row) {
					$value = get_user_meta($row->user_id, c_al2fb_meta_trailer, true);
					update_user_meta($row->user_id, c_al2fb_meta_trailer, ' ' . $value);
				}
			}
			update_option(c_al2fb_option_version, 5);
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
				delete_user_meta($user_ID, c_al2fb_meta_picture_default);
				delete_user_meta($user_ID, c_al2fb_meta_page);
				delete_user_meta($user_ID, c_al2fb_meta_page_owner);
				delete_user_meta($user_ID, c_al2fb_meta_use_groups);
				delete_user_meta($user_ID, c_al2fb_meta_group);
				delete_user_meta($user_ID, c_al2fb_meta_caption);
				delete_user_meta($user_ID, c_al2fb_meta_msg);
				delete_user_meta($user_ID, c_al2fb_meta_shortlink);
				delete_user_meta($user_ID, c_al2fb_meta_trailer);
				delete_user_meta($user_ID, c_al2fb_meta_hyperlink);
				delete_user_meta($user_ID, c_al2fb_meta_share_link);
				delete_user_meta($user_ID, c_al2fb_meta_fb_comments);
				delete_user_meta($user_ID, c_al2fb_meta_fb_likes);
				delete_user_meta($user_ID, c_al2fb_meta_post_likers);
				delete_user_meta($user_ID, c_al2fb_meta_post_like_button);
				delete_user_meta($user_ID, c_al2fb_meta_like_nohome);
				delete_user_meta($user_ID, c_al2fb_meta_like_noposts);
				delete_user_meta($user_ID, c_al2fb_meta_like_nopages);
				delete_user_meta($user_ID, c_al2fb_meta_like_layout);
				delete_user_meta($user_ID, c_al2fb_meta_like_faces);
				delete_user_meta($user_ID, c_al2fb_meta_like_width);
				delete_user_meta($user_ID, c_al2fb_meta_like_action);
				delete_user_meta($user_ID, c_al2fb_meta_like_font);
				delete_user_meta($user_ID, c_al2fb_meta_like_colorscheme);
				delete_user_meta($user_ID, c_al2fb_meta_like_link);
				delete_user_meta($user_ID, c_al2fb_meta_open_graph);
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

			// Image request
			if (isset($_GET['al2fb_image'])) {
				$img = dirname(__FILE__) . '/wp-blue-s.png';
				header('Content-type: image/png');
				readfile($img);
  				exit();
			}

			// Set default capability
			if (!get_option(c_al2fb_option_min_cap))
				update_option(c_al2fb_option_min_cap, 'edit_posts');

			// I18n
			load_plugin_textdomain(c_al2fb_text_domain, false, dirname(plugin_basename(__FILE__)) . '/language/');

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

			// Check user capability
			if (current_user_can(get_option(c_al2fb_option_min_cap))) {
				if (is_admin()) {
					// Enqueue script
					wp_enqueue_script('jquery');

					// Initiate Facebook authorization
					if (isset($_REQUEST['al2fb_action']) && $_REQUEST['al2fb_action'] == 'init') {
						// Debug info
						update_option(c_al2fb_log_redir_init, date('c'));

						// Get current user
						global $user_ID;
						get_currentuserinfo();

						// Redirect
						$auth_url = self::Authorize_url($user_ID);
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

				// Disable shared application
				if (!self::Client_side_flow_available() &&
					get_user_meta($user_ID, c_al2fb_meta_shared, true)) {
					update_user_meta($user_ID, c_al2fb_meta_shared, false);
					delete_user_meta($user_ID, c_al2fb_meta_access_token);
				}

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
			if (empty($_POST[c_al2fb_meta_use_groups]))
				$_POST[c_al2fb_meta_use_groups] = null;
			if (empty($_POST[c_al2fb_meta_group]))
				$_POST[c_al2fb_meta_group] = null;
			if (empty($_POST[c_al2fb_meta_caption]))
				$_POST[c_al2fb_meta_caption] = null;
			if (empty($_POST[c_al2fb_meta_msg]))
				$_POST[c_al2fb_meta_msg] = null;
			if (empty($_POST[c_al2fb_meta_shortlink]))
				$_POST[c_al2fb_meta_shortlink] = null;
			if (empty($_POST[c_al2fb_meta_trailer]))
				$_POST[c_al2fb_meta_trailer] = null;
			if (empty($_POST[c_al2fb_meta_hyperlink]))
				$_POST[c_al2fb_meta_hyperlink] = null;
			if (empty($_POST[c_al2fb_meta_share_link]))
				$_POST[c_al2fb_meta_share_link] = null;
			if (empty($_POST[c_al2fb_meta_fb_comments]))
				$_POST[c_al2fb_meta_fb_comments] = null;
			if (empty($_POST[c_al2fb_meta_fb_likes]))
				$_POST[c_al2fb_meta_fb_likes] = null;
			if (empty($_POST[c_al2fb_meta_post_likers]))
				$_POST[c_al2fb_meta_post_likers] = null;
			if (empty($_POST[c_al2fb_meta_post_like_button]))
				$_POST[c_al2fb_meta_post_like_button] = null;
			if (empty($_POST[c_al2fb_meta_like_nohome]))
				$_POST[c_al2fb_meta_like_nohome] = null;
			if (empty($_POST[c_al2fb_meta_like_noposts]))
				$_POST[c_al2fb_meta_like_noposts] = null;
			if (empty($_POST[c_al2fb_meta_like_nopages]))
				$_POST[c_al2fb_meta_like_nopages] = null;
			if (empty($_POST[c_al2fb_meta_like_layout]))
				$_POST[c_al2fb_meta_like_layout] = null;
			if (empty($_POST[c_al2fb_meta_like_faces]))
				$_POST[c_al2fb_meta_like_faces] = null;
			if (empty($_POST[c_al2fb_meta_like_action]))
				$_POST[c_al2fb_meta_like_action] = null;
			if (empty($_POST[c_al2fb_meta_like_font]))
				$_POST[c_al2fb_meta_like_font] = null;
			if (empty($_POST[c_al2fb_meta_like_colorscheme]))
				$_POST[c_al2fb_meta_like_colorscheme] = null;
			if (empty($_POST[c_al2fb_meta_open_graph]))
				$_POST[c_al2fb_meta_open_graph] = null;
			if (empty($_POST[c_al2fb_meta_clean]))
				$_POST[c_al2fb_meta_clean] = null;
			if (empty($_POST[c_al2fb_meta_donated]))
				$_POST[c_al2fb_meta_donated] = null;

			$_POST[c_al2fb_meta_client_id] = trim($_POST[c_al2fb_meta_client_id]);
			$_POST[c_al2fb_meta_app_secret] = trim($_POST[c_al2fb_meta_app_secret]);
			$_POST[c_al2fb_meta_picture] = trim(stripslashes($_POST[c_al2fb_meta_picture]));
			$_POST[c_al2fb_meta_picture_default] = trim(stripslashes($_POST[c_al2fb_meta_picture_default]));
			$_POST[c_al2fb_meta_trailer] = rtrim($_POST[c_al2fb_meta_trailer]);
			$_POST[c_al2fb_meta_like_width] = trim($_POST[c_al2fb_meta_like_width]);
			$_POST[c_al2fb_meta_like_link] = trim($_POST[c_al2fb_meta_like_link]);

			// Prevent losing selected page
			if (!self::Is_authorized($user_ID) ||
				(get_user_meta($user_ID, c_al2fb_meta_use_groups, true) &&
				get_user_meta($user_ID, c_al2fb_meta_group, true)))
				$_POST[c_al2fb_meta_page] = get_user_meta($user_ID, c_al2fb_meta_page, true);

			// Prevent losing selected group
			if (!self::Is_authorized($user_ID) || !get_user_meta($user_ID, c_al2fb_meta_use_groups, true))
				$_POST[c_al2fb_meta_group] = get_user_meta($user_ID, c_al2fb_meta_group, true);

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

			// Use groups changed
			if ($_POST[c_al2fb_meta_use_groups] && !get_user_meta($user_ID, c_al2fb_meta_use_groups, true))
				if (!get_user_meta($user_ID, c_al2fb_meta_group, true))
					delete_user_meta($user_ID, c_al2fb_meta_access_token);

			// Update user options
			update_user_meta($user_ID, c_al2fb_meta_shared, $_POST[c_al2fb_meta_shared]);
			update_user_meta($user_ID, c_al2fb_meta_client_id, $_POST[c_al2fb_meta_client_id]);
			update_user_meta($user_ID, c_al2fb_meta_app_secret, $_POST[c_al2fb_meta_app_secret]);
			update_user_meta($user_ID, c_al2fb_meta_picture_type, $_POST[c_al2fb_meta_picture_type]);
			update_user_meta($user_ID, c_al2fb_meta_picture, $_POST[c_al2fb_meta_picture]);
			update_user_meta($user_ID, c_al2fb_meta_picture_default, $_POST[c_al2fb_meta_picture_default]);
			update_user_meta($user_ID, c_al2fb_meta_page, $_POST[c_al2fb_meta_page]);
			update_user_meta($user_ID, c_al2fb_meta_page_owner, $_POST[c_al2fb_meta_page_owner]);
			update_user_meta($user_ID, c_al2fb_meta_use_groups, $_POST[c_al2fb_meta_use_groups]);
			update_user_meta($user_ID, c_al2fb_meta_group, $_POST[c_al2fb_meta_group]);
			update_user_meta($user_ID, c_al2fb_meta_caption, $_POST[c_al2fb_meta_caption]);
			update_user_meta($user_ID, c_al2fb_meta_msg, $_POST[c_al2fb_meta_msg]);
			update_user_meta($user_ID, c_al2fb_meta_shortlink, $_POST[c_al2fb_meta_shortlink]);
			update_user_meta($user_ID, c_al2fb_meta_trailer, $_POST[c_al2fb_meta_trailer]);
			update_user_meta($user_ID, c_al2fb_meta_hyperlink, $_POST[c_al2fb_meta_hyperlink]);
			update_user_meta($user_ID, c_al2fb_meta_share_link, $_POST[c_al2fb_meta_share_link]);
			update_user_meta($user_ID, c_al2fb_meta_fb_comments, $_POST[c_al2fb_meta_fb_comments]);
			update_user_meta($user_ID, c_al2fb_meta_fb_likes, $_POST[c_al2fb_meta_fb_likes]);
			update_user_meta($user_ID, c_al2fb_meta_post_likers, $_POST[c_al2fb_meta_post_likers]);
			update_user_meta($user_ID, c_al2fb_meta_post_like_button, $_POST[c_al2fb_meta_post_like_button]);
			update_user_meta($user_ID, c_al2fb_meta_like_nohome, $_POST[c_al2fb_meta_like_nohome]);
			update_user_meta($user_ID, c_al2fb_meta_like_noposts, $_POST[c_al2fb_meta_like_noposts]);
			update_user_meta($user_ID, c_al2fb_meta_like_nopages, $_POST[c_al2fb_meta_like_nopages]);
			update_user_meta($user_ID, c_al2fb_meta_like_layout, $_POST[c_al2fb_meta_like_layout]);
			update_user_meta($user_ID, c_al2fb_meta_like_faces, $_POST[c_al2fb_meta_like_faces]);
			update_user_meta($user_ID, c_al2fb_meta_like_width, $_POST[c_al2fb_meta_like_width]);
			update_user_meta($user_ID, c_al2fb_meta_like_action, $_POST[c_al2fb_meta_like_action]);
			update_user_meta($user_ID, c_al2fb_meta_like_font, $_POST[c_al2fb_meta_like_font]);
			update_user_meta($user_ID, c_al2fb_meta_like_colorscheme, $_POST[c_al2fb_meta_like_colorscheme]);
			update_user_meta($user_ID, c_al2fb_meta_like_link, $_POST[c_al2fb_meta_like_link]);
			update_user_meta($user_ID, c_al2fb_meta_open_graph, $_POST[c_al2fb_meta_open_graph]);
			update_user_meta($user_ID, c_al2fb_meta_clean, $_POST[c_al2fb_meta_clean]);
			update_user_meta($user_ID, c_al2fb_meta_donated, $_POST[c_al2fb_meta_donated]);

			if (isset($_REQUEST['debug'])) {
				if (empty($_POST[c_al2fb_meta_access_token]))
					$_POST[c_al2fb_meta_access_token] = null;
				$_POST[c_al2fb_meta_access_token] = trim($_POST[c_al2fb_meta_access_token]);
				update_user_meta($user_ID, c_al2fb_meta_access_token, $_POST[c_al2fb_meta_access_token]);
			}

			// Update admin options
			if (current_user_can('manage_options')) {
				if (empty($_POST[c_al2fb_option_app_share]))
					$_POST[c_al2fb_option_app_share] = null;
				else
					$_POST[c_al2fb_option_app_share] = $user_ID;
				if (is_multisite())
					update_site_option(c_al2fb_option_app_share, $_POST[c_al2fb_option_app_share]);
				else
					update_option(c_al2fb_option_app_share, $_POST[c_al2fb_option_app_share]);

				if (empty($_POST[c_al2fb_option_nonotice]))
					$_POST[c_al2fb_option_nonotice] = null;
				if (empty($_POST[c_al2fb_option_min_cap]))
					$_POST[c_al2fb_option_min_cap] = null;

				$_POST[c_al2fb_option_msg_refresh] = trim($_POST[c_al2fb_option_msg_refresh]);
				$_POST[c_al2fb_option_max_descr] = trim($_POST[c_al2fb_option_max_descr]);
				$_POST[c_al2fb_option_exclude_type] = trim($_POST[c_al2fb_option_exclude_type]);

				update_option(c_al2fb_option_nonotice, $_POST[c_al2fb_option_nonotice]);
				update_option(c_al2fb_option_min_cap, $_POST[c_al2fb_option_min_cap]);
				update_option(c_al2fb_option_msg_refresh, $_POST[c_al2fb_option_msg_refresh]);
				update_option(c_al2fb_option_max_descr, $_POST[c_al2fb_option_max_descr]);
				update_option(c_al2fb_option_exclude_type, $_POST[c_al2fb_option_exclude_type]);

				if (isset($_REQUEST['debug'])) {
					if (empty($_POST[c_al2fb_option_siteurl]))
						$_POST[c_al2fb_option_siteurl] = null;
					if (empty($_POST[c_al2fb_option_nocurl]))
						$_POST[c_al2fb_option_nocurl] = null;
					if (empty($_POST[c_al2fb_option_use_pp]))
						$_POST[c_al2fb_option_use_pp] = null;
					if (empty($_POST[c_al2fb_option_debug]))
						$_POST[c_al2fb_option_debug] = null;

					update_option(c_al2fb_option_siteurl, $_POST[c_al2fb_option_siteurl]);
					update_option(c_al2fb_option_nocurl, $_POST[c_al2fb_option_nocurl]);
					update_option(c_al2fb_option_use_pp, $_POST[c_al2fb_option_use_pp]);
					update_option(c_al2fb_option_debug, $_POST[c_al2fb_option_debug]);
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
				update_option(c_al2fb_log_auth_time, date('c'));
				update_user_meta($user_ID, c_al2fb_meta_access_token, $_REQUEST['access_token']);
				delete_option(c_al2fb_last_error);
				delete_option(c_al2fb_last_error_time);
				echo '<div id="message" class="updated fade al2fb_notice"><p>' . __('Authorized, go posting!', c_al2fb_text_domain) . '</p></div>';
			}

			// Server-side flow authorization
			if (isset($_REQUEST['code'])) {
				try {
					// Get & store token
					$access_token = self::Get_token($user_ID);
					update_option(c_al2fb_log_auth_time, date('c'));
					update_user_meta($user_ID, c_al2fb_meta_access_token, $access_token);
					delete_option(c_al2fb_last_error);
					delete_option(c_al2fb_last_error_time);
					echo '<div id="message" class="updated fade al2fb_notice"><p>' . __('Authorized, go posting!', c_al2fb_text_domain) . '</p></div>';
				}
				catch (Exception $e) {
					delete_user_meta($user_ID, c_al2fb_meta_access_token);
					update_option(c_al2fb_last_error, $e->getMessage());
					update_option(c_al2fb_last_error_time, date('c'));
					echo '<div id="message" class="error fade al2fb_error"><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, get_bloginfo('charset')) . '</p></div>';
				}
			}

			// Authorization error
			else if (isset($_REQUEST['error'])) {
				delete_user_meta($user_ID, c_al2fb_meta_access_token);
				$msg = stripslashes($_REQUEST['error_description']);
				$msg .= ' error: ' . stripslashes($_REQUEST['error']);
				$msg .= ' reason: ' . stripslashes($_REQUEST['error_reason']);
				update_option(c_al2fb_last_error, $msg);
				update_option(c_al2fb_last_error_time, date('c'));
				echo '<div id="message" class="error fade al2fb_error"><p>' . htmlspecialchars($msg, ENT_QUOTES, get_bloginfo('charset')) . '</p></div>';
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
			$message .= '<p>' . nl2br(htmlspecialchars(stripslashes($_POST[c_al2fb_mail_msg]), ENT_QUOTES, get_bloginfo('charset'))) . '</p>';
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

			$nonotice = get_option(c_al2fb_option_nonotice);
			if (is_multisite())
				$nonotice = $nonotice || get_site_option(c_al2fb_option_app_share);
			else
				$nonotice = $nonotice || get_option(c_al2fb_option_app_share);

			if ($nonotice ? strpos($uri, $url) !== false : true) {
				if (!get_user_meta($user_ID, c_al2fb_meta_shared, true) &&
					(!get_user_meta($user_ID, c_al2fb_meta_client_id, true) ||
					!get_user_meta($user_ID, c_al2fb_meta_app_secret, true))) {
					$notice = __('needs configuration', c_al2fb_text_domain);
					$anchor = 'configure';
				}
				else if (!self::Is_authorized($user_ID)) {
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
				echo htmlspecialchars(stripslashes($_REQUEST['error']), ENT_QUOTES, get_bloginfo('charset')) . '</p></div>';
			}

			// Check for post errors
			$posts = new WP_Query(array(
				'author' => $user_ID,
				'meta_key' => c_al2fb_meta_error,
				'posts_per_page' => 5));
			while ($posts->have_posts()) {
				$posts->next_post();
				$error = get_post_meta($posts->post->ID, c_al2fb_meta_error, true);
				if (!empty($error)) {
					echo '<div id="message" class="error fade al2fb_error"><p>';
					echo __('Add Link to Facebook', c_al2fb_text_domain) . ' - ';
					edit_post_link($posts->post->post_title, null, null, $posts->post->ID);
					echo ': ' . htmlspecialchars($error, ENT_QUOTES, get_bloginfo('charset')) . '</p></div>';
				}
			}
		}

		// Register options page
		function Admin_menu() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			// Check for app share
			if (is_multisite())
				$shared_user_ID = get_site_option(c_al2fb_option_app_share);
			else
				$shared_user_ID = get_option(c_al2fb_option_app_share);
			if ($shared_user_ID && $shared_user_ID != $user_ID)
				return;

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
			$config_url = admin_url('tools.php?page=' . plugin_basename($this->main_file));
			if (isset($_REQUEST['debug']))
				$config_url .= '&debug=1';

			// Decode picture type
			$pic_type = get_user_meta($user_ID, c_al2fb_meta_picture_type, true);
			$pic_wordpress = ($pic_type == 'wordpress' ? ' checked' : '');
			$pic_media = ($pic_type == 'media' ? ' checked' : '');
			$pic_featured = ($pic_type == 'featured' ? ' checked' : '');
			$pic_facebook = ($pic_type == 'facebook' ? ' checked' : '');
			$pic_post = ($pic_type == 'post' ? ' checked' : '');
			$pic_custom = ($pic_type == 'custom' ? ' checked' : '');
			if (!current_theme_supports('post-thumbnails') ||
				!function_exists('get_post_thumbnail_id') ||
				!function_exists('wp_get_attachment_image_src'))
				$pic_featured .= ' disabled';

			// Like button
			$like_layout = get_user_meta($user_ID, c_al2fb_meta_like_layout, true);
			$like_layout_standard = ($like_layout == 'standard' ? ' checked' : '');
			$like_layout_button = ($like_layout == 'button_count' ? ' checked' : '');
			$like_layout_box = ($like_layout == 'box_count' ? ' checked' : '');
			$like_action = get_user_meta($user_ID, c_al2fb_meta_like_action, true);
			$like_action_like = ($like_action == 'like' ? ' checked' : '');
			$like_action_recommend = ($like_action == 'recommend' ? ' checked' : '');
			$like_font = get_user_meta($user_ID, c_al2fb_meta_like_font, true);
			$like_color = get_user_meta($user_ID, c_al2fb_meta_like_colorscheme, true);
			$like_color_light = ($like_color == 'light' ? ' checked' : '');
			$like_color_dark = ($like_color == 'dark' ? ' checked' : '');

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
				if (self::Is_authorized($user_ID)) {
					// Get page name
					try {
						$me = self::Get_me($user_ID, false);
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

<?php		if (self::Client_side_flow_available() ||
				get_user_meta($user_ID, c_al2fb_meta_shared, true)) { ?>
				<table class="form-table">
				<tr valign="top"><th scope="row">
					<label for="al2fb_app_shared"><strong><?php _e('Use shared Facebook application:', c_al2fb_text_domain); ?></strong></label>
				</th><td>
					<input id="al2fb_app_shared" name="<?php echo c_al2fb_meta_shared; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_shared, true)) echo ' checked="checked"'; ?> />
					<strong>Beta!</strong>
					<br /><a class="al2fb_explanation" href="http://wordpress.org/extend/plugins/add-link-to-facebook/faq/" target="_blank"><?php _e('Simple, but less secure', c_al2fb_text_domain); ?></a>
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

			<table class="form-table al2fb_border">
			<tr valign="top"><th scope="row">
				<label for="al2fb_client_id"><strong><?php _e('App ID:', c_al2fb_text_domain); ?></strong></label>
			</th><td>
				<input id="al2fb_client_id" class="al2fb_text" name="<?php echo c_al2fb_meta_client_id; ?>" type="text" value="<?php echo get_user_meta($user_ID, c_al2fb_meta_client_id, true); ?>" />
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_app_secret"><strong><?php _e('App Secret:', c_al2fb_text_domain); ?></strong></label>
			</th><td>
				<input id="al2fb_app_secret" class="al2fb_text" name="<?php echo c_al2fb_meta_app_secret; ?>" type="text" value="<?php echo get_user_meta($user_ID, c_al2fb_meta_app_secret, true); ?>" />
			</td></tr>

<?php		if (isset($_REQUEST['debug'])) { ?>
				<tr valign="top"><th scope="row">
					<label for="al2fb_access_token"><strong><?php _e('Access token:', c_al2fb_text_domain); ?></strong></label>
				</th><td>
					<input id="al2fb_access_token" class="al2fb_text" name="<?php echo c_al2fb_meta_access_token; ?>" type="text" value="<?php echo get_user_meta($user_ID, c_al2fb_meta_access_token, true); ?>" />
				</td></tr>
<?php
			}

			if (self::Is_authorized($user_ID))
				try {
					$app = self::Get_application($user_ID);
?>
					<tr valign="top"><th scope="row">
						<label for="al2fb_app_name"><?php _e('App Name:', c_al2fb_text_domain); ?></label>
					</th><td>
						<a id="al2fb_app_name" href="<?php echo $app->link; ?>" target="_blank"><?php echo htmlspecialchars($app->name, ENT_QUOTES, $charset); ?></a>
					</td></tr>
<?php
				}
				catch (Exception $e) {
					echo '<div id="message" class="error fade al2fb_error"><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, $charset) . '</p></div>';
				}

			if (current_user_can('manage_options')) {
?>
				<tr valign="top"><th scope="row">
					<label for="al2fb_app_share"><?php _e('Share with all users on this site:', c_al2fb_text_domain); ?></label>
				</th><td>
					<input id="al2fb_app_share" name="<?php echo c_al2fb_option_app_share; ?>" type="checkbox"<?php if (get_site_option(c_al2fb_option_app_share)) echo ' checked="checked"'; ?> />
				</td></tr>
<?php
			}
?>
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

			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save', c_al2fb_text_domain) ?>" />
			</p>

			<hr />
			<h3><?php _e('Additional settings', c_al2fb_text_domain); ?></h3>

			<table class="form-table al2fb_border">
			<tr valign="top"><th scope="row">
				<label for="al2fb_picture_type"><?php _e('Link picture:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input type="radio" name="<?php echo c_al2fb_meta_picture_type; ?>" value="wordpress"<?php echo $pic_wordpress; ?>><?php _e('WordPress logo', c_al2fb_text_domain); ?><br>
				<input type="radio" name="<?php echo c_al2fb_meta_picture_type; ?>" value="media"<?php echo $pic_media; ?>><?php _e('First attached image', c_al2fb_text_domain); ?><br>
				<input type="radio" name="<?php echo c_al2fb_meta_picture_type; ?>" value="featured"<?php echo $pic_featured; ?>><?php _e('Featured post image', c_al2fb_text_domain); ?><br>
				<input type="radio" name="<?php echo c_al2fb_meta_picture_type; ?>" value="facebook"<?php echo $pic_facebook; ?>><?php _e('Let Facebook select', c_al2fb_text_domain); ?><br>
				<input type="radio" name="<?php echo c_al2fb_meta_picture_type; ?>" value="post"<?php echo $pic_post; ?>><?php _e('First image in the post', c_al2fb_text_domain); ?><br>
				<input type="radio" name="<?php echo c_al2fb_meta_picture_type; ?>" value="custom"<?php echo $pic_custom; ?>><?php _e('Custom picture below', c_al2fb_text_domain); ?><br>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_picture"><?php _e('Custom picture URL:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_picture" class="al2fb_text" name="<?php echo c_al2fb_meta_picture; ?>" type="text" value="<?php echo get_user_meta($user_ID, c_al2fb_meta_picture, true); ?>" />
				<br /><span class="al2fb_explanation"><?php _e('At least 50 x 50 pixels', c_al2fb_text_domain); ?></span>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_picture_default"><?php _e('Default picture URL:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_picture_default" class="al2fb_text" name="<?php echo c_al2fb_meta_picture_default; ?>" type="text" value="<?php echo get_user_meta($user_ID, c_al2fb_meta_picture_default, true); ?>" />
				<br /><span class="al2fb_explanation"><?php _e('Default WordPress logo', c_al2fb_text_domain); ?></span>
			</td></tr>
			</table>
<?php
			if (self::Is_authorized($user_ID))
				try {
					if (!get_user_meta($user_ID, c_al2fb_meta_use_groups, true) ||
						!get_user_meta($user_ID, c_al2fb_meta_group, true)) {
						$me = self::Get_me($user_ID, true);
						$pages = self::Get_pages($user_ID);
						$selected_page = get_user_meta($user_ID, c_al2fb_meta_page, true);
?>
						<table class="form-table al2fb_border">
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
						</table>
<?php				} ?>

					<table class="form-table al2fb_border">
					<tr valign="top"><th scope="row">
						<label for="al2fb_use_groups"><?php _e('Use groups:', c_al2fb_text_domain); ?></label>
					</th><td>
						<input id="al2fb_use_groups" name="<?php echo c_al2fb_meta_use_groups; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_use_groups, true)) echo ' checked="checked"'; ?> />
						<br /><span class="al2fb_explanation"><?php _e('Requires user groups permission', c_al2fb_text_domain); ?></span>
					</td></tr>

<?php				if (get_user_meta($user_ID, c_al2fb_meta_use_groups, true)) {
						$groups = self::Get_groups($user_ID);
						$selected_group = get_user_meta($user_ID, c_al2fb_meta_group, true);
?>
						<tr valign="top"><th scope="row">
							<label for="al2fb_group"><?php _e('Add to group:', c_al2fb_text_domain); ?></label>
						</th><td>
							<select id="al2fb_group" name="<?php echo c_al2fb_meta_group; ?>">
<?php
							echo '<option value=""' . ($selected_group ? '' : ' selected') . '>' . __('None', c_al2fb_text_domain) . '</option>';
							foreach ($groups->data as $group) {
								echo '<option value="' . $group->id . '"';
								if ($group->id == $selected_group)
									echo ' selected';
								echo '>' . htmlspecialchars($group->name, ENT_QUOTES, $charset) . '</option>';
							}
?>
							</select>
						</td></tr>
<?php
					}
?>
					</table>
<?php
				}
				catch (Exception $e) {
					echo '<div id="message" class="error fade al2fb_error"><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, $charset) . '</p></div>';
				}
?>
			<table class="form-table al2fb_border">
			<tr valign="top"><th scope="row">
				<label for="al2fb_caption"><?php _e('Use site title as caption:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_caption" name="<?php echo c_al2fb_meta_caption; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_caption, true)) echo ' checked="checked"'; ?> />
				<br /><span class="al2fb_explanation">&quot;<?php echo html_entity_decode(get_bloginfo('title'), ENT_QUOTES, get_bloginfo('charset')); ?>&quot;</span>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_msg"><?php _e('Use excerpt as message:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_msg" name="<?php echo c_al2fb_meta_msg; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_msg, true)) echo ' checked="checked"'; ?> />
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_trailer"><?php _e('Text trailer:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_trailer" class="al2fb_text" name="<?php echo c_al2fb_meta_trailer; ?>" type="text" value="<?php  echo get_user_meta($user_ID, c_al2fb_meta_trailer, true); ?>" />
				<br /><span class="al2fb_explanation"><?php _e('For example "Read more ..."', c_al2fb_text_domain); ?></span>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_hyperlink"><?php _e('Keep hyperlinks:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_hyperlink" name="<?php echo c_al2fb_meta_hyperlink; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_hyperlink, true)) echo ' checked="checked"'; ?> />
				<br /><span class="al2fb_explanation"><?php _e('The hyperlink title will be removed', c_al2fb_text_domain); ?></span>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_share_link"><?php _e('Add \'Share\' link:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_share_link" name="<?php echo c_al2fb_meta_share_link; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_share_link, true)) echo ' checked="checked"'; ?> />
				<strong>Experimental!</strong>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_shortlink"><?php _e('Use short URL:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_shortlink" name="<?php echo c_al2fb_meta_shortlink; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_shortlink, true)) echo ' checked="checked"'; ?> />
				<br /><span class="al2fb_explanation"><?php _e('If available', c_al2fb_text_domain); ?></span>
			</td></tr>
			</table>

			<table class="form-table al2fb_border">
			<tr valign="top"><th scope="row">
				<label for="al2fb_fb_comments"><?php _e('Integrate comments from Facebook:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_fb_comments" name="<?php echo c_al2fb_meta_fb_comments; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_fb_comments, true)) echo ' checked="checked"'; ?> />
				<strong>Beta!</strong>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_fb_likes"><?php _e('Integrate likes from Facebook:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_fb_likes" name="<?php echo c_al2fb_meta_fb_likes; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_fb_likes, true)) echo ' checked="checked"'; ?> />
				<strong>Beta!</strong>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_post_likers"><?php _e('Show likers below the post text:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_post_likers" name="<?php echo c_al2fb_meta_post_likers; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_post_likers, true)) echo ' checked="checked"'; ?> />
			</td></tr>
			</table>

			<table class="form-table al2fb_border">
			<tr valign="top"><th scope="row">
				<label for="al2fb_post_like_button"><?php _e('Show Facebook like button:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_post_like_button" name="<?php echo c_al2fb_meta_post_like_button; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_post_like_button, true)) echo ' checked="checked"'; ?> />
				<br /><a class="al2fb_explanation" href="http://developers.facebook.com/docs/reference/plugins/like/" target="_blank"><?php _e('Documentation', c_al2fb_text_domain); ?></a>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_post_nohome"><?php _e('Do not show on the home page:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_post_nohome" name="<?php echo c_al2fb_meta_like_nohome; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_like_nohome, true)) echo ' checked="checked"'; ?> />
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_post_noposts"><?php _e('Do not show on posts:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_post_noposts" name="<?php echo c_al2fb_meta_like_noposts; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_like_noposts, true)) echo ' checked="checked"'; ?> />
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_post_nopages"><?php _e('Do not show on pages:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_post_nopages" name="<?php echo c_al2fb_meta_like_nopages; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_like_nopages, true)) echo ' checked="checked"'; ?> />
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_like_layout"><?php _e('Layout:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input type="radio" name="<?php echo c_al2fb_meta_like_layout; ?>" value="standard"<?php echo $like_layout_standard; ?>><?php _e('Standard', c_al2fb_text_domain); ?><br>
				<input type="radio" name="<?php echo c_al2fb_meta_like_layout; ?>" value="button_count"<?php echo $like_layout_button; ?>><?php _e('Button with count', c_al2fb_text_domain); ?><br>
				<input type="radio" name="<?php echo c_al2fb_meta_like_layout; ?>" value="box_count"<?php echo $like_layout_box; ?>><?php _e('Box with count', c_al2fb_text_domain); ?><br>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_like_faces"><?php _e('Faces:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_like_faces" name="<?php echo c_al2fb_meta_like_faces; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_like_faces, true)) echo ' checked="checked"'; ?> />
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_like_width"><?php _e('Width:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input class="al2fb_numeric" id="al2fb_like_width" name="<?php echo c_al2fb_meta_like_width; ?>" type="text" value="<?php echo get_user_meta($user_ID, c_al2fb_meta_like_width, true); ?>" />
				<span><?php _e('Pixels', c_al2fb_text_domain); ?></span>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_like_action"><?php _e('Action:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input type="radio" name="<?php echo c_al2fb_meta_like_action; ?>" value="like"<?php echo $like_action_like; ?>><?php _e('Like', c_al2fb_text_domain); ?><br>
				<input type="radio" name="<?php echo c_al2fb_meta_like_action; ?>" value="recommend"<?php echo $like_action_recommend; ?>><?php _e('Recommend', c_al2fb_text_domain); ?><br>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_like_font"><?php _e('Font:', c_al2fb_text_domain); ?></label>
			</th><td>
				<select id="al2fb_like_font" name="<?php echo c_al2fb_meta_like_font; ?>">
				<option value="" <?php echo empty($like_font) ? 'selected' : ''; ?>></option>
				<option value="arial" <?php echo $like_font == 'arial' ? 'selected' : ''; ?>>arial</option>
				<option value="lucida grande" <?php echo $like_font == 'lucida grande' ? 'selected' : ''; ?>>lucida grande</option>
				<option value="segoe ui" <?php echo $like_font == 'segoe ui' ? 'selected' : ''; ?>>segoe ui</option>
				<option value="tahoma" <?php echo $like_font == 'tahoma' ? 'selected' : ''; ?>>tahoma</option>
				<option value="trebuchet ms" <?php echo $like_font == 'trebuchet ms' ? 'selected' : ''; ?>>trebuchet ms</option>
				<option value="verdana" <?php echo $like_font == 'verdana' ? 'selected' : ''; ?>>verdana</option>
				</select>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_like_color"><?php _e('Color scheme:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input type="radio" name="<?php echo c_al2fb_meta_like_colorscheme; ?>" value="light"<?php echo $like_color_light; ?>><?php _e('Light', c_al2fb_text_domain); ?><br>
				<input type="radio" name="<?php echo c_al2fb_meta_like_colorscheme; ?>" value="dark"<?php echo $like_color_dark; ?>><?php _e('Dark', c_al2fb_text_domain); ?><br>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_like_link"><?php _e('Link to:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_like_link" class="al2fb_text" name="<?php echo c_al2fb_meta_like_link; ?>" type="text" value="<?php echo get_user_meta($user_ID, c_al2fb_meta_like_link, true); ?>" />
				<br /><span class="al2fb_explanation"><?php _e('Default the post or page', c_al2fb_text_domain); ?></span>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_open_graph"><?php _e('Use Open Graph protocol:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_open_graph" name="<?php echo c_al2fb_meta_open_graph; ?>" type="checkbox"<?php if (get_user_meta($user_ID, c_al2fb_meta_open_graph, true)) echo ' checked="checked"'; ?> />
				<br>
				<a class="al2fb_explanation" href="http://developers.facebook.com/docs/opengraph/" target="_blank"><?php _e('Documentation', c_al2fb_text_domain); ?></a>
			</td></tr>
			</table>

			<table class="form-table al2fb_border">
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

				<table class="form-table al2fb_border">
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
					<input class="al2fb_numeric" id="al2fb_cache" name="<?php echo c_al2fb_option_msg_refresh; ?>" type="text" value="<?php echo get_option(c_al2fb_option_msg_refresh); ?>" />
					<span><?php _e('Minutes', c_al2fb_text_domain); ?></span>
					<br /><span class="al2fb_explanation"><?php _e('Default every 10 minutes', c_al2fb_text_domain); ?></span>
				</td></tr>

				<tr valign="top"><th scope="row">
					<label for="al2fb_max_descr"><?php _e('Maximum Facebook text length:', c_al2fb_text_domain); ?></label>
				</th><td>
					<input class="al2fb_numeric" id="al2fb_max_descr" name="<?php echo c_al2fb_option_max_descr; ?>" type="text" value="<?php echo get_option(c_al2fb_option_max_descr); ?>" />
					<span><?php _e('Characters', c_al2fb_text_domain); ?></span>
					<br /><span class="al2fb_explanation"><?php _e('Default 256 characters', c_al2fb_text_domain); ?></span>
				</td></tr>

				<tr valign="top"><th scope="row">
					<label for="al2fb_exclude_type"><?php _e('Exclude these custom post types:', c_al2fb_text_domain); ?></label>
				</th><td>
					<input class="al2fb_exclude_type" id="al2fb_max_descr" name="<?php echo c_al2fb_option_exclude_type; ?>" type="text" value="<?php echo get_option(c_al2fb_option_exclude_type); ?>" />
					<br /><span class="al2fb_explanation"><?php _e('Separate by commas', c_al2fb_text_domain); ?></span>
				</td></tr>
				</table>

<?php		   if (isset($_REQUEST['debug'])) { ?>
					<h3><?php _e('Debug options', c_al2fb_text_domain); ?></h3>
					<table class="form-table al2fb_border">
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

					<tr valign="top"><th scope="row">
						<label for="al2fb_use_pp"><?php _e('Use publish_post action:', c_al2fb_text_domain); ?></label>
					</th><td>
						<input id="al2fb_use_pp" name="<?php echo c_al2fb_option_use_pp; ?>" type="checkbox"<?php if (get_option(c_al2fb_option_use_pp)) echo ' checked="checked"'; ?> />
					</td></tr>

					<tr valign="top"><th scope="row">
						<label for="al2fb_debug"><?php _e('Debug:', c_al2fb_text_domain); ?></label>
					</th><td>
						<input id="al2fb_debug" name="<?php echo c_al2fb_option_debug; ?>" type="checkbox"<?php if (get_option(c_al2fb_option_debug)) echo ' checked="checked"'; ?> />
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
			<li><a href="<?php echo 'tools.php?page=' . plugin_basename($this->main_file) . '&debug=1'; ?>"><?php _e('Debug information', c_al2fb_text_domain); ?></a></li>
			<li><a href="http://blog.bokhorst.biz/about/" target="_blank"><?php _e('About the author', c_al2fb_text_domain); ?></a></li>
			<li><a href="http://wordpress.org/extend/plugins/profile/m66b" target="_blank"><?php _e('Other plugins', c_al2fb_text_domain); ?></a></li>
			</ul>
<?php		if (!get_user_meta($user_ID, c_al2fb_meta_donated, true)) { ?>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
				<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				</form>
<?php		} ?>
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
			return false;
			$available = get_transient(c_al2fb_transient_available);
			if (!$available)
				try {
					$plugin_folder = get_plugins('/' . plugin_basename(dirname(__FILE__)));
					$plugin_version = $plugin_folder[basename($this->main_file)]['Version'];
					$available = self::Request(c_al2fb_app_url, 'available=' . c_al2fb_app_version . '&plugin=' . $plugin_version, 'GET');
					set_transient(c_al2fb_transient_available, $available, 60 * 60);
				}
				catch (Exception $e) {
					$available = false;
				}
			return $available;
		}

		// Get Facebook authorize addess
		function Authorize_url($user_ID) {
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

			if (get_user_meta($user_ID, c_al2fb_meta_use_groups, true))
				$url .= ',user_groups';

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
				$url .= '&' . http_build_query($query, '', '&');

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
		function Get_token($user_ID) {
			$url = 'https://graph.facebook.com/oauth/access_token';
			$query = http_build_query(array(
				'client_id' => get_user_meta($user_ID, c_al2fb_meta_client_id, true),
				'redirect_uri' => self::Redirect_uri(),
				'client_secret' => get_user_meta($user_ID, c_al2fb_meta_app_secret, true),
				'code' => $_REQUEST['code']
			), '', '&');
			$response = self::Request($url, $query, 'GET');
			$key = 'access_token=';
			$access_token = substr($response, strpos($response, $key) + strlen($key));
			$access_token = explode('&', $access_token);
			$access_token = $access_token[0];
			return $access_token;
		}

		// Get application properties
		function Get_application($user_ID) {
			if (get_user_meta($user_ID, c_al2fb_meta_shared, true))
				$app_id = c_al2fb_app_id;
			else
				$app_id = get_user_meta($user_ID, c_al2fb_meta_client_id, true);
			$url = 'https://graph.facebook.com/' . $app_id;
			$query = http_build_query(array(
				'access_token' => get_user_meta($user_ID, c_al2fb_meta_access_token, true)
			), '', '&');
			$response = self::Request($url, $query, 'GET');
			$app = json_decode($response);
			return $app;
		}

		// Get wall or page name
		function Get_me($user_ID, $self) {
			if (get_user_meta($user_ID, c_al2fb_meta_use_groups, true))
				$page_id = get_user_meta($user_ID, c_al2fb_meta_group, true);
			if (empty($page_id))
				$page_id = get_user_meta($user_ID, c_al2fb_meta_page, true);
			if ($self || empty($page_id))
				$page_id = 'me';
			$url = 'https://graph.facebook.com/' . $page_id;
			$query = http_build_query(array(
				'access_token' => self::Get_access_token_by_page($user_ID, $page_id)
			), '', '&');
			$response = self::Request($url, $query, 'GET');
			$me = json_decode($response);
			if ($me) {
				if (empty($me->link))	// Group
					$me->link = 'http://www.facebook.com/home.php?sk=group_' . $page_id;
				return $me;
			}
			else
				throw new Exception('Page ' . $page_id . ' not found');
		}

		// Get page list
		function Get_pages($user_ID) {
			$url = 'https://graph.facebook.com/me/accounts';
			$query = http_build_query(array(
				'access_token' => get_user_meta($user_ID, c_al2fb_meta_access_token, true)
			), '', '&');
			$response = self::Request($url, $query, 'GET');
			$accounts = json_decode($response);
			return $accounts;
		}

		// Get group list
		function Get_groups($user_ID) {
			$url = 'https://graph.facebook.com/me/groups';
			$query = http_build_query(array(
				'access_token' => get_user_meta($user_ID, c_al2fb_meta_access_token, true)
			), '', '&');
			$response = self::Request($url, $query, 'GET');
			$groups = json_decode($response);
			return $groups;
		}

		// Get comments
		function Get_comments($user_ID, $id) {
			$url = 'https://graph.facebook.com/' . $id . '/comments';
			$query = http_build_query(array(
				'access_token' => get_user_meta($user_ID, c_al2fb_meta_access_token, true)
			), '', '&');
			$response = self::Request($url, $query, 'GET');
			$comments = json_decode($response);
			return $comments;
		}

		// Get comments
		function Get_likes($user_ID, $id) {
			$url = 'https://graph.facebook.com/' . $id . '/likes';
			$query = http_build_query(array(
				'access_token' => get_user_meta($user_ID, c_al2fb_meta_access_token, true)
			), '', '&');
			$response = self::Request($url, $query, 'GET');
			$likes = json_decode($response);
			return $likes;
		}

		// Add exclude checkbox
		function Post_submitbox() {
			global $post;
			$exclude = get_post_meta($post->ID, c_al2fb_meta_exclude, true);
			$chk_exclude = $exclude ? 'checked' : '';
?>
			<div class="al2fb_post_submit">
			<input id="al2fb_exclude" type="checkbox" name="<?php echo c_al2fb_meta_exclude; ?>" <?php echo $chk_exclude; ?> />
			<label for="al2fb_exclude"><?php _e('Do not add link to Facebook', c_al2fb_text_domain); ?></label>
<?php
			$link_id = get_post_meta($post->ID, c_al2fb_meta_link_id, true);
			if (!empty($link_id)) {
?>
				<br />
				<input id="al2fb_delete" type="checkbox" name="al2fb_delete"/>
				<label for="al2fb_delete"><?php _e('Delete existing Facebook link', c_al2fb_text_domain); ?></label>
<?php		} ?>
			</div>
<?php
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
			add_meta_box(
				'al2fb_meta',
				__('Add Link to Facebook', c_al2fb_text_domain),
				array(&$this, 'Meta_box'),
				'post');
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

			// Skip auto save
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return $post_id;

			// Process exclude flag
			if (isset($_POST[c_al2fb_meta_exclude]) && $_POST[c_al2fb_meta_exclude])
				update_post_meta($post_id, c_al2fb_meta_exclude, true);
			else
				delete_post_meta($post_id, c_al2fb_meta_exclude);

			// Persist data
			if (isset($_POST['al2fb_image_id']))
				update_post_meta($post_id, c_al2fb_meta_image_id, $_POST['al2fb_image_id']);
		}

		// Remote publish & custom action
		function Remote_publish($post_ID) {
			$post = get_post($post_ID);

			// Log
			if ($this->debug)
				add_post_meta($post->ID, c_al2fb_meta_log, 'Remote ' . $post->post_status . ' @' . date('c'));

			// Only if published
			if ($post->post_status == 'publish')
				self::Publish_post($post);
		}

		// Workaround
		function Future_to_publish($post_ID) {
			$post = get_post($post_ID);

			// Log
			if ($this->debug)
				add_post_meta($post->ID, c_al2fb_meta_log, 'Future_to_publish @' . date('c'));

			// Delegate
			self::Transition_post_status('publish', 'future', $post);
		}

		// Handle post status change
		function Transition_post_status($new_status, $old_status, $post) {
			$user_ID = self::Get_user_ID($post);
			$delete = (isset($_POST['al2fb_delete']) && $_POST['al2fb_delete']);

			// Log
			if ($this->debug) {
				global $al2fb_transition_count;
				if (isset($al2fb_transition_count))
					$al2fb_transition_count++;
				else
					$al2fb_transition_count = 1;

				$msg = ($delete ? 'Delete' : 'Add') . ':';
				$msg .= ' ' . $old_status . '->' . $new_status . ':' . $post->post_status;
				$msg .= ((self::user_can($user_ID, get_option(c_al2fb_option_min_cap)) ? '' : ' no') . ' can;');
				$msg .= ((get_post_meta($post->ID, c_al2fb_meta_error, true) ? '' : ' no') . ' err;');
				$msg .= ' @' . date('c');
				$msg .= ' #' . $al2fb_transition_count;
				add_post_meta($post->ID, c_al2fb_meta_log, $msg);
			}

			// Security check
			if (self::user_can($user_ID, get_option(c_al2fb_option_min_cap))) {
				// Add or delete link
				if ($delete) {
					$link_id = get_post_meta($post->ID, c_al2fb_meta_link_id, true);
					if (!empty($link_id) && self::Is_authorized($user_ID))
						self::Delete_link($post);
				}
				else {
					// Check post status
					if ($new_status == 'publish' &&
						($new_status != $old_status ||
						get_post_meta($post->ID, c_al2fb_meta_error, true)))
						self::Publish_post($post);
				}
			}
		}

		// Handle publish post / XML-RPC publish post
		function Publish_post($post) {
			$user_ID = self::Get_user_ID($post);

			// Log
			if ($this->debug) {
				$msg = 'Publish ' . $post->post_type . ':';
				$msg .= ((self::user_can($user_ID, get_option(c_al2fb_option_min_cap)) ? '' : ' no') . ' can;');
				$msg .= ((self::Is_authorized($user_ID) ? '' : ' no') . ' auth;');
				$msg .= ((get_post_meta($post->ID, c_al2fb_meta_link_id, true) ? '' : ' no') . ' lnk;');
				$msg .= ((get_post_meta($post->ID, c_al2fb_meta_exclude, true) ? '' : ' no') . ' ex;');
				$msg .= ((empty($post->post_password) ? ' no' : '') . ' pwd;');
				$msg .= ' ' . strlen($post->post_excerpt) . ':' . strlen($post->post_content);
				$msg .= ' @' . date('c');
				add_post_meta($post->ID, c_al2fb_meta_log, $msg);
			}

			// Checks
			if (self::user_can($user_ID, get_option(c_al2fb_option_min_cap))) {
				// Check if not added
				if (self::Is_authorized($user_ID) &&
					!get_post_meta($post->ID, c_al2fb_meta_link_id, true) &&
					!get_post_meta($post->ID, c_al2fb_meta_exclude, true)) {

					// Check if public post
					if (empty($post->post_password) &&
						$post->post_type != 'page' &&
						!in_array($post->post_type, explode(',', get_option(c_al2fb_option_exclude_type))))
						self::Add_link($post);
				}
			}
		}

		// Build texts for link/ogp
		function Get_texts($post) {
			$user_ID = self::Get_user_ID($post);

			// Execute shortcodes
			$excerpt = do_shortcode($post->post_excerpt);
			$content = do_shortcode($post->post_content);

			// Replace hyperlinks
			if (get_user_meta($user_ID, c_al2fb_meta_hyperlink, true)) {
				$excerpt = preg_replace('/< *a[^>]*href *= *["\']([^"\']*)["\'][^\<]*/i', '$1<a>', $excerpt);
				$content = preg_replace('/< *a[^>]*href *= *["\']([^"\']*)["\'][^\<]*/i', '$1<a>', $content);
			}

			// Get plain texts
			$excerpt = preg_replace('/<[^>]*>/', '', $excerpt);
			$content = preg_replace('/<[^>]*>/', '', $content);

			// Get body
			$description = '';
			if (get_user_meta($user_ID, c_al2fb_meta_msg, true))
				$description = $content;
			else
				$description = ($excerpt ? $excerpt : $content);

			// Trailer: limit body size
			$trailer = get_user_meta($user_ID, c_al2fb_meta_trailer, true);
			if ($trailer) {
				$trailer = preg_replace('/<[^>]*>/', '', $trailer);

				// Get maximum FB description size
				$maxlen = get_option(c_al2fb_option_max_descr);
				if (!$maxlen)
					$maxlen = 256;

				// Add maximum number of sentences
				$lines = explode('.', $description);
				if ($lines) {
					$count = 0;
					$description = '';
					foreach ($lines as $sentence) {
						$line = $sentence;
						if ($count + 1 < count($lines))
							$line .= '.';
						if (strlen($description) + strlen($line) + strlen($trailer) < $maxlen)
							$description .= $line;
						else
							break;
					}
					if (empty($description) && count($lines) > 0)
						$description = substr($lines[0], 0, $maxlen - strlen($trailer));
					$description .= $trailer;
				}
			}

			// Build result
			$texts = array(
				'excerpt' => $excerpt,
				'content' => $content,
				'description' => $description
			);
			return $texts;
		}

		// Add Link to Facebook
		function Add_link($post) {
			// Get url
			$user_ID = self::Get_user_ID($post);
			if (get_user_meta($user_ID, c_al2fb_meta_shortlink, true))
				$link = wp_get_shortlink($post->ID);
			if (empty($link))
				$link = get_permalink($post->ID);

			// Get processed texts
			$texts = self::Get_texts($post);
			$excerpt = $texts['excerpt'];
			$content = $texts['content'];
			$description = $texts['description'];

			// Get caption
			$caption = '';
			if (get_user_meta($user_ID, c_al2fb_meta_caption, true))
				$caption = html_entity_decode(get_bloginfo('title'), ENT_QUOTES, get_bloginfo('charset'));

			// Log
			if ($this->debug) {
				$picture_type = get_user_meta($user_ID, c_al2fb_meta_picture_type, true);
				$log = 'Picture type: ' . $picture_type . PHP_EOL;

				$image_id = get_post_meta($post->ID, c_al2fb_meta_image_id, true);
				$log .= '- meta: ' . $image_id . PHP_EOL;

				$images = array_values(get_children('post_type=attachment&post_mime_type=image&order=ASC&post_parent=' . $post->ID));
				$log .= '- attached: ' . print_r($images, true);

				$picture_id = get_post_thumbnail_id($post->ID);
				$log .= '- featured: ' . $picture_id . PHP_EOL;

				if (preg_match('/< *img[^>]*src *= *["\']([^"\']*)["\']/i', $post->post_content, $matches))
					$log .= '- post: ' .  $matches[1] . PHP_EOL;
				else
					$log .= '- post: none' . PHP_EOL;

				$custom = get_user_meta($user_ID, c_al2fb_meta_picture, true);
				$log .= '- custom: ' .  $custom . PHP_EOL;
				add_post_meta($post->ID, c_al2fb_meta_log, $log);
			}

			// Get link picture
			$image_id = get_post_meta($post->ID, c_al2fb_meta_image_id, true);
			if (!empty($image_id) && function_exists('wp_get_attachment_thumb_url')) {
				$picture_type = 'meta';
				$picture = wp_get_attachment_thumb_url($image_id);
			}

			if (empty($picture)) {
				// Default picture
				$picture = get_user_meta($user_ID, c_al2fb_meta_picture_default, true);
				if (empty($picture))
					$picture = self::Redirect_uri() . '?al2fb_image=1';

				// Check picture type
				$picture_type = get_user_meta($user_ID, c_al2fb_meta_picture_type, true);
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
				else if ($picture_type == 'post') {
					if (preg_match('/< *img[^>]*src *= *["\']([^"\']*)["\']/i', $post->post_content, $matches))
						$picture = $matches[1];
				}
				else if ($picture_type == 'custom') {
					$custom = get_user_meta($user_ID, c_al2fb_meta_picture, true);
					if ($custom)
						$picture = $custom;
				}
			}

			// Get user note
			$message = '';
			if (get_user_meta($user_ID, c_al2fb_meta_msg, true))
				$message = $excerpt;

			// Do not disturb WordPress
			try {
				// Build request
				if (get_user_meta($user_ID, c_al2fb_meta_use_groups, true))
					$page_id = get_user_meta($user_ID, c_al2fb_meta_group, true);
				if (empty($page_id))
					$page_id = get_user_meta($user_ID, c_al2fb_meta_page, true);
				if (empty($page_id))
					$page_id = 'me';
				$url = 'https://graph.facebook.com/' . $page_id . '/feed';

				$query_array = array(
					'access_token' => self::Get_access_token_by_post($post),
					'link' => $link,
					'name' => $post->post_title,
					'caption' => $caption,
					'description' => $description,
					'picture' => $picture,
					'message' => $message
				);

				// Add share link
				if (get_user_meta($user_ID, c_al2fb_meta_share_link, true)) {
					// http://forum.developers.facebook.net/viewtopic.php?id=50049
					// http://bugs.developers.facebook.net/show_bug.cgi?id=9075
					$actions = array(
						'name' => __('Share', c_al2fb_text_domain),
						'link' => 'http://www.facebook.com/share.php?u=' . urlencode($link) . '&t=' . urlencode($post->post_title)
					);
					$query_array['actions'] = json_encode($actions);
				}

				// http://developers.facebook.com/docs/reference/api/link/
				$query = http_build_query($query_array, '', '&');
				if ($this->debug) {
					add_post_meta($post->ID, c_al2fb_meta_log, print_r($query_array, true));
					add_post_meta($post->ID, c_al2fb_meta_log, $query);
				}

				// Execute request
				$response = self::Request($url, $query, 'POST');
				if ($this->debug)
					add_post_meta($post->ID, c_al2fb_meta_log, print_r($response, true));
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
					'access_token' => self::Get_access_token_by_post($post),
					'method' => 'delete'
				), '', '&');
				if ($this->debug)
					add_post_meta($post->ID, c_al2fb_meta_log, $query);

				// Execute request
				$response = self::Request($url, $query, 'POST');
				if ($this->debug)
					add_post_meta($post->ID, c_al2fb_meta_log, print_r($response, true));

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

		function Is_authorized($user_ID) {
			return get_user_meta($user_ID, c_al2fb_meta_access_token, true);
		}

		// Get correct access for post
		function Get_access_token_by_post($post) {
			$user_ID = self::Get_user_ID($post);
			$page_id = get_user_meta($user_ID, c_al2fb_meta_page, true);
			return self::Get_access_token_by_page($user_ID, $page_id);
		}

		// Get access token for page
		function Get_access_token_by_page($user_ID, $page_id) {
			$access_token = get_user_meta($user_ID, c_al2fb_meta_access_token, true);
			if ($page_id && $page_id != 'me' &&
				get_user_meta($user_ID, c_al2fb_meta_page_owner, true)) {
				$found = false;
				$pages = self::Get_pages($user_ID);
				foreach ($pages->data as $page)
					if ($page->id == $page_id) {
						$found = true;
						$access_token = $page->access_token;
					}
			}
			return $access_token;
		}

		// HTML header
		function WP_head() {
			if (is_single() || is_page()) {
				global $post;
				$user_ID = self::Get_user_ID($post);
				if (get_user_meta($user_ID, c_al2fb_meta_open_graph, true)) {
					$charset = get_bloginfo('charset');
					$title = html_entity_decode(get_bloginfo('title'), ENT_QUOTES, get_bloginfo('charset'));

					$link_picture = get_post_meta($post->ID, c_al2fb_meta_link_picture, true);
					if (empty($link_picture)) {
						$picture = get_user_meta($user_ID, c_al2fb_meta_picture_default, true);
						if (empty($picture))
							$picture = self::Redirect_uri() . '?al2fb_image=1';
					}
					else
						$picture = substr($link_picture, strpos($link_picture, '=') + 1);

					echo '<meta property="og:title" content="' . htmlspecialchars($post->post_title, ENT_QUOTES, $charset) . '" />' . PHP_EOL;
					echo '<meta property="og:type" content="blog" />' . PHP_EOL;
					echo '<meta property="og:url" content="' . get_permalink($post->ID) . '" />' . PHP_EOL;
					echo '<meta property="og:image" content="' . $picture . '" />' . PHP_EOL;
					echo '<meta property="og:site_name" content="' . htmlspecialchars($title, ENT_QUOTES, $charset) . '" />' . PHP_EOL;

					if (is_single()) {
						$texts = self::Get_texts($post);
						echo '<meta property="og:description" content="' . htmlspecialchars($texts['description'], ENT_QUOTES, $charset) . '" />' . PHP_EOL;
					}

					$appid = get_user_meta($user_ID, c_al2fb_meta_client_id, true);
					if (!empty($appid))
						echo '<meta property="fb:app_id" content="' . $appid . '" />' . PHP_EOL;
				}
			}

			else if (is_home())
			{
				$charset = get_bloginfo('charset');
				$title = html_entity_decode(get_bloginfo('title'), ENT_QUOTES, get_bloginfo('charset'));
				echo '<meta property="og:title" content="' . htmlspecialchars($title, ENT_QUOTES, $charset) . '" />' . PHP_EOL;
				echo '<meta property="og:type" content="blog" />' . PHP_EOL;
				echo '<meta property="og:url" content="' . get_home_url() . '" />' . PHP_EOL;
			}
		}

		// Post content
		function The_content($content = '') {
			global $post;

			// Show likers
			$user_ID = self::Get_user_ID($post);
			if (get_user_meta($user_ID, c_al2fb_meta_post_likers, true)) {
				$likers = '';
				$charset = get_bloginfo('charset');
				$fb_likes = self::Get_fb_comments($post, true);
				if ($fb_likes)
					foreach ($fb_likes->data as $fb_like) {
						if (!empty($likers))
							$likers .= ', ';
						$link = 'http://www.facebook.com/profile.php?id=' . $fb_like->id;
						$likers .= '<a href="' . $link . '">' . htmlspecialchars($fb_like->name, ENT_QUOTES, $charset) . '</a>';
					}

				if (!empty($likers)) {
					$likers .= ' <span class="al2fb_liked">' . _n('liked this post', 'liked this post', count($fb_likes->data), c_al2fb_text_domain) . '</span>';
					$content .= '<div class="al2fb_likers">' . $likers . '</div>';
				}
			}

			// Show like button
			if (get_user_meta($user_ID, c_al2fb_meta_post_like_button, true) &&
				!(get_user_meta($user_ID, c_al2fb_meta_like_nohome, true) && is_home()) &&
				!(get_user_meta($user_ID, c_al2fb_meta_like_noposts, true) && is_single()) &&
				!(get_user_meta($user_ID, c_al2fb_meta_like_nopages, true) && is_page())) {
				// Get language
				$lang = WPLANG;
				if (empty($lang))
					$lang = 'en_US';

				// Get options
				$layout = get_user_meta($user_ID, c_al2fb_meta_like_layout, true);
				$faces = get_user_meta($user_ID, c_al2fb_meta_like_faces, true);
				$width = get_user_meta($user_ID, c_al2fb_meta_like_width, true);
				$action = get_user_meta($user_ID, c_al2fb_meta_like_action, true);
				$font = get_user_meta($user_ID, c_al2fb_meta_like_font, true);
				$colorscheme = get_user_meta($user_ID, c_al2fb_meta_like_colorscheme, true);
				$link = get_user_meta($user_ID, c_al2fb_meta_like_link, true);
				if (empty($link))
					$link = get_permalink($post->ID);

				// Build content
				$content .= '<script src="http://connect.facebook.net/' . $lang . '/all.js#xfbml=1"></script>';
				$content .= '<fb:like ref="AL2FB"';
				if (!empty($layout))
					$content .= ' layout="' . $layout . '"';
				if ($faces)
					$content .= ' show_faces="true"';
				else
					$content .= ' show_faces="false"';
				if (empty($width))
					$content .= ' width="450"';
				else
					$content .= ' width="' . $width . '"';
				if (!empty($action))
					$content .= ' action="' . $action . '"';
				if (!empty($font))
					$content .= ' font="' . $font . '"';
				if (!empty($colorscheme))
					$content .= ' colorscheme="' . $colorscheme . '"';
				$content .= ' href="' . $link . '"></fb:like>';
			}
			return $content;
		}

		function The_posts($posts, $query) {
			foreach ($posts as $post) {
				$user_ID = self::Get_user_ID($post);
				if (get_user_meta($user_ID, c_al2fb_meta_fb_comments, true)) {
					$fb_comments = self::Get_fb_comments($post, false);
					if ($fb_comments)
						foreach ($fb_comments->data as $fb_comment) {
							// Create new virtual comment
							$new = null;
							$new->comment_ID = $fb_comment->id;
							$new->comment_post_ID = $post->ID;
							$new->comment_author = $fb_comment->from->name . ' ' . __('on Facebook', c_al2fb_text_domain);
							$new->comment_author_email = str_replace(' ', '_', $fb_comment->from->name) . '@example.org';
							$new->comment_author_url = 'http://www.facebook.com/profile.php?id=' . $fb_comment->from->id;
							$new->comment_author_ip = '';
							$new->comment_date = date('Y-m-d H:i:s', strtotime($fb_comment->created_time));
							$new->comment_date_gmt = $new->comment_date;
							$new->comment_content = $fb_comment->message;
							$new->comment_karma = 0;
							$new->comment_approved = 1;
							$new->comment_agent = 'Add Link to Facebook';
							$new->comment_type = 'comment'; // pingback|trackback
							$new->comment_parent = 0;
							$new->user_id = 0;
							$query->comments[] = $new;
							$query->comment_count++;
							$post->comment_count++;
						}
				}
			}
			return $posts;
		}

		// Modify comment list
		function Comments_array($comments, $post_ID) {
			$post = get_post($post_ID);
			$user_ID = self::Get_user_ID($post);

			// Process comments
			if (get_user_meta($user_ID, c_al2fb_meta_fb_comments, true)) {
				$fb_comments = self::Get_fb_comments($post, false);
				if ($fb_comments)
					foreach ($fb_comments->data as $fb_comment) {
						// Create new virtual comment
						$new = null;
						$new->comment_ID = $fb_comment->id;
						$new->comment_post_ID = $post_ID;
						$new->comment_author = $fb_comment->from->name . ' ' . __('on Facebook', c_al2fb_text_domain);
						$new->comment_author_email = str_replace(' ', '_', $fb_comment->from->name) . '@example.org';
						$new->comment_author_url = 'http://www.facebook.com/profile.php?id=' . $fb_comment->from->id;
						$new->comment_author_ip = '';
						$new->comment_date = date('Y-m-d H:i:s', strtotime($fb_comment->created_time));
						$new->comment_date_gmt = $new->comment_date;
						$new->comment_content = $fb_comment->message;
						$new->comment_karma = 0;
						$new->comment_approved = 1;
						$new->comment_agent = 'Add Link to Facebook';
						$new->comment_type = 'comment'; // pingback|trackback
						$new->comment_parent = 0;
						$new->user_id = 0;
						$comments[] = $new;
					}
			}

			// Check if likes
			if (get_user_meta($user_ID, c_al2fb_meta_fb_likes, true)) {
				$fb_likes = self::Get_fb_comments($post, true);
				if ($fb_likes)
					foreach ($fb_likes->data as $fb_like) {
						// Create new virtual comment
						$link = 'http://www.facebook.com/profile.php?id=' . $fb_like->id;
						$new = null;
						$new->comment_ID = $fb_like->id;
						$new->comment_post_ID = $post_ID;
						$new->comment_author = $fb_like->name . ' ' . __('on Facebook', c_al2fb_text_domain);
						$new->comment_author_email = '';
						$new->comment_author_url = $link;
						$new->comment_author_ip = '';
						$new->comment_date = date('Y-m-d H:i:s', time());
						$new->comment_date_gmt = $new->comment_date;
						$new->comment_content = '<em>' . __('Liked this post', c_al2fb_text_domain) . '</em>';
						$new->comment_karma = 0;
						$new->comment_approved = 1;
						$new->comment_agent = 'Add Link to Facebook';
						$new->comment_type = 'pingback';
						$new->comment_parent = 0;
						$new->user_id = 0;
						$comments[] = $new;
					}
			}

			if (!empty($fb_comments) || !empty($fb_likes)) {
				// Sort comments by time
				usort($comments, array(&$this, 'Comment_compare'));
				if (get_option('comment_order') == 'desc')
					array_reverse($comments);
			}
			return $comments;
		}

		function Comment_compare($a, $b) {
			return strcmp($a->comment_date_gmt, $b->comment_date_gmt);
		}

		function Get_comments_number($count, $post_ID) {
			$post = get_post($post_ID);
			$user_ID = self::Get_user_ID($post);
			if (get_user_meta($user_ID, c_al2fb_meta_fb_comments, true))
				$fb_comments = self::Get_fb_comments($post, false);
			if (!empty($fb_comments))
				$count += count($fb_comments->data);
			if (get_user_meta($user_ID, c_al2fb_meta_fb_likes, true))
				$fb_likes = self::Get_fb_comments($post, true);
			if (!empty($fb_likes))
				$count += count($fb_likes->data);
			return $count;
		}

		function Get_fb_comments($post, $likes) {
			$user_ID = self::Get_user_ID($post);
			$link_id = get_post_meta($post->ID, c_al2fb_meta_link_id, true);
			if ($link_id) {
				try {
					// Get cache duration
					$duration = intval(get_option(c_al2fb_option_msg_refresh));
					if (!$duration)
						$duration = 10;

					if ($likes) {
						// Get (cached) likes
						$fb_key = c_al2fb_transient_cache . md5('l' . $link_id);
						$fb_likes = get_transient($fb_key);
						if ($fb_likes === false) {
							$fb_likes = self::Get_likes($user_ID, $link_id);
							set_transient($fb_key, $fb_likes, $duration * 60);
						}
						return $fb_likes;
					}
					else {
						// Get (cached) comments
						$fb_key = c_al2fb_transient_cache . md5( 'c' . $link_id);
						$fb_comments = get_transient($fb_key);
						if ($fb_comments === false) {
							$fb_comments = self::Get_comments($user_ID, $link_id);
							set_transient($fb_key, $fb_comments, $duration * 60);
						}
						return $fb_comments;
					}
				}
				catch (Exception $e) {
					return null;
				}
			}
			return null;
		}

		function Get_user_ID($post) {
			if (is_multisite())
				$shared_user_ID = get_site_option(c_al2fb_option_app_share);
			else
				$shared_user_ID = get_option(c_al2fb_option_app_share);
			if ($shared_user_ID)
				return $shared_user_ID;
			return $post->post_author;
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

		function user_can($user, $capability) {
			if (!is_object($user))
				$user = new WP_User($user);

			if (!$user || !$user->ID)
				return false;

			$args = array_slice(func_get_args(), 2 );
			$args = array_merge(array($capability), $args);

			return call_user_func_array(array(&$user, 'has_cap'), $args);
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

			// Get application
			try {
				if (self::Is_authorized($user_ID)) {
					$a = self::Get_application($user_ID);
					$app = '<a href="' . $a->link . '">' . $a->name . '</a>';
				}
				else
					$app = 'n/a';
			}
			catch (Exception $e) {
				$app = get_user_meta($user_ID, c_al2fb_meta_client_id, true) . ': ' . $e->getMessage();
			}

			// Get page
			try {
				if (self::Is_authorized($user_ID)) {
					$me = self::Get_me($user_ID, false);
					$page = '<a href="' . $me->link . '" target="_blank">' . htmlspecialchars($me->name, ENT_QUOTES, $charset);
					if (!empty($me->category))
						$page .= ' - ' . htmlspecialchars($me->category, ENT_QUOTES, $charset);
					$page .= '</a>';
				}
				else
					$page = 'n/a';
			}
			catch (Exception $e) {
				$page = get_user_meta($user_ID, c_al2fb_meta_page, true) . ': ' . $e->getMessage();
			}

			// Get picture
			$picture = '<a href="' . get_user_meta($user_ID, c_al2fb_meta_picture, true) . '">' . get_user_meta($user_ID, c_al2fb_meta_picture, true) . '</a>';
			$picture_default = '<a href="' . get_user_meta($user_ID, c_al2fb_meta_picture_default, true) . '">' . get_user_meta($user_ID, c_al2fb_meta_picture_default, true) . '</a>';

			// Build info
			$info = '<div class="al2fb_debug"><table border="1">';
			$info .= '<tr><td>Time:</td><td>' . date('c') . '</td></tr>';
			$info .= '<tr><td>Server software:</td><td>' . htmlspecialchars($_SERVER['SERVER_SOFTWARE'], ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>SAPI:</td><td>' . htmlspecialchars(php_sapi_name(), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>PHP version:</td><td>' . PHP_VERSION . '</td></tr>';
			$info .= '<tr><td>safe_mode:</td><td>' . (ini_get('safe_mode') ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>open_basedir:</td><td>' . ini_get('open_basedir') . '</td></tr>';
			$info .= '<tr><td>User agent:</td><td>' . htmlspecialchars($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>WordPress version:</td><td>' . $wp_version . '</td></tr>';
			$info .= '<tr><td>Plugin version:</td><td>' . $plugin_version . '</td></tr>';
			$info .= '<tr><td>Settings version:</td><td>' . get_option(c_al2fb_option_version) . '</td></tr>';
			$info .= '<tr><td>Multi site:</td><td>' . (is_multisite() ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Blog address (home):</td><td><a href="' . get_home_url() . '">' . htmlspecialchars(get_home_url(), ENT_QUOTES, $charset) . '</a></td></tr>';
			$info .= '<tr><td>WordPress address (site):</td><td><a href="' . get_site_url() . '">' . htmlspecialchars(get_site_url(), ENT_QUOTES, $charset) . '</a></td></tr>';
			$info .= '<tr><td>Redirect URI:</td><td><a href="' . self::Redirect_uri() . '">' . htmlspecialchars(self::Redirect_uri(), ENT_QUOTES, $charset) . '</a></td></tr>';
			$info .= '<tr><td>Authorize URL:</td><td><a href="' . self::Authorize_url($user_ID) . '">' . htmlspecialchars(self::Authorize_url($user_ID), ENT_QUOTES, $charset) . '</a></td></tr>';
			$info .= '<tr><td>Authorization init:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_init), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Authorization check:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_check), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Redirect time:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_time), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Redirect referer:</td><td><a href="' . get_option(c_al2fb_log_redir_ref) . '">' . htmlspecialchars(get_option(c_al2fb_log_redir_ref), ENT_QUOTES, $charset) . '</a></td></tr>';
			$info .= '<tr><td>Redirect from:</td><td>' . htmlspecialchars(get_option(c_al2fb_log_redir_from), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Redirect to:</td><td><a href="' . get_option(c_al2fb_log_redir_to) . '">' . htmlspecialchars(get_option(c_al2fb_log_redir_to), ENT_QUOTES, $charset) . '</a></td></tr>';
			$info .= '<tr><td>Authorized:</td><td>' . (self::Is_authorized($user_ID) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Authorized time:</td><td>' . get_option(c_al2fb_log_auth_time) . '</td></tr>';
			$info .= '<tr><td>allow_url_fopen:</td><td>' . (ini_get('allow_url_fopen') ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>cURL:</td><td>' . (function_exists('curl_init') ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>SSL:</td><td>' . (function_exists('openssl_sign') ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Application:</td><td>' . $app . '</td></tr>';

			$info .= '<tr><td>Picture type:</td><td>' . get_user_meta($user_ID, c_al2fb_meta_picture_type, true) . '</td></tr>';
			$info .= '<tr><td>Custom picture URL:</td><td>' . $picture . '</td></tr>';
			$info .= '<tr><td>Default picture URL:</td><td>' . $picture_default . '</td></tr>';

			$info .= '<tr><td>Page:</td><td>' . $page . '</td></tr>';
			$info .= '<tr><td>Page owner:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_page_owner, true) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Use groups:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_use_groups, true) ? 'Yes' : 'No')  . '</td></tr>';
			$info .= '<tr><td>Group:</td><td>' . get_user_meta($user_ID, c_al2fb_meta_group, true) . '</td></tr>';

			$info .= '<tr><td>Caption:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_caption, true) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Excerpt:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_msg, true) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Shortlink:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_shortlink, true) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Trailer:</td><td>' . htmlspecialchars(get_user_meta($user_ID, c_al2fb_meta_trailer, true), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Hyperlink:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_hyperlink, true) ? 'Yes' : 'No') . '</td></tr>';

			$info .= '<tr><td>FB comments:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_fb_comments, true) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>FB likes:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_fb_likes, true) ? 'Yes' : 'No') . '</td></tr>';

			$info .= '<tr><td>Post likers:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_post_likers, true) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Post like button:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_post_like_button, true) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Not home page:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_like_nohome, true) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Not posts:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_like_noposts, true) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Not pages:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_like_nopages, true) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Like layout:</td><td>' . get_user_meta($user_ID, c_al2fb_meta_like_layout, true) . '</td></tr>';
			$info .= '<tr><td>Like faces:</td><td>' . (get_user_meta($user_ID, c_al2fb_meta_like_faces, true) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Like width:</td><td>' . get_user_meta($user_ID, c_al2fb_meta_like_width, true) . '</td></tr>';
			$info .= '<tr><td>Like action:</td><td>' . get_user_meta($user_ID, c_al2fb_meta_like_action, true) . '</td></tr>';
			$info .= '<tr><td>Like font:</td><td>' . get_user_meta($user_ID, c_al2fb_meta_like_font, true) . '</td></tr>';
			$info .= '<tr><td>Like color scheme:</td><td>' . get_user_meta($user_ID, c_al2fb_meta_like_colorscheme, true) . '</td></tr>';
			$info .= '<tr><td>Like link:</td><td>' . get_user_meta($user_ID, c_al2fb_meta_like_link, true) . '</td></tr>';

			$info .= '<tr><td>No notices:</td><td>' . (get_option(c_al2fb_option_nonotice) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Min. capability:</td><td>' . htmlspecialchars(get_option(c_al2fb_option_min_cap), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Refresh comments:</td><td>' . htmlspecialchars(get_option(c_al2fb_option_msg_refresh), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Max. length:</td><td>' . htmlspecialchars(get_option(c_al2fb_option_max_descr), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Exclude post types:</td><td>' . htmlspecialchars(get_option(c_al2fb_option_exclude_type), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Site URL:</td><td>' . htmlspecialchars(get_option(c_al2fb_option_siteurl), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Do not use cURL:</td><td>' . (get_option(c_al2fb_option_nocurl) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Use publish_post:</td><td>' . (get_option(c_al2fb_option_use_pp) ? 'Yes' : 'No') . '</td></tr>';
			$info .= '<tr><td>Debug:</td><td>' . (get_option(c_al2fb_option_debug) ? 'Yes' : 'No') . '</td></tr>';

			$posts = new WP_Query(array('meta_key' => c_al2fb_meta_error, 'posts_per_page' => 5));
			while ($posts->have_posts()) {
				$posts->next_post();
				$error = get_post_meta($posts->post->ID, c_al2fb_meta_error, true);
				if (!empty($error)) {
					$info .= '<tr><td>Error:</td>';
					$info .= '<td>' . htmlspecialchars($error, ENT_QUOTES, $charset) . '</td></tr>';
					$info .= '<tr><td>Error time:</td>';
					$info .= '<td>' . htmlspecialchars(get_post_meta($posts->post->ID, c_al2fb_meta_link_time, true), ENT_QUOTES, $charset) . '</td></tr>';
				}
			}

			$info .= '<tr><td>Last error:</td><td>' . htmlspecialchars(get_option(c_al2fb_last_error), ENT_QUOTES, $charset) . '</td></tr>';
			$info .= '<tr><td>Last error time:</td><td>' . htmlspecialchars(get_option(c_al2fb_last_error_time), ENT_QUOTES, $charset) . '</td></tr>';
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
			self::Check_function('md5');
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
