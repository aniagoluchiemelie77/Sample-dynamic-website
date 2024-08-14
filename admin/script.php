<?php
include('connect.php'); 
$searchTerm = $_GET['search'];
$tutorialData = array();
$sql = "SELECT * FROM paid_posts WHERE Title LIKE '%$searchTerm%' OR Content LIKE '%$searchTerm%' OR 	Subtitle LIKE '%$searchTerm%' OR Niche LIKE '%$searchTerm%'"; 
$sql2 = "SELECT * FROM posts WHERE Posts_Title LIKE '%$searchTerm%' OR Posts_Content LIKE '%$searchTerm%' OR subtitle LIKE '%$searchTerm%' OR Posts_Niche LIKE '%$searchTerm%'"; 
$sql3 = "SELECT * FROM unpublished_articles WHERE article_title LIKE '%$searchTerm%' OR article_content LIKE '%$searchTerm%' OR article_subtitle LIKE '%$searchTerm%' OR article_niche LIKE '%$searchTerm%'"; 

$result = $conn->query($sql); 
$result2 = $conn->query($sql2); 
$result3 = $conn->query($sql3); 
if ($result->num_rows or $result2->num_rows or $result3->num_rows > 0) { 
  while($row = $result->fetch_assoc()) {
   $data['id']    = $row['ID'] or $row['Post_Id'] or $row['article_id'] ; 
   $data['Title'] = $row['Title'] or $row['Posts_Title'] or $row['article_title'];
   $data['Niche'] = $row['Niche'] or $row['Posts_Niche'] or $row['article_niche'];
   $data['Content'] = $row['Content'] or $row['Posts_Content'] or $row['article_content'];
   $data['Subtitle'] = $row['Subtitle'] or $row['subtitle'] or $row['article_subtitle'];
   $data['image'] = $row['image'] or $row['Posts_Image'] or $row['article_image'];
   $data['date'] = $row['Post_date'] or $row['Posts_Date'] or $row['article_date'];
   $data['links'] = $row['link'] or $row['link'] or $row['article_link'];
   array_push($tutorialData, $data);
   header("location: extras/search.php");
   } 
}
else{
  echo"<script>alert('Search Input not found')</script>";
  header("location: admin_homepage.php");
}
 echo json_encode($tutorialData);
?>