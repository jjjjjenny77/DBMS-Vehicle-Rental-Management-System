<?php
session_start();
include("mysql_connect.inc.php");
header('Content-Type: text/html; charset=utf-8');
$admin_id = $_SESSION['USER_ID'];

$id = $_SESSION['USER_ID'];
$que_question = isset($_POST['que_question']) ? $_POST['que_question'] : '';

// Insert the new question into the database if it's not empty
if (!empty($que_question)) {
    $que_question = mysqli_real_escape_string($conn, $que_question);
    $sql = "INSERT INTO question (QUE_NUM, CUS_IDNUM, QUE_QUESTION) VALUES ('NULL', '$admin_id', '$que_question')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: QnA.php");
        exit();
    } else {
        echo '詢問失敗: ' . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>Q&A Page</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="order_management.css">
    <link rel="stylesheet" href="edit_profile.css">
    <link rel="stylesheet" href="QnA.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel='icon' type='' href='https://cdn-icons-png.flaticon.com/256/55/55283.png'>
    <style>
        .chat-container {
            width: 80%;
            margin: 30px auto;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
        }
        .chat-header {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .chat-messages {
            height: 300px;
            overflow-y: scroll;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            max-width: 80%;
        }
        .user {
            background-color: #e5eaea;
            margin-left: auto;
        }
        .company {
            background-color: #f2f2f2;
            margin-right: auto;
        }
        .chat-input {
            display: flex;
            margin-top: 10px;
        }
        .chat-input input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .chat-input button {
            margin-left: 10px;
            padding: 10px 20px;
            background-color: #516c72;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <a href="homepage2.html">
        <div class="logo">EASYRENT</div>
        </a>
        <div class="user-menu">
            <img src="user.png" alt="User Icon" class="user-icon" id="userIcon">
            <div class="dropdown" id="dropdown">
                <p>哈囉 ! 使用者</p>
                <a href="edit_profile.php" style="text-decoration: none;"><button>編輯個人資料</button></a>
                <button onclick="location.href='order_management.php'">訂單管理</button>
                <button onclick="location.href='my_reviews.php'">我的評價</button>
                <button onclick="location.href='QnA.php'">Q & A</button>
                <button id="logoutbtn" onclick="location.href='homepage.html'">登出</button>
            </div>
        </div>
    </header>

    <div class="chat-container">
        <div class="chat-header">EASYRENT數位客服</div>
        <div class="chat-messages" id="chat-messages">
            <div class="message company">
                <img src="客服.png" alt="Company">
                您好！請輸入您想詢問的問題，讓我為您服務！
            </div>
            <?php
            // Fetch and display past questions and answers from the database
            $sql = "SELECT q.QUE_QUESTION, a.ANS_ANSWER FROM question q LEFT JOIN answer a ON q.QUE_NUM = a.QUE_NUM WHERE q.CUS_IDNUM = '$id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='message user'>" . $row['QUE_QUESTION'] . "</div>";
                    echo "<div class='message company'><img src='客服.png' alt='Company'>" . ($row['ANS_ANSWER'] ? $row['ANS_ANSWER'] : '感謝您的來信！正在轉接客服，請耐心等待專員為您解答...') . "</div>";
                }
            } else {
                // echo "<div class='message company'><img src='客服.png' alt='Company'>暫無提問</div>";
            }
            ?>
        </div>
        <div class="chat-input">
            <form action="QnA.php" method="post" style="display: flex; flex-grow: 1;">
                <input type="text" id="user-input" name="que_question" placeholder="請輸入您的問題" style="flex-grow: 1; width:600px; height: 40px;">
                <button type="submit" style="width:100px; height: 40px;">送出</button>
            </form>
        </div>
    </div>

    <script src="homepage.js"></script>
    <script src="homepage2.js"></script>
    <script src="login.js"></script>
    <script src="edit_profile.js"></script>
    <script src="QnA.js"></script>

    <footer class="footer">
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
    
        <div>
            <script src="homepage2.js"></script>
        </div>
    </footer>
</body>
</html>
