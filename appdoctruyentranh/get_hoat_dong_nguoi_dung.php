<?php
include "Connect.php";

// Lấy nguoi_dung_id từ POST hoặc GET (cho mục đích debug)
$nguoi_dung_id = isset($_POST['nguoi_dung_id']) ? (int)$_POST['nguoi_dung_id'] : (isset($_GET['nguoi_dung_id']) ? (int)$_GET['nguoi_dung_id'] : 0);

// Ghi log để debug (tùy chọn, có thể xóa sau khi test xong)
error_log("nguoi_dung_id: $nguoi_dung_id");

if ($nguoi_dung_id <= 0) {
    $arr = [
        'success' => false,
        'message' => "ID người dùng không hợp lệ",
        'result' => []
    ];
    echo json_encode($arr);
    exit();
}

// Câu truy vấn SQL đã được cập nhật
$query = "SELECT h.truyen_id, h.chuong_cuoi_doc, h.yeu_thich, h.cap_nhat, t.ten AS ten_truyen, t.anh_bia 
          FROM hoat_dong_nguoi_dung h 
          LEFT JOIN truyen t ON h.truyen_id = t.id 
          WHERE h.nguoi_dung_id = ? AND h.yeu_thich = 1";

$stmt = $conn->prepare($query);
if (!$stmt) {
    $arr = [
        'success' => false,
        'message' => "Lỗi chuẩn bị truy vấn: " . $conn->error,
        'result' => []
    ];
    echo json_encode($arr);
    exit();
}

$stmt->bind_param("i", $nguoi_dung_id);
$stmt->execute();
$data = $stmt->get_result();

$result = array();
while ($row = $data->fetch_assoc()) {
    $result[] = [
        'truyen_id' => (int)$row['truyen_id'],
        'ten_truyen' => $row['ten_truyen'] ?? 'Không có tiêu đề',
        'anh_bia' => $row['anh_bia'] ?? '',
        'chuong_cuoi_doc' => (int)$row['chuong_cuoi_doc'],
        'yeu_thich' => (int)$row['yeu_thich'],
        'cap_nhat' => $row['cap_nhat']
    ];
}

if (!empty($result)) {
    $arr = [
        'success' => true,
        'message' => "Lấy danh sách truyện yêu thích thành công",
        'result' => $result
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "Không có truyện yêu thích",
        'result' => []
    ];
}

$stmt->close();
$conn->close();
header('Content-Type: application/json; charset=utf-8');
echo json_encode($arr);
?>
