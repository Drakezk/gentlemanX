<?php
/**
 * Entry Point - Điểm khởi đầu của ứng dụng E-Commerce
 * File này sẽ xử lý tất cả các request và điều hướng đến controller phù hợp
 */

// Bật hiển thị lỗi (chỉ dùng trong development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Khởi động session
session_start();

// Include các file cần thiết
require_once 'config/config.php';
require_once 'core/Database.php';
require_once 'core/Model.php';
require_once 'core/Controller.php';
require_once 'core/Router.php';
require_once 'core/Auth.php';
require_once 'core/Session.php';
require_once 'core/Helper.php';

// Khởi tạo Router và xử lý request
$router = new Router();
$router->handleRequest();
?>
