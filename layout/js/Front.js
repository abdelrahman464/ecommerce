$( function()
{
    //switxh between login and sign up

    $('.login-page h1 span').click(function(){
        $(this).addClass('selectted').siblings().removeClass('selectted');
        $('.login-page section').hide();
        $('.'+$(this).data('class')).fadeIn(100);

    })


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

    // new add page 
    $('.live-name').keyup(function()
    {
        $('.live-preview .card-body h5').text($(this).val())
    });
    $('.live-desc').keyup(function()
    {
        $('.live-preview .card-body p').text($(this).val())
    });
    $('.live-price').keyup(function()
    {
        $('.live-preview .card-body .Price-tag .price').text($(this).val())
    });
    $('.live-image').keyup(function()
    {   
        
        $('.live-preview .imag-live').file($(this).val())
    });
    




});





