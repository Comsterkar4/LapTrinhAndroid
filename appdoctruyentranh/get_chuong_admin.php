<?php
header('Content-Type: application/json');
include "Connect.php";

$truyen_id = isset($_GET['truyen_id']) ? (int)$_GET['truyen_id'] : 0;
if ($truyen_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'ID truyện không hợp lệ hoặc không tồn tại'
    ]);
    exit;
}

$stmt = $conn->prepare("SELECT id, truyen_id, ten, so_chuong, ngay_tao FROM chuong WHERE truyen_id = ? ORDER BY so_chuong ASC");
$stmt->bind_param("i", $truyen_id);
$stmt->execute();
$resultSet = $stmt->get_result();

$result = [];
while ($row = $resultSet->fetch_assoc()) {
    $result[] = [
        'id' => (int)$row['id'],
        'truyen_id' => (int)$row['truyen_id'],
        'ten' => $row['ten'],
        'so_chuong' => (int)$row['so_chuong'],
        'ngay_tao' => $row['ngay_tao']
    ];
}

echo json_encode([
    'success' => true,
    'message' => 'Lấy danh sách chương thành công',
    'result' => $result
]);

$stmt->close();
$conn->close();
?>
