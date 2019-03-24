$(document).ready(function() {

  // Open new modal from click
  $(document).on('click', '.add-new-paymentplan', function() {
    $('body').addClass('modal-opened');
    var $div = $('.modal-paymentplan-new').appendTo('body').hide().fadeIn('fast');
    $('.modal-paymentplan-new').addClass('show');
  });

  // Open modal when clicking single items
  $('.items-playmentplans').on('click', '.item', function() {
    row_id = $(this).attr('data-id');
    $('body').addClass('modal-opened');
    var $div = $('.modal-paymentplan-' + row_id).appendTo('body').hide().fadeIn('fast');
    $('.modal-paymentplan-' + row_id).addClass('show');
  });

  // Save subscription to database
  $(document).on('click', '#submit-paymentplan', function() {

    // Close modals
    $('body').removeClass('modal-opened');
    $('.modal').removeClass('show');

    var paymentplan_name = $('.modal-paymentplan-new #paymentplan-name').val();
    var paymentplan_months_paid = $('.modal-paymentplan-new #paymentplan-months-paid').val();
    var paymentplan_months_total = $('.modal-paymentplan-new #paymentplan-months-total').val();

    $.ajax({
      url: 'addpaymentplan',
      type: 'POST',
      dataType: 'html',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'save': 1,
        'paymentplan_name': paymentplan_name,
        'paymentplan_months_paid': paymentplan_months_paid,
        'paymentplan_months_total': paymentplan_months_total
      },
      success: function(response) {
        // Add to row
        $('.items-paymentplans > .item:last').after(response);

        // Reload page
        setTimeout(function() {
         location.reload();
       }, 50);
      }
    });
  });

});
