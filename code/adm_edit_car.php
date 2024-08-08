<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//連接資料庫
//只要此頁面上有用到連接 MySQL就要include它
include("mysql_connect.inc.php");


// 更新資料
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $model = $_POST['model'];
    $type = $_POST['type'];
    $loc_city = $_POST['loc_city'];
	
	$query = "SELECT LOC_ID FROM location WHERE LOC_CITY = '$loc_city'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $loc_id = $row['LOC_ID'];
	}
    
    $sql = "UPDATE vehicle SET VEH_MODEL='$model', VEH_TYPE='$type', LOC_ID='$loc_id' WHERE VEH_ID='$id'";
    $conn->query($sql);
}

// 刪除資料


if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM vehicle WHERE VEH_ID = '$id' ";
    $conn->query($sql);
}

// 新增資料
if (isset($_POST['insert'])) {
	$id = $_POST['id'];
    $model = $_POST['model'];
    $type = $_POST['type'];
    $loc_city = $_POST['loc_city'];
	
	$query = "SELECT LOC_ID FROM location WHERE LOC_CITY = '$loc_city'";
    $result = $conn->query($query);
	
	if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $loc_id = $row['LOC_ID'];
	}
    
    $sql = "INSERT INTO vehicle (VEH_ID, VEH_MODEL, VEH_TYPE, LOC_ID) VALUES ('$id','$model', '$type', '$loc_id')";
    $conn->query($sql);
}

// 抓取車輛資料
$sql = "
    SELECT vehicle.VEH_ID, vehicle.VEH_MODEL, vehicle.VEH_TYPE, location.LOC_CITY 
    FROM vehicle 
    JOIN location ON vehicle.LOC_ID = location.LOC_ID
	ORDER BY vehicle.VEH_ID
";
$result = $conn->query($sql);

// 抓取所有地點資料
$sql_locations = "SELECT LOC_ID, LOC_CITY FROM location";
$result_locations = $conn->query($sql_locations);
$locations = [];
while ($row = $result_locations->fetch_assoc()) {
    $locations[$row['LOC_ID']] = $row['LOC_CITY'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>車輛管理</title>
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
            /*border: 1px solid #ccc;*/
            padding: 10px;
            text-align: center;
        }

        .btn {
            padding: 5px 10px;
            margin: 5px;
        }
        .btn-add {
            margin-left: 100px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
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
    </style>
    <script>
        function editRow(button) {
            var row = button.parentNode.parentNode;
            var cells = row.querySelectorAll('td');
            if (button.innerHTML === '修改') {
                cells.forEach(function(cell, index) {
                    if (index > 0 && index < 4) {
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
                    if (index > 0 && index < 4) {
                        var input = cell.querySelector('input');
                        cell.innerHTML = input.value;
                    }
                });
                button.innerHTML = '修改';
                var id = cells[0].innerHTML;
                var model = cells[1].innerHTML;
                var type = cells[2].innerHTML;
                var loc_city = cells[3].innerHTML;
                document.getElementById('updateForm').id.value = id;
                document.getElementById('updateForm').model.value = model;
                document.getElementById('updateForm').type.value = type;
                document.getElementById('updateForm').loc_city.value = loc_city;
                document.getElementById('updateForm').submit();
            }
        }
		
		function deleteRow(id) {
            if (confirm('確定要刪除嗎？')) {
                document.getElementById('deleteForm').id.value = id;
                document.getElementById('deleteForm').submit();
            }
        }
		
        

        function addRow() {
            var table = document.getElementById('vehicleTable');
            var row = table.insertRow(1);
            for (var i = 0; i < 5; i++) {
                var cell = row.insertCell(i);
                if (i < 4) {
                    var input = document.createElement('input');
                    input.type = 'text';
                    cell.appendChild(input);
                } else {
                    var btnSend = document.createElement('button');
                    btnSend.innerHTML = '送出';
                    btnSend.className = 'btn btn-edit';
                    btnSend.onclick = function() {
                        var cells = row.querySelectorAll('td');
						var id = cells[0].querySelector('input').value;
                        var model = cells[1].querySelector('input').value;
                        var type = cells[2].querySelector('input').value;
                        var loc_city = cells[3].querySelector('input').value;
						document.getElementById('insertForm').id.value = id;
                        document.getElementById('insertForm').model.value = model;
                        document.getElementById('insertForm').type.value = type;
                        document.getElementById('insertForm').loc_city.value = loc_city;
                        document.getElementById('insertForm').submit();
                    };
                    var btnDelete = document.createElement('button');
                    btnDelete.innerHTML = '刪除';
                    btnDelete.className = 'btn btn-delete';
                    btnDelete.onclick = function() {
                        table.deleteRow(row.rowIndex);
                    };
                    cell.appendChild(btnSend);
                    cell.appendChild(btnDelete);
                }
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
        <h2>車輛管理</h2>
        <button class="btn btn-add" onclick="addRow()">+新增</button>
        <table id="vehicleTable" class="vehicle-table">
            <tr>
                <th>車輛ID</th>
                <th>車輛名稱</th>
                <th>車輛種類</th>
                <th>所在地點</th>
                <th>車輛管理</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['VEH_ID']; ?></td>
                <td><?php echo $row['VEH_MODEL']; ?></td>
                <td><?php echo $row['VEH_TYPE']; ?></td>
                <td><?php echo $row['LOC_CITY']; ?></td>
                <td>
                    <button class="btn btn-edit" onclick="editRow(this)">修改</button>
                    <button class="btn btn-delete" onclick="deleteRow(<?php echo $row['VEH_ID']; ?>)">刪除</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <form id="updateForm" method="post" style="display: none;">
            <input type="hidden" name="id" value="">
            <input type="hidden" name="model" value="">
            <input type="hidden" name="type" value="">
            <input type="hidden" name="loc_city" value="">
            <input type="hidden" name="update" value="true">
        </form>
        <form id="deleteForm" method="post" style="display: none;">
            <input type="hidden" name="id" value="">
            <input type="hidden" name="delete" value="true">
        </form>
        <form id="insertForm" method="post" style="display: none;">
			<input type="hidden" name="id" value="">
            <input type="hidden" name="model" value="">
            <input type="hidden" name="type" value="">
            <input type="hidden" name="loc_city" value="">
            <input type="hidden" name="insert" value="true">
        </form>
    </body>
</head>
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