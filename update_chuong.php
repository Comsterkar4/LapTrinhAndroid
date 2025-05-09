<?php
header('Content-Type: application/json');
include "Connect.php";

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$ten = isset($_POST['ten']) ? mysqli_real_escape_string($conn, $_POST['ten']) : '';
$so_chuong = isset($_POST['so_chuong']) ? (int)$_POST['so_chuong'] : 0;

if ($id <= 0 || empty($ten) || $so_chuong <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Dữ liệu không hợp lệ'
    ]);
    exit;
}

$query = "UPDATE chuong 
          SET ten = '$ten', so_chuong = '$so_chuong' 
          WHERE id = '$id'";
if (mysqli_query($conn, $query)) {
    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật chương thành công'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi cập nhật chương: ' . mysqli_error($conn)
    ]);
}

mysqli_close($conn);
?>