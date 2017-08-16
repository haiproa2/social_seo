
function doEnter(evt){
	var key;
	if(evt.keyCode == 13 || evt.which == 13){
		onSearch(evt);
	}
}
function onSearch(evt) {
	var keyword = document.getElementById("keyword").value;
	if(keyword == "<?=_search_placeholder?>" || keyword == ""){
		alert("<?=_search_alert?>");
		document.getElementById("keyword").focus();
	}
	else{
		location.href = "tim-kiem/"+keyword;
		loadPage(document.location);
	}
}	
function browserDetect(){
	var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
	var isFirefox = typeof InstallTrigger !== 'undefined';   // Firefox 1.0+
	var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
	    // At least Safari 3+: "[object HTMLElementConstructor]"
	var isChrome = !!window.chrome && !isOpera;              // Chrome 1+
	var isIE = /*@cc_on!@*/false || !!document.documentMode;   // At least IE6
	if(isFirefox) var classDetect = 'isFirefox';
	else if(isChrome) var classDetect = 'isChrome';
	else if(isSafari) var classDetect = 'isSafari';
	else if(isOpera) var classDetect = 'isOpera';
	else var classDetect = 'isIE';
	$('body').addClass(classDetect);
}
$(document).ready(function(){
	browserDetect();

	if($('a.image-default').length > 0) {
		$('a.image-default').removeClass('image-default');
	} if($('#menudesktop').length > 0) {
		$(".fancybox").fancybox({
			padding: 3,
			autoPlay: true,
			loop:false,
			helpers:  {
				//title : { type : 'inside' }
				title: null
			}
		});
	} if($('#menudesktop').length > 0) {
		$('#menudesktop > ul > li').each(function() {
			if($(this).find('li.active').length != 0)
				$(this).addClass('active');
		});
	} if($('#slider .owl-carousel').length > 0) {
		if($("#slider .item").length > 1) var loop = true;
		else var loop = false;
		$('#slider .owl-carousel').owlCarousel({
			loop:loop,
			items:1,
			dots:true,
			autoplay:true,
			mouseDrag:false,
			nav:loop,
			navText:['<i class="fa fa-angle-left" title="Next"></i>','<i class="fa fa-angle-right" title="Prev"></i>'],
			autoplayTimeout: 2500,
			autoplaySpeed: 2300,
			autoplayHoverPause:true,
			animateOut: 'fadeOut',
		});
	}
	$('body').append('<div id="back2top" title="Top"></div>');
	$('#back2top').click(function() {
		$('html body').animate({scrollTop: 0}, 500);
	});
});