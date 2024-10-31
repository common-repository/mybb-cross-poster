<?php
/*
 * This file is part of MyBB Cross-Poster.
 * Updated by Jochen Gererstorfer (http://j0e.org/)
 * Original Version (MyBB Cross-Postalicious) by Markus Echterhoff (http://www.markusechterhoff.com)
 *
 * MyBB Cross-Poster is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * MyBB Cross-Poster is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with MyBB Cross-Poster.  If not, see <http://www.gnu.org/licenses/>.
 */
 
/*
Plugin Name: MyBB Cross-Poster
Plugin URI: https://wordpress.org/plugins/mybb-cross-poster/
Description: Allows cross-posting from Wordpress to MyBB.
Version: 1.0
Author: Jochen Gererstorfer
Author URI: http://j0e.org/
License: GPLv3+
*/

require_once(dirname(__FILE__) . '/classes/MyBBXP.php');
require_once(dirname(__FILE__) . '/mybbxp-recent-topics-widget.php');

// start MyBB Cross-Poster and hook it up
$myBBXPVar = new MyBBXP();
register_activation_hook(dirname(__FILE__) . '/classes/mybbxp.php', array($myBBXPVar, 'activation_hook'));
add_action('publish_post', array($myBBXPVar, 'publish_post_or_page_action'));
add_action('publish_page', array($myBBXPVar, 'publish_post_or_page_action'));
add_action('add_meta_boxes',  array($myBBXPVar, 'add_meta_boxes_action'));
add_action('admin_head-post.php', array($myBBXPVar, 'admin_head_post_php_action'));
add_action('shutdown', array($myBBXPVar, 'shutdown_action'));
add_action('admin_menu', array($myBBXPVar, 'admin_menu_action'));
add_filter('the_content', array($myBBXPVar, 'the_content_filter'));
add_filter('comment_status_pre', array($myBBXPVar, 'comment_and_ping_stati_pre'));
add_filter('ping_status_pre', array($myBBXPVar, 'comment_and_ping_stati_pre'));

// register our widget
add_action('widgets_init', create_function('', 'register_widget("mybbxp_recent_topics_widget");'));

?>
