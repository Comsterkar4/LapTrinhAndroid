<?php
header('Content-Type: application/json');

// Kết nối cơ sở dữ liệu
include 'Connect.php';

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error
    ]);
    exit();
}

// Lấy id_nguoi_dung từ query string
$id_nguoi_dung = isset($_GET['id_nguoi_dung']) ? intval($_GET['id_nguoi_dung']) : 0;

if ($id_nguoi_dung <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "ID người dùng không hợp lệ"
    ]);
    exit();
}

// Truy vấn thông tin người dùng
$stmt = $conn->prepare("SELECT id, email, mat_khau, avatar FROM nguoi_dung WHERE id = ?");
$stmt->bind_param("i", $id_nguoi_dung);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "message" => "Thành công",
        "result" => $user
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Không tìm thấy người dùng"
    ]);
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>