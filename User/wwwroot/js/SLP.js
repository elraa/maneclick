function Create() {
  var form = document.querySelector("form");
  var formData = new FormData(form);

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Handle successful response
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "Patient information saved successfully!",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "MyPatient.php";
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

  xhr.open("POST", "modules/create.php", true);
  xhr.send(formData);
}

function UpdateRecord() {
  var form = document.querySelector("form");
  var formData = new FormData(form);

  var PID = getParameterByName("PID");
  formData.append("PatientID", PID);

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Handle successful response
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "Patient information saved successfully!",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "MyPatient.php";
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

  xhr.open("POST", "modules/Update.php", true);
  xhr.send(formData);
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

function deletePatient(PID) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      DeleteRecord(PID);
    }
  });
}

function DeleteRecord(PID) {
  var formData = new FormData();
  formData.append("PatientID", PID);

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Handle successful response
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "Patient information deleted successfully!",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "MyPatient.php";
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

  xhr.open("POST", "modules/Delete.php", true);
  xhr.send(formData);
}
