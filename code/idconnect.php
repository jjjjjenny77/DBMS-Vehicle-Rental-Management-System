<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//連接資料庫
//只要此頁面上有用到連接 MySQL就要include它
include("mysql_connect.inc.php");
$id = $_POST['id'];
$_SESSION['id'] = $id;

//搜尋資料庫資料
/*$sql = "SELECT * FROM $table WHERE $id_column = '$id' AND $pw_column = '$pw'";
$result = mysqli_query($conn,$sql);
$row = @mysqli_fetch_row($result);*/
function checkLogin($conn, $table, $id, $id_column) {
    $sql = "SELECT * FROM $table WHERE $id_column = '$id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_row($result);
}
//判斷帳號與密碼是否為空白
//以及MySQL資料庫裡是否有這個會員

// 搜索 customer 表
$row = checkLogin($conn, 'customer', $id, 'CUS_IDNUM');

if ($row == null) {
    // 如果在 customer 表中未找到，繼續搜索 admin 表
    $row = checkLogin($conn, 'admin', $id, 'ADM_IDNUM');
    if ($row != null) {
        $_SESSION['ADM_IDNUM'] = $id;
    }
}

if ($row != null && $id != null && $row[0] == $id) {
    // 如果在任意表中找到匹配的行
    $_SESSION['USER_ID'] = $id;  // 使用通用的 session key 來保存用戶ID
    echo '已有帳號，繼續登入';
    //echo '<meta http-equiv=REFRESH CONTENT=1;url=password-form.html>';
    header("Location: password-form.html");
} else {
    echo '無此帳號';
    header("Location: register-form.html");
}
?>
