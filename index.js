'use strict';
const section2 = document.querySelector('.section2');
const cookieContainer = document.querySelector(".cookie_container");
const cookieBtn = document.querySelector('.cookie_container_subdiv-btns');
const section1 = document.querySelector('.section1');
const menubtn = document.querySelector('.mainheader__header-nav-1');
const searchIcon = document.getElementById('searchicon');
const searchForm = document.getElementById("search_form");
const headerSearchBar = document.querySelector('.mainheader__searchbox-container');
const closeMenuBtn = document.querySelector('.sidebarbtn');
const header = document.querySelector('.header');
const initCoords = section2.getBoundingClientRect();
const sidebar = document.getElementById('sidebar');
let surroundingDivs = !sidebar;
const container = document.getElementById("container");
let touchStartTime, clientX, clientY;
console.log(initCoords);


/*function delayPopup (param){
  setTimeout(() => {
    param.style.bottom = "0";
  }, 3000);
}
delayPopup(cookieContainer);

function responding(evt) {
  if (evt.target.nodeName === 'button'){
    evt.stopPropagation();
    evt.target.addEventListener('click', () => {
      cookieContainer.style.bottom = "-100%";
    });
  }
}
if (cookieContainer) {
cookieContainer.addEventListener('click', responding);
}else {
  alert("The element is not found!");
}*/
//implementing sticky nav bar
const stickyNavFunc = function () {
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
    headerObs.observe(section1);
};

const screenOnlyFuncs = function () {
    const onClickOutside = (element) => {
        document.addEventListener('click', e => {
          if (!element.contains(e.target)) {
            sidebar.classList.add('hidden');
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
const displaySearchBar = function (e) {
    e.stopPropagation();
    searchForm.classList.remove('hidden');
    searchForm.style.display = 'flex';
    searchIcon.classList.add('hidden')
}
searchIcon.addEventListener('click', displaySearchBar);

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

