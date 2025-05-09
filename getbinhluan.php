<?php
include "Connect.php";

$nguoi_dung_id = $_POST['nguoi_dung_id'];
$truyen_id = $_POST['truyen_id'];

$query = "SELECT binh_luan.truyen_id, binh_luan.nguoi_dung_id, binh_luan.noi_dung, nguoi_dung.ten_dang_nhap, nguoi_dung.avatar 
          FROM binh_luan 
          LEFT JOIN nguoi_dung 
          ON nguoi_dung.id = binh_luan.nguoi_dung_id 
          WHERE truyen_id = '$truyen_id' AND nguoi_dung_id = '$nguoi_dung_id'";
$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
    $result[] = ($row);
}
if (!empty($result)) {
    $arr = [
        'success' => true,
        'message' => "thanh cong",
        'result' => $result
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "khong thanh cong binh luan",
        'result' => $result
    ];
}
echo json_encode($arr);
?>