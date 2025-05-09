<?php
header('Content-Type: application/json');
include "connect.php";

$nguoi_dung_id = $_POST["nguoi_dung_id"];
$truyen_id = $_POST["truyen_id"];
$chuong_cuoi_doc = $_POST["chuong_cuoi_doc"];
$yeu_thich = $_POST["yeu_thich"];
if ($chuong_cuoi_doc === 'null') {
    $chuong_cuoi_doc = NULL; 
}
$query = "SELECT id FROM hoat_dong_nguoi_dung WHERE nguoi_dung_id = '$nguoi_dung_id' AND truyen_id = '$truyen_id'";
$data = mysqli_query($conn, $query);
$numrow = mysqli_num_rows($data);

if ($numrow > 0) {
    $query = "UPDATE hoat_dong_nguoi_dung SET chuong_cuoi_doc = '$chuong_cuoi_doc', yeu_thich = '$yeu_thich' WHERE nguoi_dung_id = '$nguoi_dung_id' AND truyen_id = '$truyen_id'";
    $data = mysqli_query($conn, $query);
    if ($data == true) {
        $arr = [
            'success' => true,
            'message' => "Cập nhật thành công"
        ];
    } else {
        $arr = [
            'success' => false,
            'message' => "Cập nhật không thành công"
        ];
    }
} else {
    $query = "INSERT INTO hoat_dong_nguoi_dung (nguoi_dung_id, truyen_id, chuong_cuoi_doc, yeu_thich) VALUES ('$nguoi_dung_id', '$truyen_id', '$chuong_cuoi_doc', '$yeu_thich')";
    $data = mysqli_query($conn, $query);
    if ($data == true) {
        $arr = [
            'success' => true,
            'message' => "Thêm mới thành công"
        ];
    } else {
        $arr = [
            'success' => false,
            'message' => "Thêm mới không thành công"
        ];
    }
}

echo json_encode($arr);
?>
