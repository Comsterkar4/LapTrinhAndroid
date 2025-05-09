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

// Lấy dữ liệu từ POST hoặc GET
$id_nguoi_dung = isset($_POST['id_nguoi_dung']) ? intval($_POST['id_nguoi_dung']) : (isset($_GET['id_nguoi_dung']) ? intval($_GET['id_nguoi_dung']) : 0);
$mat_khau_moi = isset($_POST['mat_khau_moi']) ? $_POST['mat_khau_moi'] : (isset($_GET['mat_khau_moi']) ? $_GET['mat_khau_moi'] : '');

if ($id_nguoi_dung <= 0 || empty($mat_khau_moi)) {
    echo json_encode([
        "success" => false,
        "message" => "ID người dùng hoặc mật khẩu mới không hợp lệ"
    ]);
    exit();
}

// Cập nhật mật khẩu
$stmt = $conn->prepare("UPDATE nguoi_dung SET mat_khau = ? WHERE id = ?");
$stmt->bind_param("si", $mat_khau_moi, $id_nguoi_dung);

if ($stmt->execute()) {
    $result = $conn->query("SELECT id, email, mat_khau, avatar FROM nguoi_dung WHERE id = $id_nguoi_dung");
    $user = $result->fetch_assoc();
    
    echo json_encode([
        "success" => true,
        "message" => "Đổi mật khẩu thành công",
        "result" => $user
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi đổi mật khẩu: " . $conn->error
    ]);
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>