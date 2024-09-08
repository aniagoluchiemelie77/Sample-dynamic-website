
const editBtn = document.querySelector('.profile_edit_btn');
const header = document.querySelector('.body');
const body = document.querySelector('.header');
const sidebar = document.querySelector('.sidebar');
const sideBtns = document.querySelectorAll('.sidebarbtn');
const tabContent = document.querySelectorAll('.tabcontent');
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
const deletedAlert = document.getElementById('delete');
const writeMessageDiv = document.getElementById('write_message');
const writeMessageOrigin = document.getElementById('messagediv');
const messagePopupBtns = document.querySelectorAll('.message_popup_btns-a');
const messagePopupContents = document.querySelectorAll('.messagetabcontent');
const workspaceCreator = document.getElementById('workspace_creator');
let otherWorkspaces = document.getElementById('workspaces');
let profilePicUploadBtn = document.getElementById('profileuploads');
let workspaceContainer = document.querySelector('.sidebar_workspace_container');
let workspace = document.querySelector('.sidebar_workspace');
const editAboutPageBtn = document.getElementById('Edit_about');
const editAboutDiv = document.getElementById('hidden_aboutdiv');


//editAboutPageBtn.addEventListener('click', () => {
 // editAboutDiv.style.display = 'flex';
//})
const removeHiddenClass = function (e) {
  e.stopPropagation();
  logoutDiv.classList.add('hidden');
};
  
//removing popups
const onClickOutside = (element) => {
  document.addEventListener('click', e => {
    if (!element.contains(e.target)) {
      element.parentElement.classList.add('hidden');
    }
  });
};
const tabbedComponent = function(btndiv, tabcontent){
  btndiv.forEach((tab, index) => {
    tab.addEventListener('click', (e) => {
      btndiv.forEach((tab) => {
        tab.classList.remove('active');
      });
      tab.classList.add('active');
      tabcontent.forEach((content) =>{
        content.style.display = 'none';
      })
      tabcontent[index].style.display = 'flex';
      })
  });
}
const tabbedComponent2 = function(btndiv, tabcontent){
  btndiv.forEach((tab, index) => {
    tab.addEventListener('click', (e) => {
      btndiv.forEach((tab) => {
        tab.classList.remove('active');
      });
      tab.classList.add('active');
      tabcontent.forEach((content) =>{
        content.classList.add('hidden');
      })
      tabcontent[index].classList.remove('hidden');
      })
  });
}

tabbedComponent(sideBtns, tabContent);
tabbedComponent2(messagePopupBtns, messagePopupContents);
const displayForm = function(){
    form.classList.remove('hidden');
}
//editBtn.addEventListener('click', displayForm);
let displayExit;

const displayExitAlert = function(event){
  logoutDiv.classList.remove('hidden');
  logoutDiv.style.display = 'flex';
  event.stopPropagation();
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

const displayWriteMessage = function(){
  writeMessageDiv.classList.remove('hidden');
  writeMessageDiv.style.display = 'flex';
}
writeMessageOrigin.addEventListener('click', displayWriteMessage);
const removeExitAlert = function(){
  logoutDiv.classList.toggle('hidden');
  logoutDiv.style.display = 'unset';
}
cancelLogout.addEventListener('click', removeExitAlert);

const upload = function(){
  document.getElementById('file_upload_id').click();
}
profilePicUploadBtn.addEventListener('click', upload);

anychart.onDocumentReady(function(){
  var data = [
    {x: "Dextop", value: 2500, exploded: true},
    {x: "Tablet", value: 500},
    {x: "Mobile", value: 80}
  ];
  var chart = anychart.pie();
  chart.title("Visitors Devices Statistics");
  chart.data(data);
  chart.container("pie_container")
  chart.draw();
  chart.legend().itemsLayout("vertical");
  chart.legend().position("right");
  chart.sort("desc");  
});
anychart.onDocumentReady(function(){
  var data2 = [
    {x: "New visitors", value: 2900, exploded: true},
    {x: "Returning visitors", value: 1000},
  ];
  var chart2 = anychart.pie();
  chart2.title("Visitors Statistics");
  chart2.data(data2);
  chart2.container("pie_chartcontainer2")
  chart2.draw();
  chart2.legend().itemsLayout("vertical");
  chart2.legend().position("right");
  chart2.sort("desc");  
});
onClickOutside(popupForm1);
onClickOutside(popupForm2);
onClickOutside(popupForm3);
onClickOutside(popupForm4);
