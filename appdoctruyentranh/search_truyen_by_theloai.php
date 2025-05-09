<?php
header('Content-Type: application/json');

include "Connect.php";

// Lấy tham số từ yêu cầu POST
$ten_the_loai = isset($_POST['ten_the_loai']) ? mysqli_real_escape_string($conn, $_POST['ten_the_loai']) : '';
$query_search = isset($_POST['query']) ? mysqli_real_escape_string($conn, $_POST['query']) : '';

// Xây dựng câu query
$query = "SELECT DISTINCT truyen.id, truyen.ten, truyen.mo_ta, truyen.tac_gia, truyen.anh_bia 
          FROM truyen 
          LEFT JOIN truyen_theloai ON truyen.id = truyen_theloai.id_truyen 
          LEFT JOIN the_loai ON truyen_theloai.id_the_loai = the_loai.id 
          WHERE 1=1";

if (!empty($ten_the_loai) && $ten_the_loai != "Tất cả") {
    $query .= " AND the_loai.ten_the_loai = '$ten_the_loai'";
}

if (!empty($query_search)) {
    $query .= " AND truyen.ten LIKE '%$query_search%'";
}

$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
    $result[] = $row;
}

if (!empty($result)) {
    $arr = [
        'success' => true,
        'message' => "thanh cong",
        'result' => $result
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "khong co truyen",
        'result' => $result
    ];
}
echo json_encode($arr);

mysqli_close($conn);
?>