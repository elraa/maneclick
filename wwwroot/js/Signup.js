function previewImage() {
  var preview = document.getElementById("preview");
  var previewContainer = document.querySelector(".preview-container");
  var fileInput = document.querySelector('input[name="fileUploader"]');
  var file = fileInput.files[0];
  var reader = new FileReader();

  reader.onloadend = function () {
    preview.src = reader.result;
    previewContainer.style.display = "flex"; // Show the preview container using flexbox
  };

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
    previewContainer.style.display = "none"; // Hide the preview container
  }
}

// Uppon loading the page
document.addEventListener("DOMContentLoaded", function () {
  toggleSections();

  // hide the PRCID Part
  var prcIdSection = document.getElementById("PRCID");
  prcIdSection.style.display = "none";
});

// For switching from Sign up and PRCID uplaoding
function toggleSections() {
  var signUpSection = document.getElementById("Sign-up");
  var prcIdSection = document.getElementById("PRCID");

  var btnNext = document.getElementsByName("btnNext")[0];
  var btnBack = document.getElementsByName("btnBack")[0];

  btnNext.addEventListener("click", function (event) {
    event.preventDefault();
    signUpSection.style.display = "none";
    prcIdSection.style.display = "block";
  });

  btnBack.addEventListener("click", function (event) {
    event.preventDefault();
    signUpSection.style.display = "block";
    prcIdSection.style.display = "none";
  });
}

function getParameterByName(name) {
  var url = window.location.href;
  name = name.replace(/[[]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return "";
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function saveUserData() {
  var form = document.querySelector("form");
  var allFieldsValid = true;

  var SID = "Free";

  if (getParameterByName("SID") !== null && getParameterByName("SID") !== "") {
    SID = getParameterByName("SID");
  }

  var inputSID = document.createElement("input");
  inputSID.type = "hidden";
  inputSID.name = "SubsType";
  inputSID.value = SID;
  form.appendChild(inputSID);

  form.querySelectorAll("input, select, textarea").forEach(function (field) {
    if (!field.value.trim()) {
      allFieldsValid = false;
      return;
    }
  });

  if (!allFieldsValid) {
    Swal.fire({
      icon: "error",
      title: "Validation Error",
      text: "Please fill in all required fields.",
    });
    return; // Stop execution if validation fails
  }

  // Additional validation for password match
  var txtpass = document.querySelector("input[name='txtpass']").value;
  var txtConfirmPass = document.querySelector(
    "input[name='txtConfirmPass']"
  ).value;

  if (txtpass !== txtConfirmPass) {
    Swal.fire({
      icon: "error",
      title: "Validation Error",
      text: "Password and Confirm Password do not match.",
    });
    return; // Stop execution if validation fails
  }

  var formData = new FormData(form);

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Handle successful response
        Swal.fire({
          icon: "success",
          title: "Thank you for signing up!",
          text: "An Email verification link has been sent to your email account.",
        }).then((result) => {
          if (result.isConfirmed) {
            // Redirect to the index page
            window.location.href = "login.php";
          }
        });
        console.log(xhr.responseText);
      } else {
        // Handle error
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "An error occurred. Please try again later.",
        });
        console.error("Error:", xhr.status);
      }
    }
  };

  xhr.open("POST", "modules/signup.php", true);
  xhr.send(formData);
}
