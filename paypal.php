<?php 

// Include database conection Here 


// Package autoload
require_once "vendor/autoload.php";

// Use omnipay from package
USE Omnipay\Omnipay;


// defining constant variables
define("CLIENT_ID","Enter Client Id");
define("CLIENT_SECRET","Enter client secret");


define("PAYPAL_RETURN_URL","Enter return page url");
define("PAYPAL_CANCEL_URL","Enter cancel page url");
define("PAYPAL_CURRENCY",'Enter currency code');

// creating new gateway
$gateway = Omnipay::create("PayPal_Rest");

$gateway->setClientId(CLIENT_ID);
$gateway->setSecret(CLIENT_SECRET);
$gateway->setTestMode(true); //to go live set false
