@extends('layout')

@section('title', 'Dashboard')

@section('body')

      <section class="dashboard-content">

        <div class="column-bills">
          <h1>{{ __('dashboard.summary') }}</h1>

          <div class="items status">
            <div class="item-col month-current">
              <h2 class="title-small">{{ __('dashboard.total') }}</h2>
              <p class="amount">&euro; <span class="sum total-amount formatted-amount">{{ str_replace( '.', ',', $balance ) }}</span></p>
            </div>

            <!-- <div class="item-col month-next">
              <h2 class="title-small">Ensi kuussa</h2>
              <p class="amount color-high">684,15 €</p>
            </div> -->
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
                <label for="biller">Saaja</label>
                <input type="text" name="biller" id="biller" class="biller-label" placeholder="Saaja">
              </div>

              <div class="row">
                <label for="accountnumber">Tilinumero</label>
                <input type="text" name="accountnumber" id="accountnumber" placeholder="FI0000000000000000">
              </div>

              <div class="row">
                <label for="virtualcode">Virtuaaliviivakoodi</label>
                  <input type="text" name="virtualcode" id="virtualcode" placeholder="438121430001070640000460000000000000000075867126190225">
              </div>

              <div class="row">
                <label for="refnumber">Viitenumero</label>
                <input type="text" name="refnumber" id="refnumber" placeholder="10001957104320605">
              </div>

              <div class="row">
                <label for="description">Tuote</label>
                <input type="text" name="description" id="description" placeholder="Tuotteen tai palvelun nimi">
              </div>

              <div class="row">
                <label for="type">Tyyppi:</label>
                <select name="type" id="type">
                  <option value="E-lasku">E-lasku</option>
                  <option value="Sähköpostilasku">Sähköpostilasku</option>
                  <option value="Paperilasku">Paperilasku</option>
                </select>
              </div>

              <footer class="modal-footer">
                <div class="row">
                  <label for="amount">Yhteensä</label>
                  <span class="flex amount">&euro; <input type="text" name="amount" id="amount" placeholder="100"></span>
                </div>

                <div class="row">
                  <label for="duedate">Eräpäivä</label>
                  <input type="text" name="duedate" id="duedate" class="due-date update-due-date" placeholder="{{ date('d.m.Y') }}">
                </div>
              </footer>

              <div class="row actions">
                <input type="hidden" class="user-id-input" value="{{ Auth::id() }}">
                <button type="button" id="submit-button">Lisää</button>
                <button type="button" id="update-button" style="display: none;">Päivitä</button>
              </div>
            </form>

          </div>
        </div>

          <?php
            if ( 0 === $balance ) :
            ?>
            InboxZero
          <?php else : ?>

            <table class="bills-list" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <th class="row-biller">Laskuttaja</th>
                <th class="row-billnumber row-hidden">Laskun numero</th>
                <th class="row-virtualcode row-hidden">Virtuaaliviivakoodi</th>
                <th class="row-refnumber row-hidden">Viitenumero</th>
                <th class="row-accountnumber row-hidden">Tilinumero</th>
                <th class="row-type row-hidden">Tyyppi</th>
                <th class="row-description row-hidden">Selite</th>
                <th class="row-amount row-hidden">Summa</th>
                <th class="row-duedate row-hidden">Eräpäivä</th>
                <th class="row-actions row-hidden">Toiminnot</th>
              </tr>

            <?php
              // List bills
              foreach ( $bills as $bill) :

              // Variables
              $old_date = $bill->duedate;
              $old_date_timestamp = strtotime( $old_date );
              $formatted_date = date( 'd.m.Y', $old_date_timestamp );
              $stylish_date = date( 'd/m/Y', $old_date_timestamp );
              setlocale( LC_TIME, "fi_FI" );
              $local_date = strftime( "%e. %Bta %Y", $old_date_timestamp );
              $formatted_amount = str_replace( '.', ',', $bill->amount );
              $user_id = Auth::id();

              // Check if not paid and if owned by current user
              if ( '0' == $bill->paid && $user_id == $bill->userid ) :
                ?>
                <tr class="row-clickable row-id-<?php echo $bill->id; ?>" data-row-id="<?php echo $bill->id; ?>">

                  <td data-heading="Laskuttaja" class="row-biller biller_text" data-copy-to-clipboard="<?php echo $bill->biller; ?>"><?php echo $bill->biller; ?></td>
                  <td data-heading="Laskun numero" class="able-to-copy row-hidden row-billnumber billnumber_text" data-copy-to-clipboard="<?php echo $bill->billnumber; ?>"><?php echo $bill->billnumber; ?></td>
                  <td data-heading="Virtuaaliviivakoodi" class="able-to-copy row-hidden row-virtualcode virtualcode_text" data-copy-to-clipboard="<?php echo $bill->virtualcode; ?>"><?php echo $bill->virtualcode; ?></td>
                  <td data-heading="Viitenumero" class="able-to-copy row-hidden row-refnumber refnumber_text" data-copy-to-clipboard="<?php echo $bill->refnumber; ?>"><?php echo $bill->refnumber; ?></td>
                  <td data-heading="Tilinumero" class="able-to-copy row-hidden row-accountnumber accountnumber_text" data-copy-to-clipboard="<?php echo $bill->accountnumber; ?>"><?php echo $bill->accountnumber; ?></td>
                  <td data-heading="Tyyppi" class="row-type row-hidden type_text"><?php echo $bill->type; ?></td>
                  <td data-heading="Selite" class="row-description row-hidden description_text"><?php echo $bill->description; ?></td>
                  <td data-heading="Eräpäivä" class="formatted-duedate row-duedate duedate_text" data-balloon="<?php echo $local_date; ?>" data-copy-to-clipboard="<?php echo $formatted_date; ?>" data-balloon-pos="up"><?php echo $bill->duedate; ?></td>
                  <td data-heading="Eräpäivä (original)" class="row-duedate-original row-hidden"><?php echo $bill->duedate; ?></td>
                  <td data-heading="Summa" class="row-amount amount amount_text" data-copy-to-clipboard="<?php echo $formatted_amount; ?>"><span>&euro;</span> <span class="formatted-amount"><?php echo $formatted_amount; ?></span></td>
                  <td data-heading="Toiminnot" class="row-actions row-hidden"><span class="delete" data-id="<?php echo $bill->id; ?>" ><?php echo file_get_contents( '../public/svg/dashboard/trash.svg' ); ?></span>
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
            <h1>Kuukausimaksulliset palvelut <span class="add-new add-new-subscription"><?php echo file_get_contents( 'svg/dashboard/plus.svg' ); ?></span></h1>

            <div class="items-subscriptions">
              <?php
              // List subscriptions
              foreach ( $subscriptions as $sub) :

                // Variables
                $old_date = $sub->date;
                $old_date_timestamp = strtotime( $old_date );
                $formatted_date = date( 'd.m.Y', $old_date_timestamp );
                $stylish_date = date( 'd/m/Y', $old_date_timestamp );
                setlocale( LC_TIME, "fi_FI" );
                $formatted_amount = str_replace( '.', ',', $sub->amount );
                $user_id = Auth::id();
                $biller = strtolower( $sub->biller );

                // Check if not paid and if owned by current user
                if ( $user_id == $sub->userid ) :
                  ?>

                  <div class="item item-<?php echo $biller; ?> item-<?php echo $sub->id; ?><?php if ('1' != $sub->active) : ?> inactive<?php endif; ?>" data-id="<?php echo $sub->id; ?>">
                    <div class="logo">
                      <?php echo file_get_contents( "svg/subscriptions/{$biller}.svg" ); ?>

                      <div class="details">
                        <span class="biller"><?php echo $sub->biller; ?></span>
                        <span class="type"><?php echo $sub->plan; ?></span>
                      </div>
                    </div>

                    <div class="content">
                      <ul>
                        <li class="amount">&euro; <span class="value"><?php echo $formatted_amount; ?></span></li>
                        <li class="subscription-due"><span class="value" data-copy-to-clipboard="<?php echo $formatted_date; ?>"><?php echo $stylish_date; ?></span></li>
                      </ul>
                    </div>
                  </div>

                  <?php
                endif;
              endforeach;
              ?>
            </div>

            <div class="modal modal-subscription modal-subscription-new">

              <div class="modal-overlay"></div>
              <div class="modal-content">

                <form class="subscriptions-form">
                  <header class="modal-header">
                    <div>
                      <h2 class="subscription-title">Uusi kuukausimaksu</h2>
                      <h3 class="date"><?php echo $stylish_date; ?></h3>
                    </div>
                  </header>

                  <div class="row">
                    <label for="subscription_biller">Tuote</label>
                    <select name="subscription_biller" id="subscription_biller">
                      <option value="Spotify">Spotify</option>
                      <option value="Netflix">Netflix</option>
                    </select>
                  </div>

                  <div class="row">
                    <label for="subscription_plan">Tuotepaketin nimi tai muu selite</label>
                    <input type="text" name="subscription_plan" id="subscription_plan" placeholder="Esim. Family">
                  </div>

                  <footer class="modal-footer">
                    <div class="row">
                      <label for="amount">Yhteensä</label>
                      <span class="flex amount">&euro; <input type="text" name="subscription_amount" id="subscription_amount" placeholder="100"></span>
                    </div>

                    <div class="row">
                      <label for="subscription_date">Eräpäivä</label>
                      <input type="text" name="subscription_date" id="subscription_date" class="due-date-subscription" placeholder="{{ date('d.m.Y') }}">
                    </div>
                  </footer>

                  <div class="row actions">
                    <button type="button" id="submit-subscription">Lisää</button>
                    <button type="button" id="update-subscription" style="display: none;">Päivitä</button>
                  </div>
                </form>

              </div>

            </div>

            <?php
            // Subscription modals
            foreach ( $subscriptions as $subscription ) :

              // Define formatted date
              $formatted_amount = str_replace( '.', ',', $subscription->amount );
              $old_date = $subscription->date;
              $old_date_timestamp = strtotime( $old_date );
              $local_date = strftime( "%e. %Bta %Y", $old_date_timestamp );
              $stylish_date = date( 'd/m/Y', $old_date_timestamp );
              $formatted_date = date( 'd.m.Y', $old_date_timestamp );

              // Check if not paid and if owned by current user
              if ( $user_id == $subscription->userid ) :
                ?>

              <div class="modal modal-subscription modal-subscription-<?php echo $subscription->id; ?>">

              <div class="modal-overlay"></div>
              <div class="modal-content">

                <form class="subscriptions-form">
                  <header class="modal-header">
                    <div>
                      <h2 class="subscription-title">Muokkaa kuukausimaksua</h2>
                      <h3 class="date"><?php echo $stylish_date; ?></h3>
                    </div>
                  </header>

                  <div class="row">
                    <label for="subscription_biller">Tuote</label>
                    <select name="subscription_biller" id="subscription_biller">
                      <option value="<?php echo $subscription->biller; ?>"><?php echo $subscription->biller; ?></option>
                    </select>
                  </div>

                  <div class="row">
                    <label for="subscription_plan">Tuotepaketin nimi tai muu selite</label>
                    <input type="text" name="subscription_plan" id="subscription_plan" placeholder="Esim. Family" value="<?php echo $subscription->plan; ?>">
                  </div>

                  <footer class="modal-footer">
                    <div class="row">
                      <label for="amount">Yhteensä</label>
                      <span class="flex amount">&euro; <input type="text" name="subscription_amount" id="subscription_amount" placeholder="100" value="<?php echo $formatted_amount; ?>"></span>
                    </div>

                    <div class="row">
                      <label for="subscription_date">Eräpäivä</label>
                      <input type="text" name="subscription_date" id="subscription_date" class="subscription_date" placeholder="{{ date('d.m.Y') }}" value="<?php echo $formatted_date; ?>">
                    </div>
                  </footer>

                  <div class="row actions">
                    <button type="button" id="update-subscription" data-id="<?php echo $subscription->id; ?>">Päivitä</button>
                    <?php if ('1' == $subscription->active) : ?><button type="button" id="make-inactive" data-id="<?php echo $subscription->id; ?>">Poista käytöstä</button><?php else : ?><button type="button" id="make-active" data-id="<?php echo $subscription->id; ?>">Ota käyttöön</button><?php endif; ?>
                  </div>
                </form>

              </div>

            </div>

            <?php
            endif;
            endforeach; ?>



          </div>

      </section>

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
if ( '0' == $bill->paid && $user_id == $bill->userid ) :
?>

<div class="modal modal-bill modal-bill-<?php echo $bill->id; ?>">
  <div class="modal-overlay"></div>
  <div class="modal-content">
    <header class="modal-header">
      <div>
        <h2>Lasku</h2>
        <h3 class="date"><?php echo $stylish_date; ?></h3>
      </div>

      <span class="bill-number">#<span class="able-to-copy" data-copy-to-clipboard="<?php echo $bill->billnumber; ?>"><?php echo $bill->billnumber; ?></span></span>
    </header>

    <div class="row biller">
      <h3>Saaja</h3>
      <p class="able-to-copy" data-copy-to-clipboard="<?php echo $bill->biller; ?>"><?php echo $bill->biller; ?></p>
    </div>

    <div class="row">
      <h3>Tilinumero</h3>
      <p class="able-to-copy" data-copy-to-clipboard="<?php echo $bill->accountnumber; ?>"><?php echo $bill->accountnumber; ?></p>
    </div>

    <?php if ( ! empty( $bill->virtualcode ) ) : ?>
    <div class="row">
      <h3>Virtuaaliviivakoodi</h3>
      <p class="able-to-copy" data-copy-to-clipboard="<?php echo $bill->virtualcode; ?>"><?php echo $bill->virtualcode; ?></p>
    </div>
    <?php endif; ?>

    <div class="row">
      <h3>Viitenumero</h3>
      <p class="able-to-copy" data-copy-to-clipboard="<?php echo $bill->refnumber; ?>"><?php echo $bill->refnumber; ?></p>
    </div>

    <div class="row">
      <h3>Tuote</h3>
      <p class="able-to-copy" data-copy-to-clipboard="<?php echo $bill->description; ?>"><?php echo $bill->description; ?></p>
    </div>

    <footer class="modal-footer">
      <div class="row">
        <h3>Yhteensä</h3>
        <p class="amount">&euro; <span class="formatted-amount able-to-copy" data-original-amount="<?php echo $bill->amount; ?>" data-copy-to-clipboard="<?php echo $formatted_amount; ?>"><?php echo $formatted_amount; ?></span></p>
      </div>

      <div class="row">
        <h3>Eräpäivä</h3>
        <p class="due-date formatted-duedate able-to-copy" data-original-date="<?php echo $bill->duedate; ?>" data-balloon="<?php echo $local_date; ?>" data-copy-to-clipboard="<?php echo $formatted_date; ?>" data-balloon-pos="up"><?php echo $bill->duedate; ?></p>
      </div>
    </footer>

    <div class="row actions">
      <span class="edit" data-id="<?php echo $bill->id; ?>"><?php echo file_get_contents( '../public/svg/dashboard/edit.svg' ); ?></span>
      <span class="mark-as-paid" data-id="<?php echo $bill->id; ?>"><?php echo file_get_contents( '../public/svg/dashboard/check.svg' ); ?></span>

      <?php if ( 'Osuuspankki' === Auth::user()->ebillprovider && 'E-lasku' === $bill->type ) : ?>
        <a target="_blank" href="https://www.op.fi" class="op-ebill"><?php echo file_get_contents( '../public/svg/dashboard/pay.svg' ); ?>Maksa OP E-lasku</a>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php
endif;
endforeach;
?>

@endsection
