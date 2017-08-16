jQuery.noConflict();
function randomPassword(leng){
	var text = "";
	leng = leng | 6;
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+";

	for (var i = 0; i < leng; i++)
		text += possible.charAt(Math.floor(Math.random() * possible.length));

	return text;
}

function deleteItem(message, url){
	jConfirm(message, 'THÔNG BÁO', function(r) {		
		if(r) window.location.href = url;
		return false;
	});
}

function deleteItems(message, url){
	var linkItem="";
	jQuery("input[name='chose']").each(function(){
		if (this.checked) linkItem = this.value+"-"+linkItem;
	});
	var length_prefix = url.split("/").pop();
	router = url.substring(0, url.length - length_prefix.length);
	linkItem = linkItem.substring(0, linkItem.lastIndexOf("-"))
	if (linkItem=="") {
		jQuery.jGrowl('Chọn ít nhất <strong>MỘT</strong> '+message+'!', {
			group: 'alert alert-error animate0 tada',
			life: 4000
		});
		return false;
	};
	jConfirm('Khi bạn đồng ý xóa thì tất cả dữ liệu '+message+' được chọn sẽ <span class="text-error">bị xóa vĩnh viễn</span>. <br/>Nếu không muốn '+message+' hiển thị ra ngoài nữa, bạn có thể <br/>cập nhật trạng thái '+message+' thành <span class="label">Tạm khóa</span>.<br/><br/><p class="text-error text-center">Bạn có chắc vẫn muốn xóa <b>các '+message+'</b> đã chọn?</p>', 'THÔNG BÁO', function(r) {
		if(r) window.location.href = router+linkItem;
		return false;
	});
}
function fillter(route){
	var cate = jQuery('#category').find(":selected").val();
	var keyword = jQuery('#keyword').val();
	var limit = jQuery('#limit').find(":selected").val();
	var link = link_limit = "";
	if(limit != 10)
		link_limit = "&limit="+limit;
	if(cate && cate != '-' && keyword)
		var link = "?cate="+cate+"&keyword="+keyword+link_limit;
	else if(cate && cate != '-')
		var link = "?cate="+cate+link_limit;
	else if(keyword)
		var link = "?keyword="+keyword+link_limit;
	else if(limit != 10)
		var link = "?limit="+limit;
	//console.log(route+link);
	window.location.href = route+link;
}

jQuery(document).ready(function(){
	
	prettyPrint();			//syntax highlighter
	mainwrapperHeight();
	responsive();

	/* Ajax */
	jQuery(".btn-delete-photo").click(function(){
		var table_item = jQuery(this).attr('data-table');
		var id_item = jQuery(this).attr('data-id');
		var CSRF_TOKEN = jQuery('input[name="_token"]').attr('value');
		jConfirm('Bạn có chắc là muốn <b class="text-error">Xóa Bức Ảnh</b> này?', 'Thông báo', function(r) {
			if(r){
				jQuery.ajax({
					headers: {
						'X-CSRF-TOKEN': CSRF_TOKEN
					},
					url: route_delete_image,
					method: "POST",
					data: {"_token": CSRF_TOKEN, "table_item": table_item, "id_item": id_item},
					success: function (data) {
						console.log(data);
						var data = jQuery.parseJSON(data);
						if(data.status == 'success'){
							jQuery(".thumb").attr('src', ''); // Set src for img
							jQuery(".info-photo").addClass('animate0 fadeOut hidden'); // Set val for thumb
							jQuery('input[name="_token"]').attr('value', data.token);
						}
						jQuery.jGrowl(data.messager, { life: 5000, theme: data.status});
					},
					error: function (data) {
						console.log("Cannot get thumbnail.");
						console.log(data);
					}
				});
			}
		});

	});
	jQuery(".btn-generate-slug").click(function(){
		jQuery(this).find('span').toggleClass('icon-spin');
		jQuery(this).closest('.field').removeClass('error');
		jQuery(this).closest('.field').find('.help-inline').addClass('animate0 bounceOut');
		var data_source = jQuery(this).attr('data-source');
		var data_result = jQuery(this).attr('data-result');
		var title_item = jQuery('.'+data_source).val();
		var table_item = jQuery(this).attr('data-table');
		var id_item = jQuery(this).attr('data-id');
		var CSRF_TOKEN = jQuery('input[name="_token"]').attr('value');
		if(title_item == ''){
			jAlert('<p class="text-error text-center">Tiêu đề chưa được nhập</p>', 'Thông báo', function(){
				jQuery('.'+data_source).focus();
				jQuery(".btn-generate-slug").find('span').toggleClass('icon-spin');
			});
			return false;
		}
		jQuery.ajax({
			headers: {
				'X-CSRF-TOKEN': CSRF_TOKEN
			},
			url: route_get_slug,
			method: "POST",
			data: {"_token": CSRF_TOKEN, "title_item": title_item, "table_item": table_item, "id_item": id_item},
			success: function (data) {
				jQuery(".btn-generate-slug").find('span').toggleClass('icon-spin');
				var data = jQuery.parseJSON(data);
				if(data.status == 'success'){
					jQuery("."+data_result).val(data.slug); // Set value for input
					jQuery('input[name="_token"]').attr('value', data.token);
				}
				jQuery.jGrowl(data.messager, { life: 5000, theme: data.status});
			},
			error: function (data) {
				jQuery.jGrowl('Khổng thể tạo tự động, vui lòng thử lại sau.', { life: 5000, theme: 'error'});
				jQuery(".btn-generate-slug").find('span').toggleClass('icon-spin');
				console.log("Cannot get slug.");
				console.log(data);
			}
		});

	});

	/* User detail */
	jQuery(".btn-generate-password").click(function(){
		jQuery(this).find('span').toggleClass('iconfa-random iconfa-refresh').addClass('icon-spin');
		var pass = randomPassword(10);
		jQuery("."+jQuery(this).attr('rel-class')).val(pass);
		jQuery(this).val(pass);
		jAlert('<p class="text-success text-center">'+pass+'</p>', 'Gợi ý mật khẩu', function(){
			jQuery(".btn-generate-password").find('span').toggleClass('iconfa-random iconfa-refresh').removeClass('icon-spin');
	    });
	});
	jQuery(".btn-show-password").click(function(){
		var type = jQuery(this).prev().attr('type');
		if(type=='password'){
			jQuery("."+jQuery(this).attr('rel-class')).attr('type', 'text');
			jQuery(this).attr('data-original-title', 'Click ẩn mật khẩu');
		} else {
			jQuery("."+jQuery(this).attr('rel-class')).attr('type', 'password');
			jQuery(this).attr('data-original-title', 'Click xem mật khẩu');
		}
		jQuery(this).find('span').toggleClass('iconfa-eye-close iconfa-eye-open');
	});
	jQuery(".btn-datepicker").click(function(){
		jQuery(".input-datepicker").datepicker("show");
	});
	jQuery("#birthday").datepicker({
		dateFormat: 'd MM, yy',
		changeMonth: true,
		changeYear: true,
		maxDate: '-12Y',
		yearRange: "-42:-12",
	});
	/* End User detail */

	/* Table */
	jQuery(".btn-update").click(function(){
		jQuery('#update_position').submit();
	});
	jQuery(".search-area .iconfa-remove").click(function(){
		jQuery(this).addClass('animate0 fadeOut');
		jQuery('#keyword').val('');
		var route = jQuery('#keyword').attr('data-route');
		fillter(route);
	});
	jQuery('#category').change(function(){
		var route = jQuery(this).attr('data-route');
		fillter(route);
	});
	jQuery('#limit').change(function(){
		var route = jQuery(this).attr('data-route');
		fillter(route);
	});
	jQuery('#keyword').on('keyup keypress', function(e) {
		var route = jQuery(this).attr('data-route');
		var keyword = jQuery('#keyword').val();
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			fillter(route);
		}
	});

	/* Show messager */
	if(msg)
		jQuery.jGrowl(msg, { life: 5000, theme: type});

	/* Role check all */
	jQuery('.permission-all').click(function(){
	   var itemValue = jQuery(this).val();
	   var parentTable = jQuery(this).parents('table');                                 
	   var ch = jQuery('.'+itemValue);
	   if(jQuery(this).is(':checked')) {
	      ch.each(function(){ 
	         jQuery(this).attr('checked',true);
	         jQuery(this).parent().addClass('checked');
	         jQuery(this).parents('tr').addClass('selected');
	      });         
	   } else {
	      ch.each(function(){ 
	         jQuery(this).attr('checked',false); 
	         jQuery(this).parent().removeClass('checked');
	         jQuery(this).parents('tr').removeClass('selected');
	      });   
	   }
	});

	/* form */
	jQuery('form').bind('submit', function (e) {
	    var button = jQuery('button[type=submit]');

	    // Disable the submit button while evaluating if the form should be submitted
	    button.prop('disabled', true).html('<span class="iconfa-refresh icon-spin"></span> Đang lưu ...');

	    var valid = true;    

	    // Do stuff (validations, etc) here and set
	    // "valid" to false if the validation fails

	    if (!valid) { 
	        // Prevent form from submitting if validation failed
	        e.preventDefault();

	        // Reactivate the button if the form was not submitted
	        button.prop('disabled', false).html('<span class="iconfa-save"></span> Lưu');
	    }
	});
	
	
	// animation
	if(jQuery('.contentinner').hasClass('content-dashboard')) {
		var anicount = 4;	
		jQuery('.leftmenu .nav-tabs > li').each(function(){										   
			jQuery(this).addClass('animate'+anicount+' fadeInUp');
			anicount++;
		});
		
		jQuery('.leftmenu .nav-tabs > li a').hover(function(){
			jQuery(this).find('span').addClass('animate0 swing');
		},function(){
			jQuery(this).find('span').removeClass('animate0 swing');
		});
		
		jQuery('.logopanel').addClass('animate0 fadeInUp');
		jQuery('.datewidget, .headerpanel').addClass('animate1 fadeInUp');
		jQuery('.searchwidget, .breadcrumbwidget').addClass('animate2 fadeInUp'); 
		jQuery('.plainwidget, .pagetitle').addClass('animate3 fadeInUp');
		jQuery('.maincontent').addClass('animate4 fadeInUp');
	}
	
	// widget icons dashboard
	if(jQuery('.widgeticons').length > 0) {
		jQuery('.widgeticons a').hover(function(){
			jQuery(this).find('img').addClass('animate0 bounceIn');
		},function(){
			jQuery(this).find('img').removeClass('animate0 bounceIn');
		});	
	}


	// adjust height of mainwrapper when 
	// it's below the document height
	function mainwrapperHeight() {
		var windowHeight = jQuery(window).height();
		var mainWrapperHeight = jQuery('.mainwrapper').height();
		var leftPanelHeight = jQuery('.leftpanel').height();
		if(leftPanelHeight > mainWrapperHeight)
			jQuery('.mainwrapper').css({minHeight: leftPanelHeight});	
		if(jQuery('.mainwrapper').height() < windowHeight)
			jQuery('.mainwrapper').css({minHeight: windowHeight});
	}
	
	function responsive() {
		
		var windowWidth = jQuery(window).width();
		
		// hiding and showing left menu
		if(!jQuery('.showmenu').hasClass('clicked')) {
			
			if(windowWidth < 960)
				hideLeftPanel();
			else
				showLeftPanel();
		}
		
		// rearranging widget icons in dashboard
		if(windowWidth < 768) {
			if(jQuery('.widgeticons .one_third').length == 0) {
				var count = 0;
				jQuery('.widgeticons li').each(function(){
					jQuery(this).removeClass('one_fifth last').addClass('one_third');
					if(count == 2) {
						jQuery(this).addClass('last');
						count = 0;
					} else { count++; }
				});	
			}
		} else {
			if(jQuery('.widgeticons .one_firth').length == 0) {
				var count = 0;
				jQuery('.widgeticons li').each(function(){
					jQuery(this).removeClass('one_third last').addClass('one_fifth');
					if(count == 4) {
						jQuery(this).addClass('last');
						count = 0;
					} else { count++; }
				});	
			}
		}
	}
	
	// when resize window event fired
	jQuery(window).resize(function(){
		mainwrapperHeight();
		responsive();
	});
	
	// dropdown in leftmenu
	jQuery('.leftmenu .dropdown > a').click(function(){
		jQuery('.leftmenu .dropdown > a').next().slideUp('fast');
		if(!jQuery(this).next().is(':visible'))
			jQuery(this).next().slideDown('fast');
		else
			jQuery(this).next().slideUp('fast');	
		return false;
	});
	
	// hide left panel
	function hideLeftPanel() {
		jQuery('.showmenu span').toggleClass('iconfa-arrow-right iconfa-arrow-left');
		jQuery('.leftpanel').css({marginLeft: '-260px'}).addClass('hide');
		jQuery('.rightpanel').css({marginLeft: 0});
		jQuery('.mainwrapper').css({backgroundPosition: '-260px 0'});
		jQuery('.footerleft').hide();
		jQuery('.footerright').css({marginLeft: 0});
	}
	
	// show left panel
	function showLeftPanel() {
		jQuery('.showmenu span').toggleClass('iconfa-arrow-right iconfa-arrow-left');
		jQuery('.leftpanel').css({marginLeft: '0px'}).removeClass('hide');
		jQuery('.rightpanel').css({marginLeft: '260px'});
		jQuery('.mainwrapper').css({backgroundPosition: '0 0'});
		jQuery('.footerleft').show();
		jQuery('.footerright').css({marginLeft: '260px'});
	}
	
	// show and hide left panel
	jQuery('.showmenu').click(function() {
		jQuery(this).addClass('clicked');
		if(jQuery('.leftpanel').hasClass('hide')){
			showLeftPanel();
		}
		else{
			hideLeftPanel();
		}
		return false;
	});
	
	// transform checkbox and radio box using uniform plugin
	if(jQuery().uniform)
		jQuery('input:checkbox, input:radio, select.uniformselect, .uniform-file').uniform();
	
	// transform checkbox and radio box using uniform plugin
	if(jQuery().SumoSelect)
		jQuery('.SumoSelect').SumoSelect();
	
	
	// show/hide widget content or widget content's child	
	if(jQuery('.showhide').length > 0 ) {
		jQuery('.showhide').click(function(){
			var t = jQuery(this);
			var p = t.parent();
			var target = t.attr('href');
			target = (!target)? p.next() :	p.next().find('.'+target);
			t.text((target.is(':visible'))? 'View Source' : 'Hide Source');
			(target.is(':visible'))? target.hide() : target.show(100);
			return false;
		});
	}
	
	
	// check all checkboxes in table
	if(jQuery('.checkall').length > 0) {
		jQuery('.checkall').click(function(){
			var parentTable = jQuery(this).parents('table');										   
			var ch = parentTable.find('tbody input[type=checkbox]');										 
			if(jQuery(this).is(':checked')) {
			
				//check all rows in table
				ch.each(function(){ 
					jQuery(this).attr('checked',true);
					jQuery(this).parent().addClass('checked');	//used for the custom checkbox style
					jQuery(this).parents('tr').addClass('selected'); // to highlight row as selected
				});
							
			
			} else {
				
				//uncheck all rows in table
				ch.each(function(){ 
					jQuery(this).attr('checked',false); 
					jQuery(this).parent().removeClass('checked');	//used for the custom checkbox style
					jQuery(this).parents('tr').removeClass('selected');
				});	
				
			}
		});
	}
	
	
	// delete row in a table
	if(jQuery('.deleterow').length > 0) {
		jQuery('.deleterow').click(function(){
			var conf = confirm('Continue delete?');
			if(conf)
				jQuery(this).parents('tr').fadeOut(function(){
					jQuery(this).remove();
					// do some other stuff here
				});
			return false;
		});	
	}
	
	
	// dynamic table
	if(jQuery('#dyntable').length > 0) {
		jQuery('#dyntable').dataTable({
			"sPaginationType": "full_numbers",
			"aaSortingFixed": [[0,'asc']],
			"fnDrawCallback": function(oSettings) {
				jQuery.uniform.update();
			}
		});
	}
	
	
	/////////////////////////////// ELEMENTS.HTML //////////////////////////////
	
	
	// tabbed widget
	jQuery('#tabs, #tabs2').tabs();
	
	// accordion widget
	jQuery('#accordion, #accordion2').accordion({heightStyle: "content"});
	
	
	// color picker
	if(jQuery('#colorpicker').length > 0) {
		jQuery('#colorSelector').ColorPicker({
			onShow: function (colpkr) {
				jQuery(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				jQuery(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				jQuery('#colorSelector span').css('backgroundColor', '#' + hex);
				jQuery('#colorpicker').val('#'+hex);
			}
		});
	}

	/*if(jQuery('.profilethumb').length > 0){
		jQuery('.profilethumb').hover(function(){
			jQuery(this).find('a').fadeIn();
		},function(){
			jQuery(this).find('a').fadeOut();
		});
	}*/
	
	// date picker
	if(jQuery('#datepicker').length > 0)
		jQuery( "#datepicker" ).datepicker();
		
	
	// growl notification
	if(jQuery('#growl').length > 0) {
		jQuery('#growl').click(function(){
			jQuery.jGrowl("Hello world!");
		});
	}
	
	// another growl notification
	if(jQuery('#growl2').length > 0) {
		jQuery('#growl2').click(function(){
			var msg = "This notification will live a little longer.";
			jQuery.jGrowl(msg, { life: 5000});
		});
	}

	// basic alert box
	if(jQuery('.alertboxbutton').length > 0) {
		jQuery('.alertboxbutton').click(function(){
			jAlert('This is a custom alert box', 'Alert Dialog');
		});
	}
	
	// confirm box
	if(jQuery('.confirmbutton').length > 0) {
		jQuery('.confirmbutton').click(function(){
			jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
				jAlert('Confirmed: ' + r, 'Confirmation Results');
			});
		});
	}
	
	// promptbox
	if(jQuery('.promptbutton').length > 0) {
		jQuery('.promptbutton').click
		(function(){
			jPrompt('Type something:', 'Prefilled value', 'Prompt Dialog', function(r) {
				if( r ) alert('You entered ' + r);
			});
		});
	}
	
	// alert with html
	if(jQuery('.alerthtmlbutton').length > 0) {
		jQuery('.alerthtmlbutton').click(function(){
			jAlert('You can use HTML, such as <strong>bold</strong>, <em>italics</em>, and <u>underline</u>!');
		});
	}
	
	// sortable list
	if(jQuery('#sortable').length > 0)
		jQuery("#sortable").sortable();
	
	// sortable list with content-->
	if(jQuery('#sortable2').length > 0) {
		jQuery("#sortable2").sortable();
		jQuery('.showcnt').click(function(){
			var t = jQuery(this);
			var det = t.parents('li').find('.details');
			if(!det.is(':visible')) {
				det.slideDown();
				t.removeClass('icon-arrow-down').addClass('icon-arrow-up');
			} else {
				det.slideUp();
				t.removeClass('icon-arrow-up').addClass('icon-arrow-down');
			}
		});
	}
	
	// tooltip and popover
	jQuery('[data-toggle="tooltip"]').tooltip()
	jQuery('[data-toggle="popover"]').popover({
		trigger: 'hover'
	})
	jQuery('[data-toggle="popfocus"]').popover({
		trigger: 'focus'
	})
	
	
	
	///// MESSAGES /////	
	
	if(jQuery('.mailinbox').length > 0) {
		
		// star
		jQuery('.msgstar').click(function(){
			if(jQuery(this).hasClass('starred'))
				jQuery(this).removeClass('starred');
			else
				jQuery(this).addClass('starred');
		});
		
		//add class selected to table row when checked
		jQuery('.mailinbox tbody input:checkbox').click(function(){
			if(jQuery(this).is(':checked'))
				jQuery(this).parents('tr').addClass('selected');
			else
				jQuery(this).parents('tr').removeClass('selected');
		});
		
		// trash
		if(jQuery('.msgtrash').length > 0) {
			jQuery('.msgtrash').click(function(){
				var c = false;
				var cn = 0;
				var o = new Array();
				jQuery('.mailinbox input:checkbox').each(function(){
					if(jQuery(this).is(':checked')) {
						c = true;
						o[cn] = jQuery(this);
						cn++;
					}
				});
				if(!c) {
					alert('No selected message');	
				} else {
					var msg = (o.length > 1)? 'messages' : 'message';
					if(confirm('Delete '+o.length+' '+msg+'?')) {
						for(var a=0;a<cn;a++) {
							jQuery(o[a]).parents('tr').remove();	
						}
					}
				}
			});
		}
	}

	
	// change layout
	jQuery('.skin-layout').click(function(){
		jQuery('.skin-layout').each(function(){ jQuery(this).parent().removeClass('selected'); });
		if(jQuery(this).hasClass('fixed')) {
			jQuery('.mainwrapper').removeClass('fullwrapper');
			if(jQuery('.stickyheaderinner').length > 0) jQuery('.stickyheaderinner').removeClass('wideheader');
			jQuery.cookie("skin-layout", 'fixed', { path: '/' });
		} else {
			jQuery('.mainwrapper').addClass('fullwrapper');
			if(jQuery('.stickyheaderinner').length > 0) jQuery('.stickyheaderinner').addClass('wideheader');
			jQuery.cookie("skin-layout", 'wide', { path: '/' });
		}
		return false;
	});
	
	// load selected layout from cookie
	if(jQuery.cookie('skin-layout')) {
		var layout = jQuery.cookie('skin-layout');
		if(layout == 'fixed') {
			jQuery('.mainwrapper').removeClass('fullwrapper');
			if(jQuery('.stickyheaderinner').length > 0) jQuery('.stickyheaderinner').removeClass('wideheader');
		} else {
			jQuery('.mainwrapper').addClass('fullwrapper');
			if(jQuery('.stickyheaderinner').length > 0) jQuery('.stickyheaderinner').addClass('wideheader');
		}	
	}
	
	
	// change skin color
	jQuery('.skin-color').click(function(){
		var s = jQuery(this).attr('href');
		if(jQuery('#skinstyle').length > 0) {
			if(s!='default') {
				jQuery('#skinstyle').attr('href','css/style.'+s+'.css');	
				jQuery.cookie('skin-color', s, { path: '/' });
			} else {
				jQuery('#skinstyle').remove();
				jQuery.cookie("skin-color", '', { path: '/' });
			}
		} else {
			if(s!='default') {
				jQuery('head').append('<link id="skinstyle" rel="stylesheet" href="css/style.'+s+'.css" type="text/css" />');
				jQuery.cookie("skin-color", s, { path: '/' });
			}
		}
		return false;
	});
	
	// load selected skin color from cookie
	if(jQuery.cookie('skin-color')) {
		var c = jQuery.cookie('skin-color');
		if(c) {
			jQuery('head').append('<link id="skinstyle" rel="stylesheet" href="css/style.'+c+'.css" type="text/css" />');
			jQuery.cookie("skin-color", c, { path: '/' });
		}
	}
	
});