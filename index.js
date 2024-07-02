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
const container = document.getElementById("container");
let touchStartTime, clientX, clientY;
console.log(initCoords);

//implementing sticky nav bar

/*const stickyNavFunc = function () {
    const navHeight = header.getBoundingClientRect().height;
    const stickyNav = function (entries) {
        const [entry] = entries;
        if (!entry.isIntersecting) {
            header.classList.add('sticky');
        }else{
            header.classList.remove('sticky');
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
stickyNavFunc();*/
window.addEventListener('scroll', function (e) {
    if(this.window.scrollY > initCoords.top){
        header.classList.add('sticky');
    }else{
        header.classList.remove('sticky');
    }
});
const screenOnlyFuncs = function () {
    const onClickOutside = (element) => {
        document.addEventListener('click', e => {
          if (!element.contains(e.target)) {
            sidebar.classList.toggle('hidden');
          } else return;
        });
      };
      onClickOutside(sidebar);
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

// Adding event listeners for touchstart and touchend events
const swipefunction = function () {
container.addEventListener("touchstart", touchStart);
container.addEventListener("touchend", touchEnd);
function touchStart(e) {
  //e.preventDefault();
  touchStartTime = Date.now();
  clientY = e.touches[0].clientY;
  clientX = e.touches[0].clientX;
};
function touchEnd(e) {
  const touchEndTime = Date.now();
  swipe(e, touchEndTime - touchStartTime);
}
const DURATION_THRESHOLD = 400;
const MOVE_THRESHOLD = 100;
function swipe(e, duration) {
  const endClientX = e.changedTouches[0].clientX;
  const endClientY = e.changedTouches[0].clientY;
  if (duration <= DURATION_THRESHOLD) {
    if (endClientX - clientX >= MOVE_THRESHOLD) {
        sidebar.classList.remove('hidden');
    } else return;
  }
}
};
swipefunction();
};
screenOnlyFuncs();