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
    var biller_subscription = $('#biller-subscription').val();
    var amount_subscription = $('#amount-subscription').val();
    var duedate_subscription = $('#duedate-subscription').val();
    var plan_subscription = $('#plan-subscription').val();

    // Close other possible modals
    $('body').removeClass('modal-opened');
    $('.modal-bill').removeClass('show');

    $.ajax({
      url: 'editsubscription',
      type: 'POST',
      dataType: 'html',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'update': 1,
        'biller_subscription': biller_subscription,
        'amount_subscription': amount_subscription,
        'duedate_subscription': duedate_subscription,
        'plan_subscription': plan_subscription
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

  // Make subscription inactive
  $(document).on('click', '#make-inactive', function() {
    var edit_id = $(this).attr('data-id');
    var biller_subscription = $('#biller-subscription').val();
    var amount_subscription = $('#amount-subscription').val();
    var duedate_subscription = $('#duedate-subscription').val();
    var plan_subscription = $('#plan-subscription').val();

    // Close other possible modals
    $('body').removeClass('modal-opened');
    $('.modal-bill').removeClass('show');

    $.ajax({
      url: 'cancelsubscription',
      type: 'POST',
      dataType: 'html',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'update': 1,
        'biller_subscription': biller_subscription,
        'amount_subscription': amount_subscription,
        'duedate_subscription': duedate_subscription,
        'plan_subscription': plan_subscription,
        'active': 0
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

  // Cancel editing
  $('.item').on('click', '.save-action', function() {
    $(this).parent().parent().removeClass('edit-mode');
  });

  // Save bill to database
  $(document).on('click', '#submit-subscription', function() {

    // Close modals
    $('body').removeClass('modal-opened');
    $('.modal').removeClass('show');

    var biller_subscription = $('#biller-subscription').val();
    var amount_subscription = $('#amount-subscription').val();
    var duedate_subscription = $('#duedate-subscription').val();
    var plan_subscription = $('#plan-subscription').val();

    $.ajax({
      url: 'addsubscription',
      type: 'POST',
      dataType: 'html',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'biller_subscription': biller_subscription,
        'amount_subscription': amount_subscription,
        'duedate_subscription': duedate_subscription,
        'plan_subscription': plan_subscription
      },
      success: function(response) {
        $('#biller-subscription').val('');
        $('#amount-subscription').val('');
        $('#plan-subscription').val('');
        $('#duedate-subscription').val('');

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
