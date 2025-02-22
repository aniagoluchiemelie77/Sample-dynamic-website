<?php
session_start();
require ("../connect.php");
include('../crudoperations.php');
$content = "";
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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../editor.css"/>
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<title>Create Category</title>
</head>
<body>
    <?php require("../extras/header2.php");?>
    <section class="about_section">
        <div class="page_links">
            <a href="../editor_homepage.php">Home</a> > <p>Pages</p> > <a href="../pages/categories.php">Categories</a> > <p> Create Category</p>
        </div>
        <form class="formcontainer" id="topicForm">
            <div class="head_paragraph">
                <h3>Create Category</h3>
            </div>
            <div class="formcontainer_subdiv">
                <div class="input_group">
                    <label for ="name">Category Name:</label>
                    <input type="text" name="topicName" id="topicName" required/>
                </div>
                <div class="input_group categorygroup">
                    <label for ="desc">Short Description:</label>
                    <textarea class="newpost_container_div7_subdiv2" name="topicDesc" id="myTextarea"></textarea>
                </div>
                <div class="newpost_container_div6 newpost_subdiv">
                    <label class="form__label" for="topicImg">Category Image:</label>
                    <div class="newpost_subdiv2">
                        <input class="form__input" name="topicImg" type="file" required/>
                        <p class="newpost_subdiv2-p leftp"><span>*</span>Optional</p>
                    </div>
                </div>
            </div>
            <input class="formcontainer_submit" value="Go" type="submit" onclick="submitForm()"/>
        </form>
    </section>
    <script src="../editor.js"></script>
</body>
</html>