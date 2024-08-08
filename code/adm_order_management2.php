<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.inc.php");


// 更新資料
if (isset($_POST['update'])) {

    $REN_ID = $_POST['REN_ID'];
    $CUS_PHONE = $_POST['CUS_PHONE'];
    $VEH_MODEL = $_POST['VEH_MODEL'];
    $LOC_CITY = $_POST['LOC_CITY'];
    $REN_STARTDATE = $_POST['REN_STARTDATE'];
    $REN_STARTTIME = $_POST['REN_STARTTIME'];
    $REN_PAID = $_POST['REN_PAID'];

	$query = "SELECT CUS_IDNUM FROM rent WHERE REN_ID = '$REN_ID'";
    $result = $conn -> query($query);

    if ($result -> num_rows > 0) {
        $row = $result -> fetch_assoc();
        $CUS_IDNUM = $row['CUS_IDNUM'];
	}

    $sql = "UPDATE customer SET CUS_PHONE='$CUS_PHONE' WHERE CUS_IDNUM = '$CUS_IDNUM'";
    $conn->query($sql);


    $query2 = "SELECT VEH_ID FROM vehicle WHERE VEH_MODEL = '$VEH_MODEL'";
    $result2 = $conn -> query($query2);

    if ($result2 -> num_rows > 0) {
        $row = $result2 -> fetch_assoc();
        $VEH_ID = $row['VEH_ID'];
	}

    $sql2 = "UPDATE rent SET VEH_ID = '$VEH_ID'
	WHERE REN_ID = '$REN_ID'";
    $conn->query($sql2);
	
	$sql3 = "UPDATE rent SET REN_STARTDATE = '$REN_STARTDATE'
	WHERE REN_ID = '$REN_ID'";
	$conn->query($sql3);
	
	$sql4 = "UPDATE rent SET REN_STARTTIME = '$REN_STARTTIME'
	WHERE REN_ID = '$REN_ID'";
	$conn->query($sql4);
	
	$sql5 = "UPDATE rent SET REN_PAID = '$REN_PAID'
	WHERE REN_ID = '$REN_ID'";
	$conn->query($sql5);
	
	
	$query3 = "SELECT LOC_ID FROM location WHERE LOC_CITY = '$LOC_CITY'";
    $result3 = $conn -> query($query3);
	if ($result3 -> num_rows > 0) {
        $row = $result3 -> fetch_assoc();
        $LOC_ID = $row['LOC_ID'];
	}
	
	$sql6 = "UPDATE rent SET REN_STARTLOC = '$LOC_ID', REN_ENDLOC = '$LOC_ID'
	WHERE REN_ID = '$REN_ID'";
	$conn->query($sql6);

}

// 刪除資料
if (isset($_POST['delete'])) {
	$REN_ID = $_POST['REN_ID'];
    $sql = "DELETE FROM rent WHERE REN_ID = '$REN_ID' ";
    $conn->query($sql);
}

?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>訂單管理</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="order_management.css">
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
        .vehicle-table {
            background-color: white;
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 90px;
        }
        .vehicle-table th{
            background-color: #DCDCDC;
            font-size: 14px;
            padding: 10px;
            text-align: center;
        }
        .vehicle-table td {
            background-color: white;
            padding: 10px;
            text-align: center;
        }

        .btn {
            padding: 5px 10px;
            margin: 5px;
        }
        .btn-edit {
            background-color: #516c72;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-delete {
            background-color: #B22222;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="text"] {
            width: 110px; 
            padding: 5px;
            box-sizing: border-box;
        }
    </style>
    <script>

        function editRow(button) {
            var row = button.parentNode.parentNode;
            var cells = row.querySelectorAll('td');
            if (button.innerHTML === '修改') {
                cells.forEach(function(cell, index) {
                    if (index > 1 && index < 8) {
                        var input = document.createElement('input');
                        input.type = 'text';
                        input.value = cell.innerHTML;
                        cell.innerHTML = '';
                        cell.appendChild(input);
                    }
                });
                button.innerHTML = '送出';
            } else {
                cells.forEach(function(cell, index) {
                    if (index > 1 && index < 8) {
                        var input = cell.querySelector('input');
                        cell.innerHTML = input.value;
                    }
                });
                button.innerHTML = '修改';
                var REN_ID = cells[0].innerHTML;
				var CUS_NAME = cells[1].innerHTML;
				var CUS_PHONE = cells[2].innerHTML;
                var VEH_MODEL = cells[3].innerHTML;
				var LOC_CITY = cells[4].innerHTML;
				var REN_STARTDATE = cells[5].innerHTML;
				var REN_STARTTIME = cells[6].innerHTML;
				var REN_PAID = cells[7].innerHTML;
                
				document.getElementById('updateForm').REN_ID.value = REN_ID;
				document.getElementById('updateForm').CUS_NAME.value = CUS_NAME;
                document.getElementById('updateForm').CUS_PHONE.value = CUS_PHONE;             
                document.getElementById('updateForm').VEH_MODEL.value = VEH_MODEL;
				document.getElementById('updateForm').LOC_CITY.value = LOC_CITY;
				document.getElementById('updateForm').REN_STARTDATE.value = REN_STARTDATE;
				document.getElementById('updateForm').REN_STARTTIME.value = REN_STARTTIME;
				document.getElementById('updateForm').REN_PAID.value = REN_PAID ;
                document.getElementById('updateForm').submit();
            }
        }
		
		function deleteRow(REN_ID) {
            if (confirm('確定要刪除嗎？')) {
                document.getElementById('deleteForm').REN_ID.value = REN_ID;
                document.getElementById('deleteForm').submit();
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
        <h2>訂單管理</h2>

        <div id="orderManagement" >
        <div class = menu>
            <div class="tab-button" id="unpaid" onclick="showTab('unpaid'); location.href='adm_order_management.php'">未取車</div>
            <div class="tab-button active" id="picked" onclick="showTab('picked'); location.href='adm_order_management2.php'" >已取車</div>
            <div class="tab-button" id="returned" onclick="showTab('returned'); location.href='adm_order_management3.php'">已還車</div>
        </div>
    </div>    

    <table id="vehicleTable" class="vehicle-table" style="min-width: 1200px; margin-left: 30px;">
        <thead>
            <tr>
                <th>訂單編號</th>
                <th>客戶姓名</th>
                <th>客戶電話</th>
                <th>車型</th>
                <th>取車地點</th>
                <th>取車日期</th>
                <th>取車時間</th>
                <th>付款狀態</th>
                <th>訂單管理</th>
            </tr>
        </thead>
        <tbody>
            <?php
                
                $sql = "
                    SELECT rent.REN_ID, customer.CUS_NAME, customer.CUS_PHONE, vehicle.VEH_MODEL, location.LOC_CITY, rent.REN_STARTDATE, rent.REN_STARTTIME, rent.REN_PAID
                    FROM customer
                    LEFT JOIN rent ON customer.CUS_IDNUM = rent.CUS_IDNUM
                    LEFT JOIN location ON rent.REN_STARTLOC = location.LOC_ID
                    LEFT JOIN vehicle ON vehicle.VEH_ID = rent.VEH_ID
                    WHERE rent.REN_PICKUP_CONDITION LIKE '%已取車%'";
                $resultt = $conn -> query($sql);
                if ($resultt -> num_rows > 0) {
                    while($row = $resultt -> fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["REN_ID"] . "</td>";
                        echo "<td>" . $row["CUS_NAME"] . "</td>";
                        echo "<td>" . $row["CUS_PHONE"] . "</td>";
                        echo "<td>" . $row["VEH_MODEL"] . "</td>";
                        echo "<td>" . $row["LOC_CITY"]. "</td>";
                        echo "<td>" . $row["REN_STARTDATE"]. "</td>";
                        echo "<td>" . $row["REN_STARTTIME"] . "</td>";
                        echo "<td>" . $row["REN_PAID"] . "</td>";
                        echo "  <td>";
                        echo '<button class="btn btn-edit" onclick="editRow(this)">' . '修改' . '</button>';
                        echo '<button class="btn btn-delete" onclick="deleteRow(\''. $row['REN_ID'] .'\')">刪除</button>';
                        
                        echo "</td>";
                    }
                } else {
                    echo "<tr><td colspan='8'>暫無訂單</td></tr>";
                }
            $conn->close();
            ?>
        </tbody>
    </table>

    <form id="updateForm" method="post" style="display: none;">
        <input type="hidden" name="REN_ID" value="">
        <input type="hidden" name="CUS_NAME" value="">
        <input type="hidden" name="CUS_PHONE" value="">
        <input type="hidden" name="VEH_MODEL" value="">
        <input type="hidden" name="LOC_CITY" value="">
        <input type="hidden" name="REN_STARTDATE" value="">
        <input type="hidden" name="REN_STARTTIME" value="">
        <input type="hidden" name="REN_PAID" value="">
        <input type="hidden" name="update" value="true">
    </form>
    <form id="deleteForm" method="post" style="display: none;">
        <input type="hidden" name="REN_ID" value="">
        <input type="hidden" name="delete" value="true">
    </form>
    </div>
        <script src="order_management.js"></script>
        <script src="homepage.js"></script>
        <script src="homepage2.js"></script>
        <script src="login.js"></script>
    </div>
</body>
</head>



<footer class="footer" style="margin-top: 80px;">
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