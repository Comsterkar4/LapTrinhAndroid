<?php
header('Content-Type: application/json');

include 'Connect.php';

if (!$conn) {
    echo json_encode(array("success" => false, "message" => "Connection failed: " . mysqli_connect_error()));
    exit;
}

// Lấy truyen_id và nguoi_dung_id từ yêu cầu POST
$truyen_id = isset($_POST['truyen_id']) ? (int)$_POST['truyen_id'] : 0;
$nguoi_dung_id = isset($_POST['nguoi_dung_id']) ? (int)$_POST['nguoi_dung_id'] : 0;

if ($truyen_id <= 0 || $nguoi_dung_id <= 0) {
    echo json_encode(array("success" => false, "message" => "Invalid truyen_id or nguoi_dung_id"));
    exit;
}

// Xóa bình luận từ bảng binh_luan
$query = "DELETE FROM binh_luan WHERE truyen_id = '$truyen_id' AND nguoi_dung_id = '$nguoi_dung_id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $arr = [
        'success' => true,
        'message' => "Xóa bình luận thành công"
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "Xóa bình luận thất bại: " . mysqli_error($conn)
    ];
}

echo json_encode($arr);

mysqli_close($conn);
?>