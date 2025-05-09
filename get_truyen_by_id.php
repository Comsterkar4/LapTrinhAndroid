<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Cho phép truy cập từ mọi nguồn (CORS)

include "Connect.php";

// Kiểm tra kết nối database
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Kết nối database thất bại: " . $conn->connect_error]);
    exit();
}

// Kiểm tra tham số id
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || intval($_GET['id']) <= 0) {
    echo json_encode(["success" => false, "message" => "Tham số id không hợp lệ"]);
    exit();
}

$truyen_id = intval($_GET['id']);

// Truy vấn thông tin truyện
$sql_truyen = "SELECT * FROM truyen WHERE id = ?";
$stmt_truyen = $conn->prepare($sql_truyen);
if (!$stmt_truyen) {
    echo json_encode(["success" => false, "message" => "Lỗi prepare truyện: " . $conn->error]);
    $conn->close();
    exit();
}

$stmt_truyen->bind_param("i", $truyen_id);
$stmt_truyen->execute();
$result_truyen = $stmt_truyen->get_result();

if ($result_truyen->num_rows > 0) {
    $truyen = $result_truyen->fetch_assoc();

    // Truy vấn danh sách thể loại
    $sql_genres = "SELECT tl.ten_the_loai
                   FROM the_loai tl
                   JOIN truyen_theloai ttl ON tl.id = ttl.id_the_loai
                   WHERE ttl.id_truyen = ?";
    $stmt_genres = $conn->prepare($sql_genres);
    if (!$stmt_genres) {
        echo json_encode(["success" => false, "message" => "Lỗi prepare genres SQL: " . $conn->error]);
        $stmt_truyen->close();
        $conn->close();
        exit();
    }

    $stmt_genres->bind_param("i", $truyen_id);
    $stmt_genres->execute();
    $result_genres = $stmt_genres->get_result();

    $genres = [];
    while ($row = $result_genres->fetch_assoc()) {
        $genres[] = $row['ten_the_loai'];
    }

    $truyen['genres'] = $genres;

    echo json_encode([
        "success" => true,
        "message" => "thanh cong",
        "result" => $truyen
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Không tìm thấy truyện với id: $truyen_id"]);
}

// Đóng các statement và kết nối
$stmt_truyen->close();
if (isset($stmt_genres)) {
    $stmt_genres->close();
}
$conn->close();
?>