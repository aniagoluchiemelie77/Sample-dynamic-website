<?php
require("connect.php");
function getFaviconAndLogo()
{
    global $conn;
    $geticons_sql = "SELECT logo_imagepath, favicon_imagepath FROM website_logo ORDER BY id DESC LIMIT 1";
    $geticons_result = $conn->query($geticons_sql);
    if ($geticons_result->num_rows > 0) {
        while ($row = $geticons_result->fetch_assoc()) {
            $logo_path = $row['logo_imagepath'];
            $favicon_path = $row['favicon_imagepath'];
            return ["logo" => $logo_path, "favicon" => $favicon_path];
        }
    }
}
function cookieMessageAndVision()
{
    global $conn;
    $getmessages_sql = "SELECT cookie_consent, website_vision FROM website_messages ORDER BY id DESC LIMIT 1";
    $getmessages_result = $conn->query($getmessages_sql);
    if ($getmessages_result->num_rows > 0) {
        while ($row = $getmessages_result->fetch_assoc()) {
            $cookie_message = $row['cookie_consent'];
            $vision_message = $row['website_vision'];
            return ["cookie_message" => $cookie_message, "website_vision" => $vision_message];
        }
    }
}
function metaTitles()
{
    global $conn;
    $getmetatitles_sql = "SELECT * FROM meta_titles ORDER BY id";
    $getmetatitles_result = $conn->query($getmetatitles_sql);

    $meta_data = [];
    if ($getmetatitles_result->num_rows > 0) {
        while ($row = $getmetatitles_result->fetch_assoc()) {
            $meta_data[strtolower($row['page_name'])] = [
                "meta_name1" => $row['meta_name1'],
                "meta_name2" => $row['meta_name2'],
                "meta_name3" => $row['meta_name3'],
                "meta_name4" => $row['meta_name4'],
                "meta_name5" => $row['meta_name5'],
                "meta_content1" => $row['meta_content1'],
                "meta_content2" => $row['meta_content2'],
                "meta_content3" => $row['meta_content3'],
                "meta_content4" => $row['meta_content4'],
                "meta_content5" => $row['meta_content5']
            ];
        }
    }
    return $meta_data;
}
$meta_titles = metaTitles();
?>