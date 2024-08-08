<?php session_start(); ?>
<!-- 上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
// 連接資料庫
// 只要此頁面上有用到連接 MySQL就要include它
include("mysql_connect.inc.php");

// 更新資料
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $city = $_POST['city'];
    $address = $_POST['address'];

    $sql = "UPDATE location SET LOC_CITY='$city', LOC_ADDRESS='$address' WHERE LOC_ID='$id'";
    if ($conn->query($sql) === TRUE) {
        //echo "更新成功";
    } else {
        echo "更新失敗: " . $conn->error;
    }
}

// 刪除資料
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM location WHERE LOC_ID='$id'";
    if ($conn->query($sql) === TRUE) {
        //echo "刪除成功";
    } else {
        echo "刪除失敗: " . $conn->error;
    }
}

// 新增資料
if (isset($_POST['insert'])) {
    $city = $_POST['city'];
    $address = $_POST['address'];

    $sql = "INSERT INTO location (LOC_CITY, LOC_ADDRESS) VALUES ('$city', '$address')";
    if ($conn->query($sql) === TRUE) {
        //echo "新增成功";
    } else {
        echo "新增失敗: " . $conn->error;
    }
}

// 抓取站點資料
$sql = "SELECT LOC_ID, LOC_CITY, LOC_ADDRESS FROM location";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>站點管理</title>
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
        .station-table {
            background-color: white;
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 90px;
        }
        .station-table th{
            background-color: #DCDCDC;
            font-size: 14px;
            padding: 10px;
            text-align: center;
        }
        .station-table td {
            background-color: white;
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
                    if (index > 0 && index < 3) {
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
                    if (index > 0 && index < 3) {
                        var input = cell.querySelector('input');
                        cell.innerHTML = input.value;
                    }
                });
                button.innerHTML = '修改';
                var id = cells[0].innerHTML;
                var city = cells[1].innerHTML;
                var address = cells[2].innerHTML;
                document.getElementById('updateForm').id.value = id;
                document.getElementById('updateForm').city.value = city;
                document.getElementById('updateForm').address.value = address;
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
            var table = document.getElementById('stationTable');
            var row = table.insertRow(1);
            for (var i = 0; i < 4; i++) {
                var cell = row.insertCell(i);
                if (i < 3) {
                    var input = document.createElement('input');
                    input.type = 'text';
                    cell.appendChild(input);
                } else {
                    var btnSend = document.createElement('button');
                    btnSend.innerHTML = '送出';
                    btnSend.className = 'btn btn-edit';
                    btnSend.onclick = function() {
                        var cells = row.querySelectorAll('td');
                        var city = cells[1].querySelector('input').value;
                        var address = cells[2].querySelector('input').value;
                        document.getElementById('insertForm').city.value = city;
                        document.getElementById('insertForm').address.value = address;
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
</head>
<body>
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
    <h2>站點管理</h2>
    <button class="btn btn-add" onclick="addRow()">+新增</button>
    <table id="stationTable" class="station-table">
        <tr>
            <th>站點ID</th>
            <th>站點縣市</th>
            <th>站點地址</th>
            <th>站點管理</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['LOC_ID']; ?></td>
            <td><?php echo $row['LOC_CITY']; ?></td>
            <td><?php echo $row['LOC_ADDRESS']; ?></td>
            <td>
                <button class="btn btn-edit" onclick="editRow(this)">修改</button>
                <button class="btn btn-delete" onclick="deleteRow(<?php echo $row['LOC_ID']; ?>)">刪除</button>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <form id="updateForm" method="post" style="display: none;">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="city" value="">
        <input type="hidden" name="address" value="">
        <input type="hidden" name="update" value="true">
    </form>
    <form id="deleteForm" method="post" style="display: none;">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="delete" value="true">
    </form>
    <form id="insertForm" method="post" style="display: none;">
        <input type="hidden" name="city" value="">
        <input type="hidden" name="address" value="">
        <input type="hidden" name="insert" value="true">
    </form>
</body>
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

