<?php
session_start();
include("mysql_connect.inc.php");

$location = $_POST['location'];
$veh_type = $_POST['veh_type'];
$ren_startdate = $_POST['ren_startdate'];
$ren_starttime = $_POST['ren_starttime'];
$ren_enddate = $_POST['ren_enddate'];
$ren_endtime = $_POST['ren_endtime'];

function checkCar($conn, $veh_type, $location, $ren_startdate, $ren_starttime, $ren_enddate, $ren_endtime) {
    $sql = "SELECT VEHICLE.VEH_MODEL, PRICE.PRI_PRICE, AVG(FEEDBACK.FEE_SCORE) AS AVG_SCORE
			FROM VEHICLE 
			JOIN LOCATION ON VEHICLE.LOC_ID = LOCATION.LOC_ID
			JOIN PRICE ON PRICE.VEH_MODEL = VEHICLE.VEH_MODEL
			LEFT JOIN RENT ON RENT.VEH_ID = VEHICLE.VEH_ID
			LEFT JOIN FEEDBACK ON FEEDBACK.REN_ID = RENT.REN_ID
			WHERE VEHICLE.VEH_TYPE = '$veh_type' 
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
			GROUP BY VEHICLE.VEH_MODEL, PRICE.PRI_PRICE;";
    return mysqli_query($conn, $sql);
}

// 呼叫函數進行查詢
$result = checkCar($conn, $veh_type, $location, $ren_startdate, $ren_starttime, $ren_enddate, $ren_endtime);
$resultt = checkCar($conn, $veh_type, $location, $ren_startdate, $ren_starttime, $ren_enddate, $ren_endtime);
$resulttt = checkCar($conn, $veh_type, $location, $ren_startdate, $ren_starttime, $ren_enddate, $ren_endtime);
$resultttt = checkCar($conn, $veh_type, $location, $ren_startdate, $ren_starttime, $ren_enddate, $ren_endtime);

$veh_model_count = 0;
$num_rows = 0;

if (mysqli_num_rows($result) == 0) {
} else{
    // 顯示符合條件的車款
	while($row = mysqli_fetch_assoc($result)){
		$veh_model_count+=1;
	}	
	while($row = mysqli_fetch_assoc($resultt)){
        $veh_model = $row['VEH_MODEL'];
		$model_price = $row['PRI_PRICE'];
		$avg_FEE_SCORE = $row['AVG_SCORE'];
	}
	while($row = mysqli_fetch_assoc($resultt)){
        $veh_model = $row['VEH_MODEL'];
		$model_price = $row['PRI_PRICE'];
		$avg_FEE_SCORE = $row['AVG_SCORE'];
		//header("Location: ordercar.html");
        // $link = <a href='payment.php?model_price=$model_price&veh_model=$veh_model&location=$location&veh_type=$veh_type&ren_startdate=$ren_startdate&ren_starttime=$ren_starttime&ren_enddate=$ren_enddate&ren_endtime=$ren_endtime'>$veh_model</a>;
	// 	echo "<br>一天原價: ".round(floatval($model_price), 2)."<br>";
	// 		if($avg_FEE_SCORE!=null){
	// 		echo "車款評分:".$avg_FEE_SCORE."<br><br>";
	// 		}else{
	// 			echo "車款評分: 此車款尚未被訂購，無評分<br><br>";}
	// }
	}
}
// echo $veh_model_count . "<br>";

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Sharing Cars</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel='icon' type='' href='https://cdn-icons-png.flaticon.com/256/55/55283.png'>
	<style>
		.container0{
			margin-top: 20px;
			margin-left: 30px;
			font-size: 25px;
			color: #002f6c;
			font-weight:bold;
		}
		.container1{
			margin-top: -20px;
			margin-left: 40px;
			font-size: 10px;
		}
        .card {
			display: inline-flex;
			/* display: relative ; */
			flex : 2;
            margin: 10px;
			margin-left: 300px;
			background-color: white;
			max-width: 450px;
			padding: 20px;
			background-color: #fff;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0,0,0,0.1);
			width: 480px;
			object-fit: cover;
			justify-content: space-around;
        } 
        .card img {
			display: block;
			width: 200px;
        }
        .card-title {
			display: block;
            font-size: 1.25rem;
			margin-left: 10px;
			margin-bottom: 20px;
        }
        .card-text {
			display: block;
            font-size: 0.9rem;
			margin-left: 10px;
			margin-top: -8px;
        }
		.card a{
			font-size: 0.8rem;
			margin-left: 20px;
			background-color: #007bff;
			border-radius: 12px;
			padding: 8px;
			color: white;
			text-decoration: none;
		}
        .rating {
            font-size: 1.1rem;
            color: #ffc107;
        }
        .reviews {
            font-size: 0.9rem;
            color: #6c757d;
        }
		.footer{
			margin-top: 30px;
		}
    </style>
</head>

<body>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <header>
        <!-- <div class="logo">EASYRENT</div> -->
		<a href="homepage2.html">
        	<div class="logo">EASYRENT</div>
        </a>
        <div class="user-menu">
            <img src="user.png" alt="User Icon" class="user-icon" id="userIcon">
            <div class="dropdown" id="dropdown">
                <p>哈囉 ! 使用者</p>
                <button onclick="location.href='edit_profile.php'">編輯個人資料</button>
                <button onclick="location.href='order_management.php'">訂單管理</button>
                <button onclick="location.href='my_Reviews.php'">我的評價</button>
                <button onclick="location.href='QnA.php'">Q & A</button>
                <button id="logoutbtn" onclick="location.href='homepage.html'">登出</button>
            </div>
        </div>
    </header>



    <div class="container2">
        <div class="tab">
            <button class="tablinks active" onclick="openTab(event, 'car')">租汽車</button>
            <button class="tablinks" onclick="openTab(event, 'bike')">租機車</button>
        </div>
        <div id="car" class="tabcontent">
            <form class="rental-form" method="post" action="ordercar_finish.php">
                <!-- <div class="form-group2">
                    <i class="fas fa-map-marker-alt"></i>
                    <select id="location", name="location">
                        <option value="" disabled selected>租車地點</option>
                        <option value="台北市">台北</option>
                        <option value="新北市">新北</option>
                        <option value="桃園市">桃園</option>
                        <option value="台中市">台中</option>
                        <option value="台南市">台南</option>
                        <option value="高雄市">高雄</option>
                    </select>
                </div> -->
				<div class="form-group2">
					<i class="fas fa-map-marker-alt"></i>
					<select id="location" name="location">
						<option value="" disabled <?php echo ($location == '') ? 'selected' : ''; ?>>租車地點</option>
						<option value="台北市" <?php echo ($location == '台北市') ? 'selected' : ''; ?>>台北</option>
						<option value="新北市" <?php echo ($location == '新北市') ? 'selected' : ''; ?>>新北</option>
						<option value="桃園市" <?php echo ($location == '桃園市') ? 'selected' : ''; ?>>桃園</option>
						<option value="台中市" <?php echo ($location == '台中市') ? 'selected' : ''; ?>>台中</option>
						<option value="台南市" <?php echo ($location == '台南市') ? 'selected' : ''; ?>>台南</option>
						<option value="高雄市" <?php echo ($location == '高雄市') ? 'selected' : ''; ?>>高雄</option>
					</select>
				</div>

				<div class="form-group">
					<i class="fas fa-calendar-alt"></i>
					<input type="date" id="pickup-date" name="ren_startdate" value="<?php echo htmlspecialchars($ren_startdate); ?>">
					<select id="pickup-time" name="ren_starttime">
						<?php
						$times = ["8:00", "9:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00"];
						foreach ($times as $time) {
							$selected = ($time == $ren_starttime) ? 'selected' : '';
							echo '<option value="' . $time . '" ' . $selected . '>' . $time . '</option>';
						}
						?>
					</select>
				</div>

				<div class="form-group">
					<i class="fas fa-calendar-alt"></i>
					<input type="date" id="return-date" name="ren_enddate" value="<?php echo htmlspecialchars($ren_enddate); ?>">
					<select id="return-time" name="ren_endtime">
						<?php
						$times = ["8:00", "9:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00"];
						foreach ($times as $time) {
							$selected = ($time == $ren_endtime) ? 'selected' : '';
							echo '<option value="' . $time . '" ' . $selected . '>' . $time . '</option>';
						}
						?>
					</select>
				</div>
				
				
				<div class="form-group2">
					<?php
						$veh_type = isset($_POST['veh_type']) ? $_POST['veh_type'] : '';

						function getVehTypeOptions($selectedType) {
							$types = ["轎車", "休旅車", "箱型車"];
							$options = '';

							// Add selected option
							if (!empty($selectedType)) {
								$options .= '<option value="" disabled selected>' . $selectedType . '</option>';
							} else {
								$options .= '<option value="" disabled selected>車種</option>';
							}

							// Add remaining options
							foreach ($types as $type) {
								if ($type !== $selectedType) {
									$options .= '<option value="' . $type . '">' . $type . '</option>';
								}
							}

							return $options;
						}
						?>
					<select id="seats" name="veh_type">
						<?php echo getVehTypeOptions($veh_type); ?>
					</select>
				</div>

                <button type="submit">搜尋</button>
            </form>
        </div>
        <div id="bike" class="tabcontent" style="display:none">
            <form>
                <button type="submit">搜尋</button>
            </form>
        </div>
    </div>
        <script src="homepage.js"></script>
    </div>

    </div>
        <script src="login.js"></script>
    </div>
	<br><br>
	<div class="container0">
	<?php
		if (mysqli_num_rows($result) == 0) {
			echo '無適合車款！';
		} else{
			// 顯示符合條件的車款
			while($row = mysqli_fetch_assoc($result)){
				$veh_model_count+=1;
			}
			echo "共有".$veh_model_count."台可租車輛<br><br>";
			
			while($row = mysqli_fetch_assoc($resulttt)){
				$veh_model = $row['VEH_MODEL'];
				$model_price = $row['PRI_PRICE'];
				$avg_FEE_SCORE = $row['AVG_SCORE'];
				//header("Location: ordercar.html");
				// $link = <a href='payment.php?model_price=$model_price&veh_model=$veh_model&location=$location&veh_type=$veh_type&ren_startdate=$ren_startdate&ren_starttime=$ren_starttime&ren_enddate=$ren_enddate&ren_endtime=$ren_endtime'>$veh_model</a>;
				// echo "<br>一天原價: ".round(floatval($model_price), 2)."<br>";
				// 	if($avg_FEE_SCORE!=null){
				// 	echo "車款評分:".$avg_FEE_SCORE."<br><br>";
				// 	}else{
				// 		echo "車款評分: 此車款尚未被訂購，無評分<br><br>";
				// 	}
			}
		}
	?></div>

<div class="container1">
        <?php
        if (mysqli_num_rows($result) == 0) {
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $veh_model_count += 1;
            }
			echo '<div class="row">';
            while ($row = mysqli_fetch_assoc($resultttt)) {
                $veh_model = $row['VEH_MODEL'];
                $model_price = $row['PRI_PRICE'];
                $avg_FEE_SCORE = $row['AVG_SCORE'];
                ?>
                <div class="col-md-4">
                    <div class="card">
						<img src="<?php echo $veh_model; ?>.png" class="card-img-top" alt="Car Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $veh_model; ?></h5>
                            <p class="card-text">🚗 <?php echo $veh_type; ?> ⚙️ 自排</p>
                            <p class="card-text">一天原價: <?php echo round(floatval($model_price), 2); ?> TWD</p>
                            <?php if ($avg_FEE_SCORE != null) { ?>
                                <p class="card-text">車款評分: <span class="rating">★<?php echo $avg_FEE_SCORE; ?></p>
                            <?php } else { ?>
                                <p class="card-text">車款評分: <br> 此車款尚未被訂購，尚無評分</p>
                            <?php } ?>
                            <a href="payment.php?model_price=<?php echo $model_price; ?>&veh_model=<?php echo $veh_model; ?>&location=<?php echo $location; ?>&veh_type=<?php echo $veh_type; ?>&ren_startdate=<?php echo $ren_startdate; ?>&ren_starttime=<?php echo $ren_starttime; ?>&ren_enddate=<?php echo $ren_enddate; ?>&ren_endtime=<?php echo $ren_endtime; ?>" class="btn btn-primary">了解詳情</a>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo '</div>';
        }
        //$conn->close();
        ?>
    </div>

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
        <script src="homepage2.js"></script>
    </div>
</footer>
</html>
