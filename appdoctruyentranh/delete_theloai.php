<?php
header('Content-Type: application/json');

include "Connect.php";

// Lấy dữ liệu từ yêu cầu POST
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    echo json_encode(array("success" => false, "message" => "ID không hợp lệ"));
    exit;
}

// Kiểm tra xem thể loại có đang được sử dụng trong truyen_theloai không
$query_check = "SELECT id_truyen FROM truyen_theloai WHERE id_the_loai = '$id'";
$result_check = mysqli_query($conn, $query_check);
if (mysqli_num_rows($result_check) > 0) {
    echo json_encode(array("success" => false, "message" => "Thể loại đang được sử dụng, không thể xóa"));
    exit;
}

// Xóa thể loại
$query = "DELETE FROM the_loai WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $arr = [
        'success' => true,
        'message' => "Xóa thể loại thành công"
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "Xóa thể loại thất bại: " . mysqli_error($conn)
    ];
}

echo json_encode($arr);

mysqli_close($conn);
?>