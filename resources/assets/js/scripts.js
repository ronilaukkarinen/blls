$(document).ready(function() {

  // Masonry layout settings
  var packeryOptions = {
    itemSelector: '.column',
    gutter: 0
  };

  // Initialize Packery
  var $grid = $('.dashboard-content').packery( packeryOptions );
  var isActive = true;

  if ( window.innerWidth > 560 ) {
    $grid.packery( packeryOptions );
  }

  $(window).resize(function() {
    if ( window.innerWidth > 560 ) {
      $grid.packery( packeryOptions );
    } else {
      $grid.packery('destroy');
    }
  });

  // Remove spaces from inputs if any key or click is pressed
  $('#refnumber, #accountnumber, #billnumber, #amount').keyup(function() {
    $(this).val($(this).val().replace(/ +?/g, ''));
  });

  // Remove spaces from inputs when field is in focus
  $('#refnumber, #accountnumber, #billnumber, #amount').focus(function() {
    $(this).val($(this).val().replace(/ +?/g, ''));
  });

  // Make all commas dots in amounts
  $('#amount').keyup(function() {
    $(this).val($(this).val().replace(',', '.'));
  });

  // Copy to clipboard when clicked
  $('.able-to-copy').on('click', function() {
    value = $(this).attr('data-copy-to-clipboard');

      var $temp = $('<input>');
      $("body").append($temp);
      $temp.val(value).select();
      document.execCommand("copy");
      $temp.remove();

      $(this).append('<div class="message success">Tallessa!</div>').hide().fadeIn();
      setTimeout(function() {
        $('.message').fadeOut();
      }, 2000);
  })

  // Open new bill modal from click
  $(document).on('click', '.add-new-bill', function() {
    $('body').addClass('modal-opened');
    var $div = $('.modal-bill-new').appendTo('body').hide().fadeIn('fast');
    $('.modal-bill-new').addClass('show');
    $('.bill-title').html('Uusi lasku');
  });

  // Open modal when clicking single items
  $('.bills-list').on('click', '.row-clickable', function() {
    row_id = $(this).attr('data-row-id');
    $('body').addClass('modal-opened');
    var $div = $('.modal-bill-' + row_id).appendTo('body').hide().fadeIn('fast');
    $('.modal-bill-' + row_id).addClass('show');
  });

  // Close with esc
  $(document).keyup(function(e) {
    if (e.keyCode === 27) {
      $('body').removeClass('modal-opened');
      $('.modal-bill, .modal').removeClass('show');
    }
  });

  // Close with click outside
  $(document).on('click', '.show .modal-overlay', function() {
    $('body').removeClass('modal-opened');
    $('.modal-bill, .modal').removeClass('show');
  });

  // Variables
  var duedates = $('.formatted-duedate');
  var amounts = $('.formatted-amount');
  var amounts_high = $('.formatted-amount-high');

  // Functions
  function formatDate(date) {
    date.each(function() {
      var formattedDate = $(this).text();
      var now = Date.now();
      var d = moment(formattedDate, "YYYY-MM-DD H:i:s");
      $(this).html( d.fromNow());

      if (d > now) {
        $(this).addClass('future');
      } else {
        $(this).addClass('past');
      }
    });
  };

  function colorAmounts(amount) {
    amount.each(function() {
      var formattedAmount = parseInt($(this).text());

      if ((formattedAmount >= '0') && (formattedAmount <= '30')) {
        $(this).addClass('color-low');
        $(this).closest('.amount').addClass('color-low');
      }

      else if ((formattedAmount >= '30') && (formattedAmount <= '40')) {
        $(this).addClass('color-medium');
        $(this).closest('.amount').addClass('color-medium');
      }

      else if ((formattedAmount >= '40')) {
        $(this).addClass('color-high');
        $(this).closest('.amount').addClass('color-high');
      }
    });
  };

  function colorAmountsHigh(amount) {
    amount.each(function() {
      var formattedAmount = parseInt($(this).text());

      if ((formattedAmount >= '0') && (formattedAmount <= '50')) {
        $(this).addClass('color-low');
        $(this).closest('.amount').addClass('color-low');
      }

      else if ((formattedAmount >= '50') && (formattedAmount <= '70')) {
        $(this).addClass('color-medium');
        $(this).closest('.amount').addClass('color-medium');
      }

      else if ((formattedAmount >= '70')) {
        $(this).addClass('color-high');
        $(this).closest('.amount').addClass('color-high');
      }
    });
  };

  // Run functions
  formatDate(duedates);
  colorAmounts(amounts);
  colorAmountsHigh(amounts_high);

});
