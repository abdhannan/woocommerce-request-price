jQuery(document).ready(function ($) {
  // Open modal on button click
  $('.wrp-request-price-button').on('click', function (e) {
    e.preventDefault(); // Prevent default button behavior

    var productId = $(this).data('product-id'); // Get the product ID from the button
    var productTitle = $(this).data('product-title'); // Get the product title from data attribute
    var productImage = $(this).data('product-image'); // Get the product image from data attribute

    // Set product details in the modal
    $('#wrp-product-id').val(productId);
    $('#wrp-product-title').text(productTitle);
    $('#wrp-product-image').attr('src', productImage);

    $('#wrp-modal').fadeIn(); // Show modal
  });

  // Close modal when clicking outside the modal content
  $(document).on('click', function (event) {
    if (
      !$(event.target).closest('.wrp-modal-content').length &&
      !$(event.target).hasClass('wrp-request-price-button')
    ) {
      $('#wrp-modal').fadeOut(); // Hide the modal
    }
  });

  // Close modal on clicking the "X" button
  $('#wrp-close-modal').on('click', function (e) {
    e.preventDefault(); // Prevent default button behavior
    $('#wrp-modal').fadeOut(); // Hide the modal
  });

  // Submit the Request Price form via AJAX
  $('#wrp-request-price-form').on('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    // Show the loader
    $('#wrp-loader').show();

    var formData = $(this).serialize(); // Serialize all form data, including quantity

    $.ajax({
      url: wrp_ajax.ajax_url, // AJAX URL from PHP localization
      type: 'POST',
      data: formData + '&action=wrp_request_price',
      success: function (response) {
        alert(response.data); // Show success message
        $('#wrp-loader').hide(); // Hide loader
        $('#wrp-modal').fadeOut(); // Hide modal
        $('#wrp-request-price-form')[0].reset(); // Reset form
      },
      error: function () {
        alert('There was an error submitting your request. Please try again.');
        $('#wrp-loader').hide(); // Hide loader
      },
    });
  });
});
