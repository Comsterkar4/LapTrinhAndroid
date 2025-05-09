<?php
include "Connect.php";
$chuong_id = $_POST["chuong_id"];
$query = "SELECT * FROM trang WHERE chuong_id = '$chuong_id'";
$data = mysqli_query($conn, $query);
$result = array();
while($row = mysqli_fetch_assoc($data)){
    $result[]= ($row);
}
if(!empty($result)){
    $arr = [
        'success' => true,
        'message' => "thanh cong",
        'result' => $result
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "khong thanh cong trang truyen",
        'result' => $result
    ];
}
echo json_encode($arr);
?>