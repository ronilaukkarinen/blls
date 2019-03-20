<?php
// Start MySQL connection and magic
$conn = mysqli_connect( 'localhost', 'root', 'LwyfPp4vxtWn3RCQzY', 'hillo' );

  if ( ! $conn) {
    die( 'Connection failed ' . mysqli_error( $conn ) );
  }

  if ( isset($_POST['save'] ) ) {
    $biller = $_POST['biller'];
    $billnumber = $_POST['billnumber'];
    $virtualcode = $_POST['virtualcode'];
    $refnumber = $_POST['refnumber'];
    $accountnumber = $_POST['accountnumber'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $duedate = $_POST['duedate'];
    $user_id = Auth::id();

    $sql = "INSERT INTO bills (biller, billnumber, virtualcode, refnumber, accountnumber, type, description, amount, duedate, created, paid, userid) VALUES ('{$biller}', '{$billnumber}', '{$virtualcode}', '{$refnumber}', '{$accountnumber}', '{$type}', '{$description}', '{$amount}', '{$duedate}', CURRENT_TIME(), 0, '{$user_id}')";
    if ( mysqli_query( $conn, $sql ) ) {
      $id = mysqli_insert_id( $conn );

      // Variables
      $old_date = $duedate;
      $old_date_timestamp = strtotime( $old_date );
      $formatted_date = date( 'd.m.Y', $old_date_timestamp );
      $stylish_date = date( 'd/m/Y', $old_date_timestamp );
      setlocale( LC_TIME, "fi_FI" );
      $local_date = strftime( "%e. %Bta %Y", $old_date_timestamp );
      $formatted_amount = str_replace( '.', ',', $amount );

      $saved_bill = '<tr class="row-clickable row-id-' . $id . '" data-row-id="' . $id . '">
          <td data-heading="Laskuttaja" class="row-biller biller_text" data-copy-to-clipboard="'. $biller .'">'. $biller .'</td>
          <td data-heading="Summa" class="row-amount amount amount_text" data-copy-to-clipboard="'. $formatted_amount .'">&euro; <span class="formatted-amount">'. $formatted_amount .'</span></td>
          <td data-heading="Toiminnot" class="row-actions">
          </td>
        </tr>';
      echo $saved_bill;
    } else {
      echo "Error: ". mysqli_error($conn);
    }
    exit();
  }

  // Delete bill from database
  if (isset($_GET['delete'])) {

    $id = $_GET['id'];
    $sql = "DELETE FROM bills WHERE id=" . $id;
    mysqli_query( $conn, $sql );
    exit();
  }

  if ( isset( $_POST['update'] ) ) {

    $id = $_POST['id'];
    $biller = $_POST['biller'];
    $billnumber = $_POST['billnumber'];
    $virtualcode = $_POST['virtualcode'];
    $refnumber = $_POST['refnumber'];
    $accountnumber = $_POST['accountnumber'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $duedate = $_POST['duedate'];
    $user_id = Auth::id();

    $sql = "UPDATE bills SET biller='{$biller}', billnumber='{$billnumber}', virtualcode='{$virtualcode}', refnumber='{$refnumber}', accountnumber='{$accountnumber}', type='{$type}', description='{$description}', amount='{$amount}', duedate='{$duedate}', userid='{$user_id}' WHERE id=".$id;
    if ( mysqli_query( $conn, $sql ) ) {
      $id = mysqli_insert_id( $conn );

      // Variables
      $old_date = $duedate;
      $old_date_timestamp = strtotime( $old_date );
      $formatted_date = date( 'd.m.Y', $old_date_timestamp );
      $stylish_date = date( 'd/m/Y', $old_date_timestamp );
      setlocale( LC_TIME, "fi_FI" );
      $local_date = strftime( "%e. %Bta %Y", $old_date_timestamp );
      $formatted_amount = str_replace( '.', ',', $amount );

      $saved_bill = '<tr class="row-clickable row-id-' . $id . '" data-row-id="' . $id . '">
          <td data-heading="Laskuttaja" class="row-biller biller_text" data-copy-to-clipboard="'. $biller .'">'. $biller .'</td>
          <td data-heading="Laskun numero" class="able-to-copy row-hidden row-billnumber billnumber_text" data-copy-to-clipboard="'. $billnumber .'">'. $billnumber .'</td>
          <td data-heading="Virtuaaliviivakoodi" class="able-to-copy row-hidden row-virtualcode virtualcode_text" data-copy-to-clipboard="'. $virtualcode .'">'. $virtualcode .'</td>
          <td data-heading="Viitenumero" class="able-to-copy row-hidden row-refnumber refnumber_text" data-copy-to-clipboard="'. $refnumber .'">'. $refnumber .'</td>
          <td data-heading="Tilinumero" class="able-to-copy row-hidden row-accountnumber accountnumber_text" data-copy-to-clipboard="'. $accountnumber .'">'. $accountnumber .'</td>
          <td data-heading="Tyyppi" class="row-type row-hidden type_text">'. $type .'</td>
          <td data-heading="Selite" class="row-description row-hidden description_text">'. $description .'</td>
          <td data-heading="Eräpäivä" class="formatted-duedate row-duedate duedate_text" data-balloon="' . $local_date . '" data-copy-to-clipboard="' . $formatted_date . '" data-balloon-pos="up">'. $duedate .'</td>
          <td data-heading="Summa" class="row-amount amount amount_text" data-copy-to-clipboard="'. $formatted_amount .'">&euro; <span class="formatted-amount">'. $formatted_amount .'</span></td>
          <td data-heading="Toiminnot" class="row-actions">
          </td>
        </tr>';
      echo $saved_bill;
    } else {
      echo "Error: ". mysqli_error( $conn );
    }
    exit();
  }

  // Update paid status
  if ( isset( $_POST['paid'] ) ) {

    $id = $_POST['id'];
    $paid_status = $_POST['paid_status'];

    $sql = "UPDATE bills SET paid='{$paid_status}', datepaid=CURRENT_TIME() WHERE id=".$id;
    if ( mysqli_query( $conn, $sql ) ) {
      $id = mysqli_insert_id( $conn );
    } else {
      echo "Error: ". mysqli_error( $conn );
    }
    exit();
  }

  // Retrieve bills from database
  $sql = "SELECT * FROM bills ORDER BY duedate DESC";
  $result = mysqli_query( $conn, $sql );

  $bills = '
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

  ';

  $total_sum = 0;
  while ( $row = mysqli_fetch_array( $result ) ) {

    // Variables
    $old_date = $row['duedate'];
    $old_date_timestamp = strtotime( $old_date );
    $formatted_date = date( 'd.m.Y', $old_date_timestamp );
    $stylish_date = date( 'd/m/Y', $old_date_timestamp );
    setlocale( LC_TIME, "fi_FI" );
    $local_date = strftime( "%e. %Bta %Y", $old_date_timestamp );
    $formatted_amount = str_replace( '.', ',', $row['amount'] );
    $user_id = Auth::id();

    // Check if not paid and if owned by current user
    if ( '0' == $row['paid'] && $user_id == $row['userid'] ) {
    $total_sum += $row['amount'];
    $bills .= '

        <tr class="row-clickable row-id-' . $row['id'] . '" data-row-id="' . $row['id'] . '">
          <td data-heading="Laskuttaja" class="row-biller biller_text" data-copy-to-clipboard="'. $row['biller'] .'">'. $row['biller'] .'</td>
          <td data-heading="Laskun numero" class="able-to-copy row-hidden row-billnumber billnumber_text" data-copy-to-clipboard="'. $row['billnumber'] .'">'. $row['billnumber'] .'</td>
          <td data-heading="Virtuaaliviivakoodi" class="able-to-copy row-hidden row-virtualcode virtualcode_text" data-copy-to-clipboard="'. $row['virtualcode'] .'">'. $row['virtualcode'] .'</td>
          <td data-heading="Viitenumero" class="able-to-copy row-hidden row-refnumber refnumber_text" data-copy-to-clipboard="'. $row['refnumber'] .'">'. $row['refnumber'] .'</td>
          <td data-heading="Tilinumero" class="able-to-copy row-hidden row-accountnumber accountnumber_text" data-copy-to-clipboard="'. $row['accountnumber'] .'">'. $row['accountnumber'] .'</td>
          <td data-heading="Tyyppi" class="row-type row-hidden type_text">'. $row['type'] .'</td>
          <td data-heading="Selite" class="row-description row-hidden description_text">'. $row['description'] .'</td>
          <td data-heading="Eräpäivä" class="formatted-duedate row-duedate duedate_text" data-balloon="' . $local_date . '" data-copy-to-clipboard="' . $formatted_date . '" data-balloon-pos="up">'. $row['duedate'] .'</td>
          <td data-heading="Summa" class="row-amount amount amount_text" data-copy-to-clipboard="'. $formatted_amount .'">&euro; <span class="formatted-amount">'. $formatted_amount .'</span></td>
          <td data-heading="Toiminnot" class="row-actions"><span class="delete" data-id="' . $row['id'] . '" >' . file_get_contents( '../public/svg/dashboard/trash.svg' ) . '</span>
            <span class="edit" data-id="' . $row['id'] . '">' . file_get_contents( '../public/svg/dashboard/edit.svg' ) . '</span>
            <span class="mark-as-paid" data-id="' . $row['id'] . '">' . file_get_contents( '../public/svg/dashboard/check.svg' ) . '</span>
          </td>
        </tr>';
  }

  if ( ! empty( $row['virtualcode'] ) ) {
    $virtual_code = '
    <div class="row">
        <h3>Virtuaaliviivakoodi</h3>
        <p class="able-to-copy" data-copy-to-clipboard="'. $row['virtualcode'] .'">'. $row['virtualcode'] .'</p>
      </div>';
  } else {
    $virtual_code = '';
  }

  $bills .= '
  <div class="bill-modal bill-modal-' . $row['id'] . '">
    <div class="bill-modal-overlay"></div>
    <div class="bill-modal-content">
      <header class="bill-header">
        <div>
          <h2>Lasku</h2>
          <h3 class="date">' . $stylish_date . '</h3>
        </div>

        <span class="bill-number">#<span class="able-to-copy" data-copy-to-clipboard="'. $row['billnumber'] .'">'. $row['billnumber'] .'</span></span>
      </header>

      <div class="row biller">
        <h3>Saaja</h3>
        <p class="able-to-copy" data-copy-to-clipboard="'. $row['biller'] .'">'. $row['biller'] .'</p>
      </div>

      <div class="row">
        <h3>Tilinumero</h3>
        <p class="able-to-copy" data-copy-to-clipboard="'. $row['accountnumber'] .'">'. $row['accountnumber'] .'</p>
      </div>

      '. $virtual_code .'

      <div class="row">
        <h3>Viitenumero</h3>
        <p class="able-to-copy" data-copy-to-clipboard="'. $row['refnumber'] .'">'. $row['refnumber'] .'</p>
      </div>

      <div class="row">
        <h3>Tuote</h3>
        <p class="able-to-copy" data-copy-to-clipboard="'. $row['description'] .'">'. $row['description'] .'</p>
      </div>

      <footer class="bill-footer">
        <div class="row">
          <h3>Yhteensä</h3>
          <p class="amount">&euro; <span class="formatted-amount able-to-copy" data-original-amount="'. $row['amount'] .'" data-copy-to-clipboard="'. $formatted_amount .'">'. $formatted_amount .'</span></p>
        </div>

        <div class="row">
          <h3>Eräpäivä</h3>
          <p class="due-date formatted-duedate able-to-copy" data-original-date="' . $row['duedate'] . '" data-balloon="' . $local_date . '" data-copy-to-clipboard="' . $formatted_date . '" data-balloon-pos="up">'. $row['duedate'] .'</p>
        </div>
      </footer>

      <div class="row actions">
      <span class="edit" data-id="' . $row['id'] . '">' . file_get_contents( '../public/svg/dashboard/edit.svg' ) . '</span>
      <span class="mark-as-paid" data-id="' . $row['id'] . '">' . file_get_contents( '../public/svg/dashboard/check.svg' ) . '</span>
      </div>
    </div>
  </div>
  ';
  }

  $bills .= '
  </table>';
