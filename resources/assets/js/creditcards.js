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

});
