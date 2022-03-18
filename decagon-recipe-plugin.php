<?php
/**
* @package DecagonRecipePlugin
*/
/*
Plugin Name: Decagon Recipe Plugin
Plugin URI: https://decagonhq.com/
Description:A simple plugin that can be used to create a new recipe, view all available recipes, to edit a recipe and to delete a single or multiple recipes
Version: 1.0.0
Author: Valentine Michael
Author URI: https://chionye.com/
License: GPLv2 or later
Text Domain: decagon-recipe-plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
Copyright 2005-2015 Automattic, Inc.
*/

defined( 'ABSPATH' ) or die();

register_activation_hook( __FILE__, 'createTable');

function createTable() {
  global $wpdb;
  $charsetCollate = $wpdb->get_charset_collate();
  $tableName = $wpdb->prefix . 'recipe';
  $sql = "CREATE TABLE IF NOT EXISTS `$tableName` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `recipe` text DEFAULT NULL,
  PRIMARY KEY(id)
  ) $charsetCollate";

  if ($wpdb->get_var("SHOW TABLES LIKE '$tableName'") != $tableName) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }
}

add_action('admin_menu', 'addAdminMenu');

function addAdminMenu() {
    // menu items
    add_menu_page('Recipes', 'Recipes', 'manage_options', 'Recipe', '', 'dashicons-community');
    add_submenu_page( 'Recipe', 'All Recipes', 'All Recipes',
        'manage_options', 'Recipe', 'getAllRecords');
    add_submenu_page( 'Recipe', 'Edit Recipe', 'Edit Recipe',
        'manage_options', 'Recipe', 'editRecipe');
}