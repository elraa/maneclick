document.addEventListener("DOMContentLoaded", function () {
  function fetchData(selectedRole) {
    $.ajax({
      type: "GET",
      url: "modules/fetch_data.php",
      data: { role: selectedRole },
      success: function (response) {
        $("#mainContent").html(response);
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
  }

  fetchData("SLP");

  document
    .getElementById("roleDropdown")
    .addEventListener("change", function () {
      var selectedOption = this.value;
      fetchData(selectedOption);
    });
});

$(document).ready(function () {
  $("#myDataTable").DataTable({});
});
