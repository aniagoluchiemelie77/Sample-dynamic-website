<?php
session_start();
require ("../connect.php");
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_type = $_GET['usertype'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Tech News and Articles website" />
    <meta name="keywords" content="Tech News, Content Writers, Content Strategy" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../admin.css"/>
	<title>Add Message</title>
</head>
<body>
    <?php 
        require("../extras/header2.php");
        if($post_id > 0){
            if($user_type == "Editor"){
                $geteditor_sql = "SELECT id, image, firstname FROM editor WHERE id = $post_id";
                $geteditor_result = $conn->query($geteditor_sql);
                if ($geteditor_result->num_rows > 0) {
                    $row = $geteditor_result->fetch_assoc();
                    echo "<div class='newpost_body2'>
                            <div class='nav_quicklinks'>
                                <a href = '../admin_homepage.php'>Home</a> > <p>Send Message to <span>".$row['firstname']."</span> </p>
                            </div>
                            <div class='message_div-container'>
                                <div class='message_div-container_subdiv'>
                                    <img src='../../".$row['image']."' alt='Editors Image'/>
                                    <div class='message_div-container_subdiv-imagebody'>
                                        <form id='updateForm' action='message.php' method='POST'>
                                            <div class='input_group'>
                                                <input name='subject' placeholder='Title..'/>
                                                <p><span>* </span>Optional</p>
                                            </div>
                                            <div class='input_group'>
                                                <label for='content'>Compose:</label>
                                                <textarea name='message'></textarea>
                                            </div>
                                            <input value='editor' style='display:none' name='user_type'/>
                                            <input value='".$row['id']."' style='display:none' name='user_id'/>
                                            <input type='submit' name='send_message' value='Send' class='btn send_messagebtn'/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
                }

            }
            if($user_type == "Writer"){
                $geteditor_sql = "SELECT id, image, firstname FROM writer WHERE id = $post_id";
                $geteditor_result = $conn->query($geteditor_sql);
                if ($geteditor_result->num_rows > 0) {
                    $row = $geteditor_result->fetch_assoc();
                    echo "<div class='newpost_body2'>
                            <div class='nav_quicklinks'>
                                <a href = '../admin_homepage.php'>Home</a> > <p>Send Message to <span>".$row['firstname']."</span> </p>
                            </div>
                            <div class='message_div-container'>
                                <div class='message_div-container_subdiv'>
                                    <img src='../../".$row['image']."' alt='Writers Image'/>
                                    <div class='message_div-container_subdiv-imagebody'>
                                        <form action='' method='post'>
                                            <div class='input_group'>
                                                <input name='subject' placeholder='Title..'/>
                                                <p><span>* </span>Optional</p>
                                            </div>
                                            <div class='input_group'>
                                                <label for='content'>Compose:</label>
                                                <textarea name='message'></textarea>
                                            </div>
                                            <input value='writer' style='display:none' name='user_type'/>
                                            <input value='".$row['id']."' style='display:none' name='user_id'/>
                                            <input type='submit' name='send_message' value='Send' class='btn send_messagebtn'/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
                }

            }
            if($user_type == "OtherUser"){
                $geteditor_sql = "SELECT id, image, firstname, role FROM otherwebsite_users WHERE id = $post_id";
                $geteditor_result = $conn->query($geteditor_sql);
                if ($geteditor_result->num_rows > 0) {
                    $row = $geteditor_result->fetch_assoc();
                    echo "<div class='newpost_body2'>
                            <div class='nav_quicklinks'>
                                <a href = '../admin_homepage.php'>Home</a> > <p>Send Message to <span>".$row['firstname']."</span> </p>
                            </div>
                            <div class='message_div-container'>
                                <div class='message_div-container_subdiv'>
                                    <img src='../../".$row['image']."' alt='Writers Image'/>
                                    <div class='message_div-container_subdiv-imagebody'>
                                        <form action='' method='post'>
                                            <div class='input_group'>
                                                <input name='subject' placeholder='Title..'/>
                                                <p><span>* </span>Optional</p>
                                            </div>
                                            <div class='input_group'>
                                                <label for='content'>Compose:</label>
                                                <textarea name='message'></textarea>
                                            </div>
                                            <input value='otherwebsite_users' style='display:none' name='user_type'/>
                                            <input value='".$row['id']."' style='display:none' name='user_id'/>
                                            <input type='submit' name='send_message' value='Send' class='btn send_messagebtn'/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
                }

            }
        }
    ?>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_POST['user_id'];
        $user_type = $_POST['user_type'];
        $message = $_POST['message'];
        $title = $_POST['subject'];
        $date = date('y-m-d');
        date_default_timezone_set('Africa/Lagos');
        $time = date('H:i:s'); 
        $stmt = $conn->prepare("INSERT INTO messages (user_id, user_type, title, message, Date, time) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $user_type, $title, $message, $date, $time);
        if ($stmt->execute()) {
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Published Successfully!";
        }
        $stmt->close();
        }
    ?>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
    <script src="../admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        document.getElementById('updateForm').addEventListener('submit', function(event) {
            event.preventDefault(); 
            var formData = new FormData(this);
            fetch('message.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Display the SweetAlert confirmatory message
                    Swal.fire({
                        title: 'Success!',
                        text: 'Table values updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to admin_homepage.php
                            window.location.href = '../admin_homepage.php';
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error updating the table.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }).catch(error => {
                Swal.fire({
                    title})})})

    </script>
</body>
</html>
<?php
/*
For the User's Interface
session_start();
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
// Fetch messages for the logged-in user
$stmt = $conn->prepare("SELECT message, created_at FROM messages WHERE user_id = ? AND user_type = ?");
$stmt->bind_param("is", $user_id, $user_type);
$stmt->execute();
$stmt->bind_result($message, $created_at);
?>
<h2>Your Messages</h2>
<ul>
    <?php while ($stmt->fetch()): ?>
        <li><?php echo $message; ?> <small>(<?php echo $created_at; ?>)</small></li>
    <?php endwhile; ?>
</ul>

<?php
$stmt->close();
$conn->close();
*/
?>