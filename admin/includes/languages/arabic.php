<?php

function lang($phrase)
{
    static $lang = array(
        'MESSAGE'=>'مرحبا'
        

    );
    return $lang[$phrase];
}