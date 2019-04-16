@extends('layout')

@section('title', 'Dashboard')

@section('body')

<?php
// Set locale
$lang = Config::get('app.locale');

if ( 'fi' == $lang ) :
  setlocale( LC_TIME, 'fi_FI.UTF8' );
endif;

if ( 'local' == App::environment() ) :
  setlocale( LC_TIME, 'fi_FI' );
endif;
?>

<section class="dashboard-content dashboard-content-paid">

  <div class="column-fullwidth column-bills column-bills-paid">
    <h1>{{ __('dashboard.summary') }}</h1>

    <div class="items status">
      <div class="item-col">
        <h2 class="title-small">{{ __('dashboard.totalpaid') }}</h2>
        <p class="amount"><?php echo Auth::user()->currency->symbol; ?> <span class="sum total-amount formatted-amount-high">{{ str_replace( '.', ',', $balance ) }}</span></p>
      </div>
    </div>

    <h1>{{ __('dashboard.paidbills') }}</h1>

    <div class="modal modal-bill modal-bill-new">
      <div class="modal-overlay"></div>
      <div class="modal-content">

        <form class="bills-form">
          <header class="modal-header">
            <div>
              <h2 class="bill-title">{{ __('dashboard.newbill') }}</h2>
              <h3 class="date"><?php echo date( 'd/m/Y' ); ?></h3>
            </div>

            <span class="bill-number">#<label for="billnumber" class="screen-reader-text">{{ __('dashboard.billnumber') }}</label><input type="text" name="billnumber" id="billnumber" class="bill-number" placeholder="183411639682"></span>
          </header>

          <div class="row biller">
            <label for="biller">{{ __('dashboard.biller') }}</label>
            <input type="text" name="biller" id="biller" class="biller-label" placeholder="Saaja">
          </div>

          <div class="row">
            <label for="accountnumber">{{ __('dashboard.accountnumber') }}</label>
            <input type="text" name="accountnumber" id="accountnumber" placeholder="FI0000000000000000">
          </div>

          <div class="row">
            <label for="virtualcode">{{ __('dashboard.virtualcode') }}</label>
            <input type="text" name="virtualcode" id="virtualcode" placeholder="438121430001070640000460000000000000000075867126190225">
          </div>

          <div class="row">
            <label for="refnumber">{{ __('dashboard.refnumber') }}</label>
            <input type="text" name="refnumber" id="refnumber" placeholder="10001957104320605">
          </div>

          <div class="row">
            <label for="description">{{ __('dashboard.product') }}</label>
            <input type="text" name="description" id="description" placeholder="Tuotteen tai palvelun nimi">
          </div>

          <div class="row">
            <label for="type">{{ __('dashboard.type') }}</label>
            <select name="type" id="type">
              <option value="E-lasku">{{ __('dashboard.ebill') }}</option>
              <option value="Sähköpostilasku">{{ __('dashboard.emailbill') }}</option>
              <option value="Paperilasku">{{ __('dashboard.paperbill') }}</option>
            </select>
          </div>

          <footer class="modal-footer">
            <div class="row">
              <label for="amount">{{ __('dashboard.totalamount') }}</label>
              <span class="flex amount"><?php echo Auth::user()->currency->symbol; ?> <input type="text" name="amount" id="amount" placeholder="100"></span>
            </div>

            <div class="row">
              <label for="duedate">{{ __('dashboard.datepaid') }}</label>
              <input type="text" name="duedate" id="duedate" class="due-date update-due-date" placeholder="{{ date('d.m.Y') }}">
            </div>
          </footer>

          <div class="row actions">
            <input type="hidden" class="user-id-input" value="{{ Auth::id() }}">
            <button type="button" id="submit-button" class="btn-submit">{{ __('dashboard.submit') }}</button>
            <button type="button" id="update-button" class="btn-update" style="display: none;">{{ __('dashboard.update') }}</button>
          </div>
        </form>

      </div>
    </div>

    <?php
    if ( 0 === $balance ) :
      ?>
      <div class="inbox-zero">

        <div class="freedom">
          <?php echo file_get_contents( 'svg/inboxzero/gamepad.svg' ); ?>
          <p class="punchline">You're all done!<br />Go play, you deserve it!</p>
        </div>

      </div>
      <?php else : ?>

        <table class="bills-list" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <th class="row-biller">{{ __('dashboard.biller') }}</th>
            <th class="row-billnumber">{{ __('dashboard.billnumber') }}</th>
            <th class="row-virtualcode row-hidden">{{ __('dashboard.virtualcode') }}</th>
            <th class="row-refnumber row-hidden">{{ __('dashboard.refnumber') }}</th>
            <th class="row-accountnumber row-hidden">{{ __('dashboard.accountnumber') }}</th>
            <th class="row-type row-hidden">{{ __('dashboard.type') }}</th>
            <th class="row-description row-hidden">{{ __('dashboard.description') }}</th>
            <th class="row-amount row-hidden">{{ __('dashboard.amount') }}</th>
            <th class="row-duedate row-hidden">{{ __('dashboard.datepaid') }}</th>
            <th class="row-actions row-hidden">{{ __('dashboard.actions') }}</th>
          </tr>

          <?php
          // List bills
          foreach ( $bills as $bill) :

            // Variables
            $old_date = $bill->datepaid;
            $old_date_timestamp = strtotime( $old_date );
            $formatted_date = date( 'd.m.Y', $old_date_timestamp );
            $stylish_date = date( 'd/m/Y', $old_date_timestamp );
            $local_date = strftime( "%e. %Bta %Y", $old_date_timestamp );
            $formatted_amount = str_replace( '.', ',', $bill->amount );
            $user_id = Auth::id();

              // Check if not paid and if owned by current user
            if ( '1' == $bill->paid && $user_id == $bill->userid ) :
              ?>
              <tr class="row-clickable row-id-<?php echo $bill->id; ?>" data-row-id="<?php echo $bill->id; ?>">

                <td data-heading="{{ __('dashboard.biller') }}" class="row-biller biller_text" data-copy-to-clipboard="<?php echo $bill->biller; ?>"><?php echo $bill->biller; ?></td>
                <td data-heading="{{ __('dashboard.billnumber') }}" class="able-to-copy row-hidden row-billnumber billnumber_text" data-copy-to-clipboard="<?php echo $bill->billnumber; ?>"><?php echo $bill->billnumber; ?></td>
                <td data-heading="{{ __('dashboard.virtualcode') }}" class="able-to-copy row-hidden row-virtualcode virtualcode_text" data-copy-to-clipboard="<?php echo $bill->virtualcode; ?>"><?php echo $bill->virtualcode; ?></td>
                <td data-heading="{{ __('dashboard.refnumber') }}" class="able-to-copy row-refnumber refnumber_text" data-copy-to-clipboard="<?php echo $bill->refnumber; ?>"><?php echo $bill->refnumber; ?></td>
                <td data-heading="{{ __('dashboard.accountnumber') }}" class="able-to-copy row-hidden row-accountnumber accountnumber_text" data-copy-to-clipboard="<?php echo $bill->accountnumber; ?>"><?php echo $bill->accountnumber; ?></td>
                <td data-heading="{{ __('dashboard.type') }}" class="row-type type_text"><?php echo $bill->type; ?></td>
                <td data-heading="{{ __('dashboard.description') }}" class="row-description description_text"><?php echo $bill->description; ?></td>
                <td data-heading="{{ __('dashboard.datepaid') }}" class="formatted-duedate row-duedate duedate_text" data-balloon="<?php echo $local_date; ?>" data-copy-to-clipboard="<?php echo $formatted_date; ?>" data-balloon-pos="up"><?php echo $bill->datepaid; ?></td>
                <td data-heading="{{ __('dashboard.datepaid') }} (original)" class="row-duedate-original row-hidden"><?php echo $bill->datepaid; ?></td>
                <td data-heading="{{ __('dashboard.amount') }}" class="row-amount amount amount_text" data-copy-to-clipboard="<?php echo $formatted_amount; ?>"><span><?php echo Auth::user()->currency->symbol; ?></span> <span class="formatted-amount"><?php echo $formatted_amount; ?></span></td>
                <td data-heading="{{ __('dashboard.actions') }}" class="row-actions row-hidden"><span class="delete" data-id="<?php echo $bill->id; ?>" ><?php echo file_get_contents( '../public/svg/dashboard/trash.svg' ); ?></span>
                  <span class="edit" data-id="<?php echo $bill->id; ?>"><?php echo file_get_contents( '../public/svg/dashboard/edit.svg' ); ?></span>
                  <span class="mark-as-paid" data-id="<?php echo $bill->id; ?>"><?php echo file_get_contents( '../public/svg/dashboard/check.svg' ); ?></span>
                </td>
              </tr>

            <?php endif; ?>
          <?php endforeach; ?>
        </table>

      <?php endif; ?>
    </div>

    <div class="column-fullwidth column-payment-plans">
      <h1>{{ __('dashboard.paymentplans') }}</h1>

      <?php if ( 0 == count( $paymentplans ) ) : ?>
        <div class="inbox-zero">

          <div class="freedom freedom-calendar">
            <?php echo file_get_contents( 'svg/inboxzero/calendar.svg' ); ?>
            <p class="punchline">{{ __('dashboard.punchline_calendar') }}<br />{{ __('dashboard.punchline_calendar_after_br') }}</p>
          </div>

        </div>
        <?php else : ?>

          <div class="items items-paymentplans">
            <?php foreach ( $paymentplans as $paymentplan ) :

              // Check if owned by current user and not paid
              if ( '1' == $paymentplan->paid && Auth::id() == $paymentplan->userid ) :
                ?>

                <div class="item item-<?php echo $paymentplan->id; ?>" data-id="<?php echo $paymentplan->id; ?>">
                  <h2>{{ $paymentplan->name }}</h2>

                  <div class="progress-bar">
                    <?php
                    $percent = round( ( $paymentplan->months_paid / $paymentplan->months_total ) * 100 );

                    if ( $percent < 40 ) :
                      $percent_class = ' low';
                    elseif ( $percent > 40 && $percent < 60 ) :
                      $percent_class = ' medium';
                    elseif ( $percent > 40 && $percent > 60 ) :
                      $percent_class = ' high';
                    endif;
                    ?>
                    <div class="progress<?php echo $percent_class; ?>" style="width: <?php echo $percent; ?>%;">
                      <p><?php echo $paymentplan->months_paid; ?> {{ __('dashboard.paidoftotal') }} <?php echo $paymentplan->months_total; ?> {{ __('dashboard.rounds') }}. (<?php echo $percent; ?>%)</p>
                    </div>
                  </div>
                </div>
                <?php
              endif;
            endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

  </section>

</div>

<?php
// Payment plan modals
foreach ( $paymentplans as $paymentplan ) :

  // Check if owned by current user and not paid
  if ( '1' == $paymentplan->paid && Auth::id() == $paymentplan->userid ) :
    ?>

    <div class="modal modal-paymentplan modal-paymentplan-<?php echo $paymentplan->id; ?>">

      <div class="modal-overlay"></div>
      <div class="modal-content">

        <form class="paymentplan-form">
          <header class="modal-header">
            <div>
              <h2 class="paymentplan-title">{{ __('dashboard.editpaymentplan') }}</h2>
              <h3 class="date"><?php echo date( 'd/m/Y' ); ?></h3>
            </div>
          </header>

          <div class="row">
            <label for="paymentplan-name">{{ __('dashboard.paymentplanname') }}</label>
            <input type="text" name="paymentplan-name" id="paymentplan-name" value="<?php echo $paymentplan->name; ?>" placeholder="{{ __('dashboard.paymentplanname') }}">
          </div>

          <footer class="modal-footer">
            <div class="row">
              <label for="amount">{{ __('dashboard.paymentplan_monthspaid') }}</label>
              <span class="flex amount"><input type="text" name="paymentplan-months-paid" id="paymentplan-months-paid" value="<?php echo $paymentplan->months_paid; ?>" placeholder="0"></span>
            </div>

            <div class="row">
              <label for="amount">{{ __('dashboard.paymentplan_monthstotal') }}</label>
              <span class="flex amount"><input type="text" name="paymentplan-months-total" id="paymentplan-months-total" value="<?php echo $paymentplan->months_total; ?>" placeholder="12"></span>
            </div>
          </footer>

          <div class="row actions">
            <button type="button" class="btn-update" id="update-paymentplan" data-id="<?php echo $paymentplan->id; ?>">{{ __('dashboard.update') }}</button>

            <button id="unpaid-button" class="mark-paymentplan-as-unpaid btn-markpaid" data-id="<?php echo $paymentplan->id; ?>" data-balloon="{{ __('dashboard.markunpaid') }}" data-balloon-pos="up"><?php echo file_get_contents( '../public/svg/dashboard/cancel.svg' ); ?><span class="screen-reader-text">{{ __('dashboard.markunpaid') }}</span></button>

            <button type="button" class="remove-button btn-remove" id="remove-paymentplan" data-id="<?php echo $paymentplan->id; ?>" data-balloon="{{ __('dashboard.removeforgood') }}" data-balloon-pos="up"><span class="screen-reader-text">{{ __('dashboard.removeforgood') }}</span><?php echo file_get_contents( '../public/svg/dashboard/trash.svg' ); ?></button>
          </div>
        </form>

      </div>

    </div>

    <?php
  endif;
endforeach; ?>

</div>

<?php
// Bill modals
foreach ( $bills as $bill) :

// Define formatted date
$formatted_amount = str_replace( '.', ',', $bill->amount );
$old_date = $bill->datepaid;
$old_date_timestamp = strtotime( $old_date );
$local_date = strftime( "%e. %Bta %Y", $old_date_timestamp );
$stylish_date = date( 'd/m/Y', $old_date_timestamp );

// Check if not paid and if owned by current user
if ( '1' == $bill->paid && Auth::id() == $bill->userid ) :
?>

<div class="modal modal-bill modal-bill-<?php echo $bill->id; ?>">
  <div class="modal-overlay"></div>
  <div class="modal-content">
    <header class="modal-header">
      <div>
        <h2>{{ __('dashboard.bill') }}</h2>
        <h3 class="date"><?php echo $stylish_date; ?></h3>
      </div>

      <span class="bill-number">#<span class="able-to-copy" data-copy-to-clipboard="<?php echo $bill->billnumber; ?>"><?php echo $bill->billnumber; ?></span></span>
    </header>

    <div class="row biller">
      <h3>{{ __('dashboard.biller') }}</h3>
      <p class="able-to-copy" data-copy-to-clipboard="<?php echo $bill->biller; ?>"><?php echo $bill->biller; ?></p>
    </div>

    <div class="row">
      <h3>{{ __('dashboard.accountnumber') }}</h3>
      <p class="able-to-copy" data-copy-to-clipboard="<?php echo $bill->accountnumber; ?>"><?php echo $bill->accountnumber; ?></p>
    </div>

    <?php if ( ! empty( $bill->virtualcode ) ) : ?>
    <div class="row">
      <h3>{{ __('dashboard.virtualcode') }}</h3>
      <p class="able-to-copy" data-copy-to-clipboard="<?php echo $bill->virtualcode; ?>"><?php echo $bill->virtualcode; ?></p>
    </div>
    <?php endif; ?>

    <div class="row">
      <h3>{{ __('dashboard.refnumber') }}</h3>
      <p class="able-to-copy" data-copy-to-clipboard="<?php echo $bill->refnumber; ?>"><?php echo $bill->refnumber; ?></p>
    </div>

    <div class="row">
      <h3>{{ __('dashboard.product') }}</h3>
      <p class="able-to-copy" data-copy-to-clipboard="<?php echo $bill->description; ?>"><?php echo $bill->description; ?></p>
    </div>

    <footer class="modal-footer">
      <div class="row">
        <h3>{{ __('dashboard.totalamount') }}</h3>
        <p class="amount"><?php echo Auth::user()->currency->symbol; ?> <span class="formatted-amount able-to-copy" data-original-amount="<?php echo $bill->amount; ?>" data-copy-to-clipboard="<?php echo $formatted_amount; ?>"><?php echo $formatted_amount; ?></span></p>
      </div>

      <div class="row">
        <h3>{{ __('dashboard.datepaid') }}</h3>
        <p class="due-date formatted-duedate able-to-copy" data-original-date="<?php echo $bill->datepaid; ?>" data-balloon="<?php echo $local_date; ?>" data-copy-to-clipboard="<?php echo $formatted_date; ?>" data-balloon-pos="up"><?php echo $bill->datepaid; ?></p>
      </div>
    </footer>

    <div class="row actions">
      <button type="button" class="btn-remove remove-button" id="remove-bill" data-id="<?php echo $bill->id; ?>" data-balloon="{{ __('dashboard.removeforgood') }}" data-balloon-pos="up"><span class="screen-reader-text">{{ __('dashboard.removeforgood') }}</span><?php echo file_get_contents( '../public/svg/dashboard/trash.svg' ); ?></button>

      <button class="mark-as-unpaid" data-id="<?php echo $bill->id; ?>" data-balloon="{{ __('dashboard.markunpaid') }}" data-balloon-pos="up"><?php echo file_get_contents( '../public/svg/dashboard/cancel.svg' ); ?><span class="screen-reader-text">{{ __('dashboard.markunpaid') }}</span></button>
    </div>
  </div>
</div>
<?php
endif;
endforeach;
?>

<script>
// Set moment.js to current language
moment.locale('{{ Config::get('app.locale') }}');
</script>

@endsection
