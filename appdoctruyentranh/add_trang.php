<?php
header('Content-Type: application/json');
include "Connect.php";

$chuong_id = isset($_POST['chuong_id']) ? (int)$_POST['chuong_id'] : 0;
$duong_dan_anh = isset($_POST['duong_dan_anh']) ? mysqli_real_escape_string($conn, $_POST['duong_dan_anh']) : '';
$so_trang = isset($_POST['so_trang']) ? (int)$_POST['so_trang'] : 0;

if ($chuong_id <= 0 || empty($duong_dan_anh) || $so_trang <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Dữ liệu không hợp lệ'
    ]);
    exit;
}

$query = "INSERT INTO trang (chuong_id, so_trang, duong_dan_anh) 
          VALUES ('$chuong_id', '$so_trang', '$duong_dan_anh')";
if (mysqli_query($conn, $query)) {
    echo json_encode([
        'success' => true,
        'message' => 'Thêm trang thành công'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi thêm trang: ' . mysqli_error($conn)
    ]);
}

mysqli_close($conn);
?>