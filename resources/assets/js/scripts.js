$(document).ready(function() {

  // Remove spaces from inputs if any key or click is pressed
  $('#refnumber, #accountnumber, #billnumber').keyup(function() {
    $(this).val($(this).val().replace(/ +?/g, ''));
  });

  $('#refnumber, #accountnumber, #billnumber').focus(function() {
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

  // Add new bill modal
  $(document).on('click', '.add-new', function() {
    $('body').addClass('modal-opened');
    var $div = $('.bill-modal-new').appendTo('body').hide().fadeIn('fast');
    $('.bill-modal-new').addClass('show');
    $('.bill-title').html('Uusi lasku');
  });

  // Modal on clicks
  $('.bills-list').on('click', '.row-clickable', function() {
    row_id = $(this).attr('data-row-id');
    $('body').addClass('modal-opened');
    var $div = $('.bill-modal-' + row_id).appendTo('body').hide().fadeIn('fast');
    $('.bill-modal-' + row_id).addClass('show');
  });

  // Close with esc
  $(document).keyup(function(e) {
    if (e.keyCode === 27) {
      $('body').removeClass('modal-opened');
      $('.bill-modal').removeClass('show');
    }
  });

  // Close with click outside
  $(document).on('click', '.show .bill-modal-overlay', function() {
    $('body').removeClass('modal-opened');
    $('.bill-modal').removeClass('show');
  });

  // Variables
  var duedates = $('.formatted-duedate');
  var amounts = $('.formatted-amount');

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

  // Set moment.js to Finnish language
  moment.locale('fi');

  // Run functions
  formatDate(duedates);
  colorAmounts(amounts);

  // Save bill to database
  $(document).on('click', '#submit_btn', function() {

    // Close modals
    $('body').removeClass('modal-opened');
    $('.bill-modal').removeClass('show');

    var biller = $('#biller').val();
    var billnumber = $('#billnumber').val();
    var virtualcode = $('#virtualcode').val();
    var refnumber = $('#refnumber').val();
    var accountnumber = $('#accountnumber').val();
    var type = $('#type').val();
    var description = $('#description').val();
    var amount = $('#amount').val();
    var duedate = $('#duedate').val();
    var userid = $('.user-id-input').val();

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
        'duedate': duedate,
        'userid': userid
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

        console.log(response);

        $('.bills-list tr:last').after(response);

        // Update total
        var currenttotal = $('.total .sum').text();
        var newtotal = parseInt(currenttotal) + parseInt(amount);
        $('.total .sum').text(newtotal);
      }
    });
  });

  // Delete from database
  $(document).on('click', '.delete', function() {
    var id = $(this).data('id');

    $.ajax({
      url: 'api/bills.php',
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

  $(document).on('click', '.edit', function() {
    edit_id = $(this).data('id');
    $edit_bill = $('.row-id-' + edit_id);

    // Close modals
    $('body').removeClass('modal-opened');
    $('.bill-modal').removeClass('show');

    // Open add/edit modal
    $('body').addClass('modal-opened');
    var $div = $('.bill-modal-new').appendTo('body').hide().fadeIn('fast');
    $('.bill-modal-new').addClass('show');
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
    var duedate = $('.row-id-' + edit_id + ' .duedate_text').attr('data-original-date');

    // Place bill in form
    $('#biller').val(biller);
    $('#billnumber').val(billnumber);
    $('#virtualcode').val(virtualcode);
    $('#refnumber').val(refnumber);
    $('#accountnumber').val(accountnumber);
    $('#type').val(type);
    $('#description').val(description);
    $('#amount').val(amount);
    $('#duedate').val(duedate);
    $('#submit_btn').hide();
    $('#update_btn').show();
  });

  $(document).on('click', '#update_btn', function() {
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

    $.ajax({
      url: 'api/bills.php',
      type: 'POST',
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
        $('#submit_btn').show();
        $('#update_btn').hide();
        $edit_bill.replaceWith(response);
      }
    });
  });

  // Mark as paid action
  $(document).on('click', '.mark-as-paid', function() {
    var id = $(this).attr('data-id');
    var paid = '1';
    var amount_substracted = $('.bill-modal-' + id + ' .formatted-amount').attr('data-original-amount');

    // Close modals
    $('body').removeClass('modal-opened');
    $('.bill-modal').removeClass('show');

    // Update total
    var currenttotal_substraction = $('.total .sum').text();
    var newtotal_substraction = parseInt(currenttotal_substraction) - parseInt(amount_substracted);
    $('.total .sum').text(newtotal_substraction);

    $.ajax({
      url: 'api/bills.php',
      type: 'POST',
      data: {
        'paid': 1,
        'id': id,
        'paid_status': paid,
      },
      success: function(response) {
        $('.row-id-' + id).fadeOut();
      }
    });
  });


});
