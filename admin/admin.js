'use strict';
/*sideBtns.forEach((tab, index) => {
    tab.addEventListener('click', (e) => {
      sideBtns.forEach((tab) => {
        tab.classList.remove('active');
      });
      tab.classList.add('active');
      tabContent.forEach((content) =>{
        content.style.display = 'none';
        content.classList.add('hidden');
      })
      tabContent[index].style.display = 'flex';
      tabContent[index].classList.remove('hidden');
    })
  })
  */
const editBtn = document.querySelector('.profile_edit_btn');
const header = document.querySelector('.body');
const body = document.querySelector('.header');
const sidebar = document.querySelector('.sidebar');
const sideBtns = document.querySelectorAll('.sidebarbtn');
const popupForm1 = document.querySelector('.popupform1');
const popupForm2 = document.querySelector('.popupform2');
const popupForm3 = document.querySelector('.popupform3');
const popupForm4 = document.querySelector('.popupform4');
const popupForm5 = document.querySelector('.popupform5');
const deletePostIcon = document.querySelectorAll('.users_delete');
const deletePostDiv = document.querySelector('.posts_delete_edit2');
const form = document.querySelector('.Edit_profile');
const logout = document.querySelector('.logout');
const logoutDiv = document.querySelector('.logout_alert');
const logoutDiv2 = document.querySelector('.logout_alert2');
const cancelLogout = document.querySelector('.cancellogout');
const formInput = document.getElementById('form_input');
const createEditorOrigin = document.getElementById('create_user-origin');
const createEditorDiv = document.getElementById('create_editor');
const createWriterOrigin = document.getElementById('create_writer_origin');
const createWriterDiv = document.getElementById('create_writer');
let profilePicUploadBtn = document.getElementById('profileuploads');
const editAboutPageBtn = document.getElementById('Edit_about');
const editAboutDiv = document.getElementById('hidden_aboutdiv');

function openTab(event, tabName) {
  var i, tabPane, tabButton;
  tabPane = document.getElementsByClassName("tab-pane");
  for (i = 0; i < tabPane.length; i++) {
      tabPane[i].style.display = "none";
  }
  // Remove the active class from all tab buttons
  tabButton = document.getElementsByClassName("tab-button");
  for (i = 0; i < tabButton.length; i++) {
      tabButton[i].className = tabButton[i].className.replace(" active", "");
  }
  // Show the current tab and add an active class to the button that opened the tab
  document.getElementById(tabName).style.display = "block";
  event.currentTarget.className += " active";
}
// Set the default active tab
document.addEventListener("DOMContentLoaded", function() {
  document.getElementsByClassName("tab-button")[0].click();
});
/*
const displayPopups = function(divname, clickorigin){
  clickorigin.addEventListener('click', () => {
    divname.classList.remove('hidden');
    divname.style.display = 'flex';
  })
}
displayPopups(createEditorDiv, createWriterOrigin);
logoutBtn.addEventListener('click', () => {
  logoutDiv.classList.remove('hidden');
  logoutDiv.style.display = 'flex';
});
const removeHiddenClass = function (e) {
  e.stopPropagation();
  logoutDiv.classList.add('hidden');
};
const onClickOutside = (element) => {
  document.addEventListener('click', e => {
    if (!element.contains(e.target)) {
      element.parentElement.classList.add('hidden');
    }
  });
};
const displayForm = function(){
    form.classList.remove('hidden');
}
let displayExit;
const displayExitAlert = function(event){
 logoutDiv.classList.remove('hidden');
 logoutDiv.style.display = 'flex';
 event.stopPropagation();
}
logout.addEventListener('click', displayExitAlert);
const removeExitAlert = function(){
  logoutDiv.classList.toggle('hidden');
  logoutDiv.style.display = 'unset';
}
cancelLogout.addEventListener('click', removeExitAlert);

const upload = function(){
  document.getElementById('file_upload_id').click();
}
profilePicUploadBtn.addEventListener('click', upload);
*/