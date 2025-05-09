<?php
header('Content-Type: application/json');

include "Connect.php";

// Lấy dữ liệu từ yêu cầu POST
$ten = isset($_POST['ten']) ? mysqli_real_escape_string($conn, $_POST['ten']) : '';
$tac_gia = isset($_POST['tac_gia']) ? mysqli_real_escape_string($conn, $_POST['tac_gia']) : '';
$mo_ta = isset($_POST['mo_ta']) ? mysqli_real_escape_string($conn, $_POST['mo_ta']) : '';
$anh_bia = isset($_POST['anh_bia']) ? mysqli_real_escape_string($conn, $_POST['anh_bia']) : '';
$genres = isset($_POST['genres']) ? json_decode($_POST['genres'], true) : [];

if (empty($ten) || empty($tac_gia) || empty($mo_ta) || empty($anh_bia) || empty($genres)) {
    echo json_encode(array("success" => false, "message" => "Thông tin truyện không đầy đủ"));
    exit;
}

// Thêm truyện vào bảng truyen
$query = "INSERT INTO truyen (ten, tac_gia, mo_ta, anh_bia, id_trang_thai, luot_xem, luot_thich, ngay_tao) 
          VALUES ('$ten', '$tac_gia', '$mo_ta', '$anh_bia', 1, 0, 0, NOW())";
$result = mysqli_query($conn, $query);

if ($result) {
    $truyen_id = mysqli_insert_id($conn); // Lấy ID của truyện vừa thêm

    // Thêm thể loại vào bảng truyen_theloai
    foreach ($genres as $ten_the_loai) {
        $ten_the_loai = mysqli_real_escape_string($conn, $ten_the_loai);
        $query_genre = "SELECT id FROM the_loai WHERE ten_the_loai = '$ten_the_loai'";
        $result_genre = mysqli_query($conn, $query_genre);
        if (mysqli_num_rows($result_genre) > 0) {
            $row = mysqli_fetch_assoc($result_genre);
            $the_loai_id = $row['id'];
            $query_insert = "INSERT INTO truyen_theloai (id_truyen, id_the_loai) VALUES ('$truyen_id', '$the_loai_id')";
            mysqli_query($conn, $query_insert);
        }
    }

    $arr = [
        'success' => true,
        'message' => "Thêm truyện thành công",
        'truyen_id' => $truyen_id
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "Thêm truyện thất bại: " . mysqli_error($conn)
    ];
}

echo json_encode($arr);

mysqli_close($conn);
?>