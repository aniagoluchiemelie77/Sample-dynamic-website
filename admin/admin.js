const editBtn = document.querySelector('.profile_edit_btn');
const header = document.querySelector('.body');
const body = document.querySelector('.header');
const sidebar = document.querySelector('.sidebar');
const sideBtns = document.querySelectorAll('.sidebarbtn');
const tabContent = document.querySelectorAll('.tabcontent');
const deletePostIcon = document.querySelectorAll('.users_delete');
const deletePostDiv = document.querySelector('.posts_delete_edit2');
const form = document.querySelector('.Edit_profile');
const logout = document.querySelector('.logout');
const logoutDiv = document.querySelector('.logout_alert');
const cancelLogout = document.querySelector('.cancellogout');
const formInput = document.getElementById('form_input');
const createEditorOrigin = document.getElementById('create_user-origin');
const createEditorDiv = document.getElementById('create_editor');
const createWriterOrigin = document.getElementById('create_writer_origin');
const createWriterDiv = document.getElementById('create_writer');
const deletedAlert = document.getElementById('delete');
const piechart_container = document.getElementById('piechart_container');



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
//editBtn.addEventListener('click', displayForm);
let displayExit;
const displayExitAlert = function(){
  logoutDiv.classList.remove('hidden');
  logoutDiv.style.display = 'flex';
  cancelExit();
}
logout.addEventListener('click', displayExitAlert);

const displayCreateEditor = function(){
  createEditorDiv.classList.remove('hidden');
  createEditorDiv.style.display = 'flex';
}
createEditorOrigin.addEventListener('click', displayCreateEditor);
const displayCreateWriter = function(){
  createWriterDiv.classList.remove('hidden');
  createWriterDiv.style.display = 'flex';
}
createWriterOrigin.addEventListener('click', displayCreateWriter);

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

