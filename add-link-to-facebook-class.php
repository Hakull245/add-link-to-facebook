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
define('c_al2fb_option_donated', 'al2fb_donated');
define('c_al2fb_option_clean', 'al2fb_clean');

define('c_al2fb_meta_client_id', 'al2fb_client_id');
define('c_al2fb_meta_app_secret', 'al2fb_app_secret');
define('c_al2fb_meta_access_token', 'al2fb_access_token');
define('c_al2fb_meta_picture_type', 'al2fb_picture_type');
define('c_al2fb_meta_picture', 'al2fb_picture');

define('c_al2fb_meta_link_id', 'al2fb_facebook_link_id');
define('c_al2fb_meta_exclude', 'al2fb_facebook_exclude');

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
			register_activation_hook($file, array(&$this, 'Activate'));
			register_deactivation_hook($file, array(&$this, 'Deactivate'));

			// Register actions
			add_action('init', array(&$this, 'Init'), 0);
			if (is_admin()) {
				add_action('admin_menu', array(&$this, 'Admin_menu'));
				add_action('admin_notices', array(&$this, 'Admin_notices'));
				add_action('save_post', array(&$this, 'Save_post'), 10, 2);
				add_action('publish_post', array(&$this, 'Publish_post'));
				add_action('post_submitbox_start', array(&$this, 'Post_submitbox'));
			}
		}

		// Handle plugin activation
		function Activate() {
			if (!get_option(c_al2fb_option_version)) {
				// Set version
				update_option(c_al2fb_option_version, 1);
			}
		}

		// Handle plugin deactivation
		function Deactivate() {
			// Cleanup if requested
			if (get_option(c_al2fb_option_clean)) {
				// Delete options
				delete_option(c_al2fb_option_version);
				delete_option(c_al2fb_option_timeout);
				delete_option(c_al2fb_option_donated);
				delete_option(c_al2fb_option_clean);

				// Delete user meta values
				global $wpdb;
				$rows = $wpdb->get_results("SELECT user_id, meta_key FROM " . $wpdb->usermeta . " WHERE meta_key LIKE 'al2fb_%'");
				foreach ($rows as $row)
					delete_usermeta($row->user_id, $row->meta_key);
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

			// Handle Facebook authorization
			if (strpos($_SERVER['HTTP_REFERER'], 'facebook.com/connect') &&
				strpos($_SERVER['REQUEST_URI'], basename(dirname($this->main_file))) === false &&
				(strpos($_SERVER['REQUEST_URI'], 'code=') || strpos($_SERVER['REQUEST_URI'], 'error='))) {
				// http://www.facebook.com/connect/uiserver.php?...
				$url = admin_url('tools.php?page=' . plugin_basename($this->main_file));
				header('HTTP/1.1 302 Found');
				header('Location: ' . $url . '&action=authorize&' . substr($_SERVER['REQUEST_URI'], 2));
				exit();
			}
		}

		// Display admin messages
		function Admin_notices() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			// Check if action
			if (isset($_REQUEST['action'])) {
				// Configuration
				if ($_REQUEST['action'] == 'config') {
					// Check security
					check_admin_referer(c_al2fb_nonce_form);

					// Invalidate access token
					if (get_user_meta($user_ID, c_al2fb_meta_client_id, true) != $_POST[c_al2fb_meta_client_id] ||
						get_user_meta($user_ID, c_al2fb_meta_app_secret, true) != $_POST[c_al2fb_meta_app_secret])
						delete_user_meta($user_ID, c_al2fb_meta_access_token);

					// Update options
					update_user_meta($user_ID, c_al2fb_meta_client_id, $_POST[c_al2fb_meta_client_id]);
					update_user_meta($user_ID, c_al2fb_meta_app_secret, $_POST[c_al2fb_meta_app_secret]);
					update_user_meta($user_ID, c_al2fb_meta_picture_type, $_POST[c_al2fb_meta_picture_type]);
					update_user_meta($user_ID, c_al2fb_meta_picture, $_POST[c_al2fb_meta_picture]);

					if (current_user_can('manage_options')) {
						update_option(c_al2fb_option_clean, $_POST[c_al2fb_option_clean]);
						update_option(c_al2fb_option_donated, $_POST[c_al2fb_option_donated]);
					}

					// Show result
					echo '<div id="message" class="updated fade al2fb_notice"><p>' . __('Settings updated', c_al2fb_text_domain) . '</p></div>';
				}

				// Authorization
				else if ($_REQUEST['action'] == 'authorize') {
					if (isset($_REQUEST['code'])) {
						try {
							$access_token = self::Get_token();
							update_user_meta($user_ID, c_al2fb_meta_access_token, $access_token);
							echo '<div id="message" class="updated fade al2fb_notice"><p>' . __('Authorized', c_al2fb_text_domain) . '</p></div>';
						}
						catch (Exception $e) {
							delete_user_meta($user_ID, c_al2fb_meta_access_token);
							echo '<div id="message" class="error fade al2fb_error"><p>' . $e->getMessage() . '</p></div>';
						}
					}
					else if (isset($_REQUEST['error'])) {
						// error_reason, error, error_description
						echo '<div id="message" class="error fade al2fb_error"><p>' . $_REQUEST['error_description'] . '</p></div>';
					}
				}
			}

			// Check config/authorization
			if (!get_user_meta($user_ID, c_al2fb_meta_client_id, true) || !get_user_meta($user_ID, c_al2fb_meta_app_secret, true))
				$msg = __('needs configuration', c_al2fb_text_domain);
			else if (!get_user_meta($user_ID, c_al2fb_meta_access_token, true))
				$msg = __('needs authorization', c_al2fb_text_domain);
			if ($msg) {
				$url = admin_url('tools.php?page=' . plugin_basename($this->main_file));
				echo '<div class="error fade al2fb_error"><p>';
				_e('Add Link to Facebook', c_al2fb_text_domain);
				echo ' <a href="' . $url . '">' . $msg . '</a></p></div>';
			}
		}

		// Register options page
		function Admin_menu() {
			if (function_exists('add_management_page'))
				add_management_page(
					__('Add Link to Facebook', c_al2fb_text_domain) . ' ' . __('Administration', c_al2fb_text_domain),
					__('Add Link to Facebook', c_al2fb_text_domain),
					'edit_posts',
					$this->main_file,
					array(&$this, 'Administration'));
		}

		// Handle option page
		function Administration() {
			// Security check
			if (!current_user_can('edit_posts'))
				die('Unauthorized');

			// Get current user
			global $user_ID;
			get_currentuserinfo();

			self::Sponsorship();

			$pic_type = get_user_meta($user_ID, c_al2fb_meta_picture_type, true);
			$pic_wordpress = ($pic_type == 'wordpress' ? ' checked' : '');
			$pic_featured = ($pic_type == 'featured' ? ' checked' : '');
			$pic_facebook = ($pic_type == 'facebook' ? ' checked' : '');
			$pic_custom = ($pic_type == 'custom' ? ' checked' : '');
?>
			<div class="wrap">
<?php		self::Resources(); ?>
			<div class="al2fb_options">
			<h2><?php _e('Add Link to Facebook', c_al2fb_text_domain); ?></h2>

			<span><?php _e('To get an App ID and Secret you have to create a Facebook application', c_al2fb_text_domain); ?></span><br />
			<span><a href="http://www.facebook.com/developers/createapp.php" target="_blank">
			<?php _e('Click here to create', c_al2fb_text_domain); ?></a></span><br />
			<span><strong><?php _e('App Name', c_al2fb_text_domain); ?></strong>:
			<em><?php _e('Anything you like, will appear as "via ..." below the message', c_al2fb_text_domain); ?></em></span><br />
			<span><strong><?php _e('Web Site > Site URL', c_al2fb_text_domain); ?></strong>:
			<em><?php echo htmlspecialchars(get_site_url(null, '/', 'http')); ?></em></span><br />

			<form method="post" action="">
			<input type="hidden" name="action" value="config">
			<?php wp_nonce_field(c_al2fb_nonce_form); ?>

			<table class="form-table">
			<tr valign="top"><th scope="row">
				<label for="al2fb_client_id"><?php _e('App ID:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_client_id" class="al2fb_client_id" name="<?php echo c_al2fb_meta_client_id; ?>" type="text" value="<?php echo get_user_meta($user_ID, c_al2fb_meta_client_id, true); ?>" />
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_app_secret"><?php _e('App Secret:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_app_secret" class="al2fb_app_secret" name="<?php echo c_al2fb_meta_app_secret; ?>" type="text" value="<?php echo get_user_meta($user_ID, c_al2fb_meta_app_secret, true); ?>" />
			</td></tr>

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
				<br /><span><?php _e('At least 50 x 50 pixels', c_al2fb_text_domain); ?></span>
			</td></tr>

<?php		if (current_user_can('manage_options')) { ?>

			<tr valign="top"><th scope="row">
				<label for="al2fb_clean"><?php _e('Clean on deactivate:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_clean" name="<?php echo c_al2fb_option_clean; ?>" type="checkbox"<?php if (get_option(c_al2fb_option_clean)) echo ' checked="checked"'; ?> />
				<br /><span><?php _e('All data, except link id\'s', c_al2fb_text_domain); ?></span>
			</td></tr>

			<tr valign="top"><th scope="row">
				<label for="al2fb_donated"><?php _e('I have donated to this plugin:', c_al2fb_text_domain); ?></label>
			</th><td>
				<input id="al2fb_donated" name="<?php echo c_al2fb_option_donated; ?>" type="checkbox"<?php if (get_option(c_al2fb_option_donated)) echo ' checked="checked"'; ?> />
			</td></tr>

<?php		} ?>

			</table>

			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save', c_al2fb_text_domain) ?>" />
			</p>

			</form>

<?php		if (get_user_meta($user_ID, c_al2fb_meta_client_id, true) &&
				get_user_meta($user_ID, c_al2fb_meta_app_secret, true)) {
				if (get_user_meta($user_ID, c_al2fb_meta_access_token, true))
					try {
						$me = self::Get_me();
						_e('Links will be added to', c_al2fb_text_domain);
						echo ' <a href="' . $me->link . '" target="_blank">' . $me->name . '</a>';
					}
					catch (Exception $e) {
						echo '<div id="message" class="error fade al2fb_error"><p>' . $e->getMessage() . '</p></div>';
					}
?>
				<form method="get" action="<?php echo self::Authorize_url(); ?>">
				<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Authorize', c_al2fb_text_domain) ?>" />
				</p>
				</form>
<?php		} ?>

			</div>
			</div>
<?php
		}

		function Sponsorship() {
			if (!get_option(c_al2fb_option_donated)) {
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
?>
			<div class="al2fb_resources">
			<h3><?php _e('Resources', c_al2fb_text_domain); ?></h3>
			<ul>
			<li><a href="http://wordpress.org/extend/plugins/add-link-to-facebook/faq/" target="_blank"><?php _e('Frequently asked questions', c_al2fb_text_domain); ?></a></li>
			<li><a href="http://blog.bokhorst.biz/5018/computers-en-internet/wordpress-plugin-add-link-to-facebook/" target="_blank"><?php _e('Support page', c_al2fb_text_domain); ?></a></li>
			<li><a href="http://blog.bokhorst.biz/about/" target="_blank"><?php _e('About the author', c_al2fb_text_domain); ?></a></li>
			<li><a href="http://wordpress.org/extend/plugins/profile/m66b" target="_blank"><?php _e('Other plugins', c_al2fb_text_domain); ?></a></li>
			</ul>
<?php		if (!get_option(c_al2fb_option_donated)) { ?>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			</form>
<?php		} ?>
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
			$url .= '&redirect_uri=' . urlencode(get_site_url(null, '/', 'http'));
			$url .= '&scope=publish_stream,offline_access';
			return $url;
		}

		// Request token
		function Get_token() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			$url = 'https://graph.facebook.com/oauth/access_token';
			$query = http_build_query(array(
				'client_id' => get_user_meta($user_ID, c_al2fb_meta_client_id, true),
				'redirect_uri' => get_site_url(null, '/', 'http'),
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

		// Get profile data
		function Get_me() {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			$url = 'https://graph.facebook.com/me';
			$query = http_build_query(array(
				'access_token' => get_user_meta($user_ID, c_al2fb_meta_access_token, true)
			));
			$response = self::Request($url, $query, 'GET');
			$me = json_decode($response);
			return $me;
		}

		// Add exclude checkbox
		function Post_submitbox() {
			global $post;
			$exclude = get_post_meta($post->ID, c_al2fb_meta_exclude, true);
			$chk_exclude = $exclude ? 'checked' : '';
?>
			<div class="al2fb_post_submit">
			<input type="checkbox" name="<?php echo c_al2fb_meta_exclude; ?>" <?php echo $chk_exclude; ?> />
			<span><?php _e('Do not add link to Facebook', c_al2fb_text_domain); ?></span>
			</div>
<?php
		}

		// Handle save post
		function Save_post($post_ID, $post) {
			// Process exclude flag
			$exclude = $_POST[c_al2fb_meta_exclude];
			if ($exclude)
				update_post_meta($post_ID, c_al2fb_meta_exclude, $exclude);
			else
				delete_post_meta($post_ID, c_al2fb_meta_exclude);
		}

		// Handle publish post
		function Publish_post($post_ID) {
			// Get current user
			global $user_ID;
			get_currentuserinfo();

			// Check if not added
			if (!get_post_meta($post_ID, c_al2fb_meta_link_id, true) &&
				!get_post_meta($post_ID, c_al2fb_meta_exclude, true)) {
				$post = get_post($post_ID);

				// Check if public
				if ($post->post_status == 'publish' && empty($post->post_password)) {
					// Get link picture
					$picture = '';
					$picture_type = get_user_meta($user_ID, c_al2fb_meta_picture_type, true);
					if (!$picture_type || $picture_type == 'wordpress')
						$picture = 'http://s.wordpress.org/about/images/logo-blue/blue-s.png';
					else if ($picture_type == 'featured') {
						$picture_id = get_post_thumbnail_id($post_ID);
						if ($picture_id) {
							$picture = wp_get_attachment_image_src($picture_id, 'large');
							$picture = $picture[0];
						}
					}
					else if ($picture_type == 'custom')
						$picture = get_user_meta($user_ID, c_al2fb_meta_picture, true);

					// Add link
					try {
						// http://developers.facebook.com/docs/reference/api
						$url = 'https://graph.facebook.com/me/feed';
						$excerpt = do_shortcode($post->post_excerpt ? $post->post_excerpt : $post->post_content);
						$query = http_build_query(array(
							'access_token' => get_user_meta($user_ID, c_al2fb_meta_access_token, true),
							'link' => get_permalink($post_ID),
							'name' => $post->post_title,
							//'caption' => $picture,
							'description' => $excerpt,
							//'icon' => 'Add Link to Facebook',
							'picture' => $picture
							//'message' => 'Add Link to Facebook'
						));
						$response = self::Request($url, $query, 'POST');
						$link = json_decode($response);

						// Register link
						add_post_meta($post_ID, c_al2fb_meta_link_id, $link->id);
					}
					catch (Exception $e) {
						// Do not disturb WordPress
					}
				}
			}
		}

		// Generic http request
		function Request($url, $query, $type) {
			// Get timeout
			$timeout = get_option(c_al2fb_option_timeout);
			if (!$timeout)
				$timeout = 60;

			// Use cURL if available
			if (function_exists('curl_init'))
				return self::curl_file_get_contents($url, $query, $type, $timeout);

			if (version_compare(PHP_VERSION, '5.2.1') < 0)
				ini_set('default_socket_timeout', $timeout);

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
			$status = explode(' ', $http_response_header[0]);
			$status = intval($status[1]);
			if ($status == 200)
				return $content;
			else
				throw new Exception('Error ' . $status . ': ' . $this->php_error);
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
				throw new Exception('Error ' . $status . ': ' . $error);
			}
		}

		// Check environment
		function Check_prerequisites() {
			// Check PHP version
			if (version_compare(PHP_VERSION, '5.0.0', '<'))
				die('Add Link to Facebook requires at least PHP 5.0.0');

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
