<?php
header('Content-Type: application/json; charset=utf-8');
include "Connect.php";

// Lấy nguoi_dung_id từ GET
$nguoi_dung_id = isset($_GET['nguoi_dung_id']) ? (int)$_GET['nguoi_dung_id'] : 0;

if ($nguoi_dung_id <= 0) {
    $response = [
        'success' => false,
        'message' => "Người dùng ID không hợp lệ"
    ];
    echo json_encode($response);
    exit();
}

// Kiểm tra kết nối cơ sở dữ liệu
if ($conn->connect_error) {
    $response = [
        'success' => false,
        'message' => "Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error
    ];
    echo json_encode($response);
    exit();
}

// Lấy danh sách lịch sử đọc, join với bảng truyen
$query = "SELECT h.truyen_id, t.ten, t.anh_bia, h.chuong_cuoi_doc AS chuong_so, h.cap_nhat AS thoi_gian_doc, h.yeu_thich
          FROM hoat_dong_nguoi_dung h
          JOIN truyen t ON h.truyen_id = t.id
          WHERE h.nguoi_dung_id = ? AND h.chuong_cuoi_doc > 0
          ORDER BY h.cap_nhat DESC";
$stmt = $conn->prepare($query);
if (!$stmt) {
    $response = [
        'success' => false,
        'message' => "Lỗi chuẩn bị truy vấn: " . $conn->error
    ];
    echo json_encode($response);
    $conn->close();
    exit();
}
$stmt->bind_param("i", $nguoi_dung_id);
$stmt->execute();
$result = $stmt->get_result();

$lich_su = [];
while ($row = $result->fetch_assoc()) {
    $lich_su[] = [
        'truyen_id' => (int)$row['truyen_id'],
        'ten' => $row['ten'],
        'anh_bia' => $row['anh_bia'],
        'chuong_so' => (int)$row['chuong_so'],
        'thoi_gian_doc' => $row['thoi_gian_doc'],
        'yeu_thich' => (int)$row['yeu_thich']
    ];
}

$response = [
    'success' => true,
    'message' => "Lấy lịch sử đọc thành công",
    'result' => $lich_su
];

$stmt->close();
$conn->close();

echo json_encode($response);
?>