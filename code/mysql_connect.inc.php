<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
// 資料庫設定
// 資料庫位置
$db_server = "localhost";
// 資料庫名稱
$db_name = "sharingcar";
// 資料庫管理者帳號
$db_user = " ";
// 資料庫管理者密碼
$db_passwd = " ";

// 對資料庫連線
$conn = new mysqli($db_server, $db_user, $db_passwd);

// 檢查連線是否成功
if ($conn->connect_error) {
    die("無法對資料庫連線: " . $conn->connect_error);
}

// 資料庫連線採用UTF8
if (!mysqli_query($conn, "SET NAMES utf8")) {
    die("設定資料庫編碼失敗: " . mysqli_error($conn));
}

// 選擇資料庫
if (!@mysqli_select_db($conn, $db_name)) {
    die("無法使用資料庫: " . mysqli_error($conn));
}

?>
