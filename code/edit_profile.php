<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//連接資料庫
//只要此頁面上有用到連接 MySQL就要include它
include("mysql_connect.inc.php");
$id = $_SESSION['USER_ID'];

function checkUserDetail($conn, $id) {
    $sql = "SELECT * FROM customer 
            WHERE CUS_IDNUM = '$id';
            ";
    return mysqli_query($conn, $sql);
}

$result = checkUserDetail($conn, $id);

if (mysqli_num_rows($result ) == 0) {
    echo '無資料！';
} else{
    while($row = mysqli_fetch_assoc($result)){
    $pw = $row['CUS_PASSWORD'];
    $name = $row['CUS_NAME'];
    $email = $row['CUS_EMAIL'];
    $phone = $row['CUS_PHONE']; 
    }
    }

?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>編輯個人資料</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="order_management.css">
    <link rel="stylesheet" href="edit_profile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel='icon' type='' href='https://cdn-icons-png.flaticon.com/256/55/55283.png'>
</head>
<body>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <header>
        <a href="homepage2.html">
        <div class="logo">EASYRENT</div>
        </a>
        <div class="user-menu">
            <img src="user.png" alt="User Icon" class="user-icon" id="userIcon">
            <div class="dropdown" id="dropdown">
                <p>哈囉 ! 使用者</p>
                <button onclick="location.href='edit_profile.php'">編輯個人資料</button>
                <button onclick="location.href='order_management.php'">訂單管理</button>
                <button onclick="location.href='my_reviews.php'">我的評價</button>
                <button onclick="location.href='QnA.php'">Q & A</button>
                <button id="logoutbtn" onclick="location.href='homepage.html'">登出</button>
            </div>
        </div>
    </header>
    <h1>編輯個人資料</h1>
    <form class="content" method="post" action="update_profile.php">
        <div class="profile-item">
            <label>帳號</label>
            <label><?php echo $id; ?></label>
        </div>
        <div class="profile-item">
            <label>姓名</label>
             <input id="nameValue" name="new_name" style="width:250px;"  placeholder="<?php echo $name; ?>">
            <a class="edit-link" href="#" onclick="editField('name')" name = 'name'>編輯</a>
        </div>
        <div class="profile-item">
            <label>Email</label>
            <input id="emailValue" name="new_email" style="width:250px;" placeholder="<?php echo $email; ?>" >
            <a class="edit-link" href="javascript:void(0);" onclick="editField('email')" name = 'new_email'>編輯</a>
        </div>
        <div class="profile-item">
            <label>密碼</label>
            <input id="pwValue" name="new_pw"  style="width:250px;" placeholder="<?php echo $pw; ?>">
            <a class="edit-link" href="javascript:void(0);" onclick="editField('pw')" name = 'new_pw'>編輯</a>
        </div>
        <div class="profile-item">
            <label>手機</label>
            <input id="phoneValue" name="new_phone" style="width:250px;"  placeholder="<?php echo $phone; ?>">
            <a class="edit-link" href="javascript:void(0);" onclick="editField('phone')" name = 'new_phone'>編輯</a>
        </div>
        <button class="save-button" id="saveButton" onclick="saveChanges()">保存</button> 
    </form>    
    </div>
        <script src="homepage.js"></script>
        <script src="homepage2.js"></script>
        <script src="login.js"></script>
        <script src="edit_profile.js"></script>
        <script>
            function saveChanges() {
                alert("已修改成功");
                window.location.href = "update_profile.php";
            }
        </script>
    </div>
</body>

<footer class="footer" style="margin-top:50px;">
    <div class="footer-container">
        <div class="footer-column">
            <img src="car.png" alt="logo" class="footer-logo">
        </div>
        <div class="footer-column">
            <h3>EASYRENT</h3>
            <ul>
                <li><a href="#">關於我們</a></li>
                <li><a href="#">人才招募</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>租車公司</h3>
            <ul>
                <li><a href="#">店家登入</a></li>
                <li><a href="#">車輛上架</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>使用指南</h3>
            <ul>
                <li><a href="#">租車說明</a></li>
                <li><a href="#">常見問題</a></li>
                <li><a href="#">使用者評論</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>服務規章</h3>
            <ul>
                <li><a href="#">使用者條款</a></li>
                <li><a href="#">隱私權政策</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>追蹤我們</h3>
            <ul class="social-icons">
                <li><a href="https://www.facebook.com/profile.php?id=61561113173951"><img src="facebook.png" alt="Facebook"></a></li>
                <li><a href="#"><img src="line.png" alt="LINE"></a></li>
                <li><a href="#"><img src="messenger.png" alt="Messenger"></a></li>
                <li><a href="#"><img src="youtube.png" alt="YouTube"></a></li>
            </ul>
            <br>
            <p>COPYRIGHT © EASYRENT CO., LTD 2024 ALL RIGHTS RESERVED.</p>
        </div>
    </div>
</footer>

</html>
