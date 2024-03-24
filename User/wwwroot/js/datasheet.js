window.onload = function () {
  // Fetch prompts from the server
  fetchPromptsAndAddRow();
};

function fetchPromptsAndAddRow() {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var options = JSON.parse(xhr.responseText);
        // Add a new row with fetched options
        addRow(options);
      } else {
        console.error("Error fetching prompts:", xhr.status);
      }
    }
  };

  xhr.open("GET", "modules/getPrompts.php", true);
  xhr.send();
}

function addRow(options) {
  var table = document.getElementById("dataTable");
  var rowCount = table.rows.length;

  var row = table.insertRow(rowCount);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);

  cell1.innerHTML = rowCount;
  cell2.innerHTML = '<input type="text" name="inputText[]">';

  // Create a select element
  var select = document.createElement("select");
  select.name = "dropdown[]";

  // Add options to the select element
  for (var i = 0; i < options.length; i++) {
    var option = document.createElement("option");
    option.value = options[i].promptID;
    option.text = options[i].promptName;
    select.add(option);
  }

  // Append the select element to the cell
  cell3.appendChild(select);

  cell4.innerHTML = '<textarea name="inputText[]"></textarea>';
}

function createPatient() {
  // Disable the Save button to prevent multiple clicks
  document.getElementById("saveButton").setAttribute("disabled", "true");

  var form = document.querySelector("form");
  var formData = new FormData(form);

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      // Re-enable the Save button regardless of the request outcome
      document.getElementById("saveButton").removeAttribute("disabled");

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

  xhr.open("POST", "modules/datasheet.php", true);
  xhr.send(formData);
}

document.getElementById("addRowButton").addEventListener("click", function () {
  fetchPromptsAndAddRow();
});
