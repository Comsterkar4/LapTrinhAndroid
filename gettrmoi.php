<?php
include "Connect.php";
$query = "SELECT * FROM truyen ORDER BY ngay_dang DESC LIMIT 10";  // Semicolon added
$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
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
        'message' => "khong thanh cong moi",
        'result' => $result
    ];
}
echo json_encode($arr);