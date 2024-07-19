const editBtn = document.querySelector('.profile_edit_btn');
const sideBtns = document.querySelectorAll('.sidebarbtn');
const tabContent = document.querySelectorAll('.tabcontent');
const form = document.querySelector('.Edit_profile');
const formInput = document.getElementById('form_input')

sideBtns.forEach((tab, index) => {
    tab.addEventListener('click', (e) => {
      sideBtns.forEach((tab) => {
        tab.classList.remove('active');
      });
      tab.classList.add('active');
      tabContent.forEach((content) =>{
        content.classList.add('hidden');
      })
      tabContent[index].classList.remove('hidden');
    })
  })

const displayForm = function(){
    form.classList.remove('hidden');
}
editBtn.addEventListener('click', displayForm);