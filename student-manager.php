<?php
/*
Plugin Name: Student Manager
Plugin URI: https://yourwebsite.com
Description: Plugin quản lý sinh viên với Custom Post Type, Meta Box và Shortcode.
Version: 1.0
Author: Vu Truong Giang
Text Domain: student-manager
*/

// Ngăn chặn truy cập trực tiếp vào file
if (! defined('ABSPATH')) {
    exit;
}

// Gọi các file chức năng từ thư mục includes
require_once plugin_dir_path(__FILE__) . 'includes/cpt-student.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-boxes.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';
