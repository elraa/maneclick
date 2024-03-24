function processLogin() {
  const url = "Modules/login_action.php";
  const formData = new FormData(document.querySelector("form"));

  fetch(url, {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Failed to login. Status: " + response.status);
      }
      return response.json(); // Parse the response as JSON
    })
    .then((data) => {
      console.log("Server response:", data);

      if (data.error) {
        // Server returned an error
        Swal.fire({
          icon: "error",
          title: data.error,
          showConfirmButton: true,
        });
      } else {
        // Successful login
        const { role } = data;
        Swal.fire({
          icon: "success",
          title: "Hello, Welcome to MANE Click!",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          // Use uppercase role names for comparison
          if (role.toUpperCase() === "ADMIN") {
            window.location.href = "admin/index.php";
          } else if (role.toUpperCase() === "SLP") {
            window.location.href = "user/index.php";
          } else {
            console.error("Unknown user role:", role);
            // Handle unexpected user role here
          }
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error.message);

      Swal.fire({
        icon: "error",
        title: "Unexpected server response",
        showConfirmButton: true,
      });
    });
}

let globalOTP;

function FindEmail() {
  const url = "Modules/FindEmail.php";
  const formData = new FormData(document.querySelector("form"));

  fetch(url, {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Failed to login. Status: " + response.status);
      }
      return response.json(); // Parse the response as JSON
    })
    .then((data) => {
      if (data.error) {
        // Server returned an error
        Swal.fire({
          icon: "error",
          title: data.error,
          showConfirmButton: true,
        });
      } else {
        globalOTP = generateOTP();

        localStorage.setItem("globalOTP", globalOTP); // to store it in local storage of the machine

        sendMail(data.uemail, globalOTP, data.uid);
      }
    })
    .catch((error) => {
      console.error("Error:", error.message);

      Swal.fire({
        icon: "error",
        title: "Something went wrong. Please try again later.",
        showConfirmButton: true,
      });
    });
}

function ValidatePassword() {
  var newPassword = document.getElementsByName("txtpass")[0].value;
  var confirmNewPassword = document.getElementsByName("txtconfirm")[0].value;

  if (newPassword !== confirmNewPassword) {
    Swal.fire({
      icon: "error",
      title: "Passwords do not match. Please enter matching passwords.",
      showConfirmButton: true,
    });
  } else {
    PasswordReset();
  }
}
function PasswordReset() {
  const urlParams = new URLSearchParams(window.location.search);
  const uid = urlParams.get("UID");

  if (!uid) {
    console.error("UID not found in URL parameters");
    return; // or handle the error in some way
  }

  const formData = new FormData(document.getElementById("resetPasswordForm"));
  formData.append("UID", uid);

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);

        if (response.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Change Password Success!",
            showConfirmButton: false,
            timer: 1500,
          }).then(() => {
            window.location.href = "login.php";
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Failed to reset password.",
            showConfirmButton: true,
          });
        }
      } else {
        console.error("Error:", xhr.status);
        // Handle other HTTP status codes if needed
      }
    }
  };

  xhr.open("POST", "modules/ResetPassword.php", true);
  xhr.send(formData);
}

function generateOTP() {
  const otpLength = 6;
  const otpArray = Array.from({ length: otpLength }, () =>
    Math.floor(Math.random() * 10)
  );
  const otp = otpArray.join("");

  return otp;
}

function sendMail(Email, OTP, UID) {
  const url = "Modules/mailer.php";
  const otp = OTP;
  const email = Email;

  fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `email=${email}&OTP=${otp}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Failed to send Email. Status: " + response.status);
      }
      return response.json();
    })
    .then((data) => {
      if (data.error) {
        Swal.fire({
          icon: "error",
          title: "Failed to send otp",
          text: "Please make sure you have internet and try again later.",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.href = "login.php";
        });
      } else {
        Swal.fire({
          icon: "success",
          title: "OTP is sent to your Email",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.href = `Authentication.php?UID=${UID}`;
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error.message);

      Swal.fire({
        icon: "error",
        title: "Something went wrong. Please try again later.",
        showConfirmButton: true,
      });
    });
}

function ValidateOTP() {
  const storedOTP = localStorage.getItem("globalOTP");
  const urlParams = new URLSearchParams(window.location.search);
  const uid = urlParams.get("UID");

  const inputtedOTP = document.getElementById("txtCode").value;

  if (inputtedOTP === storedOTP) {
    Swal.fire({
      icon: "success",
      title: "Success",
      text: "Procees to change password.",
      showConfirmButton: false,
      timer: 1500,
    }).then(() => {
      window.location.href = `ForgotPassword.php?UID=${uid}`;
    });
  } else {
    Swal.fire({
      icon: "error",
      title: "OTP not match.",
      text: "Please make sure you input the right OTP sent to your email.",
      showConfirmButton: true,
    });
  }
}
