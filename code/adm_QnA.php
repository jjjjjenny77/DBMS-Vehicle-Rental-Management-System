<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//連接資料庫
include("mysql_connect.inc.php");
$admin_id = $_SESSION['USER_ID'];

// 更新資料
if (isset($_POST['update'])) {
    $que_num = $_POST['que_num'];
    $ans_answer = $_POST['ans_answer'];
    
    // Check if the answer already exists for the given question number
    $sql_check = "SELECT * FROM answer WHERE QUE_NUM='$que_num'";
    $result_check = $conn->query($sql_check);
    
    if ($result_check->num_rows > 0) {
        // Update existing answer
        $sql_update = "UPDATE answer SET ANS_ANSWER='$ans_answer' WHERE QUE_NUM='$que_num'";
        $sql_update = "UPDATE answer SET ADM_IDNUM='$admin_id' WHERE QUE_NUM='$que_num'";
        $conn->query($sql_update);
    } else {
        // Insert new answer
        $sql_insert = "INSERT INTO answer (QUE_NUM, ADM_IDNUM, ANS_ANSWER) VALUES ('$que_num', '$admin_id', '$ans_answer')";
        $conn->query($sql_insert);
    }
}

// 抓取客戶問題資料
$sql = "
    SELECT question.QUE_NUM, question.CUS_IDNUM, customer.CUS_NAME, question.QUE_QUESTION, answer.ANS_ANSWER
    FROM question
    JOIN customer ON question.CUS_IDNUM = customer.CUS_IDNUM
    LEFT JOIN answer ON question.QUE_NUM = answer.QUE_NUM
";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>回覆客戶</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel='icon' type='' href='https://cdn-icons-png.flaticon.com/256/55/55283.png'>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
        }
        h2{
            margin-left: 20px;
            font-size: 20px;
        }
        .reply-table {
            background-color: white;
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 90px;
        }
        .reply-table th{
            background-color: #DCDCDC;
            font-size: 14px;
            padding: 10px;
            text-align: center;
        }
        .reply-table td {
            background-color: white;
            padding: 10px;
            text-align: center;
        }

        .btn {
            padding: 5px 10px;
            margin: 5px;
        }
        .btn-reply {
            background-color: #516c72;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
    <script>
        function replyRow(button) {
            var row = button.parentNode.parentNode;
            var cells = row.querySelectorAll('td');
            if (button.innerHTML === '回覆') {
                var cell = cells[4];
                var input = document.createElement('textarea');
                input.style.width = '400px'; // 設置寬度
                input.style.height = '50px'; // 設置高度
                input.value = cell.innerHTML;
                cell.innerHTML = '';
                cell.appendChild(input);
                button.innerHTML = '送出';
            } else {
                var cell = cells[4];
                var input = cell.querySelector('textarea');
                cell.innerHTML = input.value;
                button.innerHTML = '回覆';

                var que_num = cells[0].innerHTML;
                var ans_answer = cell.innerHTML;
                document.getElementById('updateForm').que_num.value = que_num;
                document.getElementById('updateForm').ans_answer.value = ans_answer;
                document.getElementById('updateForm').submit();
            }
        }
    </script>
    <body>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <header>
            <a href="adm_homepage2.php">
            <div class="logo">EASYRENT Admin</div>
            </a>
            <div class="user-menu">
                <img src="user.png" alt="User Icon" class="user-icon" id="userIcon">
                <div class="dropdown" id="dropdown">
                    <p>哈囉 ! 管理者</p>
                    <button onclick="location.href='adm_edit_car.php'">車輛管理</button>
                    <button onclick="location.href='adm_order_management.php'">訂單管理</button>
                    <button onclick="location.href='adm_edit_station.php'">站點管理</button>
                    <button onclick="location.href='adm_QnA.php'">回覆客戶</button>
                    <button id="logoutbtn" onclick="location.href='homepage.html'">登出</button>
                </div>
            </div>
        </header>
        <h2>回覆客戶</h2>
        <table id="replyTable" class="reply-table">
            <tr>
                <th>問題編號</th>
                <th>客戶帳號</th>
                <th>客戶名稱</th>
                <th>客戶問題</th>
                <th>管理者回覆</th>
                <th>管理</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['QUE_NUM']; ?></td>
                <td><?php echo $row['CUS_IDNUM']; ?></td>
                <td><?php echo $row['CUS_NAME']; ?></td>
                <td><?php echo $row['QUE_QUESTION']; ?></td>
                <td><?php echo $row['ANS_ANSWER']; ?></td>
                <td>
                    <button class="btn btn-reply" onclick="replyRow(this)">回覆</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <form id="updateForm" method="post" style="display: none;">
            <input type="hidden" name="que_num" value="">
            <input type="hidden" name="ans_answer" value="">
            <input type="hidden" name="update" value="true">
        </form>
    </body>
</head>
<footer class="footer"  style="margin-top: 110px;">
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
        <script src="homepage.js"></script>
        <script src="login.js"></script>
        <script src="homepage2.js"></script>
    </div>
</footer>
</html>
