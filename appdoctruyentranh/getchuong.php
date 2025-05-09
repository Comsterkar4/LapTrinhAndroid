<?php
include "Connect.php";
$id_truyen = $_POST['id_truyen'];
$query = "SELECT id,truyen_id,so_chuong FROM chuong WHERE truyen_id = '$id_truyen'";
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
        'message' => "khong thanh cong chuong truyen",
        'result' => $result
    ];
}
echo json_encode($arr);
?>
