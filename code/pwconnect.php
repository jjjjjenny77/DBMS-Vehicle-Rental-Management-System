<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//連接資料庫
//只要此頁面上有用到連接 MySQL就要include它
include("mysql_connect.inc.php");
$pw = $_POST['pw'];
$id = $_SESSION['id'];

//搜尋資料庫資料
/*$sql = "SELECT * FROM $table WHERE $pw_column = '$pw'";
$result = mysqli_query($conn,$sql);
$row = @mysqli_fetch_row($result);*/

function checkLogin($conn, $table, $pw, $pw_column, $id, $id_column ) {
    $sql = "SELECT * FROM $table 
	WHERE $pw_column = '$pw'
	and $id_column = '$id';
	";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_row($result);
}
//判斷帳號與密碼是否為空白
//以及MySQL資料庫裡是否有這個會員

// 搜索 customer 表
$row = checkLogin($conn, 'customer', $pw, 'CUS_PASSWORD', $id, 'CUS_IDNUM');

if ($row == null) {
    // 如果在 customer 表中未找到，繼續搜索 admin 表
    $row = checkLogin($conn, 'admin', $pw, 'ADM_PASSWORD',$id, 'ADM_IDNUM');
    if ($row != null) {
        $_SESSION['ADM_PASSWORD'] = $pw;
        echo '<script>alert("管理者您好！"); window.location.href = "adm_homepage2.php";</script>';
    }
}

if ($pw != null && $row[1] == $pw) {
    // 如果在任意表中找到匹配的行
    $_SESSION['USER_PASSWORD'] = $pw;  // 使用通用的 session key 來保存用戶pw
    echo '<script>alert("登入成功！"); window.location.href = "homepage2.html";</script>';
} else {
    echo '<script>alert("密碼錯誤！"); window.location.href = "password-form.html";</script>';
    echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
    echo '<meta http-equiv=REFRESH CONTENT=1;url=register.php>';
}
?>
