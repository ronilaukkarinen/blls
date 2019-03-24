$(document).ready(function() {

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

  // Set moment.js to Finnish language
  moment.locale('fi');

  // Run functions
  formatDate(duedates);
  colorAmounts(amounts);
  colorAmountsHigh(amounts_high);

  // Save bill to database
  $(document).on('click', '#submit-button', function() {

    // Close modals
    $('body').removeClass('modal-opened');
    $('.modal-bill').removeClass('show');

    var biller = $('#biller').val();
    var billnumber = $('#billnumber').val();
    var virtualcode = $('#virtualcode').val();
    var refnumber = $('#refnumber').val();
    var accountnumber = $('#accountnumber').val();
    var type = $('#type').val();
    var description = $('#description').val();
    var amount = $('#amount').val();
    var duedate = $('#duedate').val();

    // Update totals
    var currenttotal = $('.total-amount').text();
    var newtotal = parseFloat(currenttotal).toFixed(2) + parseFloat(amount).toFixed(2);
    $('.total-amount').html(newtotal);

    $.ajax({
      url: 'addbill',
      type: 'POST',
      dataType: 'html',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'save': 1,
        'biller': biller,
        'billnumber': billnumber,
        'virtualcode': virtualcode,
        'refnumber': refnumber,
        'accountnumber': accountnumber,
        'type': type,
        'description': description,
        'amount': amount,
        'duedate': duedate
      },
      success: function(response) {
        $('#biller').val('');
        $('#billnumber').val('');
        $('#virtualcode').val('');
        $('#refnumber').val('');
        $('#accountnumber').val('');
        $('#type').val('');
        $('#description').val('');
        $('#amount').val('');
        $('#duedate').val('');

        // Add to row
        $('.bills-list tr:last').after(response);

        // Reload page
        setTimeout(function() {
           location.reload();
        }, 50);
      }
    });
  });

  // Delete from database
  $(document).on('click', '.delete', function() {
    var id = $(this).data('id');

    $.ajax({
      url: 'deletebill',
      type: 'GET',
      data: {
      'delete': 1,
      'id': id,
      },
      success: function(response) {

        // Remove the deleted bill
        $('.row-id-' + id).remove();
        $('#biller').val('');
        $('#billnumber').val('');
        $('#virtualcode').val('');
        $('#refnumber').val('');
        $('#accountnumber').val('');
        $('#type').val('');
        $('#description').val('');
        $('#amount').val('');
        $('#duedate').val('');
      }
    });
  });
  var edit_id;
  var $edit_bill;

  // Edit bill
  $(document).on('click', '.edit', function() {
    edit_id = $(this).data('id');
    $edit_bill = $('.row-id-' + edit_id);

    // Close modals
    $('body').removeClass('modal-opened');
    $('.modal-bill').removeClass('show');

    // Open add/edit modal
    $('body').addClass('modal-opened');
    var $div = $('.modal-bill-new').appendTo('body').hide().fadeIn('fast');
    $('.modal-bill-new').addClass('show');
    $('.bill-title').html('Muokkaa laskua');

    // Grab the bill to be edited
    var biller = $('.row-id-' + edit_id + ' .biller_text').text();
    var billnumber = $('.row-id-' + edit_id + ' .billnumber_text').text();
    var virtualcode = $('.row-id-' + edit_id + ' .virtualcode_text').text();
    var refnumber = $('.row-id-' + edit_id + ' .refnumber_text').text();
    var accountnumber = $('.row-id-' + edit_id + ' .accountnumber_text').text();
    var type = $('.row-id-' + edit_id + ' .type_text').text();
    var description = $('.row-id-' + edit_id + ' .description_text').text();
    var amount = $('.row-id-' + edit_id + ' .formatted-amount').text();
    var duedate = $('.row-id-' + edit_id + ' .formatted-duedate').attr('data-copy-to-clipboard');

    // Place bill details into the form
    $('#biller').val(biller);
    $('#billnumber').val(billnumber);
    $('#virtualcode').val(virtualcode);
    $('#refnumber').val(refnumber);
    $('#accountnumber').val(accountnumber);
    $('#type').val(type);
    $('#description').val(description);
    $('#amount').val(amount);
    $('#duedate').val(duedate);
    $('#submit-button').hide();
    $('#update-button').show();
  });

  $(document).on('click', '#update-button', function() {
    var id = edit_id;
    var biller = $('#biller').val();
    var billnumber = $('#billnumber').val();
    var virtualcode = $('#virtualcode').val();
    var refnumber = $('#refnumber').val();
    var accountnumber = $('#accountnumber').val();
    var type = $('#type').val();
    var description = $('#description').val();
    var amount = $('#amount').val();
    var duedate = $('#duedate').val();

    // Close modals
    $('body').removeClass('modal-opened');
    $('.modal-bill').removeClass('show');

    $.ajax({
      url: 'editbill',
      type: 'POST',
      dataType: 'html',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'update': 1,
        'id': id,
        'biller': biller,
        'billnumber': billnumber,
        'virtualcode': virtualcode,
        'refnumber': refnumber,
        'accountnumber': accountnumber,
        'type': type,
        'description': description,
        'amount': amount,
        'duedate': duedate,
      },
      success: function(response) {
        $('#biller').val('');
        $('#billnumber').val('');
        $('#virtualcode').val('');
        $('#refnumber').val('');
        $('#accountnumber').val('');
        $('#type').val('');
        $('#description').val('');
        $('#amount').val('');
        $('#duedate').val('');
        $('#submit-button').show();
        $('#update-button').hide();

        $edit_bill.replaceWith(response);

        // Reload page
        setTimeout(function() {
         location.reload();
       }, 50);
      }
    });
  });

  // Mark as paid action
  $(document).on('click', '.mark-as-paid', function() {
    var id = $(this).attr('data-id');
    var amount_to_be_substracted = $('.modal-bill-' + id + ' .formatted-amount').attr('data-original-amount');

    // Close modals
    $('body').removeClass('modal-opened');
    $('.modal-bill').removeClass('show');

    // Update total
    var currenttotal_substraction = $('.total-amount').text();
    var newtotal_substraction = parseFloat(currenttotal_substraction).toFixed(2) - parseFloat(amount_to_be_substracted).toFixed(2);
    $('.total-amount').html(newtotal_substraction);

    // Fade out row
    $('.row-id-' + id).fadeOut();

    $.ajax({
      url: 'markaspaid',
      type: 'POST',
      dataType: 'html',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'id': id
      },
      success: function(response) {
      }
    });
  });

});
