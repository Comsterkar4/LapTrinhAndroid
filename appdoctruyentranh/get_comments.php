<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include 'Connect.php';

if (!$conn) {
    echo json_encode([
        "success" => false,
        "message" => "Kết nối thất bại: " . mysqli_connect_error()
    ]);
    exit;
}

$query = "
    SELECT binh_luan.noi_dung, nguoi_dung.ten_dang_nhap, 
           COALESCE(nguoi_dung.avatar, 'default_avatar.png') AS avatar
    FROM binh_luan
    LEFT JOIN nguoi_dung ON nguoi_dung.id = binh_luan.nguoi_dung_id
";

$result = mysqli_query($conn, $query);

$comments = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }

    $response = [
        'success' => true,
        'message' => 'Lấy bình luận thành công',
        'result' => $comments
    ];
} else {
    $response = [
        'success' => false,
        'message' => 'Không thể thực hiện truy vấn',
        'result' => []
    ];
}

echo json_encode($response);
mysqli_close($conn);
?>
