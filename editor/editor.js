'use strict';
const timerElement = document.querySelector('.timer');
const verifyButton = document.querySelector('.verifyButton');
const inputs = document.querySelectorAll('.otp-input');
const sideBtns = document.querySelectorAll('.sidebarbtn');
const tabComponents = document.querySelectorAll('.tab_content');
const logoutDiv = document.getElementById('logout_alert');
const logoutDiv2 = document.getElementById('logout_alert2');
const exitLogout = document.getElementById('dismiss-popup-btn');

window.addEventListener("resize", function() {
    if (tinymce.activeEditor) {
        let newWidth = window.innerWidth * 0.8; // Adjust width dynamically
        let newHeight = window.innerHeight * 0.7; // Adjust height dynamically
        
        tinymce.activeEditor.editorContainer.style.width = newWidth + "px";
        tinymce.activeEditor.editorContainer.style.height = newHeight + "px";
    }
});

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
function displayExit2() {
    logoutDiv2.style.display = 'flex';
  };
function cancelExit () {
  logoutDiv.style.display = 'none';
};
function cancelExit2 () {
    logoutDiv2.style.display = 'none';
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
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = 'delete.php?id5=' + postId;
      }
  })
};
function confirmDeleteC2(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../delete.php?id5=' + postId;
        }
    })
  };
function confirmDeleteResource(Id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../delete.php?id=' + Id + '&type=Resource';
        }
    })
};
  function confirmDeletePage(Id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../delete.php?id=' + Id + '&type=Page';
        }
    })
  };
function confirmDeleteCategory(Id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../delete.php?id=' + Id + '&type=Category';
        }
    })
  };
function confirmDeleteP(postId) {
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = 'delete.php?id2=' + postId;
      }
  })
};
function confirmDeleteP2(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
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
        confirmButtonColor: '#3085d6',
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
        confirmButtonColor: '#3085d6',
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
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = 'delete.php?id=' + Id + '&usertype=Editor';
      }
  })
};
function confirmDeleteN(postId) {
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = 'delete.php?id4=' + postId;
      }
  })
};
function confirmDeleteN2(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
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
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = 'delete.php?id=' + Id + '&usertype=Otheruser';
      }
  })
};
function confirmDeletePP(postId) {
  Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = 'delete.php?id1=' + postId;
      }
  })
};
function confirmDeletePP2(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
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
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = 'delete.php?id6=' + postId;
      }
  })
};
function confirmDeletePR2(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
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
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = 'delete.php?id3=' + postId;
      }
  })
};
function confirmDeleteD2(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
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
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete!'
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = 'delete.php?id=' + Id + '&usertype=Writer';
      }
  })
};
tinymce.init({
  selector: '#myTextarea',
  setup: function(editor) {
    editor.on('init', function() {
        editor.editorContainer.style.width = "90%";
        editor.editorContainer.style.height = "50vh";
    });
},
  resize: true,
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
  resize: true,
  setup: function(editor) {
    editor.on('init', function() {
        editor.editorContainer.style.width = "90%";
        editor.editorContainer.style.height = "50vh";
    });
  },
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
  resize: true,
  setup: function(editor) {
    editor.on('init', function() {
        editor.editorContainer.style.width = "90%";
        editor.editorContainer.style.height = "50vh";
    });
  },
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
  resize: true,
  setup: function(editor) {
    editor.on('init', function() {
        editor.editorContainer.style.width = "90%";
        editor.editorContainer.style.height = "50vh";
    });
},
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
  resize: true,
  setup: function(editor) {
    editor.on('init', function() {
        editor.editorContainer.style.width = "90%";
        editor.editorContainer.style.height = "50vh";
    });
  },
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
  resize: true,
  setup: function(editor) {
    editor.on('init', function() {
        editor.editorContainer.style.width = "90%";
        editor.editorContainer.style.height = "50vh";
    });
  },
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
    selector: '#myTextarea6b',
    resize: true,
    setup: function(editor) {
        editor.on('init', function() {
            editor.editorContainer.style.width = "90%";
            editor.editorContainer.style.height = "50vh";
        });
    },
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
    selector: '#myTextarea6c',
    resize: true,
    setup: function(editor) {
        editor.on('init', function() {
            editor.editorContainer.style.width = "90%";
            editor.editorContainer.style.height = "50vh";
        });
    },
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
  resize: true,
  setup: function(editor) {
    editor.on('init', function() {
        editor.editorContainer.style.width = "90%";
        editor.editorContainer.style.height = "50vh";
    });
  },
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
  resize: true,
  setup: function(editor) {
    editor.on('init', function() {
        editor.editorContainer.style.width = "90%";
        editor.editorContainer.style.height = "50vh";
    });
  },
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
  resize: true,
  setup: function(editor) {
    editor.on('init', function() {
        editor.editorContainer.style.width = "90%";
        editor.editorContainer.style.height = "50vh";
    });
  },
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
  resize: true,
  setup: function(editor) {
    editor.on('init', function() {
        editor.editorContainer.style.width = "90%";
        editor.editorContainer.style.height = "50vh";
    });
  },
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
function disableInputs(){
  inputs.forEach(function(input) {
      input.disabled = true;
      input.value = " ";
  });
  verifyButton.disabled = true;
};
function startCountdown(){
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