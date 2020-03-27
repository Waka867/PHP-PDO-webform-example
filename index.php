<?php
// By Ledwing Hernandez
include( 'functions.php' );
include( 'header.php' );

$errorMessage            = '';
$call_backF              = '';
$staff_id                = isset( $_POST['staff_id'] ) ? filter_var( $_POST['staff_id'], FILTER_SANITIZE_NUMBER_INT ) : '';
$customer_id             = isset( $_POST['customer_id'] ) ? filter_var( $_POST['customer_id'], FILTER_SANITIZE_STRING ) : '';
$date_of_call            = isset( $_POST['date_of_call'] ) ? filter_var( $_POST['date_of_call'], FILTER_SANITIZE_STRING ) : '';
$spoke_with              = isset( $_POST['spoke_with'] ) ? filter_var( $_POST['spoke_with'], FILTER_SANITIZE_NUMBER_INT ) : '';
$current_status          = isset( $_POST['current_status'] ) ? filter_var( $_POST['current_status'], FILTER_VALIDATE_INT ) : '';
$notes                   = isset( $_POST['notes'] ) ? filter_var( $_POST['notes'], FILTER_SANITIZE_STRING ) : '';
$call_back               = isset( $_POST['call_back'] ) ? filter_var( $_POST['call_back'], FILTER_VALIDATE_INT ) : '';
$length_of_call          = isset( $_POST['length_of_call'] ) ? filter_var( $_POST['length_of_call'], FILTER_VALIDATE_INT ) : '0';
$requires_review         = isset( $_POST['requires_review'] ) ? filter_var( $_POST['requires_review'], FILTER_VALIDATE_INT ) : '';
$lang_other_than_english = isset( $_POST['lang_other_than_english'] ) ? filter_var( $_POST['lang_other_than_english'], FILTER_VALIDATE_INT ) : '';
$other_language          = isset( $_POST['other_language'] ) ? filter_var( $_POST['other_language'], FILTER_SANITIZE_STRING ) : '';
$record_entry            = isset( $_POST['record_entry'] ) ? $_POST['record_entry'] : '';


// Handling for when users leave non-required fields empty
$requires_review         = ( $requires_review == '' ) ? 0 : $requires_review;
$lang_other_than_english = ( $lang_other_than_english == '' ) ? 0 : $lang_other_than_english;
$customer_id             = ( $customer_id  == '' ) ? NULL : $customer_id;
$account_id              = ( $account_id == '' ) ? NULL : $account_id;
$notes                   = ( $notes == '' ) ? NULL : $notes;
$other_language          = ( $other_language == '' ) ? NULL : $other_language;



// Handling for date - takes today's date and adds X time
if( $call_back ){
  switch ( $call_back ) {
    // Call back tomorrow
    case 1:
      $call_backF = date( 'Y-m-d', strtotime( $date_of_call . "+1 days"  ) );
      echo "cbf = " . $call_backF . "<br>";
      break;
    // Call back in three days
    case 2:
      $call_backF = date( 'Y-m-d', strtotime( $date_of_call . "+3 days"  ) );
      echo "cbf = " . $call_backF . "<br>";
      break;
    // Call back in one week
    case 3:
      $call_backF = date( 'Y-m-d', strtotime( $date_of_call . "+1 week"  ) );
      echo "cbf = " . $call_backF . "<br>";
      break;
    // Call back in two weeks
    case 4:
      $call_backF = date( 'Y-m-d', strtotime( $date_of_call . "+2 weeks"  ) );
      echo "cbf = " . $call_backF . "<br>";
      break;
    // No more calls
    case 5:
      $call_backF = NULL;
      break;
    //
    default:
      $call_backF = NULL;
      break;
  }
}



// If sucess is true, set the success message
if( isset( $_REQUEST['success'] ) ){
      echo "<p class='success' style='text-align: center;'>Call Record has been successfully entered.</p>";
}


if( $record_entry ) {
  $sql = "
    INSERT INTO
      `contact_records`
    (
      `staff_id`,
      `customer_id`,
      `date_of_call`,
      `spoke_with`,
      `current_status`,
      `notes`,
      `call_back`,
      `length_of_call`,
      `requires_review`,
      `lang_other_than_english`,
      `other_language`
    ) VALUES (
      :staff_id,
      :customer_id,
      :date_of_call,
      :spoke_with,
      :current_status,
      :notes,
      :call_back,
      :length_of_call,
      :requires_review,
      :lang_other_than_english,
      :other_language
    )
  ";

  $re          = $db->prepare( $sql );
  $re->bindValue( ':staff_id',                      $staff_id, PDO::PARAM_INT );
  $re->bindValue( ':customer_id',                   $customer_id, PDO::PARAM_STR );
  $re->bindValue( ':date_of_call',                  $date_of_call, PDO::PARAM_INT );
  $re->bindValue( ':spoke_with',                    $spoke_with, PDO::PARAM_INT );
  $re->bindValue( ':current_status',                $current_status, PDO::PARAM_INT );
  $re->bindValue( ':notes',                         $notes, PDO::PARAM_STR );
  $re->bindValue( ':call_back',                     $call_backF, PDO::PARAM_STR );
  $re->bindValue( ':length_of_call',                $length_of_call, PDO::PARAM_INT );
  $re->bindValue( ':requires_review',               $requires_review, PDO::PARAM_INT );
  $re->bindValue( ':lang_other_than_english',       $lang_other_than_english, PDO::PARAM_INT );
  $re->bindValue( ':other_language',                $other_language, PDO::PARAM_STR );
  $query       = $re->execute();

  if( $query ){
    header( 'Location: /index.php?success=true' );
  } else {
    echo "query failed";
  }
} else {
  echo "<p class='required' style='text-align: center;'>" . $errorMessage . "</p>";
}



// Call Entry form
echo "
  <!--form action='functions.php' method='post' id='call-entry-form' -->
  <form action='" . $_SERVER['PHP_SELF'] . "' method='post' id='call-entry-form' >
    <input type='hidden' name='record_entry' value='1'/>
    <label class='form-label' for=''>Staff ID<span class='required'>*</span></label>
    <input class='form-input' type='text' placeholder='' maxlength='7' name='staff_id' required />
    <br>
    <hr>
    <label class='form-label' for=''>Customer ID</label><span class='required'>*</span></label>
    <input class='form-input' type='text' placeholder='' maxlength='19' name='customer_id' required/>
    <br>
    <hr>
    <br>
    <label class='form-label' for=''>Date of Call<span class='required'>*</span></label>
    <input class='form-input' type='date' name='date_of_call' required />
    <br>
    <label class='form-label' for=''>Spoke With</label> (select one)<span class='required'>*</span>
    <br>
    <div>
      <input type='hidden' id='spoke-with-none' name='spoke_with' value='0' required>
      <input type='radio' id='spoke-with-customer' name='spoke_with' value='1' required>
      <label for='contactChoice1'>Customer</label><br>
      <input type='radio' id='spoke-with-family-member' name='spoke_with' value='2' required>
      <label for='contactChoice2'>Family Member</label><br>
      <input type='radio' id='spoke-with-other' name='spoke_with' value='3' required>
      <label for='contactChoice3'>Other</label><br>
    </div>
    <br>

    <label class='form-label' for=''>Current Status</label> (select one)<span class='required'>*</span>
    <div>
      <input type='hidden' id='currentStatusChoice0' name='current_status' value='0' required>
      <input type='radio' id='currentStatusChoice1' name='current_status' value='1' required>
      <label for=''>Interested</label><br>
      <input type='radio' id='currentStatusChoice2' name='current_status' value='2' required>
      <label for=''>Some questions</label><br>
      <input type='radio' id='currentStatusChoice3' name='current_status' value='3' required>
      <label for=''>Would like more info/time to think.</label><br>
      <input type='radio' id='currentStatusChoice4' name='current_status' value='4' required>
      <label for=''>Already a customer</label><br>
      <input type='radio' id='currentStatusChoice5' name='current_status' value='5' required>
      <label for=''>Not interested</label><br>
    </div>
    <br>
    <br>
    <label class='form-label' for=''>Call Back</label> (select one)<span class='required'>*</span>
    <div>
      <input type='hidden' id='callBackChoice0' name='call_back' value='0' required>
      <input type='radio' id='callBackChoice1' name='call_back' value='1' required>
      <label for=''>Tomorrow</label><br>
      <input type='radio' id='callBackChoice2' name='call_back' value='2' required>
      <label for=''>Three days</label><br>
      <input type='radio' id='callBackChoice3' name='call_back' value='3' required>
      <label for=''>Next Week</label><br>
      <input type='radio' id='callBackChoice4' name='call_back' value='4' required>
      <label for=''>Two Weeks</label><br>
      <input type='radio' id='callBackChoice5' name='call_back' value='5' required>
      <label for=''>No more calls</label><br>
    </div>
    <br>
    <label class='form-label' for=''>Notes</label>
    <textarea class='form-input' type='' maxlength='250' name='notes' rows='5' cols='25' /></textarea>
    <br>
    <label class='form-label' for=''>Length of Call</label> (in minutes)<span class='required'>*</span>
    <input class='form-input' type='number' maxlength='4' name='length_of_call' required/>
    <br>
    <label class='form-label' for=''>Requires review by supervisor</label>
    <input class='form-input' type='checkbox' name='requires_review' value='1' />
    <br>
    <label class='form-label' for=''>Speaks language other than English</label>
    <input class='form-input' type='checkbox' name='lang_other_than_english' value='1' />
    <br>
    <label class='form-label' for=''>Specify if known</label>
    <input class='form-input' type='text' maxlength='250' name='other_language' />
    <br>
    <br>
    <label class='form-label' for=''>Submit Call Record</label>
    <button class='form-input' type='submit'>Submit</button>
    <br>
    <br>
    <br>
    <br>
    <button id='reset' class='form-input' type='reset'>Reset</button>
  </form>
";


include('footer.php');
?>
