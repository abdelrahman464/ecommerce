$( function()
{
    // hide placeholder on form focus
    'use strict'
    $('[placeholder]').focus(function(){
        $(this).attr('data-text' ,$(this).attr('placeholder'));
        $(this).attr('placeholder','');
    }).blur(function()
    {
        $(this).attr('placeholder',$(this).attr('data-text'));
    });

    // add asterisk on required field
    $('input').each(function() {
        if($(this).attr('required') === 'required')
        {
            $(this).after('<span class="asterisk">*</span>');
        }
    });
    // convert password field to text field on hover
    var passfield = $('.password');
    $('.show-pass').hover(function(){
        passfield.attr('type','text');

    },function(){

        passfield.attr('type','password');
    });
    // confimation msg on btn 
    $('.confirm').click(function(){
        return confirm('Are You Sure?');
    });
});