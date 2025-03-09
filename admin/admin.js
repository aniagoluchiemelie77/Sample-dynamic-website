'use strict';
const timerElement = document.querySelector('.timer');
const verifyButton = document.querySelector('.verifyButton');
const inputs = document.querySelectorAll('.otp-input');
const sideBtns = document.querySelectorAll('.sidebarbtn');
const tabComponents = document.querySelectorAll('.tab_content');
const logoutDiv = document.getElementById('logout_alert');
const exitLogout = document.getElementById('dismiss-popup-btn');

sideBtns.forEach((tab, index) =>{
    tab.addEventListener('click', () => {
        sideBtns.forEach((tab) => tab.classList.remove('active'));
        tab.classList.add('active');
        tabComponents.forEach((tabContent) => {
            tabContent.classList.remove('active2');
            tabContent.style.display = 'none';}
        );
        tabComponents[index].classList.add('active2');
        tabComponents[index].style.display = 'flex';
    });
})       
function displayExit () {
  logoutDiv.style.display = 'flex';
};
function cancelExit () {
  logoutDiv.style.display = 'none';
};
const editAction = function (btn, txtEditor) {
  btn.addEventListener("click", () => {
    txtEditor.style.display = "block";
  });
};
function submitForm() {
  var topicName = document.getElementById('topicName').value;
  if (topicName) {
      fetch('../forms.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'topicName=' + encodeURIComponent(topicName)
      })
      .then(response => response.text())
      .then(data => {
          Swal.fire('Success', data, 'success');
      })
      .catch(error => {
          Swal.fire('Error', 'Something went wrong!', 'error');
      });
  } else {
      Swal.fire('Error', 'Please enter a topic name', 'error');
  }
};
function confirmDeleteC(postId) {
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#F93404',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = '../delete.php?id5=' + postId;
      }
  })
};
function confirmDeleteP(postId) {
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#F93404',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = '../delete.php?id2=' + postId;
      }
  })
};
function confirmDeleteSubscriber(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#F93404',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href =  '../delete.php?id=' + postId + '&usertype=Subscriber';
        }
    })
};
function confirmDeleteNewslSubscriber(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#F93404',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href =  '../delete.php?id=' + postId + '&usertype=NewsletterSubscriber';
        }
    })
};
function confirmDeleteEditor(Id) {
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#F93404',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = '../delete.php?id=' + Id + '&usertype=Editor';
      }
  })
};
function confirmDeleteN(postId) {
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#F93404',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = '../delete.php?id4=' + postId;
      }
  })
};
function confirmDeleteOtheruser(Id) {
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#F93404',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = '../delete.php?id=' + Id + '&usertype=Otheruser';
      }
  })
};
function confirmDeletePP(postId) {
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#F93404',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = '../delete.php?id1=' + postId;
      }
  })
};
function confirmDeletePR(postId) {
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#F93404',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = '../delete.php?id6=' + postId;
      }
  })
};
function confirmDeleteD(postId) {
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#F93404',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = '../delete.php?id3=' + postId;
      }
  })
};
function confirmDeleteWriter(Id) {
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#F93404',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = '../delete.php?id=' + Id + '&usertype=Writer';
      }
  })
};
tinymce.init({
  selector: '#myTextarea',
  width: 810,
  height: 900,
  plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'emoticons', 'help'
  ],toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
  menu: {
  favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
  },
  menubar: 'favs file edit view insert format tools table help',
  content_css: 'css/content.css'
});
tinymce.init({
  selector: '#myTextarea2',
  width: 810,
  height: 900,
  plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'emoticons', 'help'
  ],toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
  menu: {
  favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
  },
  menubar: 'favs file edit view insert format tools table help',
  content_css: 'css/content.css'
});
tinymce.init({
  selector: '#myTextarea3',
  width: 810,
  height: 900,
  plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'emoticons', 'help'
  ],toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
  menu: {
  favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
  },
  menubar: 'favs file edit view insert format tools table help',
  content_css: 'css/content.css'
});
tinymce.init({
  selector: '#myTextarea4',
  width: 810,
  height: 900,
  plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'emoticons', 'help'
  ],toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
  menu: {
  favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
  },
  menubar: 'favs file edit view insert format tools table help',
  content_css: 'css/content.css'
});
tinymce.init({
  selector: '#myTextarea5',
  width: 810,
  height: 900,
  plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'emoticons', 'help'
  ],toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
  menu: {
  favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
  },
  menubar: 'favs file edit view insert format tools table help',
  content_css: 'css/content.css'
});
tinymce.init({
  selector: '#myTextarea6',
  width: 810,
  height: 900,
  plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'emoticons', 'help'
  ],toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
  menu: {
  favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
  },
  menubar: 'favs file edit view insert format tools table help',
  content_css: 'css/content.css'
});
tinymce.init({
  selector: '#myTextarea7',
  width: 810,
  height: 900,
  plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'emoticons', 'help'
  ],toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
  menu: {
  favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
  },
  menubar: 'favs file edit view insert format tools table help',
  content_css: 'css/content.css'
});
tinymce.init({
  selector: '#myTextarea8',
  width: 810,
  height: 900,
  plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'emoticons', 'help'
  ],toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
  menu: {
  favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
  },
  menubar: 'favs file edit view insert format tools table help',
  content_css: 'css/content.css'
});
tinymce.init({
  selector: '#myTextarea9',
  width: 810,
  height: 900,
  plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'emoticons', 'help'
  ],toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
  menu: {
  favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
  },
  menubar: 'favs file edit view insert format tools table help',
  content_css: 'css/content.css'
});
tinymce.init({
  selector: '#myTextarea10',
  width: 810,
  height: 900,
  plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'emoticons', 'help'
  ],toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
  menu: {
  favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
  },
  menubar: 'favs file edit view insert format tools table help',
  content_css: 'css/content.css'
});
function disableInputs() {
  inputs.forEach(function(input) {
      input.disabled = true;
      input.value = " ";
  });
  verifyButton.disabled = true;
};
function startCountdown() {
  var timeLeft = 60;
  var interval = setInterval(function() {
      if (timeLeft <= 0) {
          clearInterval(interval);
          var anchor = document.createElement('a');
          anchor.name = 'resend_otp';
          anchor.innerHTML = 'Resend OTP?';
          timerElement.innerHTML = "";
          timerElement.appendChild(anchor);
          disableInputs();
      } else {
          timerElement.innerHTML = 'Time remaining: ' + timeLeft + 's';
      }
      timeLeft -= 1;
  }, 1000); // Update every second
};
function checkInputs() {
  var allFilled = true;
  inputs.forEach(function(input) {
      if (input.value.length !== 1) {
          allFilled = false;
      }
      if (input.value.length > 1) {
          input.value = "";
          return;
      } 
  });
  verifyButton.style.display = allFilled ? 'block' : 'none';
};
function setupInputs() {
  inputs.forEach(function(input, index) {
      input.addEventListener('input', function() {
          if (input.value.length === 1 && index < inputs.length - 1) {
              inputs[index + 1].focus();
          }
          checkInputs();
      });
      input.addEventListener('keydown', function(e) {
          if (e.key === 'Backspace') {
              if (input.value.length === 0 && index > 0) {
                  inputs[index - 1].focus();
                  inputs[index - 1].value = '';
              } else if (input.value.length === 1) {
                  input.value = '';
              }
          }
      });
  });
};