<?php
;
$do =isset($_GET['do'])?$_GET['do']:'Manage' ;


// id the page is main page
if($do == 'Manage')
{
   echo 'welcom you are in category page';
   echo '<a href="?do=Add">Add new category + </a>';
}elseif($do == 'Add') 
{
    echo 'welcom you are in Add page';
}else
{   
    echo 'Error there is no with this name ';
}