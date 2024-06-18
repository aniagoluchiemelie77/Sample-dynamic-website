'use strict';
const section2 = document.querySelector('.section2');
const menubtn = document.querySelector('.mainheader__header-nav-1');
const menubtn2 = document.getElementById('searchicon');
const headerSearchBar = document.querySelector('.mainheader__searchbox-container');
const closeMenuBtn = document.querySelector('.sidebarbtn');
const header = document.querySelector('.header');
const initCoords = section2.getBoundingClientRect();
const sidebar = document.getElementById('sidebar');
let surroundingDivs = !sidebar;
console.log(initCoords);


window.addEventListener('scroll', function (e) {
    if(this.window.scrollY > initCoords.top){
        header.classList.add('sticky');
    }else{
        header.classList.remove('sticky');
    }
});

//displaying sidebar
const removeHiddenClass = function (e) {
    e.stopPropagation();
    sidebar.classList.remove('hidden');
}
menubtn.addEventListener('click', removeHiddenClass);
//closing sidebar
const addHiddenClass = function (e) {
    e.stopPropagation();
    sidebar.classList.toggle('hidden');
}
closeMenuBtn.addEventListener('click', addHiddenClass);
//displaying search bar
const removeHiddenClass2 = function (e) {
    e.stopPropagation();
    headerSearchBar.classList.toggle('hidden');
    menubtn2.classList.toggle('hidden');
}
menubtn2.addEventListener('click', removeHiddenClass2);