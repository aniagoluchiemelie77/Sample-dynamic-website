'use strict';

var timerElement = document.querySelector('.timer');
var verifyButton = document.querySelector('.verifyButton');
var inputs = document.querySelectorAll('.otp-input');
var sideBtns = document.querySelectorAll('.sidebarbtn');
var tabComponents = document.querySelectorAll(".tab_content");
var exitLogout = document.getElementById('dismiss-popup-btn');
sideBtns.forEach(function (tab, index) {
  tab.addEventListener('click', function () {
    sideBtns.forEach(function (tab) {
      return tab.classList.remove('active');
    });
    tab.classList.add('active');
    tabComponents.forEach(function (tabContent) {
      tabContent.classList.remove('active2');
      tabContent.style.display = 'none';
    });
    tabComponents[index].classList.add('active2');
    tabComponents[index].style.display = 'flex';
  });
});
function displayExit() {
  var logoutDiv = document.getElementById("logoutAlert");
  logoutDiv.style.display = "flex";
}
function displayExit2() {
  var logoutDiv2 = document.getElementById("logoutAlert2");
  logoutDiv2.style.display = "flex";
}
;
function cancelExit() {
  var logoutDiv = document.getElementById("logoutAlert");
  logoutDiv.style.display = "none";
}
function cancelExit2() {
  var logoutDiv2 = document.getElementById("logoutAlert2");
  logoutDiv2.style.display = "none";
}
;
function preventSubmitIfUnchanged(formSelector, inputSelector) {
  document.addEventListener("DOMContentLoaded", function () {
    var form = document.querySelector(formSelector);
    if (!form) return;
    var inputs = form.querySelectorAll(inputSelector);
    var originalValues = Array.from(inputs).map(function (input) {
      return input.value.trim();
    });
    form.addEventListener("submit", function (e) {
      var hasChanged = false;
      inputs.forEach(function (input, index) {
        if (input.type === "file") {
          if (input.files.length > 0) {
            hasChanged = true;
          }
        } else if (input.value.trim() !== originalValues[index]) {
          hasChanged = true;
        }
      });
      if (!hasChanged) {
        e.preventDefault();
        Swal.fire({
          title: "No Changes",
          text: "No changes made to the form.",
          icon: "info",
          confirmButtonText: "Ok"
        });
      }
    });
  });
}
function preventSubmitIfEmpty(formSelector, inputSelector) {
  document.addEventListener("DOMContentLoaded", function () {
    var form = document.querySelector(formSelector);
    if (!form) return;
    var inputs = form.querySelectorAll(inputSelector);
    var originalValues = Array.from(inputs).map(function (input) {
      return input.value.trim();
    });
    form.addEventListener("submit", function (e) {
      var hasChanged = false;
      inputs.forEach(function (input, index) {
        if (input.type === "file") {
          if (input.files.length > 0) {
            hasChanged = true;
          }
        } else if (input.value.trim() !== originalValues[index]) {
          hasChanged = true;
        }
      });
      if (!hasChanged) {
        e.preventDefault();
        Swal.fire({
          title: "Empty Form",
          text: "Cannot submit an empty form.",
          icon: "info",
          confirmButtonText: "Ok"
        });
      }
    });
  });
}
var editAction = function editAction(btn, txtEditor) {
  btn.addEventListener("click", function () {
    txtEditor.style.display = "block";
  });
};
function submitForm() {
  var topicName = document.getElementById('topicName').value;
  if (topicName) {
    fetch('../forms.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'topicName=' + encodeURIComponent(topicName)
    }).then(function (response) {
      return response.text();
    }).then(function (data) {
      Swal.fire('Success', data, 'success');
    })["catch"](function (error) {
      Swal.fire('Error', 'Something went wrong!', 'error');
    });
  } else {
    Swal.fire('Error', 'Please enter a topic name', 'error');
  }
}
;

function confirmDeleteResource(Id, ResourceName) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.isConfirmed) {
      console.log("Deleting resource with ID:", Id, "and name:", ResourceName);
      window.location.href =
        "../helpers/deleteactions.php?id=" +
        Id +
        "&type=Resource&resourceName=" +
        ResourceName +
        "";
    }
  });
}
function confirmDeleteCategory(Id, topicName, userFirstname) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.isConfirmed) {
      const usertype = "Editor";
      const type = "Category";
      const url = `../helpers/deleteactions.php?id=${encodeURIComponent(
        Id
      )}&usertype=${encodeURIComponent(
        usertype
      )}&userFirstname=${encodeURIComponent(
        userFirstname
      )}&type=${encodeURIComponent(type)}&topicName=${encodeURIComponent(
        topicName
      )}`;
      window.location.href = url;
    }
  });
}
function confirmDeleteP(postId, usertype, userFirstname) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.isConfirmed) {
      const url = `../helpers/deleteactions.php?id2=${encodeURIComponent(
        postId
      )}&usertype=${encodeURIComponent(
        usertype
      )}&userFirstname=${encodeURIComponent(userFirstname)}`;
      window.location.href = url;
    }
  });
}
function confirmDeleteD(postId, usertype, userFirstname) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.isConfirmed) {
      const url = `../helpers/deleteactions.php?id3=${encodeURIComponent(
        postId
      )}&usertype=${encodeURIComponent(
        usertype
      )}&userFirstname=${encodeURIComponent(userFirstname)}`;
      window.location.href = url;
    }
  });
}
function confirmDeleteN(postId, usertype, userFirstname) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.isConfirmed) {
      const url = `../helpers/deleteactions.php?id4=${encodeURIComponent(
        postId
      )}&usertype=${encodeURIComponent(
        usertype
      )}&userFirstname=${encodeURIComponent(userFirstname)}`;
      window.location.href = url;
    }
  });
}
function confirmDeletePR(postId, usertype, userFirstname) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.isConfirmed) {
      const url = `../helpers/deleteactions.php?id6=${encodeURIComponent(
        postId
      )}&usertype=${encodeURIComponent(
        usertype
      )}&userFirstname=${encodeURIComponent(userFirstname)}`;
      window.location.href = url;
    }
  });
}
function confirmDeleteC(postId, usertype, userFirstname) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.isConfirmed) {
      const url = `../helpers/deleteactions.php?id5=${encodeURIComponent(
        postId
      )}&usertype=${encodeURIComponent(
        usertype
      )}&userFirstname=${encodeURIComponent(userFirstname)}`;
      window.location.href = url;
    }
  });
}
function confirmDeleteOtheruser(Id, userFirstname) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete!",
  }).then(function (result) {
    if (result.isConfirmed) {
      const usertype = "Otheruser";
      const action = "deleteUser";
      const usertype2 = "Editor";
      const url = `../helpers/deleteactions.php?id=${encodeURIComponent(
        Id
      )}&usertype=${encodeURIComponent(
        usertype
      )}&userFirstname=${encodeURIComponent(
        userFirstname
      )}&usertype2=${encodeURIComponent(usertype2)}&action=${encodeURIComponent(
        action
      )}`;
      window.location.href = url;
    }
  });
}
function confirmDeleteWriter(Id, userFirstname) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete!",
  }).then(function (result) {
    if (result.isConfirmed) {
      const usertype = "Writer";
      const action = "deleteUser";
      const usertype2 = "Editor";
      const url = `../helpers/deleteactions.php?id=${encodeURIComponent(
        Id
      )}&usertype=${encodeURIComponent(
        usertype
      )}&userFirstname=${encodeURIComponent(
        userFirstname
      )}&usertype2=${encodeURIComponent(usertype2)}&action=${encodeURIComponent(
        action
      )}`;
      window.location.href = url;
    }
  });
}
function confirmDeleteResourceFile(Id, userFirstname, ResourceFileType) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.isConfirmed) {
      const usertype = "Editor";
      const action = "deleteResource";
      const url = `../helpers/deleteactions.php?id=${encodeURIComponent(
        Id
      )}&usertype=${encodeURIComponent(
        usertype
      )}&userFirstname=${encodeURIComponent(
        userFirstname
      )}&action=${encodeURIComponent(
        action
      )}&ResourceFileType=${encodeURIComponent(ResourceFileType)}`;
      window.location.href = url;
    }
  });
}
function disableInputs() {
  inputs.forEach(function (input) {
    input.disabled = true;
    input.value = " ";
  });
  verifyButton.disabled = true;
}
;
function startCountdown() {
  var timeLeft = 60;
  var interval = setInterval(function () {
    if (timeLeft <= 0) {
      clearInterval(interval);

      var anchor = document.createElement("a");
      anchor.textContent = "Resend OTP?";
      anchor.href = "forgotpassword.php";
      anchor.className = "resend-link"; // Optional: for styling

      timerElement.innerHTML = "";
      timerElement.appendChild(anchor);

      disableInputs();
    } else {
      timerElement.innerHTML = "Time remaining: " + timeLeft + "s";
    }
    timeLeft -= 1;
  }, 1000);
}
;
function checkInputs() {
  var allFilled = true;
  inputs.forEach(function (input) {
    if (input.value.length !== 1) {
      allFilled = false;
    }
    if (input.value.length > 1) {
      input.value = "";
      return;
    }
  });
  verifyButton.style.display = allFilled ? 'block' : 'none';
}
;
function setupInputs() {
  inputs.forEach(function (input, index) {
    input.addEventListener('input', function () {
      if (input.value.length === 1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
      checkInputs();
    });
    input.addEventListener('keydown', function (e) {
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
}
;
function saveToLocalStorage() {
  const inputs = document.querySelectorAll('input:not([type="file"]), textarea, select');
  inputs.forEach(input => {
    localStorage.setItem(input.name, input.value);
    console.log(`Saved ${input.name}: ${input.value}`);
  });
}

function restoreFromLocalStorage() {
  console.log("Restoring values...");
  const inputs = document.querySelectorAll('input:not([type="file"]), textarea, select');
  inputs.forEach(input => {
    const savedValue = localStorage.getItem(input.name);
    if (savedValue !== null) {
      input.value = savedValue;
      console.log(`Restored ${input.name}: ${savedValue}`);
    }
  });
}

function clearLocalStorage() {
  const inputs = document.querySelectorAll('input:not([type="file"]), textarea, select');
  inputs.forEach(input => {
    localStorage.removeItem(input.name);
    console.log(`Cleared ${input.name}`);
  });
}
;