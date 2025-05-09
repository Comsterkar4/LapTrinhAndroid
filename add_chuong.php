<?php
header('Content-Type: application/json');
include "Connect.php";

$truyen_id = isset($_POST['truyen_id']) ? (int)$_POST['truyen_id'] : 0;
$ten = isset($_POST['ten']) ? mysqli_real_escape_string($conn, $_POST['ten']) : '';
$so_chuong = isset($_POST['so_chuong']) ? (int)$_POST['so_chuong'] : 0;

if ($truyen_id <= 0 || empty($ten) || $so_chuong <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Dữ liệu không hợp lệ'
    ]);
    exit;
}

$query = "INSERT INTO chuong (truyen_id, ten, so_chuong, ngay_tao) 
          VALUES ('$truyen_id', '$ten', '$so_chuong', NOW())";
if (mysqli_query($conn, $query)) {
    echo json_encode([
        'success' => true,
        'message' => 'Thêm chương thành công'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi thêm chương: ' . mysqli_error($conn)
    ]);
}

mysqli_close($conn);
?>