<?php
require('crudoperations.php');
if (!function_exists('renderMessageForm')) {
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
                        <form class='formC' id='updateForm' action='" . $formAction . "' method='POST' oninput='saveToLocalStorage()'>
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
                            <input id='formSubmitBtn' type='submit' name='" . $submitName . "' value='" . $translations['send_message'] . "' class='btn send_messagebtn'/>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
}
}
if (!function_exists('renderPostTypeSelect')) {
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
}
if (!function_exists('renderCategories')) {
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
}
if (!function_exists('renderCreateNewPostForm')) {
function renderCreateNewPostForm($usertype, $translations, $base_url)
{
    echo "<section class='newpost_body'>
        <form class='newpost_container' method='post' action='../../helpers/forms.php' enctype='multipart/form-data' id='postForm' oninput='saveToLocalStorage()'>";
    if ($usertype === 'Admin') {
        echo "<div class='page_links'>
                    <a href='" . $base_url . "admin_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['create_new_post'] . "</p>
                </div>";
    } else {
        echo "<div class='page_links'>
                    <a href='" . $base_url . "editor_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['create_new_post'] . "</p>
                </div>";
    }
    echo "
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
                <input class='form__submit_input' id='formSubmitBtn' type='submit' value='" . $translations['publish'] . "' name='create_post' />
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
}
if (!function_exists('renderCreateNewResourceFile')) {
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
    echo "
           <form class='formcontainer' oninput='saveToLocalStorage()' id='topicForm' method='post' action='../../helpers/forms.php' enctype='multipart/form-data'>
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
               <input id='formSubmitBtn' class='formcontainer_submit' value='" . $translations['save'] . "' type='submit' name='create_new_resource_file' />
           </form>
       </section>";
}
}
if (!function_exists('renderCreateNewCategoryForm')) {
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
    echo "
            <form class='formcontainer' id='topicForm' oninput='saveToLocalStorage()' action='../../helpers/forms.php' method='POST' enctype='multipart/form-data'>
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
                <input class='formcontainer_submit' id='formSubmitBtn' name='create_page' value='" . $translations['save'] . "' type='submit' />
            </form>
        </section>";
}
}
if (!function_exists('renderCreateNewUserForm')) {
function renderCreateNewUserForm($base_url, $translations, $usertype)
{
    echo "<section class='about_section'>";
    if ($usertype === 'Admin') {
        echo "<div class='page_links'>
                <a href='" . $base_url . "admin_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['users'] . "</p> > <p>" . $translations['create_user'] . "</p>
            </div>";
    } else {
        echo "<div class='page_links'>
                <a href='" . $base_url . "editor_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['users'] . "</p> > <p>" . $translations['create_user'] . "</p>
            </div>";
    }
    echo "
        <form class='formcontainer' oninput='saveToLocalStorage()' id='topicForm' method='post' action='../../helpers/forms.php' enctype='multipart/form-data'>
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
            <input id='formSubmitBtn' class='formcontainer_submit' value='" . $translations['save'] . "' type='submit' name='create_user' />
        </form>
    </section>";
};
}
if (!function_exists('renderCreateNewWorkspace')) {
function renderCreateNewWorkspace($base_url, $translations, $usertype)
{
    echo "<section class='newpost_body'>
            <form class='newpost_container' oninput='saveToLocalStorage()' method='post' action=''../../helpers/forms.php' enctype='multipart/form-data' id='postForm'>";
    if ($usertype === 'Admin') {
        echo "<div class='page_links'>
                <a href='" . $base_url . "admin_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['add_draft'] . "</p>
            </div>";
    } else {
        echo "<div class='page_links'>
                <a href='" . $base_url . "editor_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['add_draft'] . "</p>
            </div>";
    }
    echo "
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
                    <input class='form__submit_input' id='formSubmitBtn' type='submit' value='" . $translations['save_draft'] . "' name='create_draft' />
                </div> 
            </form>
        </section>";
}
}
if (!function_exists('renderCreateNewWriter')) {
function renderCreateNewWriter($base_url, $translations, $usertype)
{
    echo "<section class='about_section'>";
    if ($usertype === 'Admin') {
        echo " <div class='page_links'>
                <a href='" . $base_url . "admin_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['users'] . "</p> > <p>" . $translations['create_writer'] . "</p>
            </div>";
    } else {
        echo "<div class='page_links'>
                <a href='" . $base_url . "editor_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['users'] . "</p> > <p>" . $translations['create_writer'] . "</p>
            </div>";
    }
    echo "
            <form class='formcontainer' oninput='saveToLocalStorage()' id='topicForm' method='post' action='../../helpers/forms.php' enctype='multipart/form-data'>
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
                        <label for='writer_email'>" . $translations['writers_email'] . ":</label>
                        <input type='email' name='writer_email' id='topicName' />
                    </div>
                    <div class='newpost_container_div6 newpost_subdiv'>
                        <label class='form__label' for='Img'>" . $translations['writers_image'] . ":</label>
                        <div class='newpost_subdiv2'>
                            <input class='form__input' name='Img' type='file' />
                        </div>
                    </div>
                </div>
                <input class='formcontainer_submit' id='formSubmitBtn' value='" . $translations['save'] . "' type='submit' name='create_writer' />
            </form>
        </section>
    ";
}
}
if (!function_exists('renderEditMetatitlesForm')) {
function renderEditMetatitlesForm($translations, $page_name)
{
    echo "<div class='editprofile_container'>
            <form class='newpost_container modal-content containerDiv' method='POST' action=' ' id='postForm' enctype='multipart/form-data'>
                <h2 class='sectioneer_form_header'>" . $translations['edit_metatitles_p'] . " " . $page_name . "</h2>
            ";
    for ($i = 1; $i <= 5; $i++) {
        $meta_name = isset($_GET["meta_name$i"]) ? $_GET["meta_name$i"] : "";
        $meta_content = isset($_GET["meta_content$i"]) ? $_GET["meta_content$i"] : "";

        echo "<div class='newpost_container_div3 newpost_subdiv'>
                <label class='form__label'>Meta Name (" . $i . ")</label>
                <div class='newpost_container_div3_subdiv2'>
                    <input class='form__input' type='text' name='meta_name" . $i . "' value='" . $meta_name . "'/>
                </div>
            </div>
            <div class='newpost_container_div3 newpost_subdiv'>
                <label class='form__label'>Meta Content (" . $i . ")</label>
                <div class='newpost_container_div3_subdiv2'>
                    <input class='form__input' type='text' name='meta_content" . $i . "' value='" . $meta_content . "'/>
                </div>
            </div>";
    }
    echo "<div class='newpost_container_div9 newpost_subdiv'>
            <input class='form__submit_input' type='submit' value='" . $translations['save'] . "' name='edit_metatitle' />
        </div>
        </form>
    </div>";
}
}
if (!function_exists('renderEditPostForm')) {
function renderEditPostForm($base_url, $translations, $post_id, $title, $subtitle, $category, $link, $image, $foreign_imagePath, $content, $author_firstname, $author_lastname, $author_bio, $usertype)
{
    echo "<form class='newpost_container' method='post' action='../../helpers/forms.php' enctype='multipart/form-data' id='postForm'>";
    if ($usertype === 'Admin') {
        echo " <div class='page_links'>
                    <a href=" . $base_url . "admin_homepage.php>" . $translations['home'] . "</a> > <p>" . $translations['edit_post'] . "</p>
                </div>";
    } else {
        echo " <div class='page_links'>
                    <a href=" . $base_url . "editor_homepage.php>" . $translations['home'] . "</a> > <p>" . $translations['edit_post'] . "</p>
                </div>";
    }
    echo "  <div class='newpost_container_div1 newpost_subdiv'>
                <h1>" . $translations['edit_post'] . "</h1>
            </div>
            <div class='newpost_container_div2 newpost_subdiv'>
                <input class='form__input input1' name='Post_Title' type='text' value='" . $title . "'/>
                <div class='newpost_container_div2_subdiv2'>
                    <input class='form__input' name='Post_Niche' type='text' value='" . $category . "'/>
                </div>
                </div>
                    <input type='hidden' name='table_type' value='paid_posts' type='text'/>
                    <input type='hidden' name='post_id' value='" . $post_id . "' type='text'/>
                    <div class='newpost_container_div3 newpost_subdiv'>
                        <label class='form__label' for='Post_Sub_Title'>" . $translations['subtitle'] . ":</label>
                        <div class='newpost_container_div3_subdiv2'>
                            <input class='form__input' name='Post_Sub_Title' type='text' value='" . $subtitle . "'/>
                            <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['post_subtitle_p'] . "</p>
                        </div>
                        </div>
                        <div class='newpost_container_div5 newpost_subdiv'>
                            <label class='form__label' for='Post_featured'>" . $translations['featured_audio_video'] . ":</label>
                            <div class='newpost_container_div5_subdiv2'>
                                <input class='form__input' name='Post_featured' type='text' value='" . $link . "'/>
                                <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['featured_audio_video_p'] . "</p>
                            </div>
                        </div>
                        <div class='newpost_container_div6 newpost_subdiv'>";
    if (!empty($image)) {
        echo "  <div class='newpost_container_div6_subdiv1'>
                                <img src='" . $image . "' alt='Post Image'/>
                            </div>
                        ";
    } elseif (!empty($foreign_imagePath)) {
        echo "  <div class='newpost_container_div6_subdiv1'>
                                <img src='" . $foreign_imagePath . "' alt='Post Image'/>
                            </div>
                        ";
    }
    echo "      <div class='newpost_container_div6_subdiv2'>
                                <label class='form__label' for='Post_Image'>" . $translations['post_image'] . ": </label>
                                <div class='newpost_subdiv2'>
                                    <input class='form__input' name='Post_Image' type='file' />
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['post_image_p'] . "</p>
                                </div>
                            </div>
                        </div>
                        <div class='newpost_container_div7 newpost_subdiv'>
                            <label class='form__label' for='Post_content'>" . $translations['post_content'] . ":</label>
                            <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                $content
                            </textarea>
                        </div>";
    echo "
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_firstname'>" . $translations['author_firstname'] . ":</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_firstname' type='text' value='" . $author_firstname . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>" . $translations['author_firstname_p'] . "</p>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_lastname'>" . $translations['author_lastname'] . ":</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_lastname' type='text' value='" . $author_lastname . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> " . $translations['author_lastname_p'] . "</p>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='about_author'>" . $translations['about_author'] . ":</label>
                                <textarea class='newpost_container_div7_subdiv2b' name='about_author'>" . $author_bio . "</textarea>
                                <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[about_author_p]</p>
                            </div>
                            ";
    echo " <input class='form__submit_input btn' type='submit' value='" . $translations['update'] . "' name='update_post' />
                        </form>";
}
}
if (!function_exists('renderEditProfileForm')) {
function renderEditProfileForm($translations, $image, $firstname, $lastname, $username, $email, $bio, $address, $addresstwo, $city, $state, $country, $country_code, $mobile)
{
    echo "<div class='editprofile_container'>
            <form class='create_editor_container' action='../../helpers/forms.php' method='post' enctype='multipart/form-data'>
                <div class='createeditor_inputgroup'>
                    <h1 class='bigheader'>" . $translations['edit_profile'] . "</h1>
                </div>
                <div class='newpost_container_div6 newpost_subdiv'>
                    <div class='newpost_container_div6_subdiv1'>
                        <img src='" . $image . "' alt='User Image' />
                    </div>
                    <div class='newpost_container_div6_subdiv2'>
                        <label class='form__label' for='Img'>" . $translations['edit_image'] . ": </label>
                        <div class='newpost_subdiv2'>
                            <input class='form__input' name='Img' type='file' />
                        </div>
                    </div>
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile_firstname'>" . $translations['firstname'] . ":</label>
                    <input class='createeditor_input' type='text' name='profile_firstname' value='" . $firstname . "' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile_lastname'>" . $translations['lastname'] . ":</label>
                    <input class='createeditor_input' type='text' name='profile_lastname' value='" . $lastname . "' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile_username'>" . $translations['username'] . ":</label>
                    <input class='createeditor_input' type='text' name='profile_username' value='" . $username . "' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile_email'>" . $translations['email'] . ":</label>
                    <input class='createeditor_input' type='email' name='profile_email' value='" . $email . "' />
                </div>
                <div class='createeditor_inputgroup flexcolumn'>
                    <label class='createeditor_label rightmargin nooutline' for='profile_bio'>" . $translations['bio'] . ":</label>
                    <textarea name='profile_bio' class='textarea' id='myTextarea4'>" . $bio . "</textarea>
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile-address1'>" . $translations['address1'] . ":</label>
                    <input class='createeditor_input' type='text' name='profile-address1' value='" . $address . "' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile-address2'>" . $translations['address2'] . ":</label>
                    <input class='createeditor_input' type='text' name='profile-address2' value='" . $addresstwo . "' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile-city'>" . $translations['city'] . ":</label>
                    <input class='createeditor_input' type='text' name='profile-city' value='" . $city . "' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile-state'>" . $translations['state'] . ":</label>
                    <input class='createeditor_input' type='text' name='profile-state' value='" . $state . "' />
                </div>
                <div class='createeditor_inputgroup'>
                    <label class='createeditor_label rightmargin' for='profile-country'>" . $translations['country'] . ":</label>
                    <input class='createeditor_input' type='text' name='profile-country' value='" . $country . "' />
                </div>
                <div class='createeditor_inputgroup'>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile-countrycode'>" . $translations['country_code'] . ":</label>
                        <input class='createeditor_input' type='text' name='profile-countrycode' value='" . $country_code . "' />
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile-mobile'>" . $translations['mobile'] . ":</label>
                        <input class='createeditor_input' type='number' name='profile-mobile' value='" . $mobile . "' />
                    </div>
                </div>
                <input class='createeditor_input-submit' value='" . $translations['update'] . "' name='edit_profile' type='submit' />
            </form>
        </div>";
}
}
if (!function_exists('renderWebsiteLogoFaviconForm')) {
function renderWebsiteLogoFaviconForm()
{
    global $conn;
    $output = "";
    $output .= '<form class="frontend_div sectioneer_form" action="../../helpers/forms.php" method="POST" enctype="multipart/form-data">';
    $selectwebsite_logo = "SELECT id, logo_imagepath, favicon_imagepath FROM website_logo ORDER BY id DESC LIMIT 1";
    $selectwebsite_logo_result = $conn->query($selectwebsite_logo);
    if ($selectwebsite_logo_result->num_rows > 0) {
        while ($row = $selectwebsite_logo_result->fetch_assoc()) {
            $logo_image = $row['logo_imagepath'];
            $favicon_image = $row['favicon_imagepath'];
            $id = $row['id'];
            $_SESSION['logo_id'] = $row['id'];
            $output .= '<div class="sectioneer_form_container" id="consent-data" data-id="' . $id . '">
                            <div class="sectioneer_form_container_subdiv2">
                                <h1 class="sectioneer_form_header">Edit Website Logo</h1>
                                <div class="sectioneer_form_container_subdiv2_subdiv">
                                    <img src="' . $logo_image . '" alt="Website Logo">
                                    <a class="add_div" name="website_logo" onclick="selectImage(\'website_logo\', ' . $id . ')">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        <p>Edit Logo</p>
                                    </a>
                                </div>
                            </div>
                            <div class="sectioneer_form_container_subdiv2">
                                <h1 class="sectioneer_form_header">Edit Favicon</h1>
                                <div class="sectioneer_form_container_subdiv2_subdiv">
                                    <img src="../../' . $favicon_image . '" alt="Favicon Image">
                                    <a class="add_div" name="website_favicon" onclick="selectImage(\'website_favicon\', ' . $id . ')">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        <p>Edit Favicon</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>';
        }
    }
    return $output;
}
}
if (!function_exists('renderCookieConsentAndWebVisionForm')) {
function renderCookieConsentAndWebVisionForm($translations)
{
    global $conn;
    $output = '';
    $output .= '<form class="frontend_div sectioneer_form div_special" action="../../helpers/forms.php" method="POST" enctype="multipart/form-data">
                <div class="sectioneer_form_container">';
    $website_messages_sql = "SELECT id, cookie_consent, website_vision FROM website_messages ORDER BY id DESC LIMIT 1";
    $website_messages_result = $conn->query($website_messages_sql);
    if ($website_messages_result->num_rows > 0) {
        while ($row = $website_messages_result->fetch_assoc()) {
            $cookie_message = $row['cookie_consent'];
            $website_vision_message = $row['website_vision'];
            $id = $row['id'];
            $_SESSION['message_id'] = $row['id'];
            $output .= " <div class='sectioneer_form_container_subdiv2'>
                            <h1 class='sectioneer_form_header'>" . $translations['edit_cookie'] . "</h1>
                            <textarea name='cookie_consent' id='myTextarea6c'>" . $cookie_message . "</textarea>
                        </div>
                        <div class='sectioneer_form_container_subdiv2' id='consent-data' data-id='" . $id . "'>
                            <h1 class='sectioneer_form_header'>" . $translations['edit_webdescription'] . "</h1>
                            <textarea name='description' id='myTextarea6b'>" . $website_vision_message . "</textarea>
                        </div>";
        }
    }
    $output .= '</div>
                <input class="btn" type="submit" value="' . $translations['save'] . '" name="change_frontend_messages" />
            </form>';
    return $output;
}
}
if (!function_exists('renderCreateNewResourceTypeForm')) {
function renderCreateNewResourceTypeForm($translations)
{
    global $conn;
    $output = '';
    $output .= '<div class="frontend_div sectioneer_div">
                <h1 class="sectioneer_form_header">' . $translations['resources'] . '</h1>';
    $getresource_sql = " SELECT id, resource_name FROM resources ORDER BY id";
    $getresource_result = $conn->query($getresource_sql);
    if ($getresource_result->num_rows > 0) {
        $output .= "<div class='sectioneer_div_subdiv'>";
        while ($row = $getresource_result->fetch_assoc()) {
            $resource_name = $row['resource_name'];
            $resource_id = $row['id'];
            $readableString = convertToReadable2($resource_name);
            $resource_name2 = removeUnderscore2($resource_name);
            $output .=  "<div class='div'>
                            <p>" . $readableString . "</p>
                            <div class='sectioneer_div_subdiv_subdiv'>
                                <a class='' onclick='confirmDeleteResource(" . $resource_id . ", \"" . htmlspecialchars(".$resource_name2.", ENT_QUOTES) . "\")'>
                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                </a>
                                <a href='../view_all/resources.php?resource_name=" . $resource_name . "'>
                                    <i class='fa fa-pencil' aria-hidden='true'></i>
                                </a>
                            </div>
                        </div>";
        }
        $output .=  "<a class='add_div' onclick='displayExit()'>
                        <i class='fa fa-plus' aria-hidden='true'></i>
                        <p>" . $translations['add_resource'] . "</p>
                    </a>
                </div>";
    }
    $output .= '</div>';
    return $output;
}
}
if (!function_exists('renderCreateNewPageForm')) {
function renderCreateNewPageForm($translations)
{
    global $conn;
    $output = '';
    $output .= '<div class="frontend_div sectioneer_div">
                <h1 class="sectioneer_form_header">' . $translations['pages'] . '</h1>';
    $getpages_sql = " SELECT id, page_name FROM pages ORDER BY id";
    $getpages_result = $conn->query($getpages_sql);
    if ($getpages_result->num_rows > 0) {
        $output .= "<div class='sectioneer_div_subdiv'>";
        while ($row = $getpages_result->fetch_assoc()) {
            $page_name = $row['page_name'];
            $page_name2 = removeHyphen2($page_name);
            $page_id = $row['id'];
            $readableString = convertToReadable($page_name);
            $output .=  "<div class='page_div'>
                            <p>" . $readableString . "</p>
                            <a class='' onclick='confirmDeletePage(" . $page_id . ", \"" . htmlspecialchars(".$page_name2.", ENT_QUOTES) . "\")'>
                                <i class='fa fa-trash' aria-hidden='true'></i>
                            </a>
                        </div>";
        }
        $output .=  "<a class='add_div' onclick='displayExit2()'>
                        <i class='fa fa-plus' aria-hidden='true'></i>
                        <p>" . $translations['add_page'] . "</p>
                    </a>
                </div>";
    }
    $output .= '</div>';
    return $output;
}
}
if (!function_exists('renderNewPagePopupForm')) {
function renderNewPagePopupForm($translations)
{
    $output = '';
    $output .= '<div class="logout_alert" id="logoutAlert2">
                    <form class="newpost_container" method="post" action="../../helpers/forms.php" id="postForm" enctype="multipart/form-data">
                        <a class="logout_alert_cancel" onclick="cancelExit2()">
                            <i class="fa fa-times popup_close1" aria-hidden="true"></i>
                        </a>
                        <div class="newpost_container_div1 newpost_subdiv">
                            <h1 class="sectioneer_form_header">' . $translations['add_page'] . '</h1>
                        </div>
                        <div class="newpost_container_div3 newpost_subdiv">
                            <label class="form__label" for="page_name">' . $translations['page_name'] . '</label>
                            <div class="newpost_container_div3_subdiv2">
                                <input class="form__input" name="page_name" type="text" />
                            </div>
                        </div>
                        <div class="newpost_container_div9 newpost_subdiv">
                            <input class="form__submit_input" type="submit" value="' . $translations['save'] . '" name="add_page" />
                        </div>
                    </form>
                </div>';
    return $output;
}
}
if (!function_exists('renderNewResourceTypePopupForm')) {
function renderNewResourceTypePopupForm($translations)
{
    $output = '';
    $output .= '<div class="logout_alert" id="logoutAlert">
                    <form class="newpost_container" method="POST" action="../../helpers/forms.php" id="postForm" enctype="multipart/form-data">
                        <a class="logout_alert_cancel" onclick="cancelExit()">
                            <i class="fa fa-times popup_close1" aria-hidden="true"></i>
                        </a>
                        <div class="newpost_container_div1 newpost_subdiv">
                            <h1 class="sectioneer_form_header">' . $translations['add_resource'] . '</h1>
                        </div>
                        <div class="newpost_container_div3 newpost_subdiv">
                            <label class="form__label" for="resource_type">' . $translations['resource_type'] . '</label>
                            <div class="newpost_container_div3_subdiv2">
                                <input class="form__input" name="resource_type" type="text" />
                            </div>
                        </div>
                        <div class="newpost_container_div6">
                            <div class="newpost_container_div6_subdiv">
                                <label class="form__label" for="resource_image">' . $translations['upload_resource'] . '</label>
                                <div class="newpost_subdiv2">
                                    <input class="form__input" name="resource_image" type="file" />
                                    <p class="newpost_subdiv2-p leftp"><span>*</span>' . $translations['message_title_i'] . '</p>
                                </div>
                            </div>
                            <div class="newpost_container_div6_subdiv">
                                <label class="form__label" for="resource_url">' . $translations['resource_url'] . ':</label>
                                <div class="newpost_container_div5_subdiv2">
                                    <input class="form__input" name="resource_url" type="text" placeholder="' . $translations['require'] . '" />
                                </div>
                            </div>
                            <div class="newpost_container_div6_subdiv">
                                <label class="form__label" for="resource_url">' . $translations['resource_niche'] . ':</label>
                                <div class="newpost_container_div5_subdiv2">
                                    <input class="form__input" name="resource_niche" type="text" placeholder="' . $translations['resource_niche_p'] . '..." />
                            </div>
                        </div>
                        <div class="newpost_container_div6_subdiv">
                            <label class="form__label" for="resource_url">' . $translations['resource_title'] . ':</label>
                            <div class="newpost_container_div5_subdiv2">
                                <input class="form__input" name="resource_title" type="text" placeholder="' . $translations['resource_title_p'] . '..." />
                            </div>
                        </div>
                    </div>
                    <div class="newpost_container_div9 newpost_subdiv">
                        <input class="form__submit_input" type="submit" value="' . $translations['save'] . '" name="add_resource" />
                    </div>
                </form>
            </div>';
    return $output;
}
}
if (!function_exists('renderEditFrontendFeaturespage')) {
function renderEditFrontendFeaturespage($translations, $base_url, $usertype, $logo)
{
    echo '' . renderNewResourceTypePopupForm($translations) . '';
    if ($usertype === 'Admin') {
        echo '' . renderNewPagePopupForm($translations) . '';
    }
    // @phpstan-ignore-next-line
    require("../extras/header3.php");
    echo '
    <section class="sectioneer">';
    if ($usertype === 'Admin') {
        echo  '<div class="page_links">
                <a href="' . $base_url . 'admin_homepage.php">' . $translations['home'] . '</a> > <p>' . $translations['settings'] . '</p> > <p>' . $translations['edit_frontend_title'] . '</p>
              </div>
        ' . renderWebsiteLogoFaviconForm() . '
        ' . renderCookieConsentAndWebVisionForm($translations) . '
        ';
    } else if ($usertype === 'Editor') {
        echo  '<div class="page_links">
                <a href="' . $base_url . 'editor_homepage.php">' . $translations['home'] . '</a> > <p>' . $translations['settings'] . '</p> > <p>' . $translations['edit_frontend_title'] . '</p>
              </div>';
    }
    echo '' . renderCreateNewResourceTypeForm($translations) . '';
    if ($usertype === 'Admin') {
        echo '' . renderCreateNewPageForm($translations) . '';
    }
    echo '</section>';
}
}
if (!function_exists('renderEditResourcefileForm')) {
function renderEditResourcefileForm($translations, $resource_name_uc, $resource_name, $id, $logo)
{
    global $conn;
    // @phpstan-ignore-next-line
    require("../extras/header3.php");
    $get_resource_file = "SELECT * FROM $resource_name WHERE id = $id";
    $get_resource_result = $conn->query($get_resource_file);
    if ($get_resource_result->num_rows > 0) {
        $resource_file = $get_resource_result->fetch_assoc();
        $name = $resource_file['name'];
        $resource_path = $resource_file['resource_path'];
        $date_added = $resource_file['date_added'];
        $date_added = formatDate($date_added);
        $time_added = $resource_file['time_added'];
        $time_added = formatTime($time_added);
        $niche = $resource_file['niche'];
        $title  = $resource_file['title'];
        echo    "<div class='editprofile_container'>
                    <form class='create_editor_container' action='../../helpers/forms.php' method='post' enctype='multipart/form-data'>
                        <div class='createeditor_inputgroup'>
                            <h1 class='bigheader'>" . $translations['edit_resource_file'] . " (" . $resource_name_uc . ") </h1>
                        </div>
                        <div class='newpost_container_div6 newpost_subdiv'>
                            <div class='newpost_container_div6_subdiv2'>
                                <label class='form__label' for='File'>" . $translations['edit_resource_path'] . ": </label>
                                <div class='newpost_subdiv2'>
                                    <input class='form__input' name='File' type='file'/>
                                </div>
                            </div>
                        </div>
                        <input name='resource_type' type='hidden' value='" . $resource_name . "'/>
                        <input name='resource_type_id' type='hidden' value='" . $id . "'/>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='resource_path'>" . $translations['resource_path'] . ":</label>
                            <input class='createeditor_input' type='text' name='resource_path' value='" . $resource_path . "'/>
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='resource_title'>" . $translations['title'] . ":</label>
                            <input class='createeditor_input' type='text' name='resource_title' value='" . $title . "'/>
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='resource_niche'>" . $translations['niche'] . ":</label>
                            <input class='createeditor_input' type='text' name='resource_niche' value='" . $niche . "'/>
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='resource_name'>" . $translations['resource_name'] . ":</label>
                            <input class='createeditor_input' type='text' name='resource_name' value='" . $name . "'/>
                        </div>
                        <div class='createeditor_inputgroup'>
                            <p>
                                <span>" . $translations['date_added'] . ":</span>" . $date_added . "
                            </p>
                            <p>
                                <span>" . $translations['time_added'] . ":</span>" . $time_added . "
                            </p>
                        </div>
                        <input class='createeditor_input-submit' value='" . $translations['save'] . "' name='edit_resource_file' type='submit'/>
                    </form>
                </div>";
    }
}
}
if (!function_exists('renderEditUserProfileForm')) {
function renderEditUserProfileForm($usertype, $id, $translations, $logo)
{
    global $conn;
    // @phpstan-ignore-next-line
    require("../extras/header3.php");
    if ($usertype == "Editor") {
        $getuser_sql = "SELECT * FROM editor WHERE id = $id";
        $getuser_result = $conn->query($getuser_sql);
        if ($getuser_result->num_rows > 0) {
            $user = $getuser_result->fetch_assoc();
            $firstname = $user['firstname'];
            $username = $user['username'];
            $lastname = $user['lastname'];
            $image = $user['image'];
            $bio = $user['bio'];
            $email = $user['email'];
            $country = $user['country'];
            $mobile = $user['mobile'];
            $state = $user['state'];
            $city = $user['city'];
            $address1 = $user['address1'];
            $address2 = $user['address2'];
            $country_code = $user['country_code'];
            echo "<div class='editprofile_container'>
                <form class='create_editor_container' action='../../helpers/forms.php' method='post' enctype='multipart/form-data'>
                    <div class='createeditor_inputgroup'>
                        <h1 class='bigheader'>" . $translations['edit_user'] . " (Editor) </h1>
                    </div>
                    <div class='newpost_container_div6 newpost_subdiv'>
                        <div class='newpost_container_div6_subdiv1'>
                            <img src='" . $image . "' alt='Post Image' />
                        </div>
                        <div class='newpost_container_div6_subdiv2'>
                            <label class='form__label' for='Img'>" . $translations['edit_user_image'] . ": </label>
                            <div class='newpost_subdiv2'>
                                <input class='form__input' name='Img' type='file' />
                            </div>
                        </div>
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile_firstname'>" . $translations['firstname'] . ":</label>
                        <input class='createeditor_input' type='text' name='profile_firstname' value='" . $firstname . "' />
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile_lastname'>" . $translations['lastname'] . ":</label>
                        <input class='createeditor_input' type='text' name='profile_lastname' value='" . $lastname . "' />
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile_username'>" . $translations['username'] . ":</label>
                        <input class='createeditor_input' type='text' name='profile_username' value='" . $username . "' />
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile_email'>" . $translations['email'] . ":</label>
                        <input class='createeditor_input' type='email' name='profile_email' value='" . $email . "' />
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin nooutline' for='profile_bio'>" . $translations['bio'] . ":</label>
                        <textarea name='profile_bio' class='textarea' id='myTextarea5'>" . $bio . "</textarea>
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile-address1'>" . $translations['address1'] . ":</label>
                        <input class='createeditor_input' type='text' name='profile-address1' value='" . $address1 . "' />
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile-address2'>" . $translations['address2'] . ":</label>
                        <input class='createeditor_input' type='text' name='profile-address2' value='" . $address2 . "' />
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile-city'>" . $translations['city'] . ":</label>
                        <input class='createeditor_input' type='text' name='profile-city' value='" . $city . "' />
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile-state'>" . $translations['state'] . ":</label>
                        <input class='createeditor_input' type='text' name='profile-state' value='" . $state . "' />
                    </div>
                    <input class='createeditor_input' type='hidden' name='profile-id' value='" . $id . "' />
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile-country'>" . $translations['country'] . ":</label>
                        <input class='createeditor_input' type='text' name='profile-country' value='" . $country . "' />
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile-countrycode'>" . $translations['country_code'] . ":</label>
                        <input class='createeditor_input' type='text' name='profile-countrycode' value='" . $country_code . "' />
                    </div>
                    <div class='createeditor_inputgroup'>
                        <label class='createeditor_label rightmargin' for='profile-mobile'>" . $translations['mobile'] . ":</label>
                        <input class='createeditor_input' type='number' name='profile-mobile' value='" . $mobile . "' />
                    </div>
                    <input class='createeditor_input-submit' value='" . $translations['save'] . "' name='edit_profile_editor' type='submit' />
                </form>
            </div>";
        }
    } else if ($usertype == "Writer") {
        $getuser_sql = "SELECT * FROM writer WHERE id = $id";
        $getuser_result = $conn->query($getuser_sql);
        if ($getuser_result->num_rows > 0) {
            $user = $getuser_result->fetch_assoc();
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];
            $image = $user['image'];
            $bio = $user['bio'];
            $email = $user['email'];
            echo "<div class='editprofile_container'>
                    <form class='create_editor_container' action='../../helpers/forms.php' method='post' enctype='multipart/form-data'>
                        <div class='createeditor_inputgroup'>
                            <h1 class='bigheader'>" . $translations['edit_user'] . " (Writer) </h1>
                        </div>
                        <div class='newpost_container_div6 newpost_subdiv'>
                            <div class='newpost_container_div6_subdiv1'>
                                <img src='" . $image . "' alt='Post Image' />
                            </div>
                            <div class='newpost_container_div6_subdiv2'>
                                <label class='form__label' for='Img'>" . $translations['edit_user_image'] . ": </label>
                                <div class='newpost_subdiv2'>
                                    <input class='form__input' name='Img' type='file' />
                                </div>
                            </div>
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='profile_firstname'>" . $translations['firstname'] . ":</label>
                            <input class='createeditor_input' type='text' name='profile_firstname' value='" . $firstname . "' />
                        </div>
                        <input class='createeditor_input' type='hidden' name='profile-id' value='" . $id . "' />
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='profile_lastname'>" . $translations['lastname'] . ":</label>
                            <input class='createeditor_input' type='text' name='profile_lastname' value='" . $lastname . "' />
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='profile_email'>" . $translations['email'] . ":</label>
                            <input class='createeditor_input' type='email' name='profile_email' value='" . $email . "' />
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin nooutline' for='profile_bio '>" . $translations['bio'] . ":</label>
                            <textarea name='profile_bio' class='textarea' id='myTextarea5'>" . $bio . "</textarea>
                        </div>
                        <input class='createeditor_input-submit' value='" . $translations['save'] . "' name='edit_profile_writer' type='submit' />
                    </form>
                </div>";
        }
    } else if ($usertype == "Other_user") {
        $getuser_sql = "SELECT * FROM otherwebsite_users WHERE id = $id";
        $getuser_result = $conn->query($getuser_sql);
        if ($getuser_result->num_rows > 0) {
            $user = $getuser_result->fetch_assoc();
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];
            $image = $user['image'];
            $bio = $user['bio'];
            $role = $user['role'];
            $email = $user['email'];
            $linkedin_url = $user['linkedin_url'];
            echo "<div class='editprofile_container'>
                    <form class='create_editor_container' action='../../helpers/forms.php' method='post' enctype='multipart/form-data'>
                        <div class='createeditor_inputgroup'>
                            <h1 class='bigheader'>" . $translations['edit_user'] . " </h1>
                        </div>
                        <div class='newpost_container_div6 newpost_subdiv'>
                            <div class='newpost_container_div6_subdiv1'>
                                <img src='" . $image . "' alt='Post Image' />
                            </div>
                            <div class='newpost_container_div6_subdiv2'>
                                <label class='form__label' for='Img'>" . $translations['edit_user_image'] . ": </label>
                                <div class='newpost_subdiv2'>
                                    <input class='form__input' name='Img' type='file' />
                                </div>
                            </div>
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='profile_firstname'>" . $translations['firstname'] . ":</label>
                            <input class='createeditor_input' type='text' name='profile_firstname' value='" . $firstname . "' />
                        </div>
                        <input class='createeditor_input' type='hidden' name='profile-id' value='" . $id . "' />
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='profile_lastname'>" . $translations['lastname'] . ":</label>
                            <input class='createeditor_input' type='text' name='profile_lastname' value='" . $lastname . "' />
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='profile_email'>" . $translations['email'] . ":</label>
                            <input class='createeditor_input' type='email' name='profile_email' value='" . $email . "' />
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin nooutline' for='profile_bio'>" . $translations['bio'] . ":</label>
                            <textarea name='profile_bio' class='textarea' id='myTextarea5'>" . $bio . "</textarea>
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='profile_role'>" . $translations['role'] . ":</label>
                            <input class='createeditor_input' type='text' name='profile_role' value='" . $role . "' />
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='profile_url'>" . $translations['users_linkedin_url'] . ":</label>
                            <input class='createeditor_input' type='text' name='profile_url' value='" . $linkedin_url . "' />
                        </div>
                        <input class='createeditor_input-submit' value='" . $translations['save'] . "' name='edit_profile_otheruser' type='submit' />
                    </form>
                </div>";
        }
    }
}
}
if (!function_exists('renderPageViewAndEditForm')) {
function renderPageViewAndEditForm($base_url, $usertype, $translations, $table_name, $textarea_name, $textareaId, $submitbtn_name, $logo)
{
    global $conn;
    // @phpstan-ignore-next-line
    require("../extras/header3.php");
    if ($usertype === 'Admin') {
        echo    "<section class='about_section'>
                    <div class='page_links'>
                        <a href='" . $base_url . "admin_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['pages'] . "</p> > <p>" . $translations[$table_name] . "</p>
                    </div>
                    <div class='about_header'>
                        <h1>" . $translations[$table_name] . "</h1>
                    </div>
                    <div class='about_contents'>";
        $selectpage = "SELECT content FROM $table_name ORDER BY id DESC LIMIT 1";
        $selectpage_result = $conn->query($selectpage);
        if ($selectpage_result->num_rows > 0) {
            while ($row = $selectpage_result->fetch_assoc()) {
                echo " <span>" . $row['content'] . "</span>
                    </div>
                    <button class='about_section_btn' id='Edit_about1'>" . $translations['edit'] . "
                        <i class='fa fa-pencil' aria-hidden='true'></i>
                    </button>
                    <form class='about_editdiv' action='../../helpers/forms.php' method='post' id='hidden_aboutdiv1'>
                        <textarea class='about_editdiv-input' name='" . $textarea_name . "' id='" . $textareaId . "'>" . $row['content'] . "</textarea>
                        <input type='submit' value='" . $translations['save'] . "' name='" . $submitbtn_name . "' />
                    </form>";
            }
        }
        echo "</section>";
    } else if ($usertype === 'Editor') {
        echo    "<section class='about_section'>
                    <div class='page_links'>
                        <a href='" . $base_url . "editor_homepage.php'>" . $translations['home'] . "</a> > <p>" . $translations['pages'] . "</p> > <p>" . $translations[$table_name] . "</p>
                    </div>
                    <div class='about_header'>
                        <h1>" . $translations[$table_name] . "</h1>
                    </div>
                    <div class='about_contents'>";
        $selectpage = "SELECT content FROM about_us ORDER BY id DESC LIMIT 1";
        $selectpage_result = $conn->query($selectpage);
        if ($selectpage_result->num_rows > 0) {
            while ($row = $selectpage_result->fetch_assoc()) {
                echo " <span>" . $row['content'] . "</span>";
            }
        }
        echo "      </div>
                </section>";
    }
}
}
if (!function_exists('renderCatergoriesSearchAndDisplayQuery')) {
function renderCatergoriesSearchAndDisplayQuery($query)
{
    global $conn, $translations;
    $output = '';
    $query = trim($query);
    if ($query !== "") {
        $stmt = $conn->prepare("SELECT * FROM topics WHERE name LIKE ? ORDER BY id DESC LIMIT 5");
        $searchTerm = "%" . $query . "%";
        $stmt->bind_param("s", $searchTerm);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $output .= "<h1>You Searched For: $query <h1>";
                while ($row = $result->fetch_assoc()) {
                    $time = $row['time'];
                    $date = $row['Date'];
                    $name = $row['name'];
                    $name = htmlspecialchars($name, ENT_QUOTES);
                    $id = $row['id'];
                    $img = $row['image_path'];
                    $dateTime = new DateTime($date);
                    $day = $dateTime->format('j');
                    $month = $dateTime->format('M');
                    $year = $dateTime->format('Y');
                    $ordinalSuffix = getOrdinalSuffix($day);
                    $formattedDate = formatDateSafely($date);
                    $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
                    $formatted_time = date("g:i A", strtotime($time));
                    $cleanString = removeHyphen2($name);
                    $readableString = convertToReadable($name);
                    $total_posts = 0;
                    $tables = ['paid_posts', 'posts', 'news', 'press_releases', 'commentaries'];
                    foreach ($tables as $table) {
                        $niche = $readableString;
                        $sql = "SELECT COUNT(*) AS count FROM $table WHERE niche = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $niche);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $total_posts += $row['count'];
                    }
                    $output .= "<div class='about_section_topicsdiv_subdiv'>";
                    if (!empty($img)) {
                        $output .= "<img src='$img' alt='article image'>";
                    }
                    $output .= "<div class='about_section_topicsdiv_subdiv_subdiv'>
                                    <h1><span>" . $readableString . "</h1>
                                    <p>" . $translations['categories_p'] . ": <span>" . $total_posts . "</span></p>
                                    <p>" . $translations['date_created'] . ": <span>" . $formattedDate . "</span></p>
                                    <p>" . $translations['time'] . ": <span>" . $formatted_time . "</span></p>
                                    <a class='topics_actions' onclick='confirmDeleteCategory($id, \"" . htmlspecialchars(".$cleanString.", ENT_QUOTES) . "\")')>
                                        <i class='fa fa-trash' aria-hidden='true'></i>
                                    </a>
                                </div>
                            </div>
            ";
                }
            } else {
                $output .= "<h1 class='posts_divcontainer_header'>No results found for ' " . $query . " '</h1>";
            }
        }
    }
    return $output;
}
}
if (!function_exists('renderCategoriesPage')) {
function renderCategoriesPage($base_url, $usertype)
{
    global $logo, $conn, $translations;
    $posttype = 'Categories';
    // @phpstan-ignore-next-line
    require("../extras/header2.php");
    echo '<section class="about_section">
            <div class="about_header">
                <h1>' . $translations['categories'] . '</h1>
            </div>
            <div class="about_section_topicsdiv">';
    if ($usertype === 'Admin') {
        echo    '<div class="page_links">
                    <a href="' . $base_url . 'admin_homepage.php">' . $translations['home'] . '</a> > <p>' . $translations['pages'] . '</p> > <p>' . $translations['categories'] . '</p>
                </div>';
    } else if ($usertype === 'Editor') {
        echo    '<div class="page_links">
                    <a href="' . $base_url . 'editor_homepage.php">' . $translations['home'] . '</a> > <p>' . $translations['pages'] . '</p> > <p>' . $translations['categories'] . '</p>
                </div>';
    }
    echo        '<div id="search-results">';
    if (isset($_GET['query'])) {
        $query = $_GET['query'];
        $query = htmlspecialchars($query, ENT_QUOTES);
        echo renderCatergoriesSearchAndDisplayQuery($query);
    }
    echo        '</div>';
    $getcategories_sql = " SELECT id, name, image_path, Date, time FROM topics ORDER BY id";
    $getcategories_result = $conn->query($getcategories_sql);
    if ($getcategories_result->num_rows > 0) {
        while ($row = $getcategories_result->fetch_assoc()) {
            $time = $row['time'];
            $date = $row['Date'];
            $name = $row['name'];
            $name = htmlspecialchars($name, ENT_QUOTES);
            $id = $row['id'];
            $img = $row['image_path'];
            $dateTime = new DateTime($date);
            $day = $dateTime->format('j');
            $month = $dateTime->format('M');
            $year = $dateTime->format('Y');
            $ordinalSuffix = getOrdinalSuffix($day);
            $formattedDate = formatDateSafely($date);
            $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
            $formatted_time = date("g:i A", strtotime($time));
            $cleanString = removeHyphen2($name);
            $readableString = convertToReadable($name);
            $total_posts = 0;
            $tables = ['paid_posts', 'posts', 'news', 'press_releases', 'commentaries'];
            foreach ($tables as $table) {
                $niche = $readableString;
                $sql = "SELECT COUNT(*) AS count FROM $table WHERE niche = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $niche);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $total_posts += $row['count'];
            }
            echo "<div class='about_section_topicsdiv_subdiv'>";
            if (!empty($img)) {
                echo "<img src='" . $img . "' alt='article image'>";
            }
            echo "  <div class='about_section_topicsdiv_subdiv_subdiv'>
                        <h1><span>" . $readableString . "</h1>
                        <p>" . $translations['categories_p'] . ": <span>" . $total_posts . "</span></p>
                        <p>" . $translations['date_created'] . ": <span>" . $formattedDate . "</span></p>
                        <p>" . $translations['time'] . ": <span>" . $formatted_time . "</span></p>
                        <a class='topics_actions' onclick='confirmDeleteCategory(" . $id . ", \"" . htmlspecialchars(".$cleanString.", ENT_QUOTES) . "\")')>
                            <i class='fa fa-trash' aria-hidden='true'></i>
                        </a>
                    </div>
                </div>";
        }
    }
    echo    '<a class="about_section_topicsdiv_subdiv-action" id="add_category" href="../create_new/category.php">
                <div class="actions_subdiv">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </div>
                <p class="actions_p2">' . $translations['create_category'] . '</p>
            </a>
        </div>
    </section>';
}
}
if (!function_exists('renderChangePasswordForm')) {
function renderChangePasswordForm($base_url, $usertype)
{
    global $translations, $logo;
    // @phpstan-ignore-next-line
    require("../extras/header3.php");
    echo '<section class="newpost_body">
            <form class="newpost_container" method="post" action="changepassword.php" enctype="multipart/form-data" id="postForm">';
    if ($usertype === 'Admin') {
        echo    '<div class="page_links">
                    <a href="' . $base_url . 'admin_homepage.php">' . $translations['home'] . '</a> > <p>' . $translations['pages'] . '</p> > <p>' . $translations['change_password'] . '</p>
                </div>';
    } else if ($usertype === 'Editor') {
        echo    '<div class="page_links">
                    <a href="' . $base_url . 'editor_homepage.php">' . $translations['home'] . '</a> > <p>' . $translations['pages'] . '</p> > <p>' . $translations['change_password'] . '</p>
                </div>';
    }
    echo        '<div class="newpost_container_div1 newpost_subdiv">
                    <h1>' . $translations['change_password'] . '</h1>
                </div>
                <div class="newpost_container_div3 newpost_subdiv">
                    <label class="form__label" for="password1"><i class="fas fa-lock"></i></label>
                    <div class="newpost_container_div3_subdiv2">
                        <input class="form__input" name="password1" type="password" placeholder="' . $translations['change_password1'] . '..." />
                    </div>
                </div>
                <div class="newpost_container_div3 newpost_subdiv">
                    <label class="form__label" for="password2"><i class="fas fa-lock"></i></label>
                    <div class="newpost_container_div3_subdiv2">
                        <input class="form__input" name="password2" type="password" placeholder="' . $translations['change_password2'] . '..." />
                    </div>
                </div>
                <div class="newpost_container_div3 newpost_subdiv">
                    <label class="form__label" for="password3"><i class="fas fa-lock"></i></label>
                    <div class="newpost_container_div3_subdiv2">
                        <input class="form__input" name="password3" type="password" placeholder="' . $translations['change_password3'] . '..." />
                    </div>
                </div> 
                <div class="newpost_container_div9 newpost_subdiv">
                    <input class="form__submit_input" type="submit" value="' . $translations['save'] . '" name="change_pwd" />
                </div>
            </form>
        </section>';
}
}
if (!function_exists('renderMetaTitlesManagementForm')) {
function renderMetaTitlesManagementForm($base_url, $usertype)
{
    global $conn, $translations, $logo;
    // @phpstan-ignore-next-line
    require("../extras/header3.php");
    echo '<section class="newpost_body">
            <form method="POST" action=" " enctype="multipart/form-data" id="postForm" class="newpost_container">';
    if ($usertype === 'Admin') {
        echo '<div class="page_links">
                    <a href="' . $base_url . 'admin_homepage.php">' . $translations['home'] . '</a> > <p>' . $translations['settings'] . '</p> > <p>' . $translations['meta_titles_management'] . '</p>
                </div>';
    } else if ($usertype === 'Editor') {
        echo '<div class="page_links">
                    <a href="' . $base_url . 'editor_homepage.php">' . $translations['home'] . '</a> > <p>' . $translations['settings'] . '</p> > <p>' . $translations['meta_titles_management'] . '</p>
                </div>';
    }
    echo '<div class="newpost_container_divnew newpost_subdiv">
                    <h1 class="sectioneer_form_header">' . $translations['meta_titles_management_title'] . '</h1>
                </div>
                <div class="frontend_div sectioneer_div">';
    $getpage_sql = " SELECT id, page_name FROM meta_titles ORDER BY id";
    $getpage_result = $conn->query($getpage_sql);
    if ($getpage_result->num_rows > 0) {
        echo "<div class='sectioneer_div_subdiv'>";
        while ($row = $getpage_result->fetch_assoc()) {
            $page_name = $row['page_name'];
            $page_id = $row['id'];
            $readableString = convertToReadable($page_name);
            echo "<div class='metadiv'>
                            <p>" . $readableString . "</p>
                            <a class='viewMeta' data-id='" . $page_id . "'>
                                <i class='fa fa-eye' aria-hidden='true'></i>
                            </a>
                        </div>";
        }
        echo "</div>";
    }
    echo '</div></form></section>';
}
}
if (!function_exists('renderPageFrontend')) {
function renderPageFrontend($logo, $website_description, $page_title, $table_name)
{
    global $conn;
    echo '<div class="body_container">
            <div class="body_right">
                <div class="sidebar_divs_container">
                    <div class="webinfo">
                        <h1>Uniquecontentwriter</h1>
                        <img src="' . $logo . '" alt="Blog Coverphoto" />
                        <p>' . $website_description . '</p>
                    </div>
                </div>
            </div>
            <div class="body_left border-gradient-leftside--lightdark">
                <div class="page_links">
                    <a href="../">Home</a> > <p>' . $page_title . '</p>
                </div>
                <h3 class="bodyleft_main">' . $page_title . '</h3>
                <div class="sidebar_divs_container thickdiv">';
    $selectpage = "SELECT content FROM $table_name ORDER BY id DESC LIMIT 1";
    $selectpage_result = $conn->query($selectpage);
    if ($selectpage_result->num_rows > 0) {
        while ($row = $selectpage_result->fetch_assoc()) {
            $content = $row['content'];
            echo " <p>$content</p>";
        }
    }
    echo '</div></div></div>';
}
}
if (!function_exists('renderViewPost')) {
function renderViewPost($tablename, $post_id, $url, $postIdVal)
{
    global $conn;
    $getposts_sql = " SELECT id,admin_id, editor_id, title, niche, content, subtitle, post_image_url, image_path, time, Date, schedule, authors_firstname, authors_lastname, about_author, link FROM " . $tablename . " WHERE id = " . $post_id . "";
    $getposts_result = $conn->query($getposts_sql);
    if ($getposts_result->num_rows > 0) {
        $id_admin = '';
        $id_editor = "";
        $id_writer = "";
        $id_type = '';
        $author_bio = '';
        $author_firstname = '';
        $author_lastname = '';
        $author_image = '';
        $role = '';
        $row = $getposts_result->fetch_assoc();
        $author1 = $row['authors_firstname'];
        $author2 = $row['editor_id'];
        $author3 = $row['admin_id'];
        $time = $row['time'];
        $title = $row['title'];
        $niche = $row['niche'];
        $content = $row['content'];
        $read_count = '';
        if (!empty($author3) && empty($author2) && empty($author1)) {
            $admin_id = $row['admin_id'];
            $sql_admin = "SELECT id, firstname, lastname, image, bio FROM admin_login_info WHERE id = $admin_id";
            $result_admin = $conn->query($sql_admin);
            if ($result_admin->num_rows > 0) {
                $admin = $result_admin->fetch_assoc();
                $author_firstname = $admin['firstname'];
                $author_lastname = $admin['lastname'];
                $author_image = $admin['image'];
                $id_type = "Admin";
                $id_admin = $admin['id'];
                $author_bio = $admin['bio'];
                $role = "Editor-in-chief Uniquetechcontentwriter.com";
            }
        } elseif (!empty($author2) && empty($author3) && empty($author1)) {
            $editor_id = $row['editor_id'];
            $sql_editor = "SELECT id, firstname, lastname, image, bio FROM editor WHERE id = $editor_id";
            $result_editor = $conn->query($sql_editor);
            if ($result_editor->num_rows > 0) {
                $editor = $result_editor->fetch_assoc();
                $author_firstname = $editor['firstname'];
                $author_image = $editor['image'];
                $author_lastname = $editor['lastname'];
                $author_bio = $editor['bio'];
                $id_editor = $editor['id'];
                $id_type = "Editor";
                $role = 'Editor At Uniquetechcontentwriter.com';
            }
        } elseif (!empty($author1) || !empty($author3) && empty($author2)) {
            $author_firstname = $row['authors_firstname'];
            $author_lastname = $row['authors_lastname'];
            $sql_writer = "SELECT id, firstname, lastname, image, bio 
               FROM writer 
               WHERE lastname LIKE ? OR firstname LIKE ?";
            $stmt = $conn->prepare($sql_writer);
            $last = "%" . $author_lastname . "%";
            $first = "%" . $author_firstname . "%";
            $stmt->bind_param("ss", $last, $first);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $writer = $result->fetch_assoc(); // Use $result here
                $author_firstname = $writer['firstname'];
                $author_lastname = $writer['lastname'];
                $author_image = $writer['image'];
                $id_type = "Writer";
                $id_writer = $writer['id'];
                $author_bio = $writer['bio'];
                $role = "Contributing Writer";
            }
        }
        $max_length = 200;
        if (strlen($author_bio) > $max_length) {
            $author_bio = substr($author_bio, 0, $max_length) . '...';
        }
        $subtitle = $row['subtitle'];
        $image = $row['image_path'];
        $foreign_imagePath = $row["post_image_url"];
        $scheduleDate = formatDateSafely($row['schedule']);
        $read_count = calculateReadingTime($content);
        $postDate = formatDateSafely($row['Date']);
        $now = date('Y-m-d H:i:s');
        if ($scheduleDate && $row['schedule'] <= $now) {
            $publishDate = $scheduleDate;
        } else {
            $publishDate = $postDate;
        }
        $id = $row['id'];
        $link = $row['link'];
        $formatted_time = date("g:i A", strtotime($time));
        echo   "<h1 class='Post_header'>" . $title . "</h1>
                <h2>" . $subtitle . "</h2>
                <div class='authors_div'>
                    <div class='authors_div_imgbox'>
                        <img src='" . $author_image . "' alt='Author's Image'/>
                        <p><span class='span1'>" . $author_firstname . " " . $author_lastname . ", " . $role . ".</span>
                           <span class='span3'>" . $publishDate . "</span>
                           <span class='span3'>" . $formatted_time . "</span>
                        </p>
                    </div>
                    <div class='authors_div_otherdiv'>
                        <i class='fa fa-clock' aria-hidden='true'></i>
                        <p>" . $read_count . "</p>
                    </div>
                </div>";
        if (!empty($link)) {
            echo "  <video width='70%' controls>
                        <source src='" . $link . "' type='video/mp4'>
                        Your browser does not support the video tag.
                    </video>";
        }
        if (!empty($image)) {
            echo   "<div class='post_image_div'>
                        <img src='" . $image . "' alt='Post Image'/>
                    </div>";
        } elseif (!empty($foreign_imagePath)) {
            echo   "<div class='post_image_div'>
                        <img src='" . $foreign_imagePath . "' alt='Post Image'/>
                    </div>";
        }
        echo "
                <div class='socialmedia_links'>
                    <a class='twitter-share-button' id='xShareBtn3'><i class='fa-brands fa-x-twitter'></i></a>
                    <a href='https://www.facebook.com/sharer/sharer.php?u=" . $url . "' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                    <a href='https://www.linkedin.com/shareArticle?mini=true&url={" . $url . "}&title={" . $title . "}' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                    <a href='https://www.reddit.com/submit?url=" . $url . "&title=" . $title . "' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                    <a onclick='window.print()' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                    <a href='mailto:?subject=" . $title . "&body=" . $subtitle . "' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                </div>
                <p class='content'>" . $content . "</p>
                <div class='socialmedia_links'>
                    <a class='twitter-share-button' id='xShareBtn4'><i class='fa-brands fa-x-twitter'></i></a>
                    <a href='https://www.facebook.com/sharer/sharer.php?u=" . $url . "' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                    <a href='https://www.linkedin.com/shareArticle?mini=true&url={" . $url . "}&title={" . $title . "}' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                    <a href='https://www.reddit.com/submit?url=" . $url . "&title=" . $title . "' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                    <a onclick='window.print()' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                    <a href='mailto:?subject=" . $title . "&body=" . $subtitle . "' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                </div>
                <h3 class='bodyleft_header3'>About the Author</h3>
                <center>
                    <a href='../authors/author.php?id=" . $id_admin . "" . $id_editor . "" . $id_writer . "&idtype=" . $id_type . "' class='aboutauthor_div'>
                        <div class='aboutauthor_div_subdiv1'>
                            <img src='" . $author_image . "' alt ='Author's Image'/>
                        </div>
                        <div class='aboutauthor_div_subdiv2'>
                            <p class='p--bold'>" . $author_firstname . " " . $author_lastname . "</p>
                            <p class='p--bold2'>" . $role . "</p>
                            <p>" . $author_bio . "</p>
                        </div>
                    </a>
                </center>
            ";
        $otherposts_sql = "SELECT id, title, niche, content, image_path, post_image_url, time, Date, schedule FROM " . $tablename . " WHERE id != " . $post_id . " ORDER BY date DESC LIMIT 8";
        $otherposts_result = $conn->query($otherposts_sql);
        if ($otherposts_result->num_rows > 0) {
            echo "<h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>You may also like</h1>
                    <div class='more_posts'>
            ";
            while ($row = $otherposts_result->fetch_assoc()) {
                $id = $row["id"];
                $max_length2 = 40;
                $title = $row["title"];
                $niche = $row["niche"];
                $image = $row["image_path"];
                $foreign_imagePath = $row["post_image_url"];
                $scheduleDate = formatDateSafely($row['schedule']);
                $postDate = formatDateSafely($row['Date']);
                $now = date('Y-m-d H:i:s');
                if ($scheduleDate && $row['schedule'] <= $now) {
                    $publishDate = $scheduleDate;
                } else {
                    $publishDate = $postDate;
                }
                $content = $row["content"];
                if (strlen($title) > $max_length2) {
                    $title = substr($title, 0, $max_length2) . '...';
                }
                $readingTime = calculateReadingTime($row['content']);
                echo "<a class='more_posts_subdiv' href='../pages/view_post.php?$postIdVal=$id'>";
                if (!empty($image)) {
                    echo "<img src='" . $image . "' alt='article image'>";
                } elseif (!empty($foreign_imagePath)) {
                    echo "<img src='" . $foreign_imagePath . "' alt='article image'>";
                }
                echo   "<div class='more_posts_subdiv_subdiv'>
                            <h1>" . $title . "</h1>
                            <span>" . $publishDate . "</span>
                            <span>" . $readingTime . "</span>
                        </div>
                        <p class='posts_div_niche'>" . $niche . "</p>
                    </a>";
            }
            echo "</div>";
        }
    } else {
        echo "<h1 class='bodyleft_header3'>Post not found</h1>";
    }
}
}
if (!function_exists('renderFrontendPageSearchResults')) {
function renderFrontendPageSearchResults($searchNiche1, $query)
{
    global $conn;
    $output = '';
    $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
    $results = [];
    if ($query !== "") {
        foreach ($tables as $table) {
            $searchNiche = $searchNiche1;
            $sql = "SELECT id, title, niche, content, image_path, Date FROM $table WHERE niche = '$searchNiche' AND (title like ? OR subtitle like ? OR content like ?) ORDER BY id DESC LIMIT 3";
            $stmt = $conn->prepare($sql);
            $searchTerm = "%" . $query . "%";
            $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
            $stmt->execute();
            $id = $title = $niche = $content = $image = $date = null;
            $stmt->bind_result($id, $title, $niche, $content, $image, $date);
            while ($stmt->fetch()) {
                $posttype = 0;
                if ($table == 'paid_posts') {
                    $posttype = 1;
                } elseif ($table == 'posts') {
                    $posttype = 2;
                } elseif ($table == 'commentaries') {
                    $posttype = 4;
                } elseif ($table == 'news') {
                    $posttype = 3;
                } elseif ($table == 'press_releases') {
                    $posttype = 5;
                }
                $results[] = [
                    'id' => $id,
                    'title' => $title,
                    'niche' => $niche,
                    'content' => $content,
                    'image_path' => $image,
                    'Date' => $date,
                    'table' => $table,
                    'posttype' => $posttype
                ];
            }
        }
        if (empty($results)) {
            $output .= "<h1>No results found for '<strong>" . htmlspecialchars($query) . "</strong>'.</h1>";
        } else {
            foreach ($results as $result) {
                $max_length = 50;

                // Safely extract and sanitize values
                $id = (int)$result['id'];
                $title = is_string($result['title']);
                $date = is_string($result['Date']);
                $content = is_string($result['content']);
                $imagePath = is_string($result['image_path']);
                $niche = is_string($result['niche']);
                $posttype = (int) $result['posttype'];

                // Truncate title if necessary
                if ($title !== null) {
                    $title = substr($title, 0, $max_length) . '...';
                }

                // Format date safely
                if ($date !== null) {
                    try {
                        $dateTime = new DateTime($date);
                        $day = $dateTime->format('j');
                        $month = $dateTime->format('M');
                        $year = $dateTime->format('Y');
                        $ordinalSuffix = getOrdinalSuffix($day);
                        $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
                    } catch (Exception $e) {
                        $formattedDate = 'Unknown Date';
                    }
                } else {
                    $formattedDate = 'Unknown Date';
                }


                // Calculate reading time
                $readingTime = calculateReadingTime($content);

                // Build output HTML
                $output .= "<a class='more_posts_subdiv' href='view_post.php?id{$posttype}={$id}'>
                        <img src='" . htmlspecialchars($imagePath) . "' alt='Post Image'/>
                        <div class='more_posts_subdiv_subdiv'>
                            <h1>" . htmlspecialchars($title) . "</h1>
                            <span>" . htmlspecialchars($formattedDate) . "</span>
                            <span>" . htmlspecialchars($readingTime) . "</span>
                        </div>
                        <p class='posts_div_niche'>" . htmlspecialchars($niche) . "</p>
                    </a>";
            }
        }
    }
    return $output;
}
}
if (!function_exists('renderFrontendPage')) {
function renderFrontendPage($ucPageTitle, $lcPageTitle)
{
    global $conn, $logo;
    require("../includes/header2.php");
    echo '<div class="body_container">
            <div class="body_left">
                <div class="page_links">
                    <a href="../">Home</a> > <p>' . $ucPageTitle . '</p>
                </div>
                <h1 class="bodyleft_header3">Search ' . $ucPageTitle . ' Posts</h1>
                <form class="header_searchbar2 search_input" id="search_form" action="' . $lcPageTitle . '.php" method="get">
                    <input type="text" name="query" id="search-bar" placeholder="Search.." />
                    <button class="fa fa-search" type="submit" onclick="submitSearch()"></button>
                </form>
                <div id="search-results">
                    <div id="results-container" class="more_posts">';
    if (isset($_GET['query'])) {
        $query = trim($_GET['query']);
        $searchNiche1 = $ucPageTitle;
        echo renderFrontendPageSearchResults($searchNiche1, $query);
    }
    echo '          </div>
                </div>
                <h1 class="bodyleft_header3 border-gradient-bottom--lightdark">Latest On ' . $ucPageTitle . '</h1>
                <div class="more_posts">';
    $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
    $results = [];
    foreach ($tables as $table) {
        $sql = "SELECT id, title, niche, content, image_path, Date FROM $table WHERE niche LIKE ? ORDER BY id DESC LIMIT 2";
        $stmt = $conn->prepare($sql);
        $nicheq = $ucPageTitle;
        $searchTerm = "%" . $nicheq . "%";
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $id = $title = $niche = $content = $image = $date = null;
        $stmt->bind_result($id, $title, $niche, $content, $image, $date);
        while ($stmt->fetch()) {
            // Ensure all variables are properly typed
            $safeId = $id;
            $safeTitle = $title;
            $safeNiche = $niche;
            $safeContent = $content;
            $safeImage = $image;
            $safeDate = $date;

            // Determine post type
            $posttype = match ($table) {
                'paid_posts' => 1,
                'posts' => 2,
                'commentaries' => 4,
                'news' => 3,
                'press_releases' => 5
            };

            // Build safe result array
            $results[] = [
                'id' => $safeId,
                'title' => $safeTitle,
                'niche' => $safeNiche,
                'content' => $safeContent,
                'image_path' => $safeImage,
                'Date' => $safeDate,
                'table' => $table,
                'posttype' => $posttype
            ];
        }
    }
    foreach ($results as $result) {
        $max_length = 50;
        $id = $result['id'];
        $title = is_string($result['title']);
        $date = is_string($result['Date']);
        $content = is_string($result['content']);
        $title = substr($title, 0, $max_length) . '...';
        if ($date !== null) {
            try {
                $dateTime = new DateTime($date);
                $day = $dateTime->format('j');
                $month = $dateTime->format('M');
                $year = $dateTime->format('Y');
                $ordinalSuffix = getOrdinalSuffix($day);
                $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
            } catch (Exception $e) {
                $formattedDate = 'Unknown Date';
            }
        }
        $readingTime = calculateReadingTime($result['content']);
        echo "<a class='more_posts_subdiv' href='view_post.php?id" . $result['posttype'] . "=$id'>
                <img src='" . $result['image_path'] . "' alt = 'Post's Image'/>
                <div class='more_posts_subdiv_subdiv'>
                    <h1>" . $title . "</h1>
                    <span>" . $formattedDate . "</span>
                    <span>" . $readingTime . "</span>
                </div>
                <p class='posts_div_niche'>" . $result['niche'] . "</p>
            </a>";
    }
    echo '</div></div>
            <div class="body_right border-gradient-leftside--lightdark">
                <div class="subscribe_container">
                    <form class="sec2__susbribe-box other_width" method="POST" action="" id="susbribe-box">
                        <div class="icon">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </div>
                        <h1 class="sec2__susbribe-box-header">Subscribe to Updates</h1>
                        <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on Cybersecurity, Artificial Intelligence and lots more.</p>
                        <input class="sec2__susbribe-box_input" type="text" placeholder="Your Email Address..." name="email" required />
                        <input class="sec2__susbribe-box_btn" type="submit" value="Submit" name="submit_btn" />
                    </form>
                </div>
                <h3 class="bodyleft_header3 border-gradient-bottom--lightdark">Editor\'s Picks</h3>';
    include("../helpers/editorspicks.php");
    echo '</div></div>
            <section class="section2" id="section1">
                <div class="section2__div1">
                    <div class="search_div" id="result"></div>
                    <div class="section2__div1__header headers">
                        <h1>For You</h1>
                    </div>';
    include('../includes/pagination.php');
    echo '</div></section>';
    include("../includes/footer2.php");
}
}
if (!function_exists('renderAuthorPage')) {
function renderAuthorPage($database_name, $id, $role, $authorTableHook)
{
    global $conn;
    $getauthor_sql = "SELECT id, firstname, lastname, image, bio FROM " . $database_name . " WHERE id = " . $id . "";
    $getauthor_result = $conn->query($getauthor_sql);
    if ($getauthor_result->num_rows > 0) {
        $author = $getauthor_result->fetch_assoc();
        $author_firstname = $author['firstname'];
        $author_lastname = $author['lastname'];
        $author_bio = $author['bio'];
        $author_image = $author['image'];
        echo "<section class='authordiv_container'>";
        if (!empty($author_image)) {
            echo "<img src='" . $author_image . "' alt='article image'>";
        }
        echo    "<div class = 'authordiv_container_subdiv'>
                        <h1><span>" . $author_firstname . " " . $author_lastname . ", </span><span>" . $role . "</span></h1>
                        <p>" . $author_bio . "</p>
                    </div>
                </section>
                <div class='body_container'>
                    <div class='body_left'>    
                        <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>More Posts By <span> " . $author_firstname . "  $author_lastname </span></h1>
                        <div class='more_posts'>";
    }
    $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
    $results = [];
    foreach ($tables as $table) {
        $sql = "SELECT id, title, niche, content, image_path, post_image_url, Date, schedule 
            FROM $table 
            WHERE $authorTableHook = ? 
            ORDER BY id DESC 
            LIMIT 12";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);

        // Declare variables for binding
        $id = $title = $niche = $content = $image = $image2 = $date = $schedule = null;
        $stmt->bind_result($id, $title, $niche, $content, $image, $image2, $date, $schedule);
        $stmt->execute();

        while ($stmt->fetch()) {
            $results[] = [
                'id' => (int)$id,
                'title' => $title,
                'niche' => $niche,
                'content' => $content,
                'image_path' => $image,
                'foreign_image_path' => $image2,
                'Date' =>  $date,
                'schedule' => $schedule,
                'table' => $table,
                'posttype' => match ($table) {
                    'paid_posts' => 1,
                    'posts' => 2,
                    'commentaries' => 4,
                    'news' => 3,
                    'press_releases' => 5,
                }
            ];
        }
    }

    foreach ($results as $result) {
        $max_length = 40;
        $id = $result['id'];
        $title = is_string($result['title']);
        $date = $result['Date'];
        $content = $result['content'];
        $schedule = $result['schedule'];
        $imagePath = $result['image_path'];
        $foreignImagePath = $result['foreign_image_path'];
        $niche = $result['niche'];
        $posttype = $result['posttype'];

        // Truncate title safely
        $title = substr($title, 0, $max_length) . '...';

        // Format dates safely
        $scheduleDate = formatDateSafely($schedule) ?? null;
        $postDate = formatDateSafely($date) ?? null;
        $now = date('Y-m-d H:i:s');
        $publishDate = ($scheduleDate && $schedule <= $now) ? $scheduleDate : $postDate;

        // Reading time
        $readingTime = calculateReadingTime($content);
        $finalImage = $imagePath ? $imagePath : $foreignImagePath;

        // Render HTML
        echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id{$posttype}={$id}'>";

        if ($finalImage) {
            echo "<img src='" . htmlspecialchars($finalImage) . "' alt='article image'>";
        }

        echo "<div class='more_posts_subdiv_subdiv'>
            <h1>" . htmlspecialchars($title) . "</h1>
            <span>" . htmlspecialchars($publishDate ?? 'Unknown Date') . "</span>
            <span>" . htmlspecialchars($readingTime) . "</span>
        </div>
        <p class='posts_div_niche'>" . htmlspecialchars($niche) . "</p>
    </a>";
    }

    echo "</div></div>";
}
}
if (!function_exists('renderUserActivitiesSearchResult')) {
function renderUserActivitiesSearchResult($query)
{
    global $conn, $translations, $usertype, $user;
    $output = '';
    if ($query !== "") {
        $stmt = $conn->prepare("SELECT * FROM updates WHERE content LIKE ? ORDER BY id DESC LIMIT 5");
        $searchTerm = "%" . $query . "%";
        $stmt->bind_param("s", $searchTerm);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $output .= "<h3 class='posts_divcontainer_header'>You Searched For: " . $query . " <h3>";
                while ($row = $result->fetch_assoc()) {
                    $time = $row['time'];
                    $date = $row['Date'];
                    $row['formatted_date'] = date("F j, Y", strtotime($date));
                    $formatted_time = date("g:i A", strtotime($time));
                    if ($usertype === 'Admin') {
                        $message = personalizeMessageAdmin($row['content'], $user);
                    } else {
                        $message = personalizeMessageEditor($row['content'], $user);
                    }
                    $output .= "<div class='posts_divcontainer_subdiv'>
                            <h3 class='posts_divcontainer_header'>" . $message . "</h3>
                            <div class='posts_divcontainer_subdiv3'>
                                <p class='posts_divcontainer_subdiv_p'><span>" . $translations['date'] . ": </span>" . $row["formatted_date"] . "</p> 
                                <p class='posts_divcontainer_subdiv_p'><span>" . $translations['time'] . ": </span>" . $formatted_time . "</p> 
                            </div>
                        </div>";
                }
            } else {
                $output .= "<h1 class='posts_divcontainer_header'>No results found for " . $query . "</h1>";
            }
        }
    }
    return $output;
}
}
if (!function_exists('renderUserActivitiesPage')) {
function renderUserActivitiesPage($usertype, $base_url, $translations, $user)
{
    global $conn, $logo, $posttype;
    // @phpstan-ignore-next-line
    require("../extras/header2.php");
    echo '<section class="sectioneer">
            <div class="posts_div1 postsdiv sectioneer_divcontainer">
                <div class="page_links">';
    if ($usertype === 'Admin') {
        echo '<a href="' . $base_url . 'admin_homepage.php">' . $translations['home'] . '</a> > <p>' . $translations['profile'] . '</p> > <p>' . $translations['user_activities'] . '</p>';
    } else if ($usertype === 'Editor') {
        echo '<a href="' . $base_url . 'editor_homepage.php">' . $translations['home'] . '</a> > <p>' . $translations['profile'] . '</p> > <p>' . $translations['user_activities'] . '</p>';
    }
    echo '      </div>
                <div class="posts_header">
                    <h1>' . $translations['user_activities'] . '</h1>
                </div>
                <div class="posts_divcontainer border-gradient-side-dark">
                    <div id="search-results">';
    if (isset($_GET['query'])) {
        $query = trim($_GET['query']);
        echo renderUserActivitiesSearchResult($query);
    }
    echo '</div>';
    $select_commentaries = "SELECT id, content, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM updates ORDER BY id DESC LIMIT 100";
    $select_commentaries_result = $conn->query($select_commentaries);
    if ($select_commentaries_result->num_rows > 0) {
        while ($row = $select_commentaries_result->fetch_assoc()) {
            $time = $row['time'];
            $formatted_time = date("g:i A", strtotime($time));
            if ($usertype === 'Admin') {
                $message = personalizeMessageAdmin($row['content'], $user);
            } else {
                $message = personalizeMessageEditor($row['content'], $user);
            }
            echo "<div class='posts_divcontainer_subdiv'>
                    <h3 class='posts_divcontainer_header'>" . $message . "</h3>
                    <div class='posts_divcontainer_subdiv3'>
                        <p class='posts_divcontainer_subdiv_p'><span>" . $translations['date'] . ": </span>" . $row["formatted_date"] . "</p> 
                        <p class='posts_divcontainer_subdiv_p'><span>" . $translations['time'] . ": </span>" . $formatted_time . "</p> 
                    </div>
                </div>";
        }
    }
    echo '</div></div></section>';
}
}
if (!function_exists('renderPostTypeSearchQueries')) {
function renderPostTypeSearchQueries($query)
{
        global $conn, $userFirstname, $translations, $post_type_dbname, $postTypeVal, $delete_querytype, $postTypeVal2, $favType, $userType;
    $output = '';
    $query = trim($query);
    if ($query !== "") {
        $stmt = $conn->prepare("SELECT * FROM " . $post_type_dbname . " WHERE title LIKE ? OR subtitle LIKE ? OR content LIKE ? OR authors_firstname LIKE ? OR authors_lastname LIKE ? ORDER BY id DESC LIMIT 5");
        $searchTerm = "%" . $query . "%";
        $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $output .= "<h3 class='posts_divcontainer_header'>You Searched For: " . $query . " <h3>";
                while ($row = $result->fetch_assoc()) {
                    $author_firstname = "";
                    $author_lastname = "";
                    $role = "";
                    $formatted_date = date("M d, Y", strtotime($row['Date']));
                    if (!empty($row['admin_id']) && empty($row['author_firstname'])) {
                        $admin_id = $row['admin_id'];
                        $sql_admin = "SELECT id, firstname, lastname FROM admin_login_info WHERE id = $admin_id";
                        $result_admin = $conn->query($sql_admin);
                        if ($result_admin->num_rows > 0) {
                            $admin = $result_admin->fetch_assoc();
                            $author_firstname = $admin['firstname'];
                            $author_lastname = $admin['lastname'];
                            $role = "Admin";
                        }
                    } elseif (!empty($row['editor_id'])) {
                        $editor_id = $row['editor_id'];
                        $sql_editor = "SELECT id, firstname, lastname FROM editor WHERE id = $editor_id";
                        $result_editor = $conn->query($sql_editor);
                        if ($result_editor->num_rows > 0) {
                            $editor = $result_editor->fetch_assoc();
                            $author_firstname = $editor['firstname'];
                            $author_lastname = $editor['lastname'];
                            $role = "Editor";
                        }
                    } else {
                        $author_firstname = $row['author_firstname'];
                        $author_lastname = $row['author_lastname'];
                        $role = "Contributing Writer";
                    }
                    $time = $row['time'];
                    $formatted_time = date("g:i A", strtotime($time));
                    $formId = "favouriteForm_" . $row["id"];
                    $output .= "<div class='posts_divcontainer_subdiv post' data-post-id='" . $row["id"] . "'>
                                    <h3 class='posts_divcontainer_header'>" . $row["title"] . "</h3>
                                    <div class='posts_divcontainer_subdiv2'>
                                        <p class='posts_divcontainer_p'><span>" . $translations['published_posts_i'] . ": </span>" . $author_firstname . " " . $author_lastname . " ( " . $role . " )</p>
                                    </div>
                                    <div class='posts_divcontainer_subdiv3'>
                                        <p class='posts_divcontainer_subdiv_p'><span>" . $translations['published_date'] . ": </span> " . $formatted_date . "</p> 
                                        <p class='posts_divcontainer_subdiv_p'><span> $translations[published_time]: </span>" . $formatted_time . "</p> 
                                    </div>
                                    <div class='posts_delete_edit'>
                                        <a class='users_edit' href='../edit/post.php?" . $postTypeVal . "=" . $row["id"] . "&title=" . $row["title"] . "'>
                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                        </a>
                                        <a class='users_delete' onclick='" . $delete_querytype . "(" . $row['id'] . ", \"" . addslashes($userType) . "\", \"" . addslashes($userFirstname) . "\")'>
                                            <i class='fa fa-trash' aria-hidden='true'></i>
                                        </a>";
                        if ($post_type_dbname !== 'unpublished_articles') {
                            echo "<form id='" . $formId . "' class='favouriteForm' action='../script.php' method='POST' data-id='" . $row['id'] . "'>
                                            <input type='hidden' name='" . $postTypeVal2 . "' value='" . $row['id'] . "'>
                                            <input type='hidden' name='" . $favType . "' value='" . ($row['is_favourite'] === 'True' ? 'True' : 'False') . "'>
                                            <button type='submit' class='users_delete2 star'>
                                                <i class='fa fa-star' aria-hidden='true'></i>
                                            </button>
                                        </form>";
                        }
                        echo "</div></div>";
                }
            } else {
                $output .= "<h1 class='posts_divcontainer_header'>No results found for " . $query . "</h1>";
            }
        }
    }
    return $output;
}
}
if (!function_exists('renderPostTypePage')) {
    function renderPostTypePage($base_url, $userFirstname, $userType, $post_type_dbname, $postTypeVal, $delete_querytype, $postTypeVal2, $favType)
{
    global $conn, $translations;
    echo '<section class="sectioneer">
            <div class="posts_div1 postsdiv sectioneer_divcontainer">';
    if ($userType === 'Admin') {
        echo '  <div class="page_links">
                    <a href="' . $base_url . 'admin_homepage.php">' . $translations['home'] . '</a> > <p>' . $translations['posts'] . '</p> > <p>' . $translations['view_' . $post_type_dbname] . '</p>
                </div>
            ';
    } else if ($userType === 'Editor') {
        echo '  <div class="page_links">
                    <a href="' . $base_url . 'editor_homepage.php">' . $translations['home'] . '</a> > <p>' . $translations['posts'] . '</p> > <p>' . $translations['view_' . $post_type_dbname] . '</p>
                </div>
            ';
    }
    echo '   <div class="posts_header">
                <h1>' . $translations['view_' . $post_type_dbname] . '</h1>
            </div>
            <div class="posts_divcontainer border-gradient-side-dark">
                <div id="search-results">';
    if (isset($_GET['query'])) {
        $query = trim($_GET['query']);
        echo '' . renderPostTypeSearchQueries($query) . '';
    }
    echo '</div>';
    $select_pressreleases = "SELECT id, admin_id, editor_id, title, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname, is_favourite FROM " . $post_type_dbname . " ORDER BY id DESC LIMIT 100";
    $select_pressreleases_result = $conn->query($select_pressreleases);
    if ($select_pressreleases_result) {
        if ($select_pressreleases_result->num_rows > 0) {
            $author_firstname = "";
            $author_lastname = "";
            $role = "";
            while ($row = $select_pressreleases_result->fetch_assoc()) {
                if (!empty($row['admin_id']) && empty($row['author_firstname'])) {
                    $admin_id = $row['admin_id'];
                    $sql_admin = "SELECT id, firstname, lastname FROM admin_login_info WHERE id = $admin_id";
                    $result_admin = $conn->query($sql_admin);
                    if ($result_admin->num_rows > 0) {
                        $admin = $result_admin->fetch_assoc();
                        $author_firstname = $admin['firstname'];
                        $author_lastname = $admin['lastname'];
                        $role = "Admin";
                    }
                } elseif (!empty($row['editor_id'])) {
                    $editor_id = $row['editor_id'];
                    $sql_editor = "SELECT id, firstname, lastname FROM editor WHERE id = $editor_id";
                    $result_editor = $conn->query($sql_editor);
                    if ($result_editor->num_rows > 0) {
                        $editor = $result_editor->fetch_assoc();
                        $author_firstname = $editor['firstname'];
                        $author_lastname = $editor['lastname'];
                        $role = "Editor";
                    }
                } else {
                    $author_firstname = $row['author_firstname'];
                    $author_lastname = $row['author_lastname'];
                    $role = "Contributing Writer";
                }
                $time = $row['time'];
                $formatted_time = date("g:i A", strtotime($time));
                $formId = "favouriteForm_" . $row["id"];
                echo "<div class='posts_divcontainer_subdiv'>
                        <h3 class='posts_divcontainer_header'>" . $row["title"] . "</h3>
                        <div class='posts_divcontainer_subdiv2'>
                            <p class='posts_divcontainer_p'><span>" . $translations['published_posts_i'] . ": </span>" . $author_firstname . " " . $author_lastname . " (" . $role . " )</p>
                        </div>
                        <div class='posts_divcontainer_subdiv3'>
                            <p class='posts_divcontainer_subdiv_p'><span>" . $translations['published_date'] . ": </span>" . $row["formatted_date"] . "</p> 
                            <p class='posts_divcontainer_subdiv_p'><span>" . $translations['published_time'] . ": </span>" . $formatted_time . "</p> 
                        </div>
                        <div class='posts_delete_edit'>
                            <a class='users_edit' href='../edit/post.php?" . $postTypeVal . "=" . $row["id"] . "&title=" . $row["title"] . "'>
                                <i class='fa fa-pencil' aria-hidden='true'></i>
                            </a>
                            <a class='users_delete' onclick='" . $delete_querytype . "(" . $row['id'] . ", \"" . addslashes($userType) . "\", \"" . addslashes($userFirstname) . "\")'> 
                                <i class='fa fa-trash' aria-hidden='true'></i>
                            </a>";
                if ($post_type_dbname !== 'unpublished_articles') {
                    echo    "<form id='" . $formId . "' class='favouriteForm' action='../script.php' method='POST' data-id='" . $row['id'] . "'>
                                <input type='hidden' name='" . $postTypeVal2 . "' value='" . $row['id'] . "'>
                                <input type='hidden' name='" . $favType . "' value='" . ($row['is_favourite'] === 'True' ? 'True' : 'False') . "'>
                                <button type='submit' class='users_delete2 star'>
                                    <i class='fa fa-star' aria-hidden='true'></i>
                                </button>
                            </form>";
                }
                echo "
                        </div>
                    </div>";
            };
        } else {
            echo "No records found.";
        }
    } else {
        echo "Query failed: " . $conn->error;
    }
    echo '</div></div></section>';
}
}
if (!function_exists('renderSignInPage')) {
function renderSignInPage($msg, $emailid, $passwordid)
{
    echo ' <section class="section1 flexcenter">
               <div class="container" id="signIn">
                    <h1 class="form__title">Sign In</h1>
                    <form method="post" class="form">
                        <p class="error_div">';
    if (!empty($msg)) {
        echo $msg;
    };
    echo '</p>
                        <div class="input_group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="Email" id="form_input" placeholder="Email" value="' . $emailid . '" required/>
                            <label for="Email">Email</label>
                        </div>
                        <div class="input_group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="Password" id="form_input" placeholder="Password" value="' . $passwordid . '" required/>
                            <label for="Password">Password</label>
                        </div>
                        <div class="checkbox_group">
                            <input type="checkbox" name="remember" id="remember_me" />
                            <p>Remember Me</p>
                        </div>
                        <p class="recover"><a href="forgotpassword.php">Forgot Password?</a></p>
                        <input type="submit" value="Sign In" class="btn_main" name="Sign_In" id="loginBtn" />
                    </form>
                </div>
            </section>';
    // @phpstan-ignore-next-line
    require("../extras/footer.php");
}
}
if (!function_exists('renderForgotPasswordPage')) {
function renderForgotPasswordPage($usertype)
{
    echo '<section class="section1 flexcenter">
            <div class="container" id="signIn">
                <form method="post" class="form" id="validate_form" action="../../helpers/forms.php">
                    <h1>Enter Your Email</h1>
                    <input type="hidden" value="' . $usertype . '" name="usertype" />
                    <div class="input_group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="form_input" placeholder="Enter your email.." data-parsley-type="email" data-parsley-trigger="keyup" required />
                        <label for="email">Email</label>
                    </div>
                    <input type="submit" value="Send OTP" class="btn_main" name="fgtpswd" />
                </form>
            </div>
        </section>
    ';
    // @phpstan-ignore-next-line
    require("../extras/footer.php");
}
}
if (!function_exists('renderOtpInputPage')) {
function renderOtpInputPage($email, $usertype)
{
    global $msg;
    echo '<section class="section1 flexcenter">
            <div class="container flexcenter" id="signIn">
                <form method="post" class="form otp_form" id="validate_otp" action="../../helpers/forms.php">
                    <h1>Enter OTP</h1>';
    if (isset($_GET['resent'])) {
        echo '<p class="error_div">A new OTP has been sent to your email.</p>';
    }
    echo '<p class="error_div">';
    if (!empty($_SESSION['status'])) {
        echo $_SESSION['status'];
        unset($_SESSION['status']);
        unset($_SESSION['status_type']);
    }
    echo '</p>
                    <div class="input-field">
                        <input type="number" class="otp-input" maxlength="1" name="otp1" required />
                        <input type="number" class="otp-input" maxlength="1" name="otp2" required />
                        <input type="number" class="otp-input" maxlength="1" name="otp3" required />
                        <input type="number" class="otp-input" maxlength="1" name="otp4" required />
                        <input type="number" class="otp-input" maxlength="1" name="otp5" required />
                    </div>
                    <input type="hidden" value="' . $email . '" name="validate_otp_email" />
                    <input type="hidden" value="' . $usertype . '" name="usertype" />
                    <p id="countdown" class="timer"></p>
                    <button id="btn" class="verifyButton" name="validate_otp">Verify</button>
                </form>
            </div>
        </section>';
    // @phpstan-ignore-next-line
    require("../extras/footer.php");
};
}
if (!function_exists('renderChangePasswordLoginPage')) {
function renderChangePasswordLoginPage($usertype, $email, $firstname)
{
    echo '<section class="section1 flexcenter">
            <div class="container" id="signIn">
                <form method="post" class="form" id="validate_form" action="../../helpers/forms.php">
                    <h1>Change Password</h1>
                    <div class="input_group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="pwd" id="form_input" placeholder="Enter your password.." data-parsley-type="password" data-parsley-trigger="keyup" required />
                        <label for="pwd">Password</label>
                    </div>
                    <input type="hidden" name="usertype" value="' . $usertype . '"/>
                    <input type="hidden" name="email" value="' . $email . '"/>
                    <input type="hidden" name="firstname" value="' . $firstname . '"/>
                    <div class="input_group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="cfpwd" id="form_input" placeholder="Enter your password.." data-parsley-type="password" data-parsley-trigger="keyup" required />
                        <label for="cfpwd">Confirm Password</label>
                    </div>
                    <input type="submit" value="Update" class="btn_main" name="change_password" />
                </form>
            </div>
        </section>
    ';
    // @phpstan-ignore-next-line
    require("../extras/footer.php");
}
}
?>