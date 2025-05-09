<?php
header('Content-Type: application/json');

include "Connect.php";

// Lấy dữ liệu từ yêu cầu POST
$ten_the_loai = isset($_POST['ten_the_loai']) ? mysqli_real_escape_string($conn, $_POST['ten_the_loai']) : '';

if (empty($ten_the_loai)) {
    echo json_encode(array("success" => false, "message" => "Tên thể loại không được để trống"));
    exit;
}

// Kiểm tra xem thể loại đã tồn tại chưa
$query_check = "SELECT id FROM the_loai WHERE ten_the_loai = '$ten_the_loai'";
$result_check = mysqli_query($conn, $query_check);
if (mysqli_num_rows($result_check) > 0) {
    echo json_encode(array("success" => false, "message" => "Thể loại đã tồn tại"));
    exit;
}

// Thêm thể loại mới
$query = "INSERT INTO the_loai (ten_the_loai) VALUES ('$ten_the_loai')";
$result = mysqli_query($conn, $query);

if ($result) {
    $arr = [
        'success' => true,
        'message' => "Thêm thể loại thành công"
    ];
} else {    
    $arr = [
        'success' => false,
        'message' => "Thêm thể loại thất bại: " . mysqli_error($conn)
    ];
}

echo json_encode($arr);

mysqli_close($conn);
?>