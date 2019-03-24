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

    // Close other possible modals
    $('body').removeClass('modal-opened');
    $('.modal').removeClass('show');

    $.ajax({
      url: 'editsubscription',
      type: 'POST',
      dataType: 'html',
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
        $('.item-' + edit_id).replaceWith(response);

        // Reload page
       //  setTimeout(function() {
       //   location.reload();
       // }, 50);
      }
    });
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
      dataType: 'html',
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

    // Close other possible modals
    $('body').removeClass('modal-opened');
    $('.modal').removeClass('show');

    $.ajax({
      url: 'handlesubscription',
      type: 'POST',
      dataType: 'html',
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
        $('.item-' + edit_id).replaceWith(response);

        // Reload page
        setTimeout(function() {
         location.reload();
       }, 50);
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

    // Close other possible modals
    $('body').removeClass('modal-opened');
    $('.modal').removeClass('show');

    $.ajax({
      url: 'handlesubscription',
      type: 'POST',
      dataType: 'html',
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
        $('.item-' + edit_id).replaceWith(response);

        // Reload page
        setTimeout(function() {
         location.reload();
       }, 50);
      }
    });
  });

  // Save subscription to database
  $(document).on('click', '#submit-subscription', function() {

    // Close modals
    $('body').removeClass('modal-opened');
    $('.modal').removeClass('show');

    var subscription_biller = $('.modal-subscription-new #subscription_biller').val();
    var subscription_amount = $('.modal-subscription-new #subscription_amount').val();
    var subscription_month_day = $('.modal-subscription-new #subscription_month_day').val();
    var subscription_plan = $('.modal-subscription-new #subscription_plan').val();

    $.ajax({
      url: 'addsubscription',
      type: 'POST',
      dataType: 'html',
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
        // Add to row
        $('.items-subscriptions > .item:last').after(response);

        // Reload page
        setTimeout(function() {
         location.reload();
       }, 50);
      }
    });
  });

});
