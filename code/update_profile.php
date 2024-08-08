<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//連接資料庫
//只要此頁面上有用到連接 MySQL就要include它
include("mysql_connect.inc.php");

$new_name = $_POST["new_name"] ;
$new_pw = $_POST["new_pw"];
$new_email = $_POST["new_email"];
$new_phone = $_POST["new_phone"];
$id = $_SESSION['USER_ID'];


if ($new_name != null) {
    $sql = "UPDATE customer SET CUS_NAME = '$new_name'
	WHERE CUS_IDNUM = '$id';";
	if(mysqli_query($conn,$sql))
	{
	    echo '更新姓名成功';
        header("Location: edit_profile.php");
	}
	else
	{
		echo '無須更新姓名';
        header("Location: edit_profile.php");
	}
}
	
if ($new_pw != null) {
	echo $new_id;
    $sql = "UPDATE customer SET CUS_PASSWORD = '$new_pw'
	WHERE CUS_IDNUM = '$id';";
	if(mysqli_query($conn,$sql))
	{
	    echo '更新密碼成功';
        header("Location: edit_profile.php");
	}
	else
	{
		echo '無須更新密碼';
        header("Location: edit_profile.php");
	}
}

if ($new_email != null) {
    $sql = "UPDATE customer SET CUS_EMAIL = '$new_email'
	WHERE CUS_IDNUM = '$id';";
	if(mysqli_query($conn,$sql))
	{
	    echo '更新信箱成功';
        header("Location: edit_profile.php");
	}
	else
	{
		echo '無須更新信箱';
        header("Location: edit_profile.php");
	}
}

if ($new_phone != null) {
    $sql = "UPDATE customer SET CUS_PHONE = '$new_phone'
	WHERE CUS_IDNUM = '$id';";
	if(mysqli_query($conn,$sql))
	{
	    echo '更新手機號碼成功';
        header("Location: edit_profile.php");
	}
	else
	{
		echo '無須更新手機號碼';
        header("Location: edit_profile.php");
	}
}
 header("Location: edit_profile.php");

?>
