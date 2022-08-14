<?php

function lang($phrase)
{
    static $lang = array(
        // dashboard page
        //nav links
       'HOME_ADMIN'=>'Admin Area',
       'CATEGORIES'=>'Sectinos',
       'ITEMS'=>'Items',
       'MEMBERS'=>'Members',
       'COMMENTS'=>'Conmments',
       'STITISTISC'=>'Stat',
       'LOGS'=>'Logs',
       'DASHBOARD'=>'Dashboard',
       ''=>''
        

    );
    return $lang[$phrase];
}