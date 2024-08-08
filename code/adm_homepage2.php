<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//連接資料庫
//只要此頁面上有用到連接 MySQL就要include它
include("mysql_connect.inc.php");



// 從 rent 表格抓取資料並計算收入總額
$sql_total_sales = "SELECT SUM(REN_PRICE) AS total_sales FROM rent";
$result_total_sales = $conn->query($sql_total_sales);
$total_sales = $result_total_sales->fetch_assoc()['total_sales'];

// 計算訂單數量
$sql_total_orders = "SELECT COUNT(REN_ID) AS total_orders FROM rent";
$result_total_orders = $conn->query($sql_total_orders);
$total_orders = $result_total_orders->fetch_assoc()['total_orders'];

// 獲取所有城市
$sql_all_cities = "SELECT LOC_CITY, LOC_ID FROM location";
$result_all_cities = $conn->query($sql_all_cities);
$all_cities = [];
while ($row = $result_all_cities->fetch_assoc()) {
    $all_cities[$row['LOC_ID']] = $row['LOC_CITY'];
}

// 計算各城市的總收入
$region_sales = array_fill_keys($all_cities, 0);
$sql_region_sales = "
    SELECT REN_STARTLOC, SUM(REN_PRICE) AS region_sales
    FROM rent
    GROUP BY REN_STARTLOC
";
$result_region_sales = $conn->query($sql_region_sales);
while ($row = $result_region_sales->fetch_assoc()) {
    $region_sales[$all_cities[$row['REN_STARTLOC']]] = $row['region_sales'];
}

// 計算各車款的收入占比
$sql_vehicle_sales = "
    SELECT VEH_MODEL, SUM(REN_PRICE) AS vehicle_sales
    FROM rent
    NATURAL JOIN vehicle
    GROUP BY VEH_MODEL
";
$result_vehicle_sales = $conn->query($sql_vehicle_sales);
$vehicle_sales = [];
while ($row = $result_vehicle_sales->fetch_assoc()) {
    $vehicle_sales[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
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
        .stat-icon {
            cursor: pointer;
            width: 57px;
            height: 57px;
        }
        h1{
            margin-left: 20px;
            font-size: 20px;
        }
        .dashboard {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top:-15;
        }
        .row {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin: 20px 0;
            margin-left:-220px;
        }
        .column {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 -90px;
        }
        .card {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            margin-right:-200px;
        }
        .chart-container{
            width: 10%;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            margin-bottom: 20px;
        }
        .chart-container h3{
            margin-top: -5px;
        }
        .chart-container canvas {
            width: 95% !important;
            height: auto !important;
        }
        #longg {
            margin-top:-90px;
            width: 50%;
            height: auto;
            width: 90px;
        }
        #long{
            width: 420px;
            height: 370px;
        }
        #pie{
            margin-left: 20px;
            width: 350px;
        }
        #piee {
            /* margin-top:-10px; */
            width: 20%;
            margin-bottom:-10px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
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
    <h1>財務報告</h1>
    <div class="dashboard">
        <div class="row">
            <div class="column">
                <div class="card">
                    <img src="money.png" alt="Money Icon" class="stat-icon">
                    <h3>Total Sales</h3>
                    <p>$<?php echo number_format($total_sales, 2); ?></p>
                </div>
                <div class="card">
                    <img src="order.png" alt="Order Icon" class="stat-icon">
                    <h3>Total Orders</h3>
                    <p><?php echo $total_orders; ?></p>
                </div>
            </div>
            <div class="chart-container" id=long>
                <h3>Region Sales</h3>
                <canvas id="regionSalesChart" id=longg></canvas>
            </div>
            <div class="chart-container" id=pie>
                <h3>Vehicle Sales Distribution</h3>
                <canvas id="vehicleSalesPieChart" id=piee></canvas>
            </div>
        </div>
    </div>

    <script>
        // 長條圖 - 各地區的總收入
        const regionSalesCtx = document.getElementById('regionSalesChart').getContext('2d');
        const regionSalesData = {
            labels: <?php echo json_encode(array_keys($region_sales)); ?>,
            datasets: [{
                label: 'Total Sales',
                data: <?php echo json_encode(array_values($region_sales)); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };
        const regionSalesChart = new Chart(regionSalesCtx, {
            type: 'bar',
            data: regionSalesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // 圓餅圖 - 各車款的收入占比
        const vehicleSalesCtx = document.getElementById('vehicleSalesPieChart').getContext('2d');
        const vehicleSalesData = {
            labels: <?php echo json_encode(array_column($vehicle_sales, 'VEH_MODEL')); ?>,
            datasets: [{
                data: <?php echo json_encode(array_column($vehicle_sales, 'vehicle_sales')); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };
        const vehicleSalesPieChart = new Chart(vehicleSalesCtx, {
            type: 'pie',
            data: vehicleSalesData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
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