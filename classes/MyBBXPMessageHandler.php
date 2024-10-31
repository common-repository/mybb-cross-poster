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
 
class MyBBXPMessageHandler {
	
	private $error = "";
	private $notice = "";
	
	function __construct() {
	}
	
	function has_messages() {
		return $this->error != "" || $this->notice != "";
	}
	
	function sql_error($sql, $file, $line) {
		$this->error .= ('(' . basename($file) . ':' . $line . ') An SQL error occured with the following query: "' . $this->prepare_for_debug_output($sql) . '"<br/>');
	}
	
	function http_error($url, $post_data, $result, $file, $line) {
		$this->error .= '(' . basename($file) . ':' . $line . ') An error occured with the following http request:<br/><br/>URL:<br/>' . $url . '<br/><br/>POST data:<br/>' . $this->prepare_for_debug_output($post_data) . '<br/><br/>WP ERROR:<br/>' . $this->prepare_for_debug_output($result) . '<br/>';
	}
	
	function error($msg, $file, $line) {
		$this->error .= '(' . basename($file) . ':' . $line . ') ' . $msg . '<br/>';
	}
		
	function notice($htmlstring) {
		$this->notice .= $htmlstring;
	}
	
	function flush_messages() {
		if ($this->error != "") {
			update_option('mybbxp_admin_message', '<div id="mybbxp_message" class="error" style="background-color: #FFEBE8 !important;"><strong>MyBBXP ERROR:</strong><br/>' . $this->error . '</div>');
		} elseif ($this->notice != "") {
			update_option('mybbxp_admin_message', '<div id="mybbxp_message" class="updated">MyBBXP NOTICE:<br/>' . $this->notice . '</div>');
		}
	}
	
	function display_buffered_admin_message() {
		if (get_option('mybbxp_admin_message')) {
		    add_action('admin_notices' , array('MyBBXPMessageHandler', 'admin_notice_callback'));
		}
	}
	
	private function prepare_for_debug_output($s) {
		return nl2br(htmlentities(print_r($s, true)));
	}
	
	static function admin_notice_callback() {
		echo get_option('mybbxp_admin_message');
		delete_option('mybbxp_admin_message');
	}
}

?>
