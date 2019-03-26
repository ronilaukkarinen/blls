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
      <section class="dashboard-content dashboard-content-grid">

        <div class="column column-bills">
          <h1>{{ __('dashboard.summary') }}</h1>

          <div class="items status">
            <div class="item-col">
              <h2 class="title-small">{{ __('dashboard.total') }}</h2>
              <p class="amount">&euro; <span class="sum total-amount formatted-amount-high">{{ str_replace( '.', ',', $balance ) }}</span></p>
            </div>

            <div class="item-col">
              <h2 class="title-small">{{ __('dashboard.subscriptiontotal') }}</h2>
              <p class="amount">&euro; <span class="sum total-amount formatted-amount-high">{{ str_replace( '.', ',', $balance_subscriptions ) }}</span></p>
            </div>

            <div class="item-col">
              <h2 class="title-small">{{ __('dashboard.overalltotal') }}</h2>
              <p class="amount">&euro; <span class="sum total-amount formatted-amount-high">{{ str_replace( '.', ',', $balance_subscriptions + $balance ) }}</span></p>
            </div>
          </div>

          <h1>{{ __('dashboard.unpaidbills') }} <span class="add-new add-new-bill"><?php echo file_get_contents( 'svg/dashboard/plus.svg' ); ?></span></h1>

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
                <input type="text" name="biller" id="biller" class="biller-label" placeholder="{{ __('dashboard.biller') }}">
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
                <input type="text" name="description" id="description" placeholder="{{ __('dashboard.productdesc') }}">
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
                  <span class="flex amount">&euro; <input type="text" name="amount" id="amount" placeholder="100"></span>
                </div>

                <div class="row">
                  <label for="duedate">{{ __('dashboard.duedate') }}</label>
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

              <div class="freedom freedom-tada">
                <?php echo file_get_contents( 'svg/inboxzero/tada.svg' ); ?>
                <p class="punchline">{{ __('dashboard.punchline_all_done') }}<br />{{ __('dashboard.punchline_all_done_after_br') }}</p>
              </div>

            </div>
          <?php else : ?>

            <table class="bills-list" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <th class="row-biller">{{ __('dashboard.biller') }}</th>
                <th class="row-billnumber row-hidden">{{ __('dashboard.billnumber') }}</th>
                <th class="row-virtualcode row-hidden">{{ __('dashboard.virtualcode') }}</th>
                <th class="row-refnumber row-hidden">{{ __('dashboard.refnumber') }}</th>
                <th class="row-accountnumber row-hidden">{{ __('dashboard.accountnumber') }}</th>
                <th class="row-type row-hidden">{{ __('dashboard.type') }}</th>
                <th class="row-description row-hidden">{{ __('dashboard.description') }}</th>
                <th class="row-amount row-hidden">{{ __('dashboard.amount') }}</th>
                <th class="row-duedate row-hidden">{{ __('dashboard.duedate') }}</th>
                <th class="row-actions row-hidden">{{ __('dashboard.actions') }}</th>
              </tr>

            <?php
              // List bills
              foreach ( $bills as $bill) :

              // Check if not paid and if owned by current user
              if ( '0' == $bill->paid && Auth::id() == $bill->userid ) :

                // Variables
                $old_date = $bill->duedate;
                $old_date_timestamp = strtotime( $old_date );
                $formatted_date = date( 'd.m.Y', $old_date_timestamp );
                $stylish_date = date( 'd/m/Y', $old_date_timestamp );
                $local_date = strftime( "%e. %Bta %Y", $old_date_timestamp );
                $formatted_amount = str_replace( '.', ',', $bill->amount );

                ?>
                <tr class="row-clickable row-id-<?php echo $bill->id; ?>" data-row-id="<?php echo $bill->id; ?>">

                  <td data-heading="{{ __('dashboard.biller') }}" class="row-biller biller_text" data-copy-to-clipboard="<?php echo $bill->biller; ?>"><?php echo $bill->biller; ?></td>
                  <td data-heading="{{ __('dashboard.billnumber') }}" class="able-to-copy row-hidden row-billnumber billnumber_text" data-copy-to-clipboard="<?php echo $bill->billnumber; ?>"><?php echo $bill->billnumber; ?></td>
                  <td data-heading="{{ __('dashboard.virtualcode') }}" class="able-to-copy row-hidden row-virtualcode virtualcode_text" data-copy-to-clipboard="<?php echo $bill->virtualcode; ?>"><?php echo $bill->virtualcode; ?></td>
                  <td data-heading="{{ __('dashboard.refnumber') }}" class="able-to-copy row-hidden row-refnumber refnumber_text" data-copy-to-clipboard="<?php echo $bill->refnumber; ?>"><?php echo $bill->refnumber; ?></td>
                  <td data-heading="{{ __('dashboard.accountnumber') }}" class="able-to-copy row-hidden row-accountnumber accountnumber_text" data-copy-to-clipboard="<?php echo $bill->accountnumber; ?>"><?php echo $bill->accountnumber; ?></td>
                  <td data-heading="{{ __('dashboard.type') }}" class="row-type row-hidden type_text"><?php echo $bill->type; ?></td>
                  <td data-heading="{{ __('dashboard.description') }}" class="row-description row-hidden description_text"><?php echo $bill->description; ?></td>
                  <td data-heading="{{ __('dashboard.duedate') }}" class="formatted-duedate row-duedate duedate_text" data-balloon="<?php echo $local_date; ?>" data-copy-to-clipboard="<?php echo $formatted_date; ?>" data-balloon-pos="up"><?php echo $bill->duedate; ?></td>
                  <td data-heading="{{ __('dashboard.duedate') }} (original)" class="row-duedate-original row-hidden"><?php echo $bill->duedate; ?></td>
                  <td data-heading="{{ __('dashboard.amount') }}" class="row-amount amount amount_text" data-copy-to-clipboard="<?php echo $formatted_amount; ?>"><span>&euro;</span> <span class="formatted-amount"><?php echo $formatted_amount; ?></span></td>
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

          <div class="column column-subscriptions">
            <h1>{{ __('dashboard.subscriptions') }} <span class="add-new add-new-subscription"><?php echo file_get_contents( 'svg/dashboard/plus.svg' ); ?></span></h1>

            <?php if ( 0 == count( $subscriptions ) ) : ?>
              <div class="inbox-zero">

                <div class="freedom freedom-beer">
                  <?php echo file_get_contents( 'svg/inboxzero/beer.svg' ); ?>
                  <p class="punchline">{{ __('dashboard.punchline_beer') }}<br />{{ __('dashboard.punchline_beer_after_br') }}</p>
                </div>

              </div>
            <?php else : ?>

            <div class="items-subscriptions">
              <?php
              // List subscriptions
              foreach ( $subscriptions as $sub) :

                // Variables
                // Get day from inserted date
                $date_inserted = new \DateTime($sub->date);
                $timestamp = $date_inserted->format('Y-m-d') . ' 00:00:00';
                $timestamp_day = $date_inserted->format('d');
                $timestamp_month = $date_inserted->format('m');

                // If day has passed in this month, let's get next month
                if ( date( 'd' ) > $sub->day && date( 'm' ) == $timestamp_month ) :
                  $relative_month = date( 'm', strtotime('+1 month') );
                else :
                  $relative_month = $timestamp_month;
                endif;

                $old_date = date( 'Y-' ) . $relative_month . '-' . str_pad($sub->day, 2, '0', STR_PAD_LEFT) . ' ' . date( 'H:i:s' );
                $old_date_timestamp = strtotime( $old_date );
                $formatted_date = date( 'd.m.Y', $old_date_timestamp );
                $stylish_date = date( 'd/m/Y', $old_date_timestamp );
                $formatted_amount = str_replace( '.', ',', $sub->amount );
                $biller = strtolower( $sub->biller );

                // Check if owned by current user
                if ( Auth::id() == $sub->userid ) :
                ?>

                  <div class="item item-<?php echo $biller; ?> item-<?php echo $sub->id; ?><?php if ('1' != $sub->active) : ?> inactive<?php endif; ?>" data-id="<?php echo $sub->id; ?>">
                    <div class="logo">
                      <?php echo file_get_contents( "svg/subscriptions/{$biller}.svg" ); ?>

                      <div class="details">
                        <span class="biller"><?php if ( 'playstation' == $biller ) : echo 'PlayStation™ Network'; else : echo $sub->biller; endif; ?></span>
                        <span class="type"><?php echo $sub->plan; ?></span>
                      </div>
                    </div>

                    <div class="content">
                      <ul>
                        <li class="amount">&euro; <span class="value"><?php echo $formatted_amount; ?></span></li>
                        <li class="subscription-due"><span class="value formatted-duedate" data-copy-to-clipboard="<?php echo $formatted_date; ?>"><?php echo $old_date; ?></span></li>
                      </ul>
                    </div>
                  </div>

                  <?php
                endif;
              endforeach;
              ?>
            </div>
            <?php endif; ?>

            <div class="modal modal-subscription modal-subscription-new">

              <div class="modal-overlay"></div>
              <div class="modal-content">

                <form class="subscriptions-form">
                  <header class="modal-header">
                    <div>
                      <h2 class="subscription-title">{{ __('dashboard.newsubscription') }}</h2>
                      <h3 class="date"><?php echo date( 'd/m/Y'); ?></h3>
                    </div>
                  </header>

                  <div class="row">
                    <label for="subscription_biller">{{ __('dashboard.product') }}</label>
                    <select name="subscription_biller" id="subscription_biller">
                      <option value="Spotify">Spotify</option>
                      <option value="Netflix">Netflix</option>
                      <option value="BookBeat">BookBeat</option>
                      <option value="PlayStation">PlayStation™ Network</option>
                      <option value="Plex">Plex</option>
                      <option value="PayPal">PayPal</option>
                      <option value="Toshl">Toshl Finance</option>
                      <option value="Trakt">Trakt</option>
                      <option value="Patreon">Patreon</option>
                      <option value="Untappd">Untappd</option>
                      <option value="IRCCloud">IRCCloud</option>
                    </select>
                  </div>

                  <div class="row">
                    <label for="subscription_plan">{{ __('dashboard.subscription_description') }}</label>
                    <input type="text" name="subscription_plan" id="subscription_plan" placeholder="Esim. Family" value="Subscription">
                  </div>

                  <footer class="modal-footer">
                    <div class="row">
                      <label for="amount">{{ __('dashboard.totalamount') }}</label>
                      <span class="flex amount">&euro; <input type="text" name="subscription_amount" id="subscription_amount" placeholder="100"></span>
                    </div>

                    <div class="row">
                      <label for="subscription_month_day">{{ __('dashboard.renewaldate') }}</label>
                      <input type="text" name="subscription_month_day" id="subscription_month_day" class="due-date-subscription" placeholder="{{ date('d.m.Y') }}">
                    </div>
                  </footer>

                  <div class="row actions">
                    <button type="button" id="submit-subscription">{{ __('dashboard.submit') }}</button>
                  </div>
                </form>

              </div>

            </div>

            <?php
            // Subscription modals
            foreach ( $subscriptions as $subscription ) :

              // Variables
              // Get day from inserted date
              $date_inserted = new \DateTime($subscription->date);
              $timestamp = $date_inserted->format('Y-m-d') . ' 00:00:00';
              $timestamp_day = $date_inserted->format('d');
              $timestamp_month = $date_inserted->format('m');

              // If day has passed in this month, let's get next month
              if ( date( 'd' ) > $subscription->day && date( 'm' ) == $timestamp_month ) :
                $relative_month = date( 'm', strtotime('+1 month') );
              else :
                $relative_month = $timestamp_month;
              endif;

              $old_date = date( 'Y-' ) . $relative_month . '-' . str_pad($subscription->day, 2, '0', STR_PAD_LEFT) . ' ' . date( 'H:i:s' );
              $old_date_timestamp = strtotime( $old_date );
              $local_date = strftime( "%e. %Bta %Y", $old_date_timestamp );
              $formatted_amount = str_replace( '.', ',', $subscription->amount );
              $stylish_date = date( 'd/m/Y', $old_date_timestamp );
              $formatted_date = date( 'd.m.Y', $old_date_timestamp );

              // Check if owned by current user
              if ( Auth::id() == $subscription->userid ) :
              ?>

              <div class="modal modal-subscription modal-subscription-<?php echo $subscription->id; ?>">

              <div class="modal-overlay"></div>
              <div class="modal-content">

                <form class="subscriptions-form">
                  <header class="modal-header">
                    <div>
                      <h2 class="subscription-title">{{ __('dashboard.editsubscription') }}</h2>
                      <h3 class="date"><?php echo $stylish_date; ?></h3>
                    </div>
                  </header>

                  <div class="row">
                    <label for="subscription_biller">{{ __('dashboard.product') }}</label>
                    <select name="subscription_biller" id="subscription_biller">
                      <option value="<?php echo $subscription->biller; ?>"><?php echo $subscription->biller; ?></option>
                    </select>
                  </div>

                  <div class="row">
                    <label for="subscription_plan">{{ __('dashboard.subscription_description') }}</label>
                    <input type="text" name="subscription_plan" id="subscription_plan" placeholder="{{ __('dashboard.subscription_description_placeholder') }}" value="<?php echo $subscription->plan; ?>">
                  </div>

                  <footer class="modal-footer">
                    <div class="row">
                      <label for="amount">{{ __('dashboard.totalamount') }}</label>
                      <span class="flex amount">&euro; <input type="text" name="subscription_amount" id="subscription_amount" placeholder="100" value="<?php echo $formatted_amount; ?>"></span>
                    </div>

                    <div class="row">
                      <label for="subscription_month_day">{{ __('dashboard.subscription_month_day') }}</label>
                      <input type="text" name="subscription_month_day" id="subscription_month_day" class="subscription_month_day" placeholder="{{ date('d.m.Y') }}" value="<?php echo $formatted_date; ?>">
                    </div>
                  </footer>

                  <div class="row actions">
                    <button type="button" class="btn-update" id="update-subscription" data-id="<?php echo $subscription->id; ?>">{{ __('dashboard.update') }}</button>
                    <?php if ('1' == $subscription->active) : ?><button type="button" class="btn-makeinactive" id="make-inactive" data-id="<?php echo $subscription->id; ?>">{{ __('dashboard.makeinactive') }}</button><?php else : ?><button type="button" class="btn-makeactive" id="make-active" data-id="<?php echo $subscription->id; ?>">{{ __('dashboard.makeactive') }}</button><?php endif; ?>
                    <button type="button" class="btn-remove remove-button" id="remove-subscription" data-id="<?php echo $subscription->id; ?>" data-balloon="{{ __('dashboard.removeforgood') }}" data-balloon-pos="up"><span class="screen-reader-text">{{ __('dashboard.removeforgood') }}</span><?php echo file_get_contents( '../public/svg/dashboard/trash.svg' ); ?></button>
                  </div>
                </form>

              </div>

            </div>

            <?php
            endif;
            endforeach; ?>

          </div>

          <div class="column column-payment-plans">
            <h1>{{ __('dashboard.paymentplans') }} <span class="add-new add-new-paymentplan"><?php echo file_get_contents( 'svg/dashboard/plus.svg' ); ?></span></h1>

            <?php if ( 0 == count( $paymentplans ) ) : ?>
              <div class="inbox-zero">

                <div class="freedom freedom-calendar">
                  <?php echo file_get_contents( 'svg/inboxzero/calendar.svg' ); ?>
                  <p class="punchline">{{ __('dashboard.punchline_calendar') }}<br />{{ __('dashboard.punchline_calendar_after_br') }}</p>
                </div>

              </div>
            <?php else : ?>

            <div class="items items-playmentplans">
            <?php foreach ( $paymentplans as $paymentplan ) :

              // Check if owned by current user and not paid
              if ( '0' == $paymentplan->paid && Auth::id() == $paymentplan->userid ) :
            ?>

              <div class="item item-<?php echo $paymentplan->id; ?>" data-id="<?php echo $paymentplan->id; ?>">
                <h2>{{ $paymentplan->name }}</h2>

                <div class="progress-bar">
                  <?php
                    $percent = round( ( $paymentplan->months_paid / $paymentplan->months_total ) * 100 );

                    if ( $percent < 40 ) :
                      $percent_class = ' low';
                    elseif ( $percent > 40 ) :
                      $percent_class = ' medium';
                    else :
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

          <div class="column column-credit-cards">
            <h1>{{ __('dashboard.creditcards') }} <span class="add-new add-new-credit-card"><?php echo file_get_contents( 'svg/dashboard/plus.svg' ); ?></span></h1>

            <?php if ( 0 == count( $subscriptions ) ) : ?>
              <div class="inbox-zero">

                <div class="freedom freedom-fireworks">
                  <?php echo file_get_contents( 'svg/inboxzero/fireworks.svg' ); ?>
                  <p class="punchline">{{ __('dashboard.punchline_creditcard') }}<br />{{ __('dashboard.punchline_creditcard_after_br') }}</p>
                </div>

              </div>
            <?php else : ?>

            <div class="items items-creditcards">
            <?php
            // List credit cards
            foreach ( $creditcards as $creditcard) :

            // Check if owned by current user
            if ( Auth::id() == $creditcard->userid ) :
            ?>

            <div class="item item-<?php echo $creditcard->id; ?> item-creditcard" data-id="<?php echo $creditcard->id; ?>">
              <div class="col col-creditcard">

                <div class="credit-card credit-card-<?php echo trim( preg_replace( '/[^a-z0-9-]+/', '-', strtolower( $creditcard->creditor ) ), '-'); ?>">
                  <h3 class="name-on-card"><?php echo Auth::user()->name; ?></h3>
                  <div class="numbers">
                    <span><b>●●●●</b> <b>●●●●</b> <b>●●●●</b></span> <?php echo $creditcard->lastfourdigits; ?>
                  </div>
                  <div class="expiration-date">
                    <?php echo $creditcard->expirationdate; ?>
                  </div>
                </div>
              </div>

              <div class="col col-details">
                <div class="details">
                  <h2 class="title-larger creditor"><?php echo $creditcard->creditor; ?></h2>
                  <h3 class="title-small">{{ __('dashboard.monthlycut') }}</h3>
                  <p class="monthly-cut"><span class="amount">&euro; <span class="formatted-amount"><?php echo str_replace( '.', ',', $creditcard->monthlyamount ); ?></span></span> / {{ __('dashboard.permonth') }}</p>

                  <div class="progress-bar">
                      <?php
                      $percent = round( ( $creditcard->amount_paid / $creditcard->amount_total ) * 100 );

                      if ( $percent < 40 ) :
                        $percent_class = ' low';
                      elseif ( $percent > 40 ) :
                        $percent_class = ' medium';
                      else :
                        $percent_class = ' high';
                      endif;
                      ?>
                      <div class="progress<?php echo $percent_class; ?>" style="width: <?php echo $percent; ?>%;">
                        <p><?php echo $creditcard->amount_paid; ?> {{ __('dashboard.paidoftotal') }} <?php echo $creditcard->amount_total; ?> {{ __('dashboard.wholecredit') }}. (<?php echo $percent; ?>%)</p>
                      </div>
                    </div>
                </div>
              </div>

            </div>

            <?php
            endif;
            endforeach; ?>
            </div>
            <?php endif; ?>

      </section><!-- Dashboard ends! -->

      <?php
      // Credit card modals
      foreach ( $creditcards as $creditcard) :

      // Check if owned by current user
      if ( Auth::id() == $creditcard->userid ) :
      ?>

        <div class="modal modal-credit-card modal-credit-card-<?php echo $creditcard->id; ?>">

          <div class="modal-overlay"></div>
          <div class="modal-content">

            <form class="credit-card-form">
              <header class="modal-header">
                <div>
                  <h2 class="credit-card-title"><?php echo $creditcard->creditor; ?></h2>
                  <h3 class="date"><?php echo date( 'd/m/Y' ); ?></h3>
                </div>
              </header>

              <div class="row">
                <label for="creditor">{{ __('dashboard.creditor') }}</label>
                <select name="creditor" id="creditor">
                  <option value="<?php echo $creditcard->creditor; ?>"><?php echo $creditcard->creditor; ?></option>
                </select>
              </div>

              <div class="row">
                <label for="expirationdate">{{ __('dashboard.expirationdate') }}</label>
                <input type="text" name="expirationdate" id="expirationdate" value="<?php echo $creditcard->expirationdate; ?>" placeholder="<?php echo date( 'm/Y' ); ?>">
              </div>

              <div class="row">
                <label for="lastfourdigits">{{ __('dashboard.lastfourdigits') }}</label>
                <input type="text" name="lastfourdigits" id="lastfourdigits" value="<?php echo $creditcard->lastfourdigits; ?>" placeholder="1234">
              </div>

              <div class="row">
                <label for="monthlycut">{{ __('dashboard.monthlycut') }}</label>
                <input class="amount-big" type="text" name="monthlycut" id="monthlycut" value="<?php echo $creditcard->monthlyamount; ?>" placeholder="100">
              </div>

              <footer class="modal-footer">
                <div class="row">
                  <label for="creditcard_amount_paid">{{ __('dashboard.creditcard_amount_paid') }}</label>
                  <span class="amount"><input type="text" name="creditcard_amount_paid" id="creditcard_amount_paid" placeholder="500" value="<?php echo $creditcard->amount_paid; ?>"></span>
                </div>

                <div class="row">
                  <label for="creditcard_amount_total">{{ __('dashboard.creditcard_amount_total') }}</label>
                  <span class="amount"><input type="text" name="creditcard_amount_total" id="creditcard_amount_total" placeholder="1000" value="<?php echo $creditcard->amount_total; ?>"></span>
                </div>
              </footer>

              <div class="row actions">
                <button type="button" id="update-credit-card" class="btn-update" data-id="<?php echo $creditcard->id; ?>">{{ __('dashboard.update') }}</button>
                <button type="button" class="remove-button btn-remove" id="remove-credit-card" data-id="<?php echo $creditcard->id; ?>" data-balloon="{{ __('dashboard.removeforgood') }}" data-balloon-pos="up"><span class="screen-reader-text">{{ __('dashboard.removeforgood') }}</span><?php echo file_get_contents( '../public/svg/dashboard/trash.svg' ); ?></button>
              </div>
            </form>

          </div>

        <?php
        endif;
        endforeach;
        ?>

    <div class="modal modal-credit-card modal-credit-card-new">

      <div class="modal-overlay"></div>
      <div class="modal-content">

        <form class="credit-card-form">
          <header class="modal-header">
            <div>
              <h2 class="credit-card-title">{{ __('dashboard.newcreditcard') }}</h2>
              <h3 class="date"><?php echo date( 'd/m/Y' ); ?></h3>
            </div>
          </header>

          <div class="row">
            <label for="creditor">{{ __('dashboard.creditor') }}</label>
            <select name="creditor" id="creditor">
              <option value="Creditea">Creditea</option>
              <option value="Bank Norwegian">Bank Norwegian</option>
              <option value="Tuohi">Tuohi</option>
            </select>
          </div>

          <div class="row">
            <label for="expirationdate">{{ __('dashboard.expirationdate') }}</label>
            <input type="text" name="expirationdate" id="expirationdate" placeholder="<?php echo date( 'm/Y' ); ?>">
          </div>

          <div class="row">
            <label for="lastfourdigits">{{ __('dashboard.lastfourdigits') }}</label>
            <input type="text" name="lastfourdigits" id="lastfourdigits" placeholder="1234">
          </div>

          <div class="row">
            <label for="monthlycut">{{ __('dashboard.monthlycut') }}</label>
            <input class="amount-big" type="text" name="monthlycut" id="monthlycut" placeholder="100">
          </div>

          <footer class="modal-footer">
            <div class="row">
              <label for="creditcard_amount_paid">{{ __('dashboard.creditcard_amount_paid') }}</label>
              <span class="amount"><input type="text" name="creditcard_amount_paid" id="creditcard_amount_paid" placeholder="500"></span>
            </div>

            <div class="row">
              <label for="creditcard_amount_total">{{ __('dashboard.creditcard_amount_total') }}</label>
              <span class="amount"><input type="text" name="creditcard_amount_total" id="creditcard_amount_total" placeholder="1000"></span>
            </div>
          </footer>

          <div class="row actions">
            <button type="button" id="submit-credit-card" class="btn-submit">{{ __('dashboard.submit') }}</button>
          </div>
        </form>

      </div>

    <div class="modal modal-paymentplan modal-paymentplan-new">

      <div class="modal-overlay"></div>
      <div class="modal-content">

        <form class="paymentplan-form">
          <header class="modal-header">
            <div>
              <h2 class="paymentplan-title">{{ __('dashboard.newpaymentplan') }}</h2>
              <h3 class="date"><?php echo date( 'd/m/Y' ); ?></h3>
            </div>
          </header>

          <div class="row">
            <label for="paymentplan-name">{{ __('dashboard.paymentplanname') }}</label>
            <input type="text" name="paymentplan-name" id="paymentplan-name" placeholder="{{ __('dashboard.paymentplanname') }}">
          </div>

          <footer class="modal-footer">
            <div class="row">
              <label for="amount">{{ __('dashboard.paymentplan_monthspaid') }}</label>
              <span class="flex amount"><input type="text" name="paymentplan-months-paid" id="paymentplan-months-paid" placeholder="0"></span>
            </div>

            <div class="row">
              <label for="amount">{{ __('dashboard.paymentplan_monthstotal') }}</label>
              <span class="flex amount"><input type="text" name="paymentplan-months-total" id="paymentplan-months-total" placeholder="12"></span>
            </div>
          </footer>

          <div class="row actions">
            <button type="button" id="submit-paymentplan" class="btn-submit">{{ __('dashboard.submit') }}</button>
          </div>
        </form>

      </div>

<?php
// Payment plan modals
foreach ( $paymentplans as $paymentplan ) :

  // Check if owned by current user and not paid
  if ( '0' == $paymentplan->paid && Auth::id() == $paymentplan->userid ) :
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

            <button id="paid-button" class="mark-paymentplan-as-paid btn-markpaid" data-id="<?php echo $paymentplan->id; ?>" data-balloon="{{ __('dashboard.markaspaid') }}" data-balloon-pos="up"><?php echo file_get_contents( '../public/svg/dashboard/check.svg' ); ?><span class="screen-reader-text">{{ __('dashboard.markaspaid') }}</span></button>
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
$old_date = $bill->duedate;
$old_date_timestamp = strtotime( $old_date );
$local_date = strftime( "%e. %Bta %Y", $old_date_timestamp );
$stylish_date = date( 'd/m/Y', $old_date_timestamp );

// Check if not paid and if owned by current user
if ( '0' == $bill->paid && Auth::id() == $bill->userid ) :
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
        <p class="amount">&euro; <span class="formatted-amount able-to-copy" data-original-amount="<?php echo $bill->amount; ?>" data-copy-to-clipboard="<?php echo $formatted_amount; ?>"><?php echo $formatted_amount; ?></span></p>
      </div>

      <div class="row">
        <h3>{{ __('dashboard.duedate') }}</h3>
        <p class="due-date formatted-duedate able-to-copy" data-original-date="<?php echo $bill->duedate; ?>" data-balloon="<?php echo $local_date; ?>" data-copy-to-clipboard="<?php echo $formatted_date; ?>" data-balloon-pos="up"><?php echo $bill->duedate; ?></p>
      </div>
    </footer>

    <div class="row actions">
      <button type="button" class="btn-remove remove-button" id="remove-bill" data-id="<?php echo $bill->id; ?>" data-balloon="{{ __('dashboard.removeforgood') }}" data-balloon-pos="up"><span class="screen-reader-text">{{ __('dashboard.removeforgood') }}</span><?php echo file_get_contents( '../public/svg/dashboard/trash.svg' ); ?></button>
      <button class="edit" data-id="<?php echo $bill->id; ?>" data-balloon="{{ __('dashboard.edit') }}" data-balloon-pos="up"><?php echo file_get_contents( '../public/svg/dashboard/edit.svg' ); ?></button>
      <button class="mark-as-paid" data-id="<?php echo $bill->id; ?>" data-balloon="{{ __('dashboard.markaspaid') }}" data-balloon-pos="up"><?php echo file_get_contents( '../public/svg/dashboard/check.svg' ); ?><span class="screen-reader-text">{{ __('dashboard.markaspaid') }}</span></button>

      <?php if ( 'Osuuspankki' === Auth::user()->ebillprovider && 'E-lasku' === $bill->type ) : ?>
        <a target="_blank" href="https://www.op.fi" class="op-ebill"><?php echo file_get_contents( '../public/svg/dashboard/pay.svg' ); ?>{{ __('dashboard.op_ebill') }}</a>
      <?php endif; ?>
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
