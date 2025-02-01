'use strict';

 const logoutBtn = document.getElementById('open-popup-btn');
const editBtn = document.querySelector('.profile_edit_btn');
const header = document.querySelector('.body');
const body = document.querySelector('.header');
const popupForm1 = document.querySelector('.popupform1');
const form = document.querySelector('.Edit_profile');
const cancelLogout = document.querySelector('.cancellogout');
const formInput = document.getElementById('form_input');
const createEditorOrigin = document.getElementById('create_user-origin');
const createEditorDiv = document.getElementById('create_editor');
const createWriterOrigin = document.getElementById('create_writer_origin');
const createWriterDiv = document.getElementById('create_writer');
let profilePicUploadBtn = document.getElementById('profileuploads');
const editAboutPageBtn = document.getElementById('Edit_about');
const editAboutDiv = document.getElementById('hidden_aboutdiv');



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