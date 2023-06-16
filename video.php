<?php
include_once "db_operations.php";

$VideoUploadOK = 1;
$VideoFilePath = "/var/www/kaist.me/api/ksa/DS/video/".basename($_FILES['file']['name']);
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$dataArr = [];
echo $_FILES['file']['name'];
if (file_exists($VideoFilePath)) {
    echo "Sorry, video with the same name already exists.";
    $VideoUploadOK = 0;
}
if ($VideoUploadOK != 0)
{
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $VideoFilePath)) {
        $tempArr = [];
        $tempArr["res"] = "SUCCESS";
        array_push($dataArr, $tempArr);
        db_insert(
            "insert into songs (user_id, filename, video_id) values (:user_id, :filename, :video_id)",
            array("user_id" => $user_id, "filename" =>$_FILES['file']['name'], "video_id" => $user_id." - ".$_FILES['file']['name'])
        );

    } else {
        $tempArr = [];
        $tempArr["res"] = "ERROR";
        array_push($dataArr, $tempArr);
    }
}
echo json_encode($dataArr, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
return;