$(document).ready(function() {

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

  // Remove bill
  $(document).on('click', '#remove-bill', function() {
  var remove_id = $(this).attr('data-id');

    // Close other possible modals
    $('body').removeClass('modal-opened');
    $('.modal').removeClass('show');

    // Fade out row
    $('.row-id-' + remove_id).fadeOut();

    // Update total
    var amount_to_be_substracted = $('.modal-bill-' + remove_id + ' .formatted-amount').attr('data-original-amount');
    var currenttotal_substraction = $('.total-amount').text();
    var newtotal_substraction = parseFloat(currenttotal_substraction).toFixed(2) - parseFloat(amount_to_be_substracted).toFixed(2);
    $('.total-amount').html(newtotal_substraction);

    $.ajax({
      url: 'removebill',
      type: 'POST',
      dataType: 'html',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        'id': remove_id
      },
      success: function(response) {
      }
    });
  });

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

  // Update bill
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
