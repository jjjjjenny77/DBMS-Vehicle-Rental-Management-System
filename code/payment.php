<?php
session_start();
include("mysql_connect.inc.php");


function checkUserData($conn, $id) {
    $sql = "SELECT CUS_PASSWORD, CUS_NAME, CUS_EMAIL, CUS_PHONE 
			FROM CUSTOMER 
			WHERE  CUS_IDNUM  = '$id';";
    return mysqli_query($conn, $sql);
}

function checkCarID($conn, $veh_type, $veh_model, $location, $ren_startdate, $ren_starttime, $ren_enddate, $ren_endtime) {
    $sql = "SELECT VEHICLE.VEH_ID
			FROM VEHICLE 
			JOIN LOCATION ON VEHICLE.LOC_ID = LOCATION.LOC_ID
			WHERE VEHICLE.VEH_MODEL = '$veh_model' 
			AND LOCATION.LOC_CITY = '$location'
			AND VEHICLE.VEH_ID NOT IN (
				SELECT RENT.VEH_ID
				FROM RENT
				JOIN VEHICLE ON RENT.VEH_ID = VEHICLE.VEH_ID
				JOIN LOCATION ON VEHICLE.LOC_ID = LOCATION.LOC_ID
				WHERE LOCATION.LOC_CITY = '$location'
				AND VEHICLE.VEH_TYPE = '$veh_type'
				AND (
					(REN_STARTDATE <= '$ren_startdate' AND REN_ENDDATE >= '$ren_startdate' AND REN_ENDTIME >= '$ren_starttime') OR
					(REN_STARTDATE <= '$ren_enddate' AND REN_ENDDATE >= '$ren_enddate' AND REN_ENDTIME >= '$ren_endtime') OR
					(REN_STARTDATE >= '$ren_startdate' AND REN_ENDDATE <= '$ren_enddate') OR
					(REN_STARTDATE = '$ren_startdate' AND REN_ENDDATE = '$ren_enddate' AND REN_STARTTIME <= '$ren_starttime' AND REN_ENDTIME >= '$ren_endtime')
				)
			)
			LIMIT 1;";
    return mysqli_query($conn, $sql);
}


function generate_rent_id($veh_type, $veh_model, $location, $ren_startdate, $ren_starttime, $ren_enddate, $ren_endtime) {
    // 將各變數連接成一個字串，並移除可能的空格或特殊字元
    $order_str = $veh_type . '_' . str_replace(' ', '', $veh_model) . '_' . $location . '_' . 
                 str_replace('-', '', $ren_startdate) . '_' . str_replace(':', '', $ren_starttime) . '_' . 
                 str_replace('-', '', $ren_enddate) . '_' . str_replace(':', '', $ren_endtime);

    // 將字串轉換為數字
    $order_id = abs(crc32($order_str)); // 使用 crc32 函數計算字串的循環冗餘檢查碼，再取絕對值

    return $order_id;
}

// 定義變數
$veh_type = $_GET['veh_type'];
$_SESSION['veh_type'] = $veh_type;

$veh_model = $_GET['veh_model'];
$_SESSION['veh_model'] = $veh_model;

$location = $_GET['location'];
$_SESSION['location'] = $location;

$ren_startdate = $_GET['ren_startdate'];
$_SESSION['ren_startdate'] = $ren_startdate;

$ren_starttime = $_GET['ren_starttime'];
$_SESSION['ren_starttime'] = $ren_starttime;

$ren_enddate = $_GET['ren_enddate'];
$_SESSION['ren_enddate'] = $ren_enddate;

$ren_endtime = $_GET['ren_endtime'];
$_SESSION['ren_endtime'] = $ren_endtime;

$model_price= $_GET['model_price']; 
$_SESSION['model_price'] = $model_price;

$id = $_SESSION['USER_ID'];

//取得rent_id資訊
$rent_id = generate_rent_id($veh_type, $veh_model, $location, $ren_startdate, $ren_starttime, $ren_enddate, $ren_endtime);
$_SESSION['rent_id'] = $rent_id;


//取得CarID資訊
$result = checkCarID($conn, $veh_type, $veh_model, $location, $ren_startdate, $ren_starttime, $ren_enddate, $ren_endtime);
$veh_id = null;
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $veh_id = $row['VEH_ID'];
    }
}
$_SESSION['veh_id'] = $veh_id;


//取得訂購人資訊
$resultt = checkUserData($conn, $id);
$CUS_PASSWORD = $CUS_NAME = $CUS_EMAIL = $CUS_PHONE = null;
if ($resultt && mysqli_num_rows($resultt) > 0) {
    while ($row = mysqli_fetch_assoc($resultt)) {
        $CUS_PASSWORD = $row['CUS_PASSWORD'];
        $CUS_NAME = $row['CUS_NAME'];
        $CUS_EMAIL = $row['CUS_EMAIL'];
        $CUS_PHONE = $row['CUS_PHONE'];
    }
}
//$_SESSION['CUS_PASSWORD'] = $CUS_PASSWORD;
//$_SESSION['CUS_NAME'] = $CUS_NAME;
//$_SESSION['CUS_EMAIL'] = $CUS_EMAIL;
//$_SESSION['CUS_PHONE'] = $CUS_PHONE;

// 計算租車天數
$start_datetime = new DateTime($ren_startdate);
$end_datetime = new DateTime($ren_enddate);
$interval = $start_datetime->diff($end_datetime);
$rental_days = $interval->days+1; // 加1是因為要包含開始和結束的那一天


// 定義平日和假日的價格
$weekday_price = number_format($model_price, 2, '.', '')* 0.7; // 平日一天租車費用
$weekend_price = number_format($model_price, 2, '.', '')* 0.9; // 假日一天租車費用打八折
$total_rental_fee = 0;

// 逐日計算租車費用
$current_date = $start_datetime;
while ($current_date <= $end_datetime) {
    $day_of_week = $current_date->format('N'); // 取得星期幾，1代表週一，7代表週日

    // 根據星期幾判斷租車費用
    if ($day_of_week >= 1 && $day_of_week <= 4) {
        // 平日
        $total_rental_fee += $weekday_price;
    } else {
        // 假日
        $total_rental_fee += $weekend_price;
    }

    // 日期加1天
    $current_date->modify('+1 day');
}

$_SESSION['total_rental_fee'] = $total_rental_fee;

// 印出相應資訊
/*
$_SESSION['rent_id'] = $rent_id;
echo "車型: $veh_model<br>";
while ($row = mysqli_fetch_assoc($result)) {
        $veh_id = $row['VEH_ID'];
		echo "車輛編號: $veh_id<br>";
}
echo "取車地點: $location<br>";
echo "取車時間: $ren_startdate $ren_starttime<br>";
echo "還車時間: $ren_enddate $ren_endtime<br>";
echo "租車天數: $rental_days 天<br>";
echo "總租車費用：$total_rental_fee 元<br>";
*/

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Sharing Cars</title>
    
    <link rel="stylesheet" href="payment.css">
    <link rel="stylesheet" href="homepage.css">
    <!-- <link rel="stylesheet" href="login.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel='icon' type='' href='https://cdn-icons-png.flaticon.com/256/55/55283.png'>
</head>
<body>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <header>
        <a href="homepage2.html"><div class="logo">EASYRENT</div></a>
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

    </div>
        <script src="homepage.js"></script>
    </div>

    <div class="flex-container">
        <div class="container1"  style="margin-bottom: 400px;">
            <form action="payment_save.php" method="post">
                <h2>訂購人資料</h2>
                <label for="name">姓名</label>
                <input type="text" id="name" name="name" value = <?php echo $CUS_NAME; ?>>
    
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value = <?php echo $CUS_EMAIL; ?>>
    
                <label for="phone">手機</label>
                <input type="text" id="phone" name="phone" value = <?php echo $CUS_PHONE; ?>>
    
                <label for="id_number">身分證字號</label>
                <input type="text" id="id_number" name="id_number" value = <?php echo $id; ?>>
    
                <h3>付款方式</h3>
                <label>
                    <input type="radio" name="payment_method" value="現金付款" required>
                    現金
                    <br>
                    <small>&nbsp&nbsp • &nbsp請提早至取車地點付款 </small>
                </label>
                <label>
                    <input type="radio" name="payment_method" value="信用卡" required >
                    信用卡
                    <br>
                    <small>&nbsp&nbsp • &nbsp請填寫您的信用卡卡號 </small>
                    <br>
                    <input type="text" id="credit_number" name="credit_card_number" placeholder="信用卡卡號" >
                </label>
                <label>
                    <input type="radio" name="payment_method" value="超商付款" required>
                    超商付款
                    <br>
                    <small>&nbsp&nbsp • &nbsp取得訂單編號即可至超商 ibon/FamiPort 機取票 </small>
                </label>
    
                <button type="submit" id="submitBtn">付款</button>
            </form>
	
        </div>
        <div>
            <div class="order-summary">
                <h2>租車明細</h2>
                <p style="font-size:15px; margin-bottom: -5px;">訂單編號 : <?php echo $rent_id; ?></span></p>
                <p style="font-size:15px; margin-bottom: -5px;">車輛編號 : <?php echo $veh_id; ?></span></p>
				<p style="font-size:15px; margin-bottom: -5px;">車輛種類 : <?php echo $veh_type; ?></span></p>
                <p style="font-size:15px; margin-bottom: -5px;">車輛型號 : <?php echo $veh_model; ?></span></p>
                <p style="font-size:15px; margin-bottom: -5px;">取車地點 : <?php echo $location; ?></span></p>
                <p style="font-size:15px; margin-bottom: -5px;">取車時間 : <?php echo $ren_startdate;?> &nbsp <?php echo $ren_starttime; ?> </span></p>
                <p style="font-size:15px; margin-bottom: -5px;">還車時間 : <?php echo $ren_enddate; ?> &nbsp <?php echo $ren_endtime; ?></span></p>
                <p style="font-size:15px; margin-bottom: -5px;">租車天數 : <?php echo $rental_days; ?></span></p>
                <p style="font-size:15px;"> 總租車費用 : <?php echo $total_rental_fee; ?></span></p>
            </div>
        </div>
            <div class="order-policy">
                <h2>⚠️ 租車條款與細則</h2>
				<p>• 租金計算</span></p>
                <h3>&nbsp&nbsp 1. 星期一~四為原價打七折，星期五~日為原價打八折。<br>&nbsp&nbsp 2. 租車費用包括基本租金、保險費用及相關稅費。</span></h3>
                <p>• 租車資格</span></p>
                <h3>&nbsp&nbsp 1. 租車人須年滿 18 歲，並持有有效駕駛執照。<br>&nbsp&nbsp 2. 租車人須提供有效的身份證明文件和信用卡。</span></h3>
                <p>• 費用支付</span></p>
                <h3>&nbsp&nbsp 1. 租車人須在取車前支付全部租車費用。<br></span></h3>
                <p>• 取車與還車</span></p>
                <h3>&nbsp&nbsp 1. 取車和還車的時間及地點須在租車合約中明確規定。<br>&nbsp&nbsp 2. 租車人須按時還車，逾期還車將收取額外費用。<br>&nbsp&nbsp 3. 租車人在取車時應檢查車輛狀況，並在還車時保持車輛原狀。</span></h3>
                <p>• 取消與退款</span></p>
                <h3>&nbsp&nbsp 1. 租車人在取車前24小時以外取消訂單，可獲得全額退款。<br>&nbsp&nbsp 2. 租車人在取車前24小時內取消訂單，將扣除租車費用的 50% 作為取消費。<br>&nbsp&nbsp 3. 未取車不予退款：租車人未按約定時間取車，將不予退款。</span></h3>
            </div>
        </div>

    </div>
    <div><script src="payment.js"></script></div>

    
</body>

<footer class="footer"  style="margin-top: -300px;">
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


