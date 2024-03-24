document.addEventListener("DOMContentLoaded", function () {
  var openModalBtn = document.getElementById("openModalBtn");
  var closeModalBtn = document.getElementById("closeModalBtn");
  var modal = document.getElementById("myModal");

  // Open the modal
  openModalBtn.addEventListener("click", function () {
    modal.style.display = "block";
  });

  // Close the modal
  closeModalBtn.addEventListener("click", function () {
    modal.style.display = "none";
  });

  // Close the modal if the user clicks outside the modal content
  window.addEventListener("click", function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  });
});

$(document).ready(function () {
  $(".openModalBtn").click(function () {
    var modalId = $(this).data("modal-id");
    $("#" + modalId).css("display", "block");
  });

  $(".close").click(function () {
    $(".modal").css("display", "none");
  });

  $(".approveBtn").click(function () {
    var modalId = $(this).data("modal-id");
    showConfirmation(modalId, "approve");
  });

  $(".disapproveBtn").click(function () {
    var modalId = $(this).data("modal-id");
    showConfirmation(modalId, "disapprove");
  });

  function showConfirmation(modalId, action) {
    var title, text, icon;
    if (action === "approve") {
      title = "Approve PRC License ID";
      text = "This will approve the PRC License ID.";
      icon = "info";
    } else if (action === "disapprove") {
      title = "Disapprove PRC License ID";
      text = "This will disapprove the PRC License ID.";
      icon = "warning";
    }

    // Show SweetAlert confirmation
    Swal.fire({
      title: title,
      text: text,
      icon: icon,
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        updateStatus(modalId, action);
      }
    });
  }

  function updateStatus(modalId, action) {
    // Trigger AJAX function to update status
    $.ajax({
      type: "POST",
      url: "Modules/updateslp.php",
      data: {
        modalId: modalId,
        action: action,
      },
      success: function (response) {
        // Handle the response if needed
        console.log(response);
        // Close the modal after successful update
        $("#" + modalId).css("display", "none");
        location.reload(true);
      },
      error: function (error) {
        // Handle the error if needed
        console.error(error);
      },
    });
  }

  $(window).click(function (event) {
    if ($(event.target).hasClass("modal")) {
      $(".modal").css("display", "none");
    }
  });
});
