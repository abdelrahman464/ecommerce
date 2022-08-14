<?php 

ini_set('display_errors','on');
error_reporting(E_ALL); 

include "admin/connect.php";

$sessionUser='';

if(isset($_SESSION['user']))
{
    $sessionUser=$_SESSION['user'];
}

//routes


$tpl='includes/templates/';// template directory
$lango = 'includes/languages/';//language directory
$func= 'includes/functions/';// functions directory
$css='layout/css/';// css directory
$js = 'layout/js/';// js directory



// include the important file
include $func.'functions.php';
include $lango.'english.php' ;
include $tpl.'header.php'; 
 



 