<?php
header('Content-Type: application/json');

include 'Connect.php';

if (!$conn) {
    echo json_encode(array("success" => false, "message" => "Connection failed: " . mysqli_connect_error()));
    exit;
}

// Lấy id người dùng từ yêu cầu POST
$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

if ($user_id <= 0) {
    echo json_encode(array("success" => false, "message" => "Invalid user ID"));
    exit;
}

// Xóa người dùng từ bảng nguoi_dung
$query = "DELETE FROM nguoi_dung WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $arr = [
        'success' => true,
        'message' => "Xóa người dùng thành công"
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "Xóa người dùng thất bại: " . mysqli_error($conn)
    ];
}

echo json_encode($arr);

mysqli_close($conn);
?>