<?php

include "connect.php";

$email = $_POST['email'];
$pass = $_POST['pass'];


$query = "SELECT id, ten_dang_nhap, mat_khau, email, ngay_tao, ho_ten, avatar, id_vai_tro FROM nguoi_dung WHERE email = '$email' AND mat_khau = '$pass'";
$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)){
    $result[] = ($row);
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
            'message' => "khong thanh cong dang nhap",
            'result' => $result
        ];
    }

echo json_encode($arr);
?>


