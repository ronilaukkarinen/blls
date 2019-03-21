$(document).ready(function() {

  // Add new subscription modal
  $(document).on('click', '.add-new-subscription', function() {
    $('body').addClass('modal-opened');
    var $div = $('.subscription-modal-new').appendTo('body').hide().fadeIn('fast');
    $('.subscription-modal-new').addClass('show');
  });

  // Edit subscriptions by clicking them
  $('.column-subscriptions').on('click', '.item', function() {
    $(this).addClass('edit-mode');
  });

  // Cancel editing
  $('.item').on('click', '.save-action', function() {
    $(this).parent().parent().removeClass('edit-mode');
  });

  // Save bill to database
  $(document).on('click', '#submit-subscription', function() {

    // Close modals
    // $('body').removeClass('modal-opened');
    // $('.subscription-modal').removeClass('show');

    var biller_subscription = $('#biller-subscription').val();
    var amount_subscription = $('#amount-subscription').val();
    var duedate_subscription = $('#duedate-subscription').val();

    $.ajax({
      url: 'addsubscription',
      type: 'POST',
      dataType: 'html',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'biller': biller_subscription,
        'amount_subscription': amount_subscription,
        'duedate_subscription': duedate_subscription
      },
      success: function(response) {
        $('#biller-subscription').val('');
        $('#amount-subscription').val('');
        $('#duedate-subscription').val('');

        // Add to row
        $('.items-subscriptions > .item:last').after(response);

        // Reload page
        setTimeout(function() {
         location.reload();
       }, 500);
      }
    });
  });

});
