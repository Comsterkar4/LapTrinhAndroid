<?php
include "Connect.php";
$id_truyen = $_POST['id_truyen'];
$query = "SELECT truyen_theloai.id_truyen,the_loai.ten_the_loai FROM truyen_theloai LEFT JOIN the_loai ON the_loai.id = truyen_theloai.id_the_loai WHERE id_truyen = '$id_truyen'";
$data = mysqli_query($conn, $query);
$result = array();
while($row = mysqli_fetch_assoc($data)){
    $result[]= ($row);
}
if(!empty($result)){
    $arr = [
        'success' => true,
        'message' => "thanh cong",
        'result' => $result
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "khong thanh cong the loai",
        'result' => $result
    ];
}
echo json_encode($arr);
?>
