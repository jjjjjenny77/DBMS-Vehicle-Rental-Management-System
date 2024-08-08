<?php
session_start();
include("mysql_connect.inc.php");

// 打印所有关键的会话变量
echo "<pre>";
echo "Session Variables: \n";
print_r($_SESSION);
echo "</pre>";

$payment_method = $_POST['payment_method'];
$credit_card_number = $_POST['credit_card_number'];

$id = $_SESSION['USER_ID'];
$rent_id = $_SESSION['rent_id'];
$veh_model = $_SESSION['veh_model'];
$veh_id = $_SESSION['veh_id'];
$location = $_SESSION['location'];
$ren_startdate = $_SESSION['ren_startdate'];
$ren_starttime = $_SESSION['ren_starttime'];
$ren_enddate = $_SESSION['ren_enddate'];
$ren_endtime = $_SESSION['ren_endtime'];
$total_rental_fee = $_SESSION['total_rental_fee'];

// 打印POST变量
echo "<pre>";
echo "POST Variables: \n";
print_r($_POST);
echo "</pre>";

function checkLocID($conn, $location) {
    $sql = "SELECT LOC_ID FROM LOCATION WHERE LOC_CITY = '$location'";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        echo "Error executing query: " . mysqli_error($conn);
    }
    
    return $result;
}

$result = checkLocID($conn, $location);

$loc_id = null;
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $loc_id = $row['LOC_ID'];
} else {
    echo 'Location ID not found or error occurred!';
    exit;
}

if ($id != null && $loc_id != null) {
    // 确认用户ID在customer表中存在
    $checkUserSql = "SELECT * FROM customer WHERE CUS_IDNUM = '$id'";
    $userResult = mysqli_query($conn, $checkUserSql);

    if (!$userResult) {
        echo "Error executing query: " . mysqli_error($conn);
        exit;
    }

    if (mysqli_num_rows($userResult) > 0) {
        // 确定取车状态
        $current_date = date('Y-m-d');
        $current_time = time();  // 获取当前时间
        if ($current_date > $ren_enddate || ($current_date == $ren_enddate && $current_time > $ren_endtime)) {
            $pickup_status = '已還車';
            $sql = "INSERT INTO rent (CUS_IDNUM, REN_ID, VEH_ID, REN_STARTLOC, REN_ENDLOC, REN_PRICE, REN_PAYMENT, REN_PAID, REN_PICKUP_CONDITION, REN_RETURN_CONDITION, REN_CANCEL, REN_STARTDATE, REN_STARTTIME, REN_ENDDATE, REN_ENDTIME)
                    VALUES ('$id', '$rent_id', '$veh_id', '$loc_id', '$loc_id', '$total_rental_fee', '$payment_method', '已付款', '$pickup_status', '未還車', '未取消', '$ren_startdate', '$ren_starttime', '$ren_enddate', '$ren_endtime')";
        } elseif (($current_date > $ren_startdate || ($current_date == $ren_startdate && $current_time > $ren_starttime)) && ($current_date < $ren_enddate || ($current_date == $ren_enddate && $current_time < $ren_endtime))) {
            $pickup_status = '已取車';
            $sql = "INSERT INTO rent (CUS_IDNUM, REN_ID, VEH_ID, REN_STARTLOC, REN_ENDLOC, REN_PRICE, REN_PAYMENT, REN_PAID, REN_PICKUP_CONDITION, REN_RETURN_CONDITION, REN_CANCEL, REN_STARTDATE, REN_STARTTIME, REN_ENDDATE, REN_ENDTIME)
                    VALUES ('$id', '$rent_id', '$veh_id', '$loc_id', '$loc_id', '$total_rental_fee', '$payment_method', '已付款', '$pickup_status', '未還車', '未取消', '$ren_startdate', '$ren_starttime', '$ren_enddate', '$ren_endtime')";
        } else {
            $pickup_status = '未取車';
            if($payment_method == '信用卡'){
            $sql = "INSERT INTO rent (CUS_IDNUM, REN_ID, VEH_ID, REN_STARTLOC, REN_ENDLOC, REN_PRICE, REN_PAYMENT, REN_PAID, REN_PICKUP_CONDITION, REN_RETURN_CONDITION, REN_CANCEL, REN_STARTDATE, REN_STARTTIME, REN_ENDDATE, REN_ENDTIME)
                    VALUES ('$id', '$rent_id', '$veh_id', '$loc_id', '$loc_id', '$total_rental_fee', '$payment_method', '已付款', '$pickup_status', '未還車', '未取消', '$ren_startdate', '$ren_starttime', '$ren_enddate', '$ren_endtime')";
                }else{
                    $sql = "INSERT INTO rent (CUS_IDNUM, REN_ID, VEH_ID, REN_STARTLOC, REN_ENDLOC, REN_PRICE, REN_PAYMENT, REN_PAID, REN_PICKUP_CONDITION, REN_RETURN_CONDITION, REN_CANCEL, REN_STARTDATE, REN_STARTTIME, REN_ENDDATE, REN_ENDTIME)
                            VALUES ('$id', '$rent_id', '$veh_id', '$loc_id', '$loc_id', '$total_rental_fee', '$payment_method', '未付款', '$pickup_status', '未還車', '未取消', '$ren_startdate', '$ren_starttime', '$ren_enddate', '$ren_endtime')";
                }
        }
        echo "<pre>";
        echo "SQL Query: \n";
        echo $sql;
        echo "</pre>";
        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("訂購成功 ！"); window.location.href = "homepage2.html";</script>';
        } else {
            echo '訂單儲存失敗: ' . mysqli_error($conn);
        }
    } else {
        echo '用戶ID不存在於customer表中!';
    }
} else {
    echo '無效的用戶ID或位置ID!';
}
?>
