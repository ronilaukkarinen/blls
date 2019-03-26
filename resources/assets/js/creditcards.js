$(document).ready(function() {

  // Open new modal from click
  $(document).on('click', '.add-new-credit-card', function() {
    $('body').addClass('modal-opened');
    var $div = $('.modal-credit-card-new').appendTo('body').hide().fadeIn('fast');
    $('.modal-credit-card-new').addClass('show');
  });

  // Open modal when clicking single items
  $('.items-creditcards').on('click', '.item', function() {
    row_id = $(this).attr('data-id');
    $('body').addClass('modal-opened');
    var $div = $('.modal-credit-card-' + row_id).appendTo('body').hide().fadeIn('fast');
    $('.modal-credit-card-' + row_id).addClass('show');
  });

// Save credit card to database
  $(document).on('click', '#submit-credit-card', function() {

    // Close modals
    $('body').removeClass('modal-opened');
    $('.modal').removeClass('show');

    var creditor = $('.modal-credit-card-new #creditor').val();
    var expirationdate = $('.modal-credit-card-new #expirationdate').val();
    var lastfourdigits = $('.modal-credit-card-new #lastfourdigits').val();
    var monthlyamount = $('.modal-credit-card-new #monthlycut').val();
    var creditcard_amount_paid = $('.modal-credit-card-new #creditcard_amount_paid').val();
    var creditcard_amount_total = $('.modal-credit-card-new #creditcard_amount_total').val();

    $.ajax({
      url: 'addcreditcard',
      type: 'POST',
      dataType: 'html',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'save': 1,
        'creditor': creditor,
        'expirationdate': expirationdate,
        'lastfourdigits': lastfourdigits,
        'monthlyamount': monthlyamount,
        'creditcard_amount_paid': creditcard_amount_paid,
        'creditcard_amount_total': creditcard_amount_total
      },
      success: function(response) {
        // Add to row
        $('.items-credit-cards > .item:last').after(response);

        // Reload page
        location.reload();
      }
    });
  });

});
