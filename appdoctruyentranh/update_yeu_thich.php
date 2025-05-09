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

// Lấy tham số từ POST
$nguoi_dung_id = isset($_POST['nguoi_dung_id']) ? (int)$_POST['nguoi_dung_id'] : 0;
$truyen_id = isset($_POST['truyen_id']) ? (int)$_POST['truyen_id'] : 0;
$yeu_thich = isset($_POST['yeu_thich']) ? (int)$_POST['yeu_thich'] : 0; // 1: Yêu thích, 0: Bỏ yêu thích

// Kiểm tra tham số hợp lệ
if ($nguoi_dung_id <= 0 || $truyen_id <= 0 || ($yeu_thich != 1 && $yeu_thich != 0)) {
    echo json_encode([
        'success' => false,
        'message' => 'Dữ liệu không hợp lệ',
        'result' => []
    ]);
    exit;
}

try {
    // Kiểm tra kết nối
    if (!$conn) {
        throw new Exception('Kết nối cơ sở dữ liệu thất bại: ' . mysqli_connect_error());
    }

    // Kiểm tra xem nguoi_dung_id và truyen_id có tồn tại
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

    $sql_check_truyen = "SELECT id FROM truyen WHERE id = ?";
    $stmt_check_truyen = $conn->prepare($sql_check_truyen);
    $stmt_check_truyen->bind_param("i", $truyen_id);
    $stmt_check_truyen->execute();
    $truyen_result = $stmt_check_truyen->get_result();
    if ($truyen_result->num_rows == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Truyện không tồn tại',
            'result' => []
        ]);
        exit;
    }

    // Kiểm tra xem bản ghi đã tồn tại chưa
    $sql_check = "SELECT yeu_thich FROM hoat_dong_nguoi_dung WHERE nguoi_dung_id = ? AND truyen_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    if (!$stmt_check) {
        throw new Exception('Lỗi khi chuẩn bị truy vấn kiểm tra: ' . $conn->error);
    }
    $stmt_check->bind_param("ii", $nguoi_dung_id, $truyen_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // Bản ghi tồn tại
        $row = $result->fetch_assoc();
        if ($row['yeu_thich'] == $yeu_thich) {
            echo json_encode([
                'success' => false,
                'message' => $yeu_thich == 1 ? 'Truyện đã được yêu thích' : 'Truyện chưa được yêu thích',
                'result' => []
            ]);
            exit;
        }

        if ($yeu_thich == 0) {
            // Xóa bản ghi nếu bỏ yêu thích
            $sql = "DELETE FROM hoat_dong_nguoi_dung WHERE nguoi_dung_id = ? AND truyen_id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception('Lỗi khi chuẩn bị truy vấn xóa: ' . $conn->error);
            }
            $stmt->bind_param("ii", $nguoi_dung_id, $truyen_id);
        } else {
            // Cập nhật trạng thái yêu thích
            $sql = "UPDATE hoat_dong_nguoi_dung SET yeu_thich = ? WHERE nguoi_dung_id = ? AND truyen_id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception('Lỗi khi chuẩn bị truy vấn cập nhật: ' . $conn->error);
            }
            $stmt->bind_param("iii", $yeu_thich, $nguoi_dung_id, $truyen_id);
        }
    } else {
        // Bản ghi không tồn tại, thêm mới nếu yeu_thich = 1
        if ($yeu_thich == 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Truyện chưa được yêu thích',
                'result' => []
            ]);
            exit;
        }

        $sql = "INSERT INTO hoat_dong_nguoi_dung (nguoi_dung_id, truyen_id, yeu_thich) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception('Lỗi khi chuẩn bị truy vấn thêm: ' . $conn->error);
        }
        $stmt->bind_param("iii", $nguoi_dung_id, $truyen_id, $yeu_thich);
    }

    $stmt->execute();
    echo json_encode([
        'success' => true,
        'message' => $yeu_thich == 1 ? 'Yêu thích thành công' : 'Bỏ yêu thích thành công',
        'result' => []
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi server: ' . $e->getMessage(),
        'result' => []
    ]);
} finally {
    if (isset($stmt_check)) {
        $stmt_check->close();
    }
    if (isset($stmt_check_nguoi_dung)) {
        $stmt_check_nguoi_dung->close();
    }
    if (isset($stmt_check_truyen)) {
        $stmt_check_truyen->close();
    }
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>