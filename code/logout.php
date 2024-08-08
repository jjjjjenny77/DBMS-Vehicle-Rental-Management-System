<?php
// 啟動session
session_start();

// 清除所有session資料
session_unset();

// 銷毀session
session_destroy();

// 重新導向到登錄頁面
header("Location: homepage.html");
exit;
?>
