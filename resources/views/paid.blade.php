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
      <section class="dashboard-content">

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

              // Variables
              $old_date = $bill->duedate;
              $old_date_timestamp = strtotime( $old_date );
              $formatted_date = date( 'd.m.Y', $old_date_timestamp );
              $stylish_date = date( 'd/m/Y', $old_date_timestamp );
              $local_date = strftime( "%e. %Bta %Y", $old_date_timestamp );
              $formatted_amount = str_replace( '.', ',', $bill->amount );
              $user_id = Auth::id();

              // Check if not paid and if owned by current user
              if ( $user_id == $bill->userid ) :
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

      </section>

<script>
// Set moment.js to current language
moment.locale('{{ Config::get('app.locale') }}');
</script>

@endsection
