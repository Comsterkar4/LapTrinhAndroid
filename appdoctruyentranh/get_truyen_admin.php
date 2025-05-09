<?php
header('Content-Type: application/json');
include "Connect.php";

$id_truyen = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "SELECT id, ten, anh_bia, mo_ta, tac_gia FROM truyen";
if ($id_truyen > 0) {
    $query .= " WHERE id = '$id_truyen'";
}
$data = mysqli_query($conn, $query);
$result = array();

while ($row = mysqli_fetch_assoc($data)) {
    // Lấy thể loại
    $id = $row['id'];
    $genre_query = "SELECT tl.ten_the_loai FROM the_loai tl JOIN truyen_theloai tt ON tl.id = tt.id_the_loai WHERE tt.id_truyen = '$id'";
    $genre_data = mysqli_query($conn, $genre_query);
    $genres = array();
    while ($genre_row = mysqli_fetch_assoc($genre_data)) {
        $genres[] = $genre_row['ten_the_loai'];
    }
    $row['genres'] = $genres;
    $result[] = $row;
}

echo json_encode([
    'success' => true,
    'message' => 'thanh cong',
    'result' => $result
]);
mysqli_close($conn);
?>