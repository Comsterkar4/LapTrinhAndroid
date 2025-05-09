<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Cho phép truy cập từ mọi nguồn (CORS)

include "Connect.php";

// Kiểm tra kết nối database
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Kết nối database thất bại: " . $conn->connect_error,
        "result" => null
    ]);
    exit();
}

// Kiểm tra tham số id
if (!isset($_POST['id']) || !is_numeric($_POST['id']) || intval($_POST['id']) <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Tham số id không hợp lệ",
        "result" => null
    ]);
    exit();
}

$truyen_id = intval($_POST['id']);

// Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
$conn->begin_transaction();

try {
    // Xóa các thể loại liên quan trong bảng truyen_theloai
    $sql_delete_theloai = "DELETE FROM truyen_theloai WHERE id_truyen = ?";
    $stmt_theloai = $conn->prepare($sql_delete_theloai);
    if (!$stmt_theloai) {
        throw new Exception("Lỗi prepare xóa thể loại: " . $conn->error);
    }
    $stmt_theloai->bind_param("i", $truyen_id);
    $stmt_theloai->execute();
    $stmt_theloai->close();

    // Xóa các chương liên quan trong bảng chuong (sửa cột id_truyen thành truyen_id)
    $sql_delete_chuong = "DELETE FROM chuong WHERE truyen_id = ?"; // Sửa ở đây
    $stmt_chuong = $conn->prepare($sql_delete_chuong);
    if (!$stmt_chuong) {
        throw new Exception("Lỗi prepare xóa chương: " . $conn->error);
    }
    $stmt_chuong->bind_param("i", $truyen_id);
    $stmt_chuong->execute();
    $stmt_chuong->close();

    // Xóa các bình luận liên quan trong bảng binh_luan
    $sql_delete_binhluan = "DELETE FROM binh_luan WHERE truyen_id = ?";
    $stmt_binhluan = $conn->prepare($sql_delete_binhluan);
    if (!$stmt_binhluan) {
        throw new Exception("Lỗi prepare xóa bình luận: " . $conn->error);
    }
    $stmt_binhluan->bind_param("i", $truyen_id);
    $stmt_binhluan->execute();
    $stmt_binhluan->close();

    // Xóa truyện trong bảng truyen
    $sql_delete_truyen = "DELETE FROM truyen WHERE id = ?";
    $stmt_truyen = $conn->prepare($sql_delete_truyen);
    if (!$stmt_truyen) {
        throw new Exception("Lỗi prepare xóa truyện: " . $conn->error);
    }
    $stmt_truyen->bind_param("i", $truyen_id);
    $stmt_truyen->execute();

    // Kiểm tra xem có bản ghi nào bị xóa không
    $affected_rows = $stmt_truyen->affected_rows;
    $stmt_truyen->close();

    if ($affected_rows > 0) {
        // Commit transaction nếu xóa thành công
        $conn->commit();
        echo json_encode([
            "success" => true,
            "message" => "thanh cong",
            "result" => null
        ]);
    } else {
        // Rollback nếu không tìm thấy truyện để xóa
        $conn->rollback();
        echo json_encode([
            "success" => false,
            "message" => "Không tìm thấy truyện với id: $truyen_id",
            "result" => null
        ]);
    }
} catch (Exception $e) {
    // Rollback nếu có lỗi
    $conn->rollback();
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi xóa truyện: " . $e->getMessage(),
        "result" => null
    ]);
}

// Đóng kết nối
$conn->close();
?>