<?php
include "Connect.php";

$nguoi_dung_id = isset($_POST['nguoi_dung_id']) ? (int)$_POST['nguoi_dung_id'] : 0;
$truyen_id = isset($_POST['truyen_id']) ? (int)$_POST['truyen_id'] : 0;

if ($nguoi_dung_id <= 0 || $truyen_id <= 0) {
    $response = [
        'success' => false,
        'message' => "Dữ liệu không hợp lệ"
    ];
    echo json_encode($response);
    exit();
}

// Kiểm tra xem truyện đã có trong danh sách yêu thích chưa
$query_check = "SELECT id FROM yeu_thich WHERE nguoi_dung_id = ? AND truyen_id = ?";
$stmt_check = $conn->prepare($query_check);
$stmt_check->bind_param("ii", $nguoi_dung_id, $truyen_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Nếu đã có, xóa khỏi danh sách yêu thích
    $query_delete = "DELETE FROM yeu_thich WHERE nguoi_dung_id = ? AND truyen_id = ?";
    $stmt_delete = $conn->prepare($query_delete);
    $stmt_delete->bind_param("ii", $nguoi_dung_id, $truyen_id);

    if ($stmt_delete->execute()) {
        $response = [
            'success' => true,
            'message' => "Đã bỏ yêu thích",
            'yeu_thich' => 0
        ];
    } else {
        $response = [
            'success' => false,
            'message' => "Xóa thất bại: " . $conn->error
        ];
    }
    $stmt_delete->close();
} else {
    // Nếu chưa có, thêm vào danh sách yêu thích
    $query_insert = "INSERT INTO yeu_thich (nguoi_dung_id, truyen_id, ngay_them) VALUES (?, ?, NOW())";
    $stmt_insert = $conn->prepare($query_insert);
    $stmt_insert->bind_param("ii", $nguoi_dung_id, $truyen_id);

    if ($stmt_insert->execute()) {
        $response = [
            'success' => true,
            'message' => "Đã thêm vào yêu thích",
            'yeu_thich' => 1
        ];
    } else {
        $response = [
            'success' => false,
            'message' => "Thêm thất bại: " . $conn->error
        ];
    }
    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
echo json_encode($response);
?>