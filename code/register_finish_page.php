<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.inc.php");

$name = $_POST['name'];
$email = $_POST['email'];
$id = $_POST['id'];
$pw = $_POST['pw'];
$phone = $_POST['phone'];

//判斷帳號密碼是否為空值
//確認密碼輸入的正確性
if($id != null)
{
 //新增資料進資料庫語法
	$sql = "INSERT INTO customer (CUS_NAME, CUS_EMAIL, CUS_IDNUM, CUS_PASSWORD, CUS_PHONE) VALUES ('$name', '$email', '$id', '$pw', '$phone')";
	if(mysqli_query($conn,$sql))
	{
	    echo '<script>alert("註冊成功！\n歡迎加入EASYRENT!"); window.location.href = "homepage2.html";</script>';
		echo '<meta http-equiv=REFRESH CONTENT=1;url=ordercar.php>';
	}
	else
	{
		echo '<script>alert("新增失敗!\n請輸入有效資料!"); window.location.href = "register-form.html";</script>';
		echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';
	}
}

else
{
	echo '您無權限觀看此頁面!';
	echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';
}
?>
