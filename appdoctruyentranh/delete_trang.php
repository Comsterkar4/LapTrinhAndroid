<?php
header('Content-Type: application/json');
include "Connect.php";

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'ID trang không hợp lệ đây là trag'
    ]);
    exit;
}

$query = "DELETE FROM trang WHERE id = '$id'";
if (mysqli_query($conn, $query)) {
    echo json_encode([
        'success' => true,
        'message' => 'Xóa trang thành công'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi xóa trang: ' . mysqli_error($conn)
    ]);
}

mysqli_close($conn);
?>