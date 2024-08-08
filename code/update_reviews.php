<?php
session_start();
include("mysql_connect.inc.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review_id = $_POST['review_id'];
    $new_score = $_POST['rating'];
    $new_comment = $_POST['comment'];
    $id = $_SESSION['USER_ID'];

    $updateSuccess = false;

    if (!empty($new_score)) {
        $sql = "UPDATE feedback SET FEE_SCORE = ? WHERE REN_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $new_score, $review_id);
        $updateSuccess = $stmt->execute();
        $stmt->close();
		
    }

    if (!empty($new_comment)) {
        $sql = "UPDATE feedback SET FEE_COMMENT = ? WHERE REN_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_comment, $review_id);
        $updateSuccess = $stmt->execute();
        $stmt->close();
    }

    if ($updateSuccess) {
        echo '提交成功！';
		echo '<script> window.location.href = " my_reviews.php";</script>';
    } else {
        echo '提交失敗，請稍後再試。';
    }
}
?>
