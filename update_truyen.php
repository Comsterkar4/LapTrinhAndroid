<?php
header('Content-Type: application/json');
include "Connect.php";

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$ten = isset($_POST['ten']) ? mysqli_real_escape_string($conn, $_POST['ten']) : '';
$tac_gia = isset($_POST['tac_gia']) ? mysqli_real_escape_string($conn, $_POST['tac_gia']) : '';
$mo_ta = isset($_POST['mo_ta']) ? mysqli_real_escape_string($conn, $_POST['mo_ta']) : '';
$anh_bia = isset($_POST['anh_bia']) ? mysqli_real_escape_string($conn, $_POST['anh_bia']) : '';
$genres = isset($_POST['genres']) ? json_decode($_POST['genres'], true) : [];

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID truyện không hợp lệ']);
    exit;
}

$query = "UPDATE truyen SET ten='$ten', tac_gia='$tac_gia', mo_ta='$mo_ta', anh_bia='$anh_bia' WHERE id='$id'";
if (mysqli_query($conn, $query)) {
    mysqli_query($conn, "DELETE FROM truyen_theloai WHERE id_truyen='$id'");
    foreach ($genres as $genre) {
        $genre = mysqli_real_escape_string($conn, $genre);
        $genre_query = "SELECT id FROM the_loai WHERE ten_the_loai='$genre'";
        $genre_result = mysqli_query($conn, $genre_query);
        if ($row = mysqli_fetch_assoc($genre_result)) {
            $id_the_loai = $row['id'];
            mysqli_query($conn, "INSERT INTO truyen_theloai (id_truyen, id_the_loai) VALUES ('$id', '$id_the_loai')");
        }
    }
    echo json_encode(['success' => true, 'message' => 'Cập nhật thành công']);
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật']);
}

mysqli_close($conn);
?>