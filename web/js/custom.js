$(function(){ 
	
	// Preload images
	$.preloadCssImages();
	
	// Setup WYSIWYG editor
    $('#wysiwyg').wysiwyg({
    	css : "css/wysiwyg.css"
    });
	
	$('.nav li a').each(function()
		{
			$(this).click(function(){
				$('.nav li a').removeClass('selected');
				$('.popup').css('display', 'none');
				
				$(this).addClass('selected');
				
				var popup = $(this).parent().find('.popup');
				
				//if has submenu
				if(popup.length > 0)
				{
					//get the position of the placeholder element
  					var pos = $(this).parent().offset();  
  					var width = $(this).parent().width();
  					var popupPos = pos.left-80+(width/2)+1;

  					//show the menu directly over the placeholder
  					popup.css( { "left": popupPos + "px", "top":pos.top + 60 + "px" } );
  					popup.show();
  					
  					return false;
				}
			});
		}
	);
	
	$('#shortcut_item li a').tipsy({gravity: 'w'});
	
	$(document).click(function(){
		$('.popup').css('display', 'none');
		$('.popup').parent().find('a').removeClass('selected');
	});
	
	$('table.global tbody tr').mouseenter(function(){
		$(this).css('background', '#f6f6f6');
	});
	
	$('table.global tbody tr').mouseleave(function(){
		$(this).css('background', '#ffffff');
	});
	
	$(window).resize(function() {
 		 $('.wysiwyg').css('width', '100%');
	});
	
	// Setup style of select
	//$('div.option div.text').html($('option:selected').text());
	$('div.option').each(function(){
		var value = $(this).find('option:selected').text();
	            $(this).find('div.text').attr("innerHTML", value);
	        });
	
	$('div.option').find('select:first').change(function(){
		//$(this).parent().find('div.text').html($(this).val());
		$(this).parent().find('div.text').html($('option:selected', this).text());
	});
	//$('div.option div.text').html($('option:selected').text());
	$('div.option_xl').each(function(){
		var value = $(this).find('option:selected').text();
	            $(this).find('div.text').attr("innerHTML", value);
	        });
	
	$('div.option_xl').find('select:first').change(function(){
		//$(this).parent().find('div.text').html($(this).val());
		$(this).parent().find('div.text').html($('option:selected', this).text());
	});
	
	// Setup style of input file
	$('div.file').find('input:first').change(function(){
		$(this).css('top', '-18px');
		var filename = $(this).val().replace(/^.*\\/, '').substr(0, 24);
		$(this).parent().find('div.text').html(filename);
	});
	
	$('.media_photos li').mouseenter(function(){
		$(this).find('.action').css('visibility', 'visible');
	});
	
	$('.media_photos li').mouseleave(function(){
		$(this).find('.action').css('visibility', 'hidden');
	});
	
	$('div.date').find('input:first').change(function(){
		if (BrowserDetect.browser != "Explorer")
		{
			$(this).css('top', '-23px');
		}
		else
		{
			if(BrowserDetect.version > 7)
			{
				$(this).css('top', '-23px');
			}
			else
			{
				$(this).css('top', '-12px');
			}
		}
		
		$(this).parent().find('div.text').html($(this).val());
	});
	
	// Setup click to hide all alert boxes
	$('.alert_warning').click(function(){
		$(this).fadeOut('fast');
	});
	$('.alert_tip').click(function(){
		$(this).fadeOut('fast');
	});
	$('.alert_success').click(function(){
		$(this).fadeOut('fast');
	});
	
	$('.alert_error').click(function(){
		$(this).fadeOut('fast');
	});
	
	// Setup modal window for all photos
	$('.media_photos li a[rel=slide]').fancybox({
		padding: 0, 
		titlePosition: 'outside', 
		overlayColor: '#333333', 
		overlayOpacity: .2
	});
	
});

$(document).ready(function() {
	
	// Find all the input elements with title attributes and add hint to it
    $('input[title!=""]').hint();

    // Start validation with 'new' reservation form
	$("#new_reservation_form").validate({
			highlight: function(element, errorClass) {
				$(element).addClass(errorClass).parent('.option').addClass('error_select');
			}
		});
   // Start validation with 'general settings' form
	$("#general_settings_form").validate({
			highlight: function(element, errorClass) {
				$(element).addClass(errorClass).parent('.option').addClass('error_select');
			}
		});
	// Start validation with 'outlet edit' form	
	$("#edit_outlet_form").validate({
			highlight: function(element, errorClass) {
				$(element).addClass(errorClass).parent('.option').addClass('error_select');
			}
		});
	// Start validation with 'events' form	
	$("#event_form").validate({
			highlight: function(element, errorClass) {
				$(element).addClass(errorClass).parent('.option').addClass('error_select');
			}
		});
	// Start validation with 'new user' form	
	$("#user_form").validate({
			rules: {
				password2: {
					required: true,
					equalTo: "#password"
				}
			},
			messages: {
				password2: {
					equalTo: "Enter the same password as above"
				}
			},
			highlight: function(element, errorClass) {
				$(element).addClass(errorClass).parent('.option').addClass('error_select');
			}
		});
	// Start validation with 'property edit' form	
	$("#property_form").validate({
			highlight: function(element, errorClass) {
				$(element).addClass(errorClass).parent('.option').addClass('error_select');
			}
		});
	// remove error class on change of select element
	$("#reservation_time").change(function() { 
		        $(this).parent('.option').removeClass('error_select');
		});
	$("#reservation_title").change(function() { 
			    $(this).parent('.option').removeClass('error_select');
		});
	$("#reservation_hotelguest_yn").change(function() { 
				    $(this).parent('.option').removeClass('error_select');
			});
	//initial setup of selected date in input field and div
		if (BrowserDetect.browser != "Explorer")
		{
			$("#datepicker").css('top', '-21px');
			$("#s_datepicker").css('top', '-21px');
			$("#e_datepicker").css('top', '-21px');
			$("#ev_datepicker").css('top', '-21px');
			//$("#recurring_date").css('top', '-21px');
		}
		else
		{
			if(BrowserDetect.version > 7)
			{
				$("#datepicker").css('top', '-21px');
				$("#s_datepicker").css('top', '-21px');
				$("#e_datepicker").css('top', '-21px');
				$("#ev_datepicker").css('top', '-21px');
				$("#recurring_date").css('top', '-21px');
			}
			else
			{
				$("#datepicker").css('top', '-10px');
				$("#s_datepicker").css('top', '-10px');
				$("#e_datepicker").css('top', '-10px');
				$("#ev_datepicker").css('top', '-21px');
				//$("#recurring_date").css('top', '-10px');
			}
		}
		
		//initial setup of selected date in input field and div
			if (BrowserDetect.browser != "Explorer")
			{
				$(".option select").css('top', '-21px');
			}
			else
			{
				if(BrowserDetect.version > 7)
				{
					$(".option select").css('top', '-21px');
				}
				else
				{
					$(".option select").css('top', '-10px');
				}
			}
		
		//initial setup of selected date in input field and div
			if (BrowserDetect.browser != "Explorer")
			{
				$(".option_xl select").css('top', '-21px');
			}
			else
			{
				if(BrowserDetect.version > 7)
				{
					$(".option_xl select").css('top', '-21px');
				}
				else
				{
					$(".option_xl select").css('top', '-10px');
				}
			}
	
	//fade out message box
	$('#messageBox').fadeTo(3500,1).fadeOut(1000);
	
	
	// outlet detail slider
	$("#outlet_detail_slider").hide();
	    $('#outlet_detail_button').click(function() {
	    $('#outlet_detail_slider').slideToggle(500);
	    return false;
	});

	//activate Autocomplete
	 $("#reservation_guest_name").autocomplete('classes/autocomplete.php', {
		extraParams:{field: "reservation_guest_name"},
		matchContains: true,
		minChars: 2,
		selectFirst: false
	  });
	 $("#reservation_booker_name").autocomplete('classes/autocomplete.php', {
		extraParams:{field: "reservation_booker_name"},
		matchContains: true,
		selectFirst: false
	  });
	$("#reservation_guest_email").autocomplete('classes/autocomplete.php', {
		extraParams:{field: "reservation_guest_email"},
		matchContains: true,
		selectFirst: false
	  });

	// delete button modal message
	$(".delbtn").fancybox({
		'titleShow' : false,        
		'modal' : true,
		onStart  :   function(selectedArray, 
		selectedIndex, selectedOpts) {
				del_id  = selectedArray[ selectedIndex ].id; 
				del_rep = selectedArray[ selectedIndex ].name;
				del_row	= $("#" + del_id).parents('tr:first');
				
				/* hide 'delete series' button at single entry */
				if (del_rep == 0 ) {
					$('#button_al').css("display","none");
				}
	        }
    });// delete button END

	// Delete action
	 $('#modalsecurity .send-button').click(function () {
	 var author_value = $('#modalsecurity #conf-author').val();
	 var del_button = $(this).attr('name');
		// Modal message send form
		 if(author_value.length>2){
				$.ajax({
					url: 'ajax/modify_entry.php',
					data: 'action=DEL&cellid=' + del_id + '&button=' + del_button + '&repeatid=' + del_rep + '&author=' + author_value,
					type: 'post',
					cache: false,
					dataType: 'html',
					success: function(original_element){
						$.fancybox.close();
						$(del_row).fadeOut(800, function() { $(this).remove(); }); //Remove the row
						window.location.reload();
					}
				});
		 } //end if 
	});// Modal message send form END

	// delete button modal message
	$(".deletebtn").fancybox({
		'titleShow' : false,        
		'modal' : true,
		onStart  :   function(selectedArray, 
		selectedIndex, selectedOpts) {
				del_id  = selectedArray[ selectedIndex ].id; 
				del_type = selectedArray[ selectedIndex ].name;
				del_row	= $("#" + del_id).parents('tr:first');
	        }
    });// delete button END

	// Delete action
	 $('#modaldelete .send-button').click(function () {
		// Modal message send form
				$.ajax({
					url: 'ajax/delete.php',
					data: 'action=DEL&cellid=' + del_id + '&type=' + del_type,
					type: 'post',
					cache: false,
					dataType: 'html',
					success: function(original_element){
						$.fancybox.close();
						$(del_row).fadeOut(800, function() { $(this).remove(); }); //Remove the row
					}
				});//end $.ajax
	});// Modal message send form END

	// Allow action
	 $(".alwbtn").click(function () {
	 var id = $(this).attr('name');
				$.ajax({
					url: 'ajax/modify_entry.php',
					data: 'action=ALW&cellid=' + id ,
					type: 'post',
					cache: false,
					dataType: 'html',
					success: function(original_element){
						//window.location.reload();
					}
				}); 
	});// Modal message send form END
	
	/* Reservation Status dropdownbox */
	$(".status_dbox").change(function(){ 
		var status_id = $(this).attr('id');
		var selected = $(this).val();
		status_id = status_id.substring(5,30);
		$.ajax({
		type: "POST",
		url: "ajax/modify_status.php",
		data: 'value=' + selected + '&id=' + status_id,
		success: function(){
		}
		});
		return true;
	}); // Reservation Status dropdownbox END

	/* Dayoff Status checkbox */
	
	$("#outlet_child_dayoff").change(function(){ 
		var status_id = $(this).attr('name');
		var value = $(this).val();
		$.ajax({
		type: "POST",
		url: "ajax/modify_dayoff.php",
		data: 'value=' + value + '&id=' + status_id,
		success: function(){
			location.reload();
		}
		});
		return true;
	}); 
	
	
	/* InlineEdit activation */
	$("#modaltabletrigger").fancybox();
	
	$('.inlineedit').editable('ajax/inline_edit.php', { 
	    type       : 'text',
	    cancel     : 'Cancel',
	    submit     : 'OK',
		placeholder: '...',
		cssclass   : 'inherit',
		onblur     : 'ignore', 
	    indicator  : '<img src="images/ajax-loader.gif">',
		callback		: function(original_element, html, value){
			// Check for unique table number and warn
			var array = [];
			var i = 0;
			$(".tb_nr").each(function () {
		   		if( $(this).text() == original_element ){
					i = i + 1;
					if( i == 2 ){
						$("#modaltabletrigger").trigger('click');
						return false;
					}
				}
			});
			}
	});
	
	/* Data Graph */
	setTimeout(function(){ 
		
		// Setup graph 1
    	$('#graph_week').visualize({
			width: '760px',
			height: '240px',
			colors: ['#26ADE4', '#D1E751']
		}).appendTo('#graph_wrapper1');
		
		// Setup graph 2
    	$('#graph_month').visualize({
			type: 'area',
			width: '760px',
			height: '240px',
			colors: ['#26ADE4', '#D1E751']
		}).appendTo('#graph_wrapper2');
		
		// Setup graph 3
    	$('#graph_type').visualize({
			type: 'pie',
			width: '760px',
			height: '240px',
			colors: ['#be1e2d','#666699','#ee8310','#92d5ea','#8d10ee','#5a3b16','#26a4ed','#f45a90','#e9e744'],
		}).appendTo('#graph_wrapper3');
		
		$('.visualize').trigger('visualizeRefresh');
		
	}, 200);
	
	$('.wysiwyg').css('width', '100%');
    
});