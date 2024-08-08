<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
// 数据库连接信息

include("mysql_connect.inc.php");
$id = $_SESSION['USER_ID'];

$sql = "SELECT
                REN_ID,
                CUS_IDNUM
                FROM
                    rent
                WHERE
                    (REN_PICKUP_CONDITION = '已還車')
				AND REN_ID NOT IN (SELECT REN_ID FROM feedback);";
		
				
		$result0 = $conn->query($sql);		
		if ($result0->num_rows > 0) {
           while($row = $result0->fetch_assoc()) {
			   $a = $row["CUS_IDNUM"];
			   $b = $row["REN_ID"];
			   $sql1 = "INSERT INTO feedback (CUS_IDNUM, REN_ID, FEE_SCORE, FEE_COMMENT, FEE_DATE) 
				VALUES ('$a', '$b', '0', ' ', ' ')
				";
			mysqli_query($conn,$sql1);		  
		 }

		}


// 處理評價提交請求
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review_id'])) {
    $review_id = $_POST['review_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $sql = "UPDATE feedback SET FEE_SCORE = ?, FEE_COMMENT = ? WHERE REN_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $rating, $comment, $review_id);
    $stmt->execute();
    $stmt->close();
}



?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>我的評價</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="order_management.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel='icon' type='' href='https://cdn-icons-png.flaticon.com/256/55/55283.png'>
    <style>
        .submit-btn {
            background-color: #516c72;
            color: white;
            padding: 10px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            flex-grow: 0;
        }
        .stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-start;
        }
        .stars input[type="radio"] {
            display: none;
        }
        .stars label {
            color: #ccc;
            font-size: 1.5em;
            padding: 0;
            cursor: pointer;
        }
        .stars input[type="radio"]:checked ~ label,
        .stars label:hover,
        .stars label:hover ~ label {
            color: #f5b301;
        }
    </style>
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
    <div id="orderManagement">
        <h1>我的評價</h1>
        <form class="content" method="post" action="update_reviews.php">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>租車單號</th>
                        <th>租賃車輛</th>
                        <th>預約店家</th>
                        <th>取車時間</th>
                        <th>還車時間</th>
                        <th>租車費用</th>
                        <th>評分</th>
                        <th>我給店家的話</th>
                        <th>提交評價</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("mysql_connect.inc.php");
                    $id = $_SESSION['USER_ID'];
                    $sql2 = "SELECT
                            RENT.REN_ID,
                            RENT.VEH_ID,
                            VEHICLE.VEH_MODEL,
                            RENT.REN_PRICE,
                            LOCATION.LOC_CITY,
                            RENT.REN_STARTDATE,
                            RENT.REN_STARTTIME,
                            RENT.REN_ENDDATE,
                            RENT.REN_ENDTIME,
                            RENT.REN_PAID,
                            FEEDBACK.FEE_SCORE,
                            FEEDBACK.FEE_COMMENT
                            FROM
                                RENT
                            JOIN
                                VEHICLE ON RENT.VEH_ID = VEHICLE.VEH_ID
                            JOIN
                                LOCATION ON RENT.REN_STARTLOC = LOCATION.LOC_ID
                            JOIN
                                FEEDBACK ON RENT.REN_ID = FEEDBACK.REN_ID
                            WHERE
                                RENT.CUS_IDNUM = '$id'
                                AND (RENT.REN_PICKUP_CONDITION = '已還車');";
                    $result = $conn->query($sql2);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["REN_ID"] . "</td>";
                            echo "<td>" . $row["VEH_ID"] ."-".$row["VEH_MODEL"]. "</td>";
                            echo "<td>" . $row["LOC_CITY"] . "</td>";
                            echo "<td>" . $row["REN_STARTDATE"] ." " .$row["REN_STARTTIME"]. "</td>";
                            echo "<td>" . $row["REN_ENDDATE"]." ".$row["REN_ENDTIME"]. "</td>";
                            echo "<td>" . $row["REN_PRICE"]. "</td>";
                            echo "<td>";
                            echo "<div class='stars'>";
                            for ($i = 5; $i >= 1; $i--) {
                                $checked = ($i == $row["FEE_SCORE"]) ? "checked" : "";
                                echo "<input type='radio' name='rating_" . $row["REN_ID"] . "' id='star" . $i . "_" . $row["REN_ID"] . "' value='" . $i . "' $checked>";
                                echo "<label for='star" . $i . "_" . $row["REN_ID"] . "'>&#9733;</label>";
                            }
                            echo "</div>";
                            echo "</td>";
                            echo "<td><input type='text' name='comment_" . $row["REN_ID"] . "' value='" . $row["FEE_COMMENT"] . "'></td>";
                            echo "<td>";
                            echo "<input type='hidden' name='review_id' value='" . $row["REN_ID"] . "'>";
                            echo "<input type='hidden' name='rating' value=''>";
                            echo "<input type='hidden' name='comment' value=''>";
                            echo "<input type='submit' value='提交' class='submit-btn'>";
                            echo "<span class='submitted' style='display:none;'>已送出</span>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>暫無評價</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </form>
    </div>
    <script>
        document.querySelectorAll('.submit-btn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const row = this.closest('tr');
                const reviewId = row.querySelector('input[name="review_id"]').value;
                const rating = row.querySelector('input[name^="rating_"]:checked').value;
                const comment = row.querySelector('input[name^="comment_"]').value;
                const formData = new FormData();
                formData.append('review_id', reviewId);
                formData.append('rating', rating);
                formData.append('comment', comment);
                fetch('update_reviews.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert('提交成功！');
                    row.querySelector('.submitted').style.display = 'block';
                    row.querySelector('.submit-btn').style.display = 'none';
                    setTimeout(() => {
                        row.querySelector('.submitted').style.display = 'none';
                        row.querySelector('.submit-btn').style.display = 'inline-block';
                    }, 500);
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
</body>
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
        <script src="homepage.js"></script>
        <script src="login.js"></script>
        <script src="homepage2.js"></script>
    </div>
</footer>

</html>
