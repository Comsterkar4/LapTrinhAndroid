<?php
header('Content-Type: application/json; charset=utf-8');

// Kiểm tra sự tồn tại của file connect.php
if (!file_exists('connect.php')) {
    echo json_encode([
        'success' => false,
        'message' => 'Không tìm thấy file connect.php',
        'result' => []
    ]);
    exit;
}

include 'connect.php'; // Kết nối MySQL

// Lấy và kiểm tra nguoi_dung_id
$nguoi_dung_id = isset($_GET['nguoi_dung_id']) ? (int)$_GET['nguoi_dung_id'] : 0;

if ($nguoi_dung_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Thiếu hoặc không hợp lệ tham số nguoi_dung_id',
        'result' => []
    ]);
    exit;
}

try {
    // Kiểm tra kết nối
    if (!$conn) {
        throw new Exception('Kết nối cơ sở dữ liệu thất bại: ' . mysqli_connect_error());
    }

    // Kiểm tra nguoi_dung_id tồn tại
    $sql_check_nguoi_dung = "SELECT id FROM nguoi_dung WHERE id = ?";
    $stmt_check_nguoi_dung = $conn->prepare($sql_check_nguoi_dung);
    $stmt_check_nguoi_dung->bind_param("i", $nguoi_dung_id);
    $stmt_check_nguoi_dung->execute();
    $nguoi_dung_result = $stmt_check_nguoi_dung->get_result();
    if ($nguoi_dung_result->num_rows == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Người dùng không tồn tại',
            'result' => []
        ]);
        exit;
    }

    // Truy vấn lấy danh sách yêu thích
    $sql = "SELECT t.id, t.ten, t.anh_bia 
            FROM truyen t 
            JOIN hoat_dong_nguoi_dung h ON t.id = h.truyen_id 
            WHERE h.nguoi_dung_id = ? AND h.yeu_thich = 1";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Lỗi khi chuẩn bị truy vấn: ' . $conn->error);
    }
    
    $stmt->bind_param("i", $nguoi_dung_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $truyen_list = [];
    while ($row = $result->fetch_assoc()) {
        $truyen_list[] = [
            'truyen_id' => (int)$row['id'],
            'ten' => $row['ten'] ?? 'Không có tiêu đề',
            'anh_bia' => !empty($row['anh_bia']) ?  $row['anh_bia'] : ''
        ];
    }

    echo json_encode([
        'success' => true,
        'message' => empty($truyen_list) ? 'Chưa có truyện yêu thích' : 'Lấy danh sách yêu thích thành công',
        'result' => $truyen_list
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi server: ' . $e->getMessage(),
        'result' => []
    ]);
} finally {
    if (isset($stmt_check_nguoi_dung)) {
        $stmt_check_nguoi_dung->close();
    }
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>