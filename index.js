'use strict';

function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }
var section2 = document.querySelector('.section2');
var cookieContainer = document.querySelector(".cookie_container");
var cookieBtn = document.querySelector('.cookie_container_subdiv-btns');
var section1 = document.querySelector('.section1');
var headerSearchBar = document.querySelector('.mainheader__searchbox-container');
var header = document.querySelector('.header');
//const initCoords = section2.getBoundingClientRect();
var surroundingDivs = !sidebar;
var container = document.getElementById("container");
var touchStartTime, clientX, clientY;
//console.log(initCoords);
var paragraph = document.getElementById('paragraph');
var lightIcon = document.getElementById('theme-icon2');
var darkIcon = document.getElementById('theme-icon1');
function removeHiddenClass(e) {
  e.stopPropagation();
  sidebar.classList.remove('hidden');
}
;
function onClickOutside(element) {
  document.addEventListener('click', function (e) {
    if (!element.contains(e.target)) {
      element.classList.add('hidden');
    } else return;
  });
}
;
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
var stickyNavFunc = function stickyNavFunc() {
  var navHeight = header.getBoundingClientRect().height;
  var stickyNav = function stickyNav(entries) {
    var _entries = _slicedToArray(entries, 1),
      entry = _entries[0];
    if (!entry.isIntersecting) {
      header.classList.add('sticky');
    } else {
      header.classList.remove('sticky');
      //headerObs.unobserve(header);
    }
  };
  var headerObs = new IntersectionObserver(stickyNav, {
    root: null,
    threshold: 0,
    rootMargin: "-".concat(navHeight, "px")
  });
  headerObs.observe(section1);
};
var screenOnlyFuncs = function screenOnlyFuncs() {
  var swipefunction = function swipefunction() {
    container.addEventListener("touchstart", touchStart);
    container.addEventListener("touchend", touchEnd);
    function touchStart(e) {
      touchStartTime = Date.now();
      clientY = e.touches[0].clientY;
      clientX = e.touches[0].clientX;
    }
    ;
    function touchEnd(e) {
      var touchEndTime = Date.now();
      swipe(e, touchEndTime - touchStartTime);
    }
    var DURATION_THRESHOLD = 400;
    var MOVE_THRESHOLD = 100;
    function swipe(e, duration) {
      var endClientX = e.changedTouches[0].clientX;
      var endClientY = e.changedTouches[0].clientY;
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