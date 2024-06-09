/* 
What: This script handles a multi-step form using ACF (Advanced Custom Fields) in WordPress.
Where: The script should be included in the WordPress theme or as a part of a custom plugin.
*/
jQuery(document).ready(function($) {

// Global variables
var steps, active, backBtn, nextBtn, submitBtn, updateContainerHeight;

// Function to set the active step and manage navigation
function setActiveStep(index, direction) {
  // Get the current and next steps based on the index
  var currentStep = $(steps[active]);
  var nextStep = $(steps[index]);

  // Add or remove the 'last_step' class on .stepFormContainer
  if (index === steps.length - 1) {
    $(".stepFormContainer").addClass("last_step");
    $(".stepFormButtons").addClass("last_step");

  } else {
    $(".stepFormContainer").removeClass("last_step");
    $(".stepFormButtons").removeClass("last_step");
    
  }

  // Slide animation based on direction
  if (direction === "forward") {
    currentStep.animate({ left: "-100%" }, 500, function () {
      currentStep.hide();
    });
    nextStep.css({ left: "100%" }).show().animate({ left: "0" }, 500);
  } else if (direction === "backward") {
    currentStep.animate({ left: "100%" }, 500, function () {
      currentStep.hide();
    });
    nextStep.css({ left: "-100%" }).show().animate({ left: "0" }, 500);
  }

  // Update the active step index
  active = index;

  // Update the container height
  updateContainerHeight();

  // Show or hide the back button
  if (active === 0) {
    backBtn.slideUp(500);
  } else {
    backBtn.slideDown(500);
  }

  // Show the submit or next button
  if (active === steps.length - 1) {
    nextBtn.slideUp(500, function () {
      submitBtn.slideDown(500);
    });
  } else {
    submitBtn.slideUp(500, function () {
      nextBtn.slideDown(500);
    });
  }
}

$(document).ready(function () {
  // Initialize global variables
  steps = $(".stepFormContainer .step");
  active = 0;
  backBtn = $(".stepFormButtons .back");
  nextBtn = $(".stepFormButtons .next");
  submitBtn = $(".stepFormButtons input[type=submit]");

  // Function to update the height of the step container
  updateContainerHeight = function () {
    var stepHeight = $(steps[active]).height();
    $(".stepFormContainer").height(stepHeight);
  };

  // Initial setup
  updateContainerHeight();
  backBtn.hide();
  submitBtn.hide();


  // Next button click event
  nextBtn.click(function () {
    if (active < steps.length - 1) {
      setActiveStep(active + 1, "forward");
    }
  });

  // Back button click event
  backBtn.click(function () {
    if (active > 0) {
      setActiveStep(active - 1, "backward");
    }
  });
});

// Update container height on click
$(document).on("click", ".stepFormContainer, .stepFormButtons", function () {
  setTimeout(updateContainerHeight, 0);
});

// ACF validation failure handling
$(document).ready(function () {
  if (typeof acf !== "undefined") {
    // Function to find the step index containing the error field
    function findStepIndexOfErrorField() {
      var stepIndex = -1;
      $(".step").each(function (index, step) {
        var errorFields = $(step).find(".acf-error-message");
        if (errorFields.length > 0) {
          stepIndex = index;
          return false;
        }
      });
      return stepIndex;
    }

    // Listen to ACF validation failure event
    acf.addAction("validation_failure", function ($form) {
      // Delay to ensure error messages are rendered
      setTimeout(function () {
        var stepIndex = findStepIndexOfErrorField();
        if (stepIndex !== -1) {
          setActiveStep(stepIndex, "forward");
        }
      }, 500);
    });
  }
});

});
