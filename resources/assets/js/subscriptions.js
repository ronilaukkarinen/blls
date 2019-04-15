$(document).ready(function() {

  // Open new modal from click
  $(document).on('click', '.add-new-subscription', function() {
    $('body').addClass('modal-opened');
    var $div = $('.modal-subscription-new').appendTo('body').hide().fadeIn('fast');
    $('.modal-subscription-new').addClass('show');
  });

  // Open modal when clicking single items
  $('.items-subscriptions').on('click', '.item', function() {
    row_id = $(this).attr('data-id');
    $('body').addClass('modal-opened');
    var $div = $('.modal-subscription-' + row_id).appendTo('body').hide().fadeIn('fast');
    $('.modal-subscription-' + row_id).addClass('show');
  });

  // Edit subscription
  $(document).on('click', '#update-subscription', function() {
    var edit_id = $(this).attr('data-id');
    var subscription_biller = $('.modal-subscription-' + edit_id + ' #subscription_biller').val();
    var subscription_amount = $('.modal-subscription-' + edit_id + ' #subscription_amount').val();
    var subscription_month_day = $('.modal-subscription-' + edit_id + ' #subscription_month_day').val();
    var subscription_plan = $('.modal-subscription-' + edit_id + ' #subscription_plan').val();

    $.ajax({
      url: 'editsubscription',
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'update': 1,
        'id': edit_id,
        'subscription_biller': subscription_biller,
        'subscription_amount': subscription_amount,
        'subscription_month_day': subscription_month_day,
        'subscription_plan': subscription_plan
      },
      success: function(response) {
        if( response.errors ) {

          $.each(response.errors, function(key, value) {
            $('.validation-error').fadeIn('slow');
            $('.modal-subscription-' + edit_id + ' .validation-error .erroneous-fields').html( response.errors.slice(0, -1).join(', ') );

            setTimeout(function() {
              $('.validation-error').fadeOut('slow');
            }, 3000);
          });

          // Log errors
          console.log( response );

        } else {

          // Close modals
          $('body').removeClass('modal-opened');
          $('.modal').removeClass('show');

          // Reload page
          location.reload();
        }
      }
    });
  });

  // If original date is in the past, update the next month to database (emulate the "recurring" feature)
  $('.subscription-due').each(function() {
    var originaldate = $(this).attr('data-original-date');
    var thisId = $(this).attr('data-id');
    var now = Date.now();
    var d = moment(originaldate, "YYYY-MM-DD H:i:s");

    if (d < now) {
    // Update subscription date to database

    $.ajax({
      url: 'updatesubscriptiondate',
      type: 'POST',
      dataType: 'html',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'update': 1,
        'id': thisId,
        'subscription_date': originaldate
      },
      success: function(response) {
      }
    });

    }
  });

  // Remove subscription
  $(document).on('click', '#remove-subscription', function() {
    var edit_id = $(this).attr('data-id');

    // Close other possible modals
    $('body').removeClass('modal-opened');
    $('.modal').removeClass('show');

    // Fade out
    $('.item-' + edit_id).fadeOut();

    $.ajax({
      url: 'removesubscription',
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'id': edit_id
      },
      success: function(response) {
      }
    });
  });

  // Make subscription inactive
  $(document).on('click', '#make-inactive', function() {
    var edit_id = $(this).attr('data-id');
    var subscription_biller = $('.modal-subscription-' + edit_id + ' #subscription_biller').val();
    var subscription_amount = $('.modal-subscription-' + edit_id + ' #subscription_amount').val();
    var subscription_month_day = $('.modal-subscription-' + edit_id + ' #subscription_month_day').val();
    var subscription_plan = $('.modal-subscription-' + edit_id + ' #subscription_plan').val();

    $.ajax({
      url: 'handlesubscription',
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'update': 1,
        'id': edit_id,
        'subscription_active': 0,
        'subscription_biller': subscription_biller,
        'subscription_amount': subscription_amount,
        'subscription_month_day': subscription_month_day,
        'subscription_plan': subscription_plan
      },
      success: function(response) {
        if( response.errors ) {

          $.each(response.errors, function(key, value) {
            $('.validation-error').fadeIn('slow');
            $('.modal-subscription-' + edit_id + ' .validation-error .erroneous-fields').html( response.errors.slice(0, -1).join(', ') );

            setTimeout(function() {
              $('.validation-error').fadeOut('slow');
            }, 3000);
          });

          // Log errors
          console.log( response );

        } else {

          // Close modals
          $('body').removeClass('modal-opened');
          $('.modal').removeClass('show');

          // Reload page
          location.reload();
        }
      }
    });
  });

  // Make subscription active
  $(document).on('click', '#make-active', function() {
    var edit_id = $(this).attr('data-id');
    var subscription_biller = $('.modal-subscription-' + edit_id + ' #subscription_biller').val();
    var subscription_amount = $('.modal-subscription-' + edit_id + ' #subscription_amount').val();
    var subscription_month_day = $('.modal-subscription-' + edit_id + ' #subscription_month_day').val();
    var subscription_plan = $('.modal-subscription-' + edit_id + ' #subscription_plan').val();

    $.ajax({
      url: 'handlesubscription',
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'update': 1,
        'id': edit_id,
        'subscription_active': 1,
        'subscription_biller': subscription_biller,
        'subscription_amount': subscription_amount,
        'subscription_month_day': subscription_month_day,
        'subscription_plan': subscription_plan
      },
      success: function(response) {
        if( response.errors ) {

          $.each(response.errors, function(key, value) {
            $('.validation-error').fadeIn('slow');
            $('.modal-subscription-' + edit_id + ' .validation-error .erroneous-fields').html( response.errors.slice(0, -1).join(', ') );

            setTimeout(function() {
              $('.validation-error').fadeOut('slow');
            }, 3000);
          });

          // Log errors
          console.log( response );

        } else {

          // Close modals
          $('body').removeClass('modal-opened');
          $('.modal').removeClass('show');

          // Reload page
          location.reload();
        }
      }
    });
  });

  // Save subscription to database
  $(document).on('click', '#submit-subscription', function() {

    var subscription_biller = $('.modal-subscription-new #subscription_biller').val();
    var subscription_amount = $('.modal-subscription-new #subscription_amount').val();
    var subscription_month_day = $('.modal-subscription-new #subscription_month_day').val();
    var subscription_plan = $('.modal-subscription-new #subscription_plan').val();

    $.ajax({
      url: 'addsubscription',
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'save': 1,
        'subscription_biller': subscription_biller,
        'subscription_amount': subscription_amount,
        'subscription_month_day': subscription_month_day,
        'subscription_plan': subscription_plan
      },
      success: function(response) {
        if( response.errors ) {

          $.each(response.errors, function(key, value) {
            $('.validation-error').fadeIn('slow');
            $('.validation-error .erroneous-fields').html( response.errors.slice(0, -1).join(', ') );

            setTimeout(function() {
              $('.validation-error').fadeOut('slow');
            }, 3000);
          });

          // Log errors
          console.log( response );

        } else {

          // Close modals
          $('body').removeClass('modal-opened');
          $('.modal').removeClass('show');

          // Reload page
          location.reload();
        }
      }
    });
  });

});
