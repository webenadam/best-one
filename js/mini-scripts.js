jQuery(document).ready(function($) {
  
  

// Function to move the slider
function moveSlider($container, tabIndex) {
  var $buttons = $container.find('.tabs .tab-button');
  var $targetButton = $buttons.eq(tabIndex);
  var sliderWidth = $targetButton.outerWidth();
  var right = $container.outerWidth() - $targetButton.position().left - sliderWidth;

  // Position the slider
  $container.find('.slider').css({
      'width': sliderWidth,
      'right': right + 'px'
  });
}

// Use 'on' method for dynamic content
$(document).on('click', '.tab-button', function() {
  var $container = $(this).closest('.tabs-container');
  var tabId = $(this).data('tab');
  var tabIndex = $(this).index() - 1; // Corrected: Adjust for the slider div


  $container.find('.tab-button').removeClass('active');
  $(this).addClass('active');

  $container.find('.tab-content').removeClass('active');
  $container.find('#tab-' + tabId).addClass('active');

  // Move the slider
  moveSlider($container, tabIndex);
});

// Initialize the first tab as active for each container and position the slider
$('.tabs-container').each(function() {
  var $firstTab = $(this).find('.tab-button.active');
  var tabIndex = $firstTab.index() - 1; // Corrected: Adjust for the slider div

  moveSlider($(this), tabIndex);
});

// Function to activate the tab containing the error
function activateTabWithError() {
  // Look for the error message class
  var $errorField = $('.acf-notice.acf-error-message').first();
  
  if ($errorField.length > 0) {
      var $currentElement = $errorField;
      var $tabContent = null;

      // Traverse up the DOM to find the parent .tab-content
      while ($currentElement.length > 0 && !$currentElement.hasClass('tabs-container')) {
          if ($currentElement.hasClass('tab-content')) {
              $tabContent = $currentElement;
              break;
          }
          $currentElement = $currentElement.parent();
      }

      
      if ($tabContent && $tabContent.length > 0) {
          var $container = $tabContent.closest('.tabs-container');
          var tabId = $tabContent.attr('id').replace('tab-', '');
          var $tabButton = $container.find('.tab-button[data-tab="' + tabId + '"]');
          var tabIndex = $tabButton.index() - 1; // Corrected: Adjust for the slider div


          $container.find('.tab-button').removeClass('active');
          $tabButton.addClass('active');

          $container.find('.tab-content').removeClass('active');
          $tabContent.addClass('active');

          // Move the slider
          moveSlider($container, tabIndex);
      } else {
          console.log('No tab content found for error field.');
      }
  } else {
      console.log('No error fields found.');
  }
}

// Listen for form submission and check for errors
$(document).on('submit', '.acf-form', function(event) {
  setTimeout(function() {
      // Delay to allow ACF to validate and show errors
      console.log('Form submitted, checking for errors...');
      activateTabWithError();
  }, 500); // Adjust delay if needed
});






    // Function to count all characters, including spaces and newlines
    function countAllCharacters(text) {
        return text.length;
    }

    function updateLetterCounts() {
        $('[letters-counter]').each(function() {
            var countedId = $(this).attr('letters-counter');
            var countedElement = $('#' + countedId);
            var text = countedElement.is('input, textarea') ? countedElement.val() : countedElement.text();
            var letterCount = countAllCharacters(text);

            $(this).text(letterCount);
        });
    }

    // Initial count
    updateLetterCounts();

    // Re-run the count after any AJAX content load
    $(document).ajaxComplete(function() {
        updateLetterCounts();
    });

    // Listen for input events to handle typing and pasting
    $(document).on('input', '[id]', function() {
        updateLetterCounts();
    });



// Accordion
$('.accordion-title').click(function() {
  var $content = $(this).next('.accordion-content');
  var $title = $(this);
  if ($content.is(':visible')) {
      $content.slideUp(200); // Adjust the duration to 200 milliseconds
      $title.removeClass('active');
  } else {
      $('.accordion-content').slideUp(200); // Adjust the duration to 200 milliseconds
      $('.accordion-title').removeClass('active');
      $content.slideDown(200); // Adjust the duration to 200 milliseconds
      $title.addClass('active');
  }
});

// Ensure the initially active item is displayed and styled correctly
$(document).ready(function() {
  $('.accordion-title.active').next('.accordion-content').show();
});




    // Create new pro form leads // Make sure it's running before the toggle-class funtcion
    $('#pro_form_submit').on('click', function (event) {

        // Check if the button has the toggle-class attribute and it's value is 'done'
        if ($(this).attr('toggle-class') == 'done') {
            const fullName = $('input[name="fullName"]').val();
            const phone = $('input[name="phone"]').val();
            const email = $('input[name="email"]').val();
            const subject = $('select[name="subject"]').val();

            // Check if any of the required fields are missing
            if (!fullName || !phone || !email || !subject) {
                $('.error-message').remove();
                $('<div class="error-message">נא למלא שדות חסרים</div>').insertAfter('#pro-contact-form');
                return;
            }

            const firstName = fullName.split(' ')[0];
            const lastName = fullName.split(' ').slice(1).join(' ');

            const postData = {
                action: 'create_lead',
                fullName: fullName,
                firstName: firstName,
                lastName: lastName,
                phone: phone,
                email: email,
                subject: subject,
                lead_source_type: 'שליחת טופס בעל מקצוע',
                lead_source_url: decodeURIComponent(window.location.href),
                lead_pro: miniScriptsData.current_post_id,
                title: fullName,
            };

            // Send the data via AJAX to the WordPress backend
            $.post(miniScriptsData.ajax_url, postData, function (response) {
                $('.confirmation-message, .error-message').remove();
                if (response.success) {
                    $('#pro-contact-form').slideUp(200);
                    $('#pro_form_submit').slideUp(200);
                    $('<div class="confirmation-message" style="font-size:var(--font-m);font-weight:var(--font-w-600);">' + response.data.message + '</div>').insertAfter('#pro-contact-form');
                } else {
                    $('<div class="error-message">' + response.data.message + '</div>').insertAfter('#pro-contact-form');
                }
            }).fail(function () {
                $('.error-message').remove();
                $('<div class="error-message">שגיאה בשליחת הטופס</div>').insertAfter('#pro-contact-form');
            });
        }

    });

    // Remove error message when starting to type or change one of the #pro-contact-form fields (input or select)
    $('#pro-contact-form input, #pro-contact-form select').on('input change', function () {
        $('.error-message').remove();
    });



  // Add click event listener to elements with the 'toggle-class' attribute
    $('[toggle-class]').on('click', function () {
        // Get the value of the 'toggle-class' attribute
        var toggleClassValue = $(this).attr('toggle-class');

        // Check if toggle-class is not equal to 'done'
        if (toggleClassValue !== 'done') {
            // Split the value to get the first selector and the class to be toggled
            var parts = toggleClassValue.split('.');
            var firstSelector = parts[0];
            var classToToggle = parts[1].replace(/-1$/, '');

            // Toggle the class on the element specified by the first selector
            $(firstSelector).toggleClass(classToToggle);

            // If toggle-class value ends with -1, set it to 'done'
            if (toggleClassValue.endsWith('-1')) {
                $(this).attr('toggle-class', 'done');
            }
            
        }
    });






  






  
});
