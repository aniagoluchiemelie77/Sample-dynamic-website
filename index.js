'use strict';
const section2 = document.querySelector('.section2');
const cookieContainer = document.querySelector(".cookie_container");
const cookieBtn = document.querySelector('.cookie_container_subdiv-btns');
const section1 = document.querySelector('.section1');
const headerSearchBar = document.querySelector('.mainheader__searchbox-container');
const header = document.querySelector('.header');
//const initCoords = section2.getBoundingClientRect();
let surroundingDivs = !sidebar;
const container = document.getElementById("container");
let touchStartTime, clientX, clientY;
//console.log(initCoords);
const paragraph = document.getElementById('paragraph');
const lightIcon = document.getElementById('theme-icon2');
const darkIcon = document.getElementById('theme-icon1');

function removeHiddenClass (e) {
  e.stopPropagation();
  sidebar.classList.remove('hidden');
};
function onClickOutside (element) {
  document.addEventListener('click', e => {
      if (!element.contains(e.target)) {
        element.classList.add('hidden');
      } else return;
  });
};
/*document.addEventListener('DOMContentLoaded', (event) => {   
  let currentTheme = localStorage.getItem('theme');  
    if (currentTheme === 'light-mode') {
        document.body.classList.add('light-mode');
        darkIcon.style.display = "none";
        lightIcon.style.display = "block";
    }
    const themeIcon = document.getElementById('theme-icon');
    themeIcon.addEventListener('click', () => {
        document.body.classList.toggle('light-mode');
        if (document.body.classList.contains('light-mode')) {
            darkIcon.style.display = "none";
            lightIcon.style.display = "block"; // Night icon
            paragraph.textContent = "Change to Dark Theme";
        } else {
            darkIcon.style.display = "block";
            lightIcon.style.display = "none";
            paragraph.textContent = "Change to Light Theme";
        }
        localStorage.setItem('theme', theme);
    });
});
function delayPopup (param){
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

