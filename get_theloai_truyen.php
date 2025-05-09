<?php
header('Content-Type: application/json');
include "Connect.php";

$id_truyen = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id_truyen <= 0) {
    echo json_encode(array("success" => false, "message" => "Id truyện không hợp lệ"));
    exit;
}
$query = "SELECT tl.id, tl.ten_the_loai 
          FROM the_loai tl 
          JOIN truyen_theloai tt ON tl.id = tt.id_the_loai 
          WHERE tt.id_truyen = '$id_truyen'";
$data = mysqli_query($conn, $query);
$result = array();

while ($row = mysqli_fetch_assoc($data)) {
    $row['id'] = (int)$row['id']; // Ép kiểu
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
        'message' => "khong co the loai",
        'result' => $result
    ];
}

echo json_encode($arr);
mysqli_close($conn);
?>