<?php
$user_avatar = $_GET["user_avatar"];
$user_name = $_GET["user_name"];
$user_repos_count = $_GET["user_repos_count"];
$user_url = $_GET["user_url"];
$user_followers = $_GET["user_followers"];
$user_last_seen = $_GET["user_last_seen"];
$user_predominant_language = $_GET["user_predominant_language"];
$client_ip = $_SERVER['REMOTE_ADDR'];

// echo $user_avatar;
// echo "<br>";
// echo $user_name;
// echo "<br>";
// echo $user_repos_count;
// echo "<br>";
// echo $user_url;
// echo "<br>";
// echo $user_followers;
// echo "<br>";
// echo $user_last_seen;
// echo "<br>";
// echo $user_predominant_language;

// echo "<br>";
// echo $client_ip;
// echo "<br>";

$json_file_path = "/var/www/html/smart/history/".$client_ip.".json"; 
if (file_exists($json_file_path)){
    $array = array(
        "user_avatar" => $user_avatar,
        "user_name" => $user_name,
        "user_repos_count" => $user_repos_count,
        "user_url" => $user_url,
        "user_followers" => $user_followers,
        "user_last_seen" => $user_last_seen,
        "user_predominant_language" => $user_predominant_language
    );

    $last_array = json_decode(file_get_contents($json_file_path), true);

    array_push($last_array, $array);
    
    file_put_contents($json_file_path,json_encode($last_array));

}else{
    $array = array(array(
        "user_avatar" => $user_avatar,
        "user_name" => $user_name,
        "user_repos_count" => $user_repos_count,
        "user_url" => $user_url,
        "user_followers" => $user_followers,
        "user_last_seen" => $user_last_seen,
        "user_predominant_language" => $user_predominant_language
    ));

    file_put_contents($json_file_path,json_encode($array));
}
?>