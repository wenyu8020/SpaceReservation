<?php
session_start();
if(!isset($_SESSION["loggedin"])){
    header("location: ./login.php");
    exit;
}

// 獲取用戶角色
$role = $_SESSION["memberRole"];

// 根據角色導向不同的頁面
if ($role === "User") {
    header("location: ./user_dashboard.php");
    exit;
} elseif ($role === "Administrator") {
    header("location: ./admin_dashboard.php");
    exit;
}
?>
