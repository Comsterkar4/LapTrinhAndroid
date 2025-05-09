<?php
header('Content-Type: application/json');
include 'Connect.php';

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Kết nối database thất bại: " . $conn->connect_error
    ]);
    exit();
}

// Nhận dữ liệu từ POST
$nguoi_dung_id = isset($_POST['nguoi_dung_id']) ? (int)$_POST['nguoi_dung_id'] :
                 (isset($_GET['nguoi_dung_id']) ? (int)$_GET['nguoi_dung_id'] : 0);

$truyen_id = isset($_POST['truyen_id']) ? (int)$_POST['truyen_id'] :
             (isset($_GET['truyen_id']) ? (int)$_GET['truyen_id'] : 0);


if ($nguoi_dung_id === 0 || $truyen_id === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Thiếu nguoi_dung_id hoặc truyen_id"
    ]);
    exit();
}

// Truy vấn trạng thái yêu thích
$sql = "SELECT truyen_id, nguoi_dung_id, chuong_cuoi_doc, yeu_thich 
        FROM hoat_dong_nguoi_dung  
        WHERE nguoi_dung_id = ? AND truyen_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi chuẩn bị truy vấn: " . $conn->error
    ]);
    exit();
}

$stmt->bind_param("ii", $nguoi_dung_id, $truyen_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

if (count($data) > 0) {
    echo json_encode([
        "success" => true,
        "message" => "Lấy trạng thái yêu thích thành công",
        "result" => $data
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Không tìm thấy dữ liệu yêu thích",
        "result" => []
    ]);
}

$stmt->close();
$conn->close();
?>
