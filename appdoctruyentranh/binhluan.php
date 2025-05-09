<?php
include "connect.php";

$nguoi_dung_id = $_POST['nguoi_dung_id'];
$truyen_id = $_POST['truyen_id'];
$noi_dung = $_POST['noi_dung'];
$query = "INSERT INTO binh_luan (nguoi_dung_id, truyen_id, noi_dung) VALUES ('$nguoi_dung_id', '$truyen_id', '$noi_dung')";
$data = mysqli_query($conn, $query);
    if ($data == true) {
        $arr = [
            'success' => true,
            'message' => "thanh cong"
        ];
    } else {
        $arr = [
            'success' => false,
            'message' => "khong thanh cong binh luan",
        ];
    }

echo json_encode($arr);
?>