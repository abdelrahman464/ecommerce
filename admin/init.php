<?php 
include "connect.php";

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



// include navbar in all pages exept the one with $noNavbar variable 

if(!isset($noNavbar)){include $tpl.'navbar.php'; }