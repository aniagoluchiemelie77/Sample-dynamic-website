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
?>