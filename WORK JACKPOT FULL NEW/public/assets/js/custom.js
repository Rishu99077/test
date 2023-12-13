jQuery(document).ready(function($){

    //  for sticky bar
    function header_stick() {
        var scroll = $(window).scrollTop();

        if (scroll >= 50) {
            $(".site_header").addClass("sticky");
        } else {
            $(".site_header").removeClass("sticky");
        }
    }
    header_stick();
    $(window).scroll(header_stick);

    /* slider */
    $('.testimonial_slider').slick({
        autoplay: false,
        autoplaySpeed: 2000,
        arrows: true,
        slidesToShow:2,
        slidesToScroll: 1,
        dots: false,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 992, // tablet breakpoint
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    //Dynamic Padding
    function dynamic_pad(){
        var marLeft= $("#content").css("margin-left");
        var pad_left = $("#content").css("padding-left");
        marLeft = parseInt(marLeft);
        pad_left = parseInt(pad_left);
        var left = marLeft+pad_left;
        left = left+"px"
        $(".foot_contact_form").css("right",left);
    }
    dynamic_pad();
    $(window).resize(dynamic_pad);


	// 	head
    $('.humbergur__menu').click(function(){$(this).toggleClass('active');});
    $('.menu-toggle').click(function(){$('.main-navigation').toggleClass('toggled');});
	$('.humbergur__menu').click(function(){
		$('html').toggleClass('overlay_bg');
	});


    $("input[type='file']").on('change',  function(e){
       var file_text = $(this).parents('.form_row').find('.file_name');
       var lbl_text = file_text.text();
       if ($(this).get(0).files.length === 0) {
           file_text.text('');
           return false;
       }
       if(!this.files[0]){
           return false;
       }
         var file = this.files[0];
       if(file.name != ''){
           file_text.text(file.name);
       }
    });

    
    if($('.show_inner_check').is(':checked')){
        $('.show_inner_check').parents('.form_check_parent').find('.inner_checked').show();    
    }else{
        $('.show_inner_check').parents('.form_check_parent').find('.inner_checked').hide();    
    }
   
    $('.show_inner_check').change(function(e){
        if($(this).is(':checked')){
            $(this).parents('.form_check_parent').find('.inner_checked').show();    
        }else{
            $(this).parents('.form_check_parent').find('.inner_checked').hide();    
        }
    });


    $('.add_more_input').click(function(e){
        var form_row = $(this).closest('.form_row');
        var available_input = $(this).closest('.form_row').find('.all_available_input');
        var cloned_element = form_row.find('.for_clone_element').clone().removeClass('for_clone_element');
        var remove_btn = 

        $(cloned_element).appendTo(available_input);
    });


    $('.form_row').on('click', '.remove_input', function(e){
        $(this).parents('.single_input').remove();
    });


    function readURL(input, img) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                console.log( e.target.result);
                $('#img_preview').attr('src', e.target.result);
                $('#img_preview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".image_upload").change(function(e){
        var img = $(this).parents('.img_preview_main').find('.img_preview');
        readURL(this, img);
    });


    // aakib 
    // *****new begins

    $('a[href="#"]').attr('href', 'javascript:void(0);');

    $('.toggle_nav').click(function () {
        var w_wid = $(window).width();
        if (w_wid >= 768) {
            $(this).parents('.left_menu').toggleClass('close');
            $('.main_right').toggleClass('open');
            $('.menu_parent ').removeClass('open_menu_a');
        } else {
            $(this).parents('.left_menu').toggleClass('open');
        }
        
    });

    $(window).scroll(function () {
        var top = $(window).scrollTop();
        var w_wid = $(window).width();
        if (top > 0 && w_wid <= 767) {
            $('body').addClass('newClass');
        } else {
            $('body').removeClass('newClass');
        }
    });

    $('.toggle_nav').click(function () {
        $('.inner_item').slideUp();

        var w_wid = $(window).width();
        if (w_wid <= 767) {
            $('body').toggleClass('overlay_bg');
        }
    })

    $('.menu_items').parents('.open_menu_a').find('.inner_item').slideToggle();
    $('.menu_items').click(function () {
        $(this).parents('.menu_parent').find('.inner_item').slideToggle();
        // $('.menu_parent').removeClass('open_menu_a');
        $(this).parents('.menu_parent').toggleClass('open_menu_a');
        // $('.menu_items').removeClass('active');
        // $(this).addClass('active');
    });


    $('.site_fil').click(function () {
        $('.filter').addClass('open');
        $('.bc').click(function() {$('.filter').removeClass('open')});
    })



    // *range slider
    //-----JS for Price Range slider-----

  

    const settings = {

        fill: '#228ee3',
        background: '#F5F5F5'

    }
    const sliders = document.querySelectorAll('.range-slider');

    Array.prototype.forEach.call(sliders, (slider) => {

        slider.querySelector('input').addEventListener('input', (event) => {

            slider.querySelector('span').innerHTML = event.target.value;
            applyFill(event.target);

        });
        applyFill(slider.querySelector('input'));

    });




    function applyFill(slider) {

        const percentage = 100 * (slider.value - slider.min) / (slider.max - slider.min);
        const bg = `linear-gradient(90deg, ${settings.fill} ${percentage}%, ${settings.background} ${percentage + 0.1}%)`;
        slider.style.background = bg;

        let lefti = parseInt(percentage) +'%';
        // console.log(lefti);
        $('.range-slider__value').css('left',lefti);
    }

    // 22-05
    $('.wishlist').click(function(){
        $(this).toggleClass('wishlist_added');
    });
   
    // aakin end

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
    
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
    
            if (sParameterName[0] === sParam) {
                return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };


    var reg_open =  getUrlParameter('open_registration');

    if(reg_open){
        $('#login_op').modal('show');
    }

    $('.click_to_down').click(function(){
        $(this).parents('.dropdown_filter').find('.slide_down_up').slideToggle();
        $(this).parents('.dropdown_filter').toggleClass('active');
    });


    //maxlength
	$(".min_lenght_text p").text(function (index, currentText) {
        var maxLength = $(this).parent().attr('data-maxlength');
        if (currentText.length > maxLength) {
          return currentText.substr(0, maxLength) + "..";
        } else {
          return currentText
        }
      });


    $('.load_parent').on('click', '.show_more', function(e){
        $(this).parents('.load_parent').find('.hidden_content').slideDown(400).addClass("d-flex");
        $(this).addClass('less_details').removeClass('show_more').text('Less Detail');
    });

    $('.load_parent').on('click', '.less_details', function(e){
        $(this).parents('.load_parent').find('.hidden_content').slideUp(400).removeClass('d-flex');
        $(this).addClass('show_more').removeClass('less_details').text('More Detail');
    });
        
    $(document).on("click", function (event) {
        if (!$(event.target).closest(".left_menu").length) {
            $("body").removeClass('overlay_bg');
            $(".left_menu ").removeClass('open');
        }
    }); 

    
    if($('#sortable').length){

        $( "#sortable").sortable();
    }

    $(function () {

        if(!$(".range-bar").length){
            return;
        }
        $(".range-bar").slider({
            range: true,
            min: 130,
            max: 500,
            values: [130, 250],
            slide: function (event, ui) {
                $(".amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });

        $(".amount").val("$" + $(".range-bar").slider("values", 0) +
            " - $" + $(".range-bar").slider("values", 1));

    });
});


function scaleCaptcha(elementWidth) {
    // Width of the reCAPTCHA element, in pixels
    var reCaptchaWidth = 304;
    // Get the containing element's width
    var containerWidth = $('.captcha_box').width();
    
    // Only scale the reCAPTCHA if it won't fit
    // inside the container
    if(reCaptchaWidth > containerWidth) {
    // Calculate the scale
    var captchaScale = containerWidth / reCaptchaWidth;
    // Apply the transformation
    $('.g-recaptcha').css({
        'transform':'scale('+captchaScale+')'
    });
    }
}

$(function() { 

    // Initialize scaling
    scaleCaptcha();
    
    // Update scaling on window resize
    // Uses jQuery throttle plugin to limit strain on the browser
    $(window).resize( scaleCaptcha);
    
});