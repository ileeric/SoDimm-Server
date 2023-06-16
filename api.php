<?php
require_once "db_operations.php";


$apiName = isset($_GET['apiName']) ? $_GET['apiName'] : '';
if ($apiName == '') {
    $apiName = isset($_POST['apiName']) ? $_POST['apiName'] : '';
}
if ($apiName == 'list') {
    $ans = db_select("select * from songs");
    for ($i = 0; $i < count($ans); $i++)
        {
            $ans[$i]["filename"] = "https://kaist.me/api/ksa/DS/video/".$ans[$i]["filename"];
        }
    echo json_encode($ans, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    return;
}
else if ($apiName == 'uploadScore') {
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $filename = isset($_POST['filename']) ? $_POST['filename'] : '';
    $score = isset($_POST['score']) ? $_POST['score'] : '';
        db_insert(
        "insert into uploadedVid (video_id, user_id, score) values (:video_id, :user_id, :score)",
        array("video_id" =>$filename, "user_id" => $user_id, "score" => $score)
    );
    return;
}
else if ($apiName == 'getRanking') {
    $filename = isset($_POST['filename']) ? $_POST['filename'] : '';
    $ans = db_select("select user_id, score from uploadedVid where video_id = :video_id order by score DESC", array('video_id' => $filename));
    echo json_encode($ans, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    return;
}

