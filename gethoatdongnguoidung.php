<?php
include "Connect.php";
$truyen_id = $_POST['truyen_id'];
$nguoi_dung_id = $_POST['nguoi_dung_id'];
$query = "SELECT * FROM hoat_dong_nguoi_dung WHERE truyen_id = '$truyen_id' AND nguoi_dung_id = '$nguoi_dung_id'";
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
        'message' => "khong thanh cong hoat doông nguoi dung",
        'result' => $result
    ];
}
echo json_encode($arr);
?>