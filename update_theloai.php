<?php
header('Content-Type: application/json');

include "Connect.php";

// Lấy dữ liệu từ yêu cầu POST
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$ten_the_loai = isset($_POST['ten_the_loai']) ? mysqli_real_escape_string($conn, $_POST['ten_the_loai']) : '';

if ($id <= 0 || empty($ten_the_loai)) {
    echo json_encode(array("success" => false, "message" => "ID hoặc tên thể loại không hợp lệ"));
    exit;
}

// Kiểm tra xem thể loại đã tồn tại chưa (trừ chính nó)
$query_check = "SELECT id FROM the_loai WHERE ten_the_loai = '$ten_the_loai' AND id != '$id'";
$result_check = mysqli_query($conn, $query_check);
if (mysqli_num_rows($result_check) > 0) {
    echo json_encode(array("success" => false, "message" => "Tên thể loại đã tồn tại"));
    exit;
}

// Cập nhật thể loại
$query = "UPDATE the_loai SET ten_the_loai = '$ten_the_loai' WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $arr = [
        'success' => true,
        'message' => "Cập nhật thể loại thành công"
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "Cập nhật thể loại thất bại: " . mysqli_error($conn)
    ];
}

echo json_encode($arr);

mysqli_close($conn);
?>