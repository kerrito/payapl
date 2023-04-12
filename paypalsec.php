<?php 

// including package connection page
require_once "paypal.php";

// checking if amount exsits

if(isset($_POST['payment'])){
 
    // Error handling
    try{
        // passing array to paypal gateway
        $reponsive =$gateway->purchase(array(
            'amount'=>$_POST['payment'],
            'currency'=>PAYPAL_CURRENCY,
            'returnUrl'=>PAYPAL_RETURN_URL,
            'cancelUrl'=>PAYPAL_CANCEL_URL

            // Using sending method to send array to gateway
        ))->send();

        // Checking if page is redirected or not
        if($reponsive->isRedirect()){

            // Redirecting to return url page
            $reponsive->Redirect();
        }else{
            // Showing eror
            echo $e->getMessage();    
        }

        // Catching exception send by try
    }catch(Exception $e){

        // Showing eror
        echo $e->getMessage();
    }
}






?>