'use strict';


/*
logoutBtn.addEventListener('click', () => {
                logoutDiv.classList.remove('hidden');
                logoutDiv.style.display = 'flex';
            })
sideBtns.forEach((tab, index) => {
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
});

const displayPopups = function(divname, clickorigin){
  clickorigin.addEventListener('click', () => {
    divname.classList.remove('hidden');
    divname.style.display = 'flex';
  })
}
displayPopups(createEditorDiv, createWriterOrigin);

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

const stickyNavFunc = function () {
  const navHeight = header.getBoundingClientRect().height;
  const stickyNav = function (entries) {
      const [entry] = entries;
      if (entry.isIntersecting) {
        console.log('yeah')
          //sidebar.classList.add('sticky');
      }else{
         // sidebar.classList.remove('sticky');
          //headerObs.unobserve(header);
      }
  }
  const headerObs = new IntersectionObserver(stickyNav, {
      root: null,
      threshold: 0,
      rootMargin: `-${navHeight}px`,
  });
  headerObs.observe(header);
};
stickyNavFunc();
const removeExitAlert = function(){
  logoutDiv.classList.toggle('hidden');
  logoutDiv.style.display = 'unset';
}
cancelLogout.addEventListener('click', removeExitAlert);

const upload = function(){
  document.getElementById('file_upload_id').click();
}
profilePicUploadBtn.addEventListener('click', upload);
onClickOutside(popupForm1);
onClickOutside(popupForm2);
onClickOutside(popupForm3);
onClickOutside(popupForm4);
*/