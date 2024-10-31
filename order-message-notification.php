<?php
/*
Plugin Name: Order Message Notification
Plugin URI: https://danielesparza.studio/order-message-notification/
Description: Order Message Notification es un Plugin para WordPress y WooCommerce que sirve para envíar un mensaje de confirmación al cliente via WhatsApp al momento de realizar un pedido. Este plugin esta integrado con la API Twilio para WhatsApp.
Version: 1.0
Author: Daniel Esparza
Author URI: https://danielesparza.studio/
License: GPL v3

Order Message Notification
©2020 Daniel Esparza, inspirado por #openliveit #dannydshore | Consultoría en servicios y soluciones de entorno web - https://danielesparza.studio/

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//global
$dewp_prefix = 'dewp_';
$dewp_plugin_name = 'Order Message Notification';
$dewp_options = get_option( 'dewp_settings' );

//includes
include ( 'includes/order-message-notification-admin.php' );
include ( 'includes/order-message-notification-functions.php' );