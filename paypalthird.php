<?php 
// including package connection page
require_once "paypal.php";

// Checking if array send by paypal
if(array_key_exists('paymentId',$_GET) && array_key_exists('PayerID',$_GET)){

  // passing array to transcation when purchase is complete
    $transaction = $gateway->completePurchase(array(
    'payer_id'=>$_GET['PayerID'],
    'transactionReference'=>$_GET['paymentId']
    ));

    // sending transaction by send method
    $response=$transaction->send();

    // checking if transaction send successfully
    if($response->isSuccessful()){
      // Getting data in array form
      $arr_body=$response->getData();

      // saving useful data in vaiables
      $payment_id=$arr_body['id'];
      $payer_id=$arr_body['payer']['payer_info']['payer_id'];
      $payer_email=$arr_body['payer']['payer_info']['email'];
      $payment_paid=$arr_body['transactions'][0]['amount']['total'];
      $curency= PAYPAL_CURRENCY;
      $payment_status=$arr_body['state'];


    // getting ride id stored in session
    $location_credentail_id = $_SESSION['location_credentail_id'];
      
    // Qurey to get payment stored in database
      $query="SELECT * FROM location_credential WHERE id=$location_credentail_id";

      // Running query and storing in to variable
      $query_res=mysqli_query($con,$query);

      // checking if data exists
      if(mysqli_num_rows($query_res)>0){
        // fetching data in associated array form 
          $query_result=mysqli_fetch_assoc($query_res);

          // storing payment in variable from database
          $payment_needed=$query_result['payment'];

          // checking if payment store in variable is equal to paid payment in paypal
          if($payment_needed==$payment_paid){

            // query to store payment transaction data in database 
            $sql="INSERT INTO payment_details SET payment_id='$payment_id',payer_id='$payer_id',payer_email='$payer_email',payment='$payment_paid',currency='$curency',payment_status='$payment_status',`ride_id`=$location_credentail_id ";
            
            // Running and checking query if running successfully
            if(mysqli_query($con,$sql)){
              
            // Redirecting to page by path
            echo "<script>
                location.href='../php/mailer.php'
                </script>";
            }
          }
    }
}
}


?>