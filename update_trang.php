<?php
header('Content-Type: application/json');
include "Connect.php";

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$duong_dan_anh = isset($_POST['duong_dan_anh']) ? mysqli_real_escape_string($conn, $_POST['duong_dan_anh']) : '';
$so_trang = isset($_POST['so_trang']) ? (int)$_POST['so_trang'] : 0;

if ($id <= 0 || empty($duong_dan_anh) || $so_trang <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Dữ liệu không hợp lệ'
    ]);
    exit;
}

$query = "UPDATE trang 
          SET duong_dan_anh = '$duong_dan_anh', so_trang = '$so_trang' 
          WHERE id = '$id'";
if (mysqli_query($conn, $query)) {
    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật trang thành công'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi cập nhật trang: ' . mysqli_error($conn)
    ]);
}

mysqli_close($conn);
?>