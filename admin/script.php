<?php
include('connect.php'); 
$searchTerm = $_GET['term'];
$sql = "SELECT * FROM paid_posts WHERE Title LIKE '%$searchTerm%' OR Content LIKE '%$searchTerm%' OR 	Subtitle LIKE '%$searchTerm%' OR Niche LIKE '%$searchTerm%'"; 
$sql2 = "SELECT * FROM posts WHERE Posts_Title LIKE '%$searchTerm%' OR Posts_Content LIKE '%$searchTerm%' OR subtitle LIKE '%$searchTerm%' OR Posts_Niche LIKE '%$searchTerm%'"; 
$sql3 = "SELECT * FROM unpublished_articles WHERE article_title LIKE '%$searchTerm%' OR article_content LIKE '%$searchTerm%' OR article_subtitle LIKE '%$searchTerm%' OR article_niche LIKE '%$searchTerm%'"; 

$result = $conn->query($sql); 
if ($result->num_rows > 0) {
  $tutorialData = array(); 
  while($row = $result->fetch_assoc()) {
   $data['id']    = $row['id']; 
   $data['value'] = $row['tutorial_name'];
   array_push($tutorialData, $data);
   } 
}
 echo json_encode($tutorialData);

 $result = $conn->query($sql2); 
if ($result->num_rows > 0) {
  $tutorialData = array(); 
  while($row = $result->fetch_assoc()) {
   $data['id']    = $row['id']; 
   $data['value'] = $row['tutorial_name'];
   array_push($tutorialData, $data);
  } 
}
 echo json_encode($tutorialData);

 $result = $conn->query($sql3); 
if ($result->num_rows > 0) {
  $tutorialData = array(); 
  while($row = $result->fetch_assoc()) {
   $data['id']    = $row['id']; 
   $data['value'] = $row['tutorial_name'];
   array_push($tutorialData, $data);
 } 
}
 echo json_encode($tutorialData);
?>