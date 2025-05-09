<?php
header('Content-Type: application/json; charset=utf-8');
include "Connect.php";

// Lấy dữ liệu từ POST hoặc GET
$nguoi_dung_id = isset($_POST['nguoi_dung_id']) ? (int)$_POST['nguoi_dung_id'] : (isset($_GET['nguoi_dung_id']) ? (int)$_GET['nguoi_dung_id'] : 0);
$truyen_id = isset($_POST['id_truyen']) ? (int)$_POST['id_truyen'] : (isset($_GET['id_truyen']) ? (int)$_GET['id_truyen'] : 0);
$chuong_cuoi_doc = isset($_POST['chuong_cuoi_doc']) ? (int)$_POST['chuong_cuoi_doc'] : (isset($_GET['chuong_cuoi_doc']) ? (int)$_GET['chuong_cuoi_doc'] : 0);

// Kiểm tra dữ liệu đầu vào
if ($nguoi_dung_id <= 0 || $truyen_id <= 0 || $chuong_cuoi_doc <= 0) {
    $response = [
        'success' => false,
        'message' => "Dữ liệu không hợp lệ. Yêu cầu: nguoi_dung_id, id_truyen, chuong_cuoi_doc phải lớn hơn 0."
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

// Kiểm tra xem đã có lịch sử đọc cho người dùng và truyện này chưa
$query_check = "SELECT id, yeu_thich FROM hoat_dong_nguoi_dung WHERE nguoi_dung_id = ? AND truyen_id = ?";
$stmt_check = $conn->prepare($query_check);
if (!$stmt_check) {
    $response = [
        'success' => false,
        'message' => "Lỗi chuẩn bị truy vấn: " . $conn->error
    ];
    echo json_encode($response);
    $conn->close();
    exit();
}
$stmt_check->bind_param("ii", $nguoi_dung_id, $truyen_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Nếu đã có, cập nhật chương cuối đọc và thời gian
    $row = $result_check->fetch_assoc();
    $query_update = "UPDATE hoat_dong_nguoi_dung SET chuong_cuoi_doc = ?, cap_nhat = NOW() WHERE id = ?";
    $stmt_update = $conn->prepare($query_update);
    if (!$stmt_update) {
        $response = [
            'success' => false,
            'message' => "Lỗi chuẩn bị truy vấn cập nhật: " . $conn->error
        ];
        echo json_encode($response);
        $stmt_check->close();
        $conn->close();
        exit();
    }
    $stmt_update->bind_param("ii", $chuong_cuoi_doc, $row['id']);
    
    if ($stmt_update->execute()) {
        $response = [
            'success' => true,
            'message' => "Cập nhật lịch sử đọc thành công"
        ];
    } else {
        $response = [
            'success' => false,
            'message' => "Cập nhật thất bại: " . $stmt_update->error
        ];
    }
    $stmt_update->close();
} else {
    // Nếu chưa có, thêm mới lịch sử đọc
    $query_insert = "INSERT INTO hoat_dong_nguoi_dung (nguoi_dung_id, truyen_id, chuong_cuoi_doc, yeu_thich, cap_nhat) VALUES (?, ?, ?, 0, NOW())";
    $stmt_insert = $conn->prepare($query_insert);
    if (!$stmt_insert) {
        $response = [
            'success' => false,
            'message' => "Lỗi chuẩn bị truy vấn thêm mới: " . $conn->error
        ];
        echo json_encode($response);
        $stmt_check->close();
        $conn->close();
        exit();
    }
    $stmt_insert->bind_param("iii", $nguoi_dung_id, $truyen_id, $chuong_cuoi_doc);
    
    if ($stmt_insert->execute()) {
        $response = [
            'success' => true,
            'message' => "Lưu lịch sử đọc thành công"
        ];
    } else {
        $response = [
            'success' => false,
            'message' => "Lưu thất bại: " . $stmt_insert->error
        ];
    }
    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();

echo json_encode($response);
?>