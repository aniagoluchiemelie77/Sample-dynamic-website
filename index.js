'use strict';
const section2 = document.querySelector('.section2');
const header = document.querySelector('.header');
const initCoords = section2.getBoundingClientRect();
console.log(initCoords);


window.addEventListener('scroll', function (e) {
    if(this.window.scrollY > initCoords.top){
        header.classList.add('sticky');
    }else{
        header.classList.remove('sticky');
    }
});