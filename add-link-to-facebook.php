<?php
/*
Plugin Name: Add Link to Facebook
Plugin URI: http://wordpress.org/extend/plugins/add-link-to-facebook/
Description: Automatically add links to published posts to your Facebook wall or pages
Version: 1.47
Author: Marcel Bokhorst
Author URI: http://blog.bokhorst.biz/about/
*/

/*
	Copyright 2011 Marcel Bokhorst

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

#error_reporting(E_ALL);

// Check PHP version
if (version_compare(PHP_VERSION, '5.0.0', '<'))
	die('Add Link to Facebook requires at least PHP 5, installed version is ' . PHP_VERSION);

// Include support class
require_once('add-link-to-facebook-class.php');

// Check pre-requisites
WPAL2Facebook::Check_prerequisites();

// Start plugin
global $wp_al2fb;
$wp_al2fb = new WPAL2Facebook();

// Template tag for likers
function al2fb_likers($post_ID = null) {
	global $wp_al2fb;
	if (empty($post_ID))
		global $post;
	else
		$post = get_post($post_ID);
	if (isset($post))
		echo $wp_al2fb->Get_likers($post);
}

// Template tag for like button
function al2fb_like_button($post_ID = null) {
	global $wp_al2fb;
	if (empty($post_ID))
		global $post;
	else
		$post = get_post($post_ID);
	if (isset($post))
		echo $wp_al2fb->Get_like_button($post);
}

// Template tag for like button
function al2fb_send_button($post_ID = null) {
	global $wp_al2fb;
	if (empty($post_ID))
		global $post;
	else
		$post = get_post($post_ID);
	if (isset($post))
		echo $wp_al2fb->Get_send_button($post);
}

// That's it!

?>
