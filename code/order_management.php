<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
// 数据库连接信息

include("mysql_connect.inc.php");
$id = $_SESSION['USER_ID'];

// 處理刪除請求
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM rent WHERE REN_ID = $delete_id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>訂單管理</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="order_management.css">
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
                 <a href="edit_profile.php" style="text-decoration: none;"><button>編輯個人資料</button></a>
                <button onclick="location.href='order_management.php'">訂單管理</button>
                <button onclick="location.href='my_reviews.php'">我的評價</button>
                <button onclick="location.href='QnA.php'">Q & A</button>
                <button id="logoutbtn" onclick="location.href='homepage.html'">登出</button>
            </div>
        </div>
    </header>
    <div id="orderManagement" >
        <h1>訂單管理</h1>
        <div class = menu>
            <div class="tab-button active" id="unpaid" onclick="showTab('unpaid'); location.href='order_management.php'">未取車</div>
            <div class="tab-button" id="picked" onclick="showTab('picked'); location.href='order_management2.php'" >已取車</div>
            <div class="tab-button" id="returned" onclick="showTab('returned'); location.href='order_management3.php'">已還車</div>
            <table id="table" class="order-table">
                <thead>
                    <tr>
                        <th>租車單號</th>
                        <th>租賃車輛</th>
                        <th>預約店家</th>
                        <th>取車時間</th>
                        <th>還車時間</th>
                        <th>租車費用</th>
						<th>付款方式</th>
                        <th>付款狀態</th>
                        <th>訂單管理</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
							$id = $_SESSION['USER_ID'];
							$sql = "SELECT 
									RENT.REN_ID,
									RENT.VEH_ID,
									VEHICLE.VEH_MODEL,
									RENT.REN_PRICE,
									LOCATION.LOC_CITY,
									RENT.REN_STARTDATE,
									RENT.REN_STARTTIME,
									RENT.REN_ENDDATE,
									RENT.REN_ENDTIME,
									REN_PAYMENT,
									RENT.REN_PAID
									FROM 
									 	RENT
									JOIN 
										VEHICLE ON RENT.VEH_ID = VEHICLE.VEH_ID
									JOIN 
										LOCATION ON RENT.REN_STARTLOC = LOCATION.LOC_ID
									WHERE 
										RENT.CUS_IDNUM = '$id'
										AND (
											(RENT.REN_STARTDATE > CURDATE())
											OR (RENT.REN_STARTDATE = CURDATE() AND RENT.REN_STARTTIME > CURTIME())
											OR (RENT.REN_PICKUP_CONDITION = '未取車'))
									";
							$result = $conn->query($sql);
                           if ($result->num_rows > 0) {
                               // 输出数据
                               while($row = $result->fetch_assoc()) {
                                   echo "<tr>";
                                   echo "<td>" . $row["REN_ID"] . "</td>";
                                   echo "<td>" . $row["VEH_ID"] ."<br>".$row["VEH_MODEL"]. "</td>";
                                   echo "<td>" . $row["LOC_CITY"] . "</td>";
                                   echo "<td>" . $row["REN_STARTDATE"] ." " .$row["REN_STARTTIME"]. "</td>";
                                   echo "<td>" . $row["REN_ENDDATE"]." ".$row["REN_ENDTIME"]. "</td>";
                                   echo "<td>" . $row["REN_PRICE"]. "</td>";
								   echo "<td>" . $row["REN_PAYMENT"]. "</td>";
                                   echo "<td>" . $row["REN_PAID"] . "</td>";
                                   echo "<td>";
									echo "<form method='post' action=''>";
									echo "<input type='hidden' name='delete_id' value='" . $row["REN_ID"] . "'>";
									echo "<input type='submit' value='取消訂單' style='background-color: #516c72;
																					color: white;
																					margin-block-end: -30px;
																					padding: 8px 5px;
																					border: none;
																					border-radius: 4px;'>";
                                    
									echo "</form>";
									echo "</td>";
									echo "</tr>";
								}
							} else {
								echo "<tr><td colspan='8'>暫無訂單</td></tr>";
							}
						$conn->close();
						?>
                </tbody>
            </table>
        </div>

    </div>


    </div>
        <script src="order_management.js"></script>
        <script src="homepage.js"></script>
        <script src="homepage2.js"></script>
        <script src="login.js"></script>
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

