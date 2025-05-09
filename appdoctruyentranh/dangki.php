<?php
include "connect.php";

$email = $_POST['email'];
$pass = $_POST['pass'];
$username = $_POST['username'];

$query = "SELECT * FROM nguoi_dung WHERE email = '$email'";
$data = mysqli_query($conn, $query);
$numrow = mysqli_num_rows($data);

if ($numrow > 0) {
    $arr = [
        'success' => false,
        'message' => "Email đã tồn tại"
    ];
} else {
    $query = "INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, email) VALUES ('$username', '$pass', '$email')";
    $data = mysqli_query($conn, $query);
    if ($data == true) {
        $arr = [
            'success' => true,
            'message' => "thanh cong"
        ];
    } else {
        $arr = [
            'success' => false,
            'message' => "khong thanh cong dang ki",
        ];
    }
}
echo json_encode($arr);
?>

