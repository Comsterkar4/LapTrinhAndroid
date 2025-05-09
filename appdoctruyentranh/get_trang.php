<?php
header('Content-Type: application/json');
include "Connect.php";

$chuong_id = isset($_GET['chuong_id']) ? (int)$_GET['chuong_id'] : 0;
if ($chuong_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'ID chương không hợp lệ'
    ]);
    exit;
}

$query = "SELECT id, chuong_id, so_trang, duong_dan_anh 
          FROM trang 
          WHERE chuong_id = '$chuong_id' 
          ORDER BY so_trang ASC";
$data = mysqli_query($conn, $query);
$result = [];

while ($row = mysqli_fetch_assoc($data)) {
    $result[] = [
        'id' => (int)$row['id'],
        'chuong_id' => (int)$row['chuong_id'],
        'so_trang' => (int)$row['so_trang'],
        'duong_dan_anh' => $row['duong_dan_anh']
    ];
}

echo json_encode([
    'success' => true,
    'message' => 'Lấy danh sách trang thành công',
    'result' => $result
]);
mysqli_close($conn);
?>