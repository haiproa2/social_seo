
function browserDetect() {
    var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
    var isFirefox = typeof InstallTrigger !== 'undefined'; // Firefox 1.0+
    var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
    // At least Safari 3+: "[object HTMLElementConstructor]"
    var isChrome = !!window.chrome && !isOpera; // Chrome 1+
    var isIE = /*@cc_on!@*/ false || !!document.documentMode; // At least IE6
    if (isFirefox) var classDetect = 'isFirefox';
    else if (isChrome) var classDetect = 'isChrome';
    else if (isSafari) var classDetect = 'isSafari';
    else if (isOpera) var classDetect = 'isOpera';
    else var classDetect = 'isIE';
    $('body').addClass(classDetect);
}

function changecaptcha(urlAjax) {
    var token = $("input[name='_token']").val();
    var action = 'get-captcha-image';
    $.ajax({
        type: 'POST',
        url: urlAjax,
        data: {_token: token, action: action},
        beforeSend: function() {
            $('.form-captcha .fa').addClass('fa-spin');
        },
        success: function(imgage) {
            if(imgage){
                $('.form-captcha .captchaIMG').attr('src', imgage);
                $('.form-captcha .fa').removeClass('fa-spin');
            } else {
                console.log('Error: No action post');
            }
        }
    });
}

function getDate(element, dateFormat) {
    var date;
    dateFormat = typeof dateFormat !== 'dd/mm/yy' ? dateFormat : 'dd/mm/yy';
    try {
        date = jQuery.datepicker.parseDate(dateFormat, element.value);
    } catch (error) {
        date = null;
    }

    return date;
}

$(document).ready(function() {
    browserDetect();
    $('.form-captcha .btn-change-captcha').click(function() {
        changecaptcha($(this).attr("data-url"));
    });
    $(".fancybox").fancybox({
        padding: 3,
        autoPlay: true,
        loop: false,
        helpers: {
            title: {
                type: 'inside'
            }
        }
    });
    $('body').append('<div id="back2top" title="Về đầu trang" data-rel="tooltip" data-placement="left"></div>');
    $('#back2top').click(function() {
        $('html body').animate({
            scrollTop: 0
        }, 500);
    });
    $('.search .fa').click(function() {
        $('.txtKeyword').focus();
    });
    $('.txtKeyword').focus(function() {
        $(this).parents(".search").css('width', '200px');
        $(this).prev(".fa").css('display', 'none');
        $(this).next(".btSubmit").css({'right':2});
    }).focusout(function() {
        $(this).parents(".search").css('width', '31px');
        $(this).prev(".fa").css('display', 'block');
        $(this).next(".btSubmit").css('right', '-30px');
    });
    var headerHeight = $('header').height();
	$(window).scroll(function() {
	    if ($(window).scrollTop() > headerHeight) {
	        $('#back2top').fadeIn();
	        $('body').addClass('fixed');
	    } else {
	        $('#back2top').fadeOut();
	        $('body').removeClass('fixed');
	    }
	});
    
    if($('.sumoSelect').length > 0) {
    	$('.sumoSelect').SumoSelect();
    } if($('.homeTopLeftImg .owl-carousel').length > 0) {
        var owl = $(".homeTopLeftImg .owl-carousel");
        owl.owlCarousel({
            items: 1,
            margin: 0,
            center: true,
            nav: false,
            navText: ['<i class="fa fa-caret-left" title="Back" data-rel="tooltip" data-placement="top"></i>','<i class="fa fa-caret-right" title="Next" data-rel="tooltip" data-placement="top"></i>'],
            dots: true,
            autoplay: true,
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
            loop: true
        });
        $(".listNormal.scrollbarOne a").hover(function(){
            var number = $(this).attr("data-owl");
            owl.trigger("to.owl.carousel", [number]);
        });
    } if($('.boxVideos .owl-carousel').length > 0) {
        $(".boxVideos .owl-carousel").owlCarousel({
            items: 1,
            margin: 0,
            center: true,
            nav: false,
            navText: ['<i class="fa fa-caret-left" title="Back" data-rel="tooltip" data-placement="top"></i>','<i class="fa fa-caret-right" title="Next" data-rel="tooltip" data-placement="top"></i>'],
            dots: false,
            autoplay: true,
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
            loop: true
        });
    } if($('.boxView .owl-carousel').length > 0) {
        $(".boxView .owl-carousel").owlCarousel({
            items: 6,
            margin: 15,
            center: false,
            nav: true,
            navText: ['<i class="fa fa-chevron-left" title="Back" data-rel="tooltip" data-placement="top"></i>','<i class="fa fa-chevron-right" title="Next" data-rel="tooltip" data-placement="top"></i>'],
            dots: false,
            autoplay: true,
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
            loop: true
        });
    } if($("#contentVideo").length > 0){
        var video, results, url;
        url = $("#contentVideo").attr("data-url");
        console.log(url);
        results = url.match('[\\?&]v=([^&#]*)');
        video   = (results === null) ? url : results[1];

        $("#contentVideo").append('<iframe width="560" height="315" src="https://www.youtube.com/embed/'+video+'?autoplay=1" frameborder="0" allowfullscreen></iframe>')
    } if($("#nanoGallery").length > 0){
        $("#nanoGallery").nanoGallery({
            thumbnailWidth: 'auto',
            thumbnailHeight: 180,
            locationHash: false,
            colorScheme: 'darkOrange',
            thumbnailHoverEffect:'borderLighter,imageScaleIn80',
            //itemsBaseURL:'http://nanogallery.brisbois.fr/demonstration/'
        });
    } if($(".boxBrands").length > 0){
        var i = 0;
        var len = 2;
        var first = true;
        var carousel = $(".boxBrands").jCarouselLite({
            vertical: true,
            hoverPause: true,
            visible: len,
            start: 0,
            warp: "circle",
            auto: 1,
            speed: 1000,
        });
    }
    $(".listNormal li").hover(function(){
        var href = $(this).attr("data-href");
    });

    $('#frmRecerDateIn').datetimepicker({
        format: 'LL',
        locale: 'fr',
    });
    $('#frmRecerDateOut').datetimepicker({
        format: 'LL',
        locale: 'fr',
        useCurrent: false
    });
    $("#frmRecerDateIn").on("dp.change", function (e) {
        $('#frmRecerDateOut').data("DateTimePicker").minDate(e.date);
    });
    $("#frmRecerDateOut").on("dp.change", function (e) {
        $('#frmRecerDateIn').data("DateTimePicker").maxDate(e.date);
    });
    var _scroll = {
        delay: 1000,
        easing: 'linear',
        items: 1,
        duration: 0.07,
        timeoutDuration: 0,
        pauseOnHover: 'immediate'
    };
    $("#newsHot").carouFredSel({
        width: '100%',
        align: false,
        items: {
            width: 'variable',
            height: 20,
            visible: 1
        },
        scroll: _scroll
    });
    $('[data-rel="popover"]').popover();
    $('[data-rel="tooltip"]').tooltip();
});