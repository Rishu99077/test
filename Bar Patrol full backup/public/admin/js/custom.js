jQuery(document).ready(function($){

    $('.toggle_nav').click(function(){
        $(this).parents('.left_menu').toggleClass('close');
        $('.main_right').toggleClass('open');
        $('.menu_parent ').removeClass('open_menu_a');
    });

    $(window).scroll(function(){
        var top = $(window).scrollTop();
        var w_wid = $(window).width();
        if(top > 0 &&  w_wid <= 767){
            $('body').addClass('newClass');
        }else{
            $('body').removeClass('newClass');
        }
    });
   
    // $('.menu_items').click(function(){
    //     $(this).parents('.menu_parent').find('.inner_item').slideToggle();
    // })
    // $('.togg_icon').click(function(){
        //     $('.inner_item').slideToggle();
        // });
    $('.toggle_nav').click(function(){
        $('.inner_item').slideUp();
    })

    $('.menu_items').parents('.open_menu_a').find('.inner_item').slideToggle();
    $('.menu_items').click(function(){
        $(this).parents('.menu_parent').find('.inner_item').slideToggle();
        // $('.menu_parent').removeClass('open_menu_a');
        $(this).parents('.menu_parent').toggleClass('open_menu_a');
        // $('.menu_items').removeClass('active');
        // $(this).addClass('active');
    });
    // $('.deletw_inven').click(function(){
    //     $(this).parents('tr').find('.alert').hide();
    // })

    // alert();


});

