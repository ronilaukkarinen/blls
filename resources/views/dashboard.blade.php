@extends('layout')

@section('title', 'Dashboard')

@section('body')

    <?php include('../public/api/bills.php'); ?>

      <section class="dashboard-content">

        <?php
          $total_sum_decimals = number_format( ( float )$total_sum, 2, '.', '');
        ?>

        <div class="column-bills">
          <h1>Laskut</h1>

          <?php
          $tables = DB::select('SHOW TABLES');
          foreach($tables as $table) {
            var_dump($table);
          }
          ?>

          <div class="items status">
            <div class="item-col month-current">
              <h2 class="title-small">Maksettavaa yhteensä</h2>
              <p class="amount">&euro; <span class="sum formatted-amount"><?php echo $total_sum_decimals; ?></span></p>
            </div>

            <!-- <div class="item-col month-next">
              <h2 class="title-small">Ensi kuussa</h2>
              <p class="amount color-high">684,15 €</p>
            </div> -->
          </div>

          <h1>Maksamattomat laskut <span class="add-new"><?php echo file_get_contents( 'svg/dashboard/plus.svg' ); ?></span></h1>

          <div class="bill-modal bill-modal-new">
            <div class="bill-modal-overlay"></div>
            <div class="bill-modal-content">

              <form class="bills-form">
              <header class="bill-header">
                <div>
                    <h2 class="bill-title">Uusi lasku</h2>
                    <h3 class="date"><?php echo date( 'd/m/Y' ); ?></h3>
                </div>

                <span class="bill-number">#<label for="billnumber" class="screen-reader-text">Laskun numero:</label><input type="text" name="billnumber" id="billnumber" class="bill-number" placeholder="183411639682"></span>
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

              <footer class="bill-footer">
                <div class="row">
                  <label for="amount">Yhteensä</label>
                  <span class="flex amount">&euro; <input type="text" name="amount" id="amount" placeholder="100"></span>
                </div>

                <div class="row">
                  <label for="duedate">Eräpäivä</label>
                  <input type="text" name="duedate" id="duedate" class="due-date update-due-date" placeholder="<?php echo date( 'Y-m-d H:i:s' ); ?>">
                </div>
              </footer>

              <div class="row actions">
                <button type="button" id="submit_btn">Lisää</button>
                <button type="button" id="update_btn" style="display: none;">Päivitä</button>
              </div>

            </form>

          </div>
        </div>

          <?php
            if ( 0 === $total_sum ) :
            ?>
            InboxZero
            <div style="display: none;" class="hidden-area">
              <?php echo $bills; ?>
              <span class="total">Total: <span class="sum"><?php echo $total_sum_decimals; ?></span></span>
            </div>
          <?php else : ?>
            <?php echo $bills; ?>
          <?php endif; ?>
        </div>

      </section>

    </div>

@endsection
