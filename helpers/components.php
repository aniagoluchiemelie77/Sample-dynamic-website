<?php 
function renderMessageForm($userType, $userId, $userImage, $userNameOrEmail, $formAction, $submitName)
{
    global $translations, $base_url;
    echo "<div class='newpost_body2'>
            <div class='nav_quicklinks'>
                <a href='" . $base_url . "admin_homepage.php'>" . $translations['home'] . "</a> > 
                <p>" . $translations['send_message_i'] . " <span>" . htmlspecialchars($userNameOrEmail) . "</span></p>
            </div>
            <div class='message_div-container'>
                <div class='message_div-container_subdiv'>
                    <img src='" . htmlspecialchars($userImage) . "' alt='" . $userType . " Image'/>
                    <div class='message_div-container_subdiv-imagebody'>
                        <form id='updateForm' action='" . $formAction . "' method='POST'>
                            <div class='input_group'>
                                <input name='subject' placeholder='" . $translations['message_title'] . "..' class='input_group_input'/>
                                <p><span>* </span>" . $translations['message_title_i'] . "</p>
                            </div>
                            <div class='input_group'>
                                <label for='content'>" . $translations['compose'] . ":</label>
                                <textarea name='message' id='myTextareaq'></textarea>
                            </div>
                            <input value='" . htmlspecialchars($userType) . "' style='display:none' name='user_type' type='text'/>
                            <input value='" . htmlspecialchars($userId) . "' style='display:none' name='user_id' type='text'/>
                            <input type='submit' name='" . $submitName . "' value='" . $translations['send_message'] . "' class='btn send_messagebtn'/>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
}
function renderPostTypeSelect($usertype, $translations) 
{
    $output = "<select class='newpost_subdiv2' name='Post_status'>";
    $output .= "<option class='newpost_subdiv4-option' value=''>-- " . $translations['post_type_option'] . " --</option>";
    if ($usertype === 'Admin') {
        $output .= "<option class='newpost_subdiv4-option' value='paid_posts'>" . $translations['paid_post'] . "</option>";
    }
    $output .= "<option class='newpost_subdiv4-option' value='posts'>" . $translations['article'] . "</option>";
    $output .= "<option class='newpost_subdiv4-option' value='news'>" . $translations['news'] . "</option>";
    $output .= "<option class='newpost_subdiv4-option' value='press_releases'>" . $translations['press_release'] . "</option>";
    $output .= "<option class='newpost_subdiv4-option' value='commentaries'>" . $translations['commentary'] . "</option>";
    $output .= "</select>";
    return $output;
}
function renderCategories() 
{
    global $conn;
    $output = "";

    $selectcategory = "SELECT name FROM topics ORDER BY id";
    $selectcategory_result = $conn->query($selectcategory);

    if ($selectcategory_result->num_rows > 0) {
        while ($row = $selectcategory_result->fetch_assoc()) {
            $category_names = $row['name'];
            $readableString = convertToReadable($category_names);
            $output .= "<option class='newpost_subdiv4-option' value='$readableString'>$readableString</option>";
        }
    }

    return $output;
}
function renderCreateNewPostForm($usertype, $translations, $base_url) 
{
    echo "<section class='newpost_body'>
        <form class='newpost_container' method='post' action='../../helpers/forms.php' enctype='multipart/form-data' id='postForm'>";
        if ($usertype === 'Admin'){
            echo "<div class='page_links'>
                    <a href='" . $base_url . "admin_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['create_new_post'] . "</p>
                </div>";
        }else{
            echo "<div class='page_links'>
                    <a href='" . $base_url . "editor_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['create_new_post'] . "</p>
                </div>";
        }
        echo"
            <div class='newpost_container_div1 newpost_subdiv'>
                <h1>" . $translations['new_post'] . "</h1>
            </div>
            <div class='newpost_container_div3 newpost_subdiv'>
                <label class='form__label' for='Post_Title'>" . $translations['post_title'] . ":</label>
                <div class='newpost_container_div3_subdiv2'>
                    <input class='form__input' name='Post_Title' type='text' />
                </div>
            </div>
            <div class='newpost_container_div3 newpost_subdiv'>
                <label class='form__label' for='Post_Sub_Title'>" . $translations['post_subtitle'] . ":</label>
                <div class='newpost_container_div3_subdiv2'>
                    <input class='form__input' name='Post_Sub_Title' type='text' />
                    <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['post_subtitle_p'] . "</p>
                </div>
            </div>
            <div class='newpost_container_div4 newpost_subdiv'>
                <label class='form__select' for='Post_Niche'>" . $translations['category'] . ":</label>
                <select class='newpost_subdiv2' name='Post_Niche'>
                    <option class='newpost_subdiv4-option' value=''>-- " . $translations['category_option'] . " --</option>
                    " . renderCategories() . "
                </select>
            </div>
            <div class='newpost_container_div4 newpost_subdiv'>
                <label class='form__select' for='Post_status'>" . $translations['post_type'] . ":</label>
                " . renderPostTypeSelect($usertype, $translations) . "
            </div>
            <div class='newpost_container_div5 newpost_subdiv'>
                <label class='form__label' for='Post_featured'>" . $translations['featured_audio_video'] . ":</label>
                <div class='newpost_container_div5_subdiv2'>
                    <input class='form__input' name='Post_featured' type='text' />
                    <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['featured_audio_video_p'] . "</p>
                </div>
            </div>
            <div class='newpost_container_div6'>
                <div class='newpost_container_div6_subdiv'>
                    <label class='form__label' for='Post_Image1'>" . $translations['post_image'] . "</label>
                    <div class='newpost_subdiv2'>
                        <input class='form__input' name='Post_Image1' type='file'/>
                        <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['post_image_p'] . "</p>
                    </div>
                </div>
                <p>------ " . $translations['or'] . " ------</p>
                <div class='newpost_container_div6_subdiv'>
                    <label class='form__label' for='Post_Image2'>" . $translations['image_url'] . ":</label>
                    <div class='newpost_container_div5_subdiv2'>
                        <input class='form__input' name='Post_Image2' type='text' placeholder='Enter Image Url...' />
                    </div>
                </div>
            </div>
            <div class='newpost_container_div7 newpost_subdiv'>
                <label class='form__label' for='Post_content'>" . $translations['post_content'] . ":</label>
                <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea'></textarea>
            </div>
            <div class='newpost_container_div3 newpost_subdiv'>
                <label class='form__label' for='author_firstname'>" . $translations['author_firstname'] . ":</label>
                <div class='newpost_container_div3_subdiv2'>
                    <input class='form__input' name='author_firstname' type='text' />
                    <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['author_firstname_p'] . "</p>
                </div>
            </div>
            <div class='newpost_container_div3 newpost_subdiv'>
                <label class='form__label' for='author_lastname'>" . $translations['author_lastname'] . ":</label>
                <div class='newpost_container_div3_subdiv2'>
                    <input class='form__input' name='author_lastname' type='text' />
                    <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['author_lastname_p'] . "</p>
                </div>
            </div>
            <div class='newpost_container_div7 newpost_subdiv'>
                <label class='form__label' for='about_author'>" . $translations['about_author'] . ":</label>
                <textarea class='newpost_container_div7_subdiv2b' name='about_author'></textarea>
                <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['about_author_p'] . "</p>
            </div>
            <div class='newpost_container_div9 newpost_subdiv'>
                <input class='form__submit_input' type='submit' value='" . $translations['publish'] . "' name='create_post' />
            </div>
            <div class='newpost_container_div10 newpost_subdiv'>
                <p class='form__submit_or centerp bold'>----------- " . $translations['or'] . " -----------</p>
            </div>
            <div class='newpost_container_div11 newpost_subdiv'>
                <label class='form__label bold' for='schedule'>" . $translations['schedule_publish'] . "</label>
                <input type='date' name='schedule' />
            </div>
        </form>
    </section>";
}
function renderCreateNewResourceFile($translations, $base_url, $usertype, $resource_type)
{
    echo "<section class='about_section'>";
    if ($usertype === 'Admin') {
        echo "<div class='page_links'>
                <a href='" . $base_url . "admin_homepage.php'>" . $translations['home'] . "</a> > <a href='../edit/frontend_features.php'> " . $translations['front_end_features'] . " </a> > <p> " . $translations['create_new_resource_file'] . "</p>
            </div>";
    } else {
        echo "<div class='page_links'>
                <a href='" . $base_url . "editor_homepage.php'>" . $translations['home'] . "</a> > <a href='../edit/frontend_features.php'> " . $translations['front_end_features'] . " </a> > <p> " . $translations['create_new_resource_file'] . "</p>
            </div>";
    }
    echo"
           <form class='formcontainer' id='topicForm' method='post' action='../../helpers/forms.php' enctype='multipart/form-data'>
               <div class='head_paragraph'>
                   <h3>" . $translations['create_new_resource_file'] . "</h3>
               </div>
               <div class='formcontainer_subdiv'>
                   <input type='hidden' name='resource_type' id='topicName' value='" . $resource_type . "' />
                   <div class='newpost_container_div6 newpost_subdiv'>
                       <label class='form__label' for='File'>" . $translations['upload_resource'] . ":</label>
                       <div class='newpost_subdiv2'>
                           <input class='form__input' name='File' type='file' />
                           <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['message_title_i'] . "</p>
                       </div>
                   </div>
                   <div class='input_group'>
                       <label for='resource_url'>" . $translations['resource_url'] . ":</label>
                       <input type='text' name='resource_url' id='topicName' />
                   </div>
                   <div class='input_group'>
                       <label for='resource_niche'>" . $translations['resource_niche'] . ":</label>
                       <input type='text' name='resource_niche' id='topicName' />
                   </div>
                   <div class='input_group'>
                       <label for='resource_title'>" . $translations['resource_title'] . ":</label>
                       <input type='text' name='resource_title' id='topicName' />
                   </div>
               </div>
               <input class='formcontainer_submit' value='" . $translations['save'] . "' type='submit' name='create_new_resource_file' />
           </form>
       </section>";
}
function renderCreateNewCategoryForm($base_url, $translations, $usertype)
{
    echo "<section class='about_section'>";
    if ($usertype === 'Admin') {
        echo "<div class='page_links'>
                <a href='" . $base_url . "admin_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['pages'] . "</p> > <a href='../pages/categories.php'>" . $translations['categories'] . "</a> > <p>" . $translations['create_category'] . "</p>
            </div>";
    } else {
        echo "<div class='page_links'>
                <a href='" . $base_url . "editor_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['pages'] . "</p> > <a href='../pages/categories.php'>" . $translations['categories'] . "</a> > <p>" . $translations['create_category'] . "</p>
            </div>";
    }
    echo"
            <form class='formcontainer' id='topicForm' action='../../helpers/forms.php' method='POST' enctype='multipart/form-data'>
                <div class='head_paragraph'>
                    <h3>" . $translations['create_category'] . "</h3>
                </div>
                <div class='formcontainer_subdiv'>
                    <div class='input_group'>
                        <label for='name'>" . $translations['category_name'] . ":</label>
                        <input type='text' name='topicName' id='topicName' />
                    </div>
                    <div class='newpost_container_div6 newpost_subdiv'>
                        <label class='form__label' for='topicImg'>" . $translations['category_image'] . ":</label>
                        <div class='newpost_subdiv2'>
                            <input class='form__input' name='topicImg' type='file' />
                            <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['message_title_i'] . "</p>
                        </div>
                    </div>
                </div>
                <input class='formcontainer_submit' name='create_page' value='" . $translations['save'] . "' type='submit' />
            </form>
        </section>";
}
function renderCreateNewUserForm($base_url, $translations, $usertype) 
{ 
    echo"<section class='about_section'>";
    if ($usertype === 'Admin') {
        echo "<div class='page_links'>
                <a href='" . $base_url . "admin_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['users'] . "</p> > <p>" . $translations['create_user'] . "</p>
            </div>";
    } else {
        echo "<div class='page_links'>
                <a href='" . $base_url . "editor_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['users'] . "</p> > <p>" . $translations['create_user'] . "</p>
            </div>";
    }
    echo"
        <form class='formcontainer' id='topicForm' method='post' action='../../helpers/forms.php' enctype='multipart/form-data'>
            <div class='head_paragraph'>
                <h3>" . $translations['create_user'] . "</h3>
            </div>
            <div class='formcontainer_subdiv'>
                <div class='input_group'>
                    <label for='user_firstname'>" . $translations['users_firstname'] . ":</label>
                    <input type='text' name='user_firstname' id='topicName' />
                </div>
                <div class='input_group'>
                    <label for='user_lastname'>" . $translations['users_lastname'] . ":</label>
                    <input type='text' name='user_lastname' id='topicName' />
                </div>
                <div class='input_group'>
                    <label for='user_email'>" . $translations['users_email'] . ":</label>
                    <input type='email' name='user_email' id='topicName' />
                </div>
                <div class='input_group'>
                    <label for='user_role'>" . $translations['users_role'] . ":</label>
                    <input type='text' name='user_role' id='topicName' />
                </div>
                <div class='newpost_container_div5 newpost_subdiv'>
                    <label class='form__label' for='user_linkedin_url'>" . $translations['users_linkedin_url'] . ":</label>
                    <div class='newpost_container_div5_subdiv2'>
                        <input class='form__input' name='user_linkedin_url' type='text' />
                        <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['users_linkedin_url_p'] . "</p>
                    </div>
                </div>
                <div class='newpost_container_div6 newpost_subdiv'>
                    <label class='form__label' for='Img'>" . $translations['users_photo'] . ":</label>
                    <div class='newpost_subdiv2'>
                        <input class='form__input' name='Img' type='file' />
                    </div>
                </div>
            </div>
            <input class='formcontainer_submit' value='" . $translations['save'] . "' type='submit' name='create_user' />
        </form>
    </section>";
};
function renderCreateNewWorkspace($base_url, $translations, $usertype)
{
    echo "<section class='newpost_body'>
            <form class='newpost_container' method='post' action=''../../helpers/forms.php' enctype='multipart/form-data' id='postForm'>";
    if ($usertype === 'Admin') {
        echo "<div class='page_links'>
                <a href='" . $base_url . "admin_homepage.php'>" . $translations['home'] . "</a> > <p>" .$translations['add_draft'] . "</p>
            </div>";
    }else {
        echo "<div class='page_links'>
                <a href='" . $base_url . "editor_homepage.php'>" . $translations['home'] . "</a> > <p>" .$translations['add_draft'] . "</p>
            </div>";
    }
    echo"
                <div class='newpost_container_div1 newpost_subdiv'>
                    <h1>" . $translations['new_draft'] . "</h1>
                </div>
                <div class='newpost_container_div3 newpost_subdiv'>
                    <label class='form__label' for='Post_Title'>" . $translations['post_title'] . ":</label>
                    <div class='newpost_container_div3_subdiv2'>
                        <input class='form__input' name='Post_Title' type='text' />
                    </div>
                </div>
                <div class='newpost_container_div3 newpost_subdiv'>
                    <label class='form__label' for='Post_Sub_Title'>" . $translations['post_subtitle'] .  ":</label>
                    <div class='newpost_container_div3_subdiv2'>
                        <input class='form__input' name='Post_Sub_Title' type='text' />
                        <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['post_subtitle_p'] . "</p>
                    </div>
                </div>
                <div class='newpost_container_div4 newpost_subdiv'>
                    <label class='form__select' for='Post_Niche'>" . $translations['category'] . ":</label>
                    " . renderCategories() . "
                </div>
                <div class='newpost_container_div5 newpost_subdiv'>
                    <label class='form__label' for='Post_featured'>" . $translations['featured_audio_video'] . ":</label>
                    <div class='newpost_container_div5_subdiv2'>
                        <input class='form__input' name='Post_featured' type='text' />
                        <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['featured_audio_video_p'] . "</p>
                    </div>
                </div>
                <div class='newpost_container_div6 newpost_subdiv'>
                    <label class='form__label' for='Post_Image'>" . $translations['post_image'] . "</label>
                    <div class='newpost_subdiv2'>
                        <input class='form__input' name='Post_Image' type='file' />
                        <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['post_image_p'] . "</p>
                    </div>
                </div>
                <div class='newpost_container_div7 newpost_subdiv'>
                    <label class='form__label' for='Post_content'>" . $translations['post_content'] . ":</label>
                    <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea2'></textarea>
                </div>
                <div class='newpost_container_div9 newpost_subdiv'>
                    <input class='form__submit_input' type='submit' value='" . $translations['save_draft'] . "' name='create_draft' />
                </div> 
            </form>
        </section>";
}
function renderCreateNewWriter($base_url, $translations, $usertype)
{
    echo "<section class='about_section'>";
    if ($usertype === 'Admin') {
        echo " <div class='page_links'>
                <a href='" .$base_url . "admin_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['users'] . "</p> > <p>" . $translations['create_writer'] . "</p>
            </div>";
    }else{
        echo "<div class='page_links'>
                <a href='" .$base_url . "editor_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['users'] . "</p> > <p>" . $translations['create_writer'] . "</p>
            </div>";
    }
    echo"
            <form class='formcontainer' id='topicForm' method='post' action='../../helpers/forms.php' enctype='multipart/form-data'>
                <div class='head_paragraph'>
                    <h3>" . $translations['create_writer'] . "</h3>
                </div>
                <div class='formcontainer_subdiv'>
                    <div class='input_group'>
                        <label for='writer_firstname'>" . $translations['writers_firstname'] . ":</label>
                        <input type='text' name='writer_firstname' id='topicName' />
                    </div>
                    <div class='input_group'>
                        <label for='writer_lastname'>" . $translations['writers_lastname'] . ":</label>
                        <input type='text' name='writer_lastname' id='topicName' />
                    </div>
                    <div class='input_group'>
                        <label for='writer_email'>" . $translations['writers_email']. ":</label>
                        <input type='email' name='writer_email' id='topicName' />
                    </div>
                    <div class='newpost_container_div6 newpost_subdiv'>
                        <label class='form__label' for='Img'>" . $translations['writers_image'] . ":</label>
                        <div class='newpost_subdiv2'>
                            <input class='form__input' name='Img' type='file' />
                        </div>
                    </div>
                </div>
                <input class='formcontainer_submit' value='" . $translations['save'] . "' type='submit' name='create_writer' />
            </form>
        </section>
    ";
}
function renderEditMetatitlesForm( $translations, $page_name)
{
    echo "<div class='editprofile_container'>
            <form class='newpost_container modal-content containerDiv' method='POST' action=' ' id='postForm' enctype='multipart/form-data'>
                <h2 class='sectioneer_form_header'>" . $translations['edit_metatitles_p']. " " . $page_name . "</h2>
            ";
    for ($i = 1; $i <= 5; $i++) {
        $meta_name = isset($_GET["meta_name$i"]) ? $_GET["meta_name$i"] : "";
        $meta_content = isset($_GET["meta_content$i"]) ? $_GET["meta_content$i"] : "";

        echo "<div class='newpost_container_div3 newpost_subdiv'>
                <label class='form__label'>Meta Name (" . $i . ")</label>
                <div class='newpost_container_div3_subdiv2'>
                    <input class='form__input' type='text' name='meta_name".$i."' value='".$meta_name."'/>
                </div>
            </div>
            <div class='newpost_container_div3 newpost_subdiv'>
                <label class='form__label'>Meta Content (".$i.")</label>
                <div class='newpost_container_div3_subdiv2'>
                    <input class='form__input' type='text' name='meta_content".$i."' value='".$meta_content."'/>
                </div>
            </div>";
    }
    echo"<div class='newpost_container_div9 newpost_subdiv'>
            <input class='form__submit_input' type='submit' value='" . $translations['save']."' name='edit_metatitle' />
        </div>
        </form>
    </div>";
}
function renderEditPostForm($base_url, $translations, $post_id, $title, $subtitle, $category, $link, $image, $foreign_imagePath, $content, $author_firstname, $author_lastname, $author_bio, $usertype)
{
    echo "<form class='newpost_container' method='post' action='../../helpers/forms.php' enctype='multipart/form-data' id='postForm'>";
    if ($usertype === 'Admin'){
        echo " <div class='page_links'>
                    <a href=" . $base_url . "admin_homepage.php>".$translations['home']."</a> > <p>".$translations['edit_post']."</p>
                </div>";
    }else{
        echo " <div class='page_links'>
                    <a href=" . $base_url . "editor_homepage.php>".$translations['home']."</a> > <p>".$translations['edit_post']."</p>
                </div>";
    }
    echo "  <div class='newpost_container_div1 newpost_subdiv'>
                <h1>".$translations['edit_post']."</h1>
            </div>
            <div class='newpost_container_div2 newpost_subdiv'>
                <input class='form__input input1' name='Post_Title' type='text' value='".$title."'/>
                <div class='newpost_container_div2_subdiv2'>
                    <input class='form__input' name='Post_Niche' type='text' value='".$category."'/>
                </div>
                </div>
                    <input type='hidden' name='table_type' value='paid_posts' type='text'/>
                    <input type='hidden' name='post_id' value='".$post_id."' type='text'/>
                    <div class='newpost_container_div3 newpost_subdiv'>
                        <label class='form__label' for='Post_Sub_Title'>".$translations['subtitle'].":</label>
                        <div class='newpost_container_div3_subdiv2'>
                            <input class='form__input' name='Post_Sub_Title' type='text' value='".$subtitle."'/>
                            <p class='newpost_subdiv2-p leftp'><span>*</span>".$translations['post_subtitle_p']."</p>
                        </div>
                        </div>
                        <div class='newpost_container_div5 newpost_subdiv'>
                            <label class='form__label' for='Post_featured'>".$translations['featured_audio_video'].":</label>
                            <div class='newpost_container_div5_subdiv2'>
                                <input class='form__input' name='Post_featured' type='text' value='".$link."'/>
                                <p class='newpost_subdiv2-p leftp'><span>*</span>".$translations['featured_audio_video_p']."</p>
                            </div>
                        </div>
                        <div class='newpost_container_div6 newpost_subdiv'>";
                if (!empty($image)) {
                    echo "  <div class='newpost_container_div6_subdiv1'>
                                <img src='".$image."' alt='Post Image'/>
                            </div>
                        ";
                } elseif (!empty($foreign_imagePath)) {
                    echo "  <div class='newpost_container_div6_subdiv1'>
                                <img src='".$foreign_imagePath."' alt='Post Image'/>
                            </div>
                        ";
                }
                echo "      <div class='newpost_container_div6_subdiv2'>
                                <label class='form__label' for='Post_Image'>".$translations['post_image'].": </label>
                                <div class='newpost_subdiv2'>
                                    <input class='form__input' name='Post_Image' type='file' />
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>".$translations['post_image_p']."</p>
                                </div>
                            </div>
                        </div>
                        <div class='newpost_container_div7 newpost_subdiv'>
                            <label class='form__label' for='Post_content'>".$translations['post_content'].":</label>
                            <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                $content
                            </textarea>
                        </div>";
                echo"
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_firstname'>".$translations['author_firstname'].":</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_firstname' type='text' value='".$author_firstname."'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>".$translations['author_firstname_p']."</p>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_lastname'>".$translations['author_lastname'].":</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_lastname' type='text' value='".$author_lastname."'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> ".$translations['author_lastname_p']."</p>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='about_author'>".$translations['about_author'].":</label>
                                <textarea class='newpost_container_div7_subdiv2b' name='about_author'>".$author_bio."</textarea>
                                <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[about_author_p]</p>
                            </div>
                            ";
                echo" <input class='form__submit_input btn' type='submit' value='".$translations['update']."' name='update_post' />
                        </form>";
}
function renderEditProfileForm($translations, $image, $firstname, $lastname, $username, $email, $bio, $address, $addresstwo, $city, $state, $country, $country_code, $mobile)
{
    echo"<div class='editprofile_container'>
            <form class='create_editor_container' action='../../helpers/forms.php' method='post' enctype='multipart/form-data'>
                <div class='createeditor_inputgroup'>
                    <h1 class='bigheader'>".$translations['edit_profile']."</h1>
                </div>
                <div class='newpost_container_div6 newpost_subdiv'>
                    <div class='newpost_container_div6_subdiv1'>
                        <img src='".$image."' alt='User Image' />
                    </div>
                    <div class='newpost_container_div6_subdiv2'>
                        <label class='form__label' for='Img'>".$translations['edit_image'].": </label>
                        <div class='newpost_subdiv2'>
                            <input class='form__input' name='Img' type='file' />
                        </div>
                    </div>
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile_firstname'>".$translations['firstname'].":</label>
                    <input class='createeditor_input' type='text' name='profile_firstname' value='".$firstname."' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile_lastname'>".$translations['lastname'].":</label>
                    <input class='createeditor_input' type='text' name='profile_lastname' value='".$lastname."' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile_username'>".$translations['username'].":</label>
                    <input class='createeditor_input' type='text' name='profile_username' value='".$username."' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile_email'>".$translations['email'].":</label>
                    <input class='createeditor_input' type='email' name='profile_email' value='".$email."' />
                </div>
                <div class='createeditor_inputgroup flexcolumn'>
                    <label class='createeditor_label rightmargin nooutline' for='profile_bio'>".$translations['bio'].":</label>
                    <textarea name='profile_bio' class='textarea' id='myTextarea4'>".$bio."</textarea>
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile-address1'>".$translations['address1'].":</label>
                    <input class='createeditor_input' type='text' name='profile-address1' value='".$address."' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile-address2'>".$translations['address2'].":</label>
                    <input class='createeditor_input' type='text' name='profile-address2' value='".$addresstwo."' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile-city'>".$translations['city'].":</label>
                    <input class='createeditor_input' type='text' name='profile-city' value='".$city."' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile-state'>".$translations['state'].":</label>
                    <input class='createeditor_input' type='text' name='profile-state' value='".$state."' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile-country'>".$translations['country'].":</label>
                    <input class='createeditor_input' type='text' name='profile-country' value='".$country."' />
                </div>
                <div class='createeditor_inputgroup'>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile-countrycode'>".$translations['country_code'].":</label>
                        <input class='createeditor_input' type='text' name='profile-countrycode' value='".$country_code."' />
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile-mobile'>".$translations['mobile'].":</label>
                        <input class='createeditor_input' type='number' name='profile-mobile' value='".$mobile."' />
                    </div>
                </div>
                <input class='createeditor_input-submit' value='".$translations['update']."' name='edit_profile' type='submit' />
            </form>
        </div>";
}
?>
