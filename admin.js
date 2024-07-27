const editBtn = document.querySelector('.profile_edit_btn');
const sideBtns = document.querySelectorAll('.sidebarbtn');
const tabContent = document.querySelectorAll('.tabcontent');
const deletePostIcon = document.querySelectorAll('.users_delete');
const deletePostDiv = document.querySelector('.posts_delete_edit2');
const form = document.querySelector('.Edit_profile');
const logout = document.querySelector('.logout');
const logoutDiv = document.querySelector('.logout_alert');
const cancelLogout = document.querySelector('.cancellogout');
const formInput = document.getElementById('form_input');

sideBtns.forEach((tab, index) => {
    tab.addEventListener('click', (e) => {
      sideBtns.forEach((tab) => {
        tab.classList.remove('active');
      });
      tab.classList.add('active');
      tabContent.forEach((content) =>{
        content.style.display = 'none';
      })
      tabContent[index].style.display = 'flex';
    })
  })

const cancelExit = function (){
    const removeExitAlert = function(){
      logoutDiv.classList.add('hidden');
    }
    cancelLogout.addEventListener('click', removeExitAlert);
};
const displayForm = function(){
    form.classList.remove('hidden');
}
editBtn.addEventListener('click', displayForm);
let displayExit;
const displayExitAlert = function(){
  logoutDiv.classList.remove('hidden');
  logoutDiv.style.display = 'flex';
  cancelExit();
}
logout.addEventListener('click', displayExitAlert);

const displayDeleteAlert = function () {
  deletePostDiv.classList.toggle('hidden');
  deletePostDiv.style.display = "flex";
}
deletePostIcon.addEventListener('click', displayDeleteAlert);