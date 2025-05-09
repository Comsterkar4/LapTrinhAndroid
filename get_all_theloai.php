<?php
header('Content-Type: application/json');

include "Connect.php";

$query = "SELECT id, ten_the_loai FROM the_loai";
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
        'message' => "khong co the loai",
        'result' => $result
    ];
}
echo json_encode($arr);

mysqli_close($conn);
?>