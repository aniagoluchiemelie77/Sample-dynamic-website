'use strict';
const section2 = document.querySelector('.section2');
const menubtn = document.querySelector('.mainheader__header-nav-1');
const closeMenuBtn = document.querySelector('.sidebarbtn');
const header = document.querySelector('.header');
const initCoords = section2.getBoundingClientRect();
const sidebar = document.getElementById('sidebar');
console.log(initCoords);


window.addEventListener('scroll', function (e) {
    if(this.window.scrollY > initCoords.top){
        header.classList.add('sticky');
    }else{
        header.classList.remove('sticky');
    }
});

//displaying menu bar
const removeHiddenClass = function (e) {
    e.stopPropagation();
    sidebar.classList.remove('hidden');
}
menubtn.addEventListener('click', removeHiddenClass);
const addHiddenClass = function (e) {
    e.stopPropagation();
    sidebar.classList.toggle('hidden');
}
closeMenuBtn.addEventListener('click', addHiddenClass);