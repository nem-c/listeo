/* ----------------- Start Document ----------------- */
(function ($) {
"use strict";

function starsOutput(firstStar, secondStar, thirdStar, fourthStar, fifthStar) {
		return(''+
			'<span class="'+firstStar+'"></span>'+
			'<span class="'+secondStar+'"></span>'+
			'<span class="'+thirdStar+'"></span>'+
			'<span class="'+fourthStar+'"></span>'+
			'<span class="'+fifthStar+'"></span>');
	}

$.fn.numericalRating = function(){

	this.each(function() {
		var dataRating = $(this).attr('data-rating');

		// Rules
	    if (dataRating >= 4.0) {
	        $(this).addClass('high');
	    } else if (dataRating >= 3.0) {
	        $(this).addClass('mid');
	    } else if (dataRating < 3.0) {
	        $(this).addClass('low');
	    }

	});

}; 

/*  Star Rating
/*--------------------------*/
$.fn.starRating = function(){


	this.each(function() {

		var dataRating = $(this).attr('data-rating');
		if(dataRating > 0) {
			// Rating Stars Output
			
			var fiveStars = starsOutput('star','star','star','star','star');

			var fourHalfStars = starsOutput('star','star','star','star','star half');
			var fourStars = starsOutput('star','star','star','star','star empty');

			var threeHalfStars = starsOutput('star','star','star','star half','star empty');
			var threeStars = starsOutput('star','star','star','star empty','star empty');

			var twoHalfStars = starsOutput('star','star','star half','star empty','star empty');
			var twoStars = starsOutput('star','star','star empty','star empty','star empty');

			var oneHalfStar = starsOutput('star','star half','star empty','star empty','star empty');
			var oneStar = starsOutput('star','star empty','star empty','star empty','star empty');

			// Rules
	        if (dataRating >= 4.75) {
	            $(this).append(fiveStars);
	        } else if (dataRating >= 4.25) {
	            $(this).append(fourHalfStars);
	        } else if (dataRating >= 3.75) {
	            $(this).append(fourStars);
	        } else if (dataRating >= 3.25) {
	            $(this).append(threeHalfStars);
	        } else if (dataRating >= 2.75) {
	            $(this).append(threeStars);
	        } else if (dataRating >= 2.25) {
	            $(this).append(twoHalfStars);
	        } else if (dataRating >= 1.75) {
	            $(this).append(twoStars);
	        } else if (dataRating >= 1.25) {
	            $(this).append(oneHalfStar);
	        } else if (dataRating < 1.25) {
	            $(this).append(oneStar);
	        }
		}
	});

}; 
})(jQuery);
/* ----------------- Start Document ----------------- */
(function($){
"use strict";

$(document).ready(function(){

	/*--------------------------------------------------*/
	/*  Mobile Menu - mmenu.js
	/*--------------------------------------------------*/
	$(function() {
		function mmenuInit() {
			var wi = $(window).width();
			if(wi <= '1024') {

				$(".mmenu-init" ).remove();
				$("#navigation").clone().addClass("mmenu-init").insertBefore("#navigation").removeAttr('id').removeClass('style-1 style-2').find('ul').removeAttr('id');

				$(".mmenu-init").mmenu({
				 	"counters": true,
				 	navbar: {
					    title: listeo_core.mmenuTitle
					  }
				}, {
				 // configuration
				 offCanvas: {
				    pageNodetype: "#wrapper"
				 }
				});

				var mmenuAPI = $(".mmenu-init").data( "mmenu" );
				var $icon = $(".hamburger");
				mmenuAPI.close();
				$icon.removeClass( "is-active" );
				//$('#mm-blocker').hide();
				$(".mmenu-trigger").click(function() {
					mmenuAPI.open();
				});

				mmenuAPI.bind( "open:finish", function() {
				   setTimeout(function() {
				      $icon.addClass( "is-active" );
				   });
				});
				mmenuAPI.bind( "close:finish", function() {
				   setTimeout(function() {
				      $icon.removeClass( "is-active" );
				   });
				});


			}
			$(".mm-next").addClass("mm-fullsubopen");
		}
		mmenuInit();
		$(window).resize(function() { mmenuInit(); });
	});


    /*  User Menu */
    $('body').on('click', '.user-menu', function(){
		$(this).toggleClass('active');
	});

	var user_mouse_is_inside = false;

	$("body" ).on( "mouseenter", ".user-menu", function() {
	 user_mouse_is_inside=true;
	});
	$("body" ).on( "mouseleave", ".user-menu" ,function() {
	 user_mouse_is_inside=false;
	});

	$("body").mouseup(function(){
	   if(! user_mouse_is_inside) $(".user-menu").removeClass('active');
	});

	/*----------------------------------------------------*/
	/*  Sticky Header
	/*----------------------------------------------------*/
	if($('#header-container').hasClass('sticky-header')) {

		$( "#header" ).not( "#header.not-sticky" ).clone(true).addClass('cloned unsticky').insertAfter( "#header" );
		var reg_logo = $("#header.cloned #logo").data('logo');
		$("#header.cloned #logo img").attr('src',reg_logo);
	
		// sticky header script
		var headerOffset = 100;	 // height on which the sticky header will shows

		$(window).scroll(function(){
			
			if($(window).scrollTop() > headerOffset){
				$("#header.cloned").addClass('sticky').removeClass("unsticky");
				$("#navigation.style-2.cloned").addClass('sticky').removeClass("unsticky");
			} else {
				$("#header.cloned").addClass('unsticky').removeClass("sticky");
				$("#navigation.style-2.cloned").addClass('unsticky').removeClass("sticky");
			}
		});
	}
	


	/*----------------------------------------------------*/
	/*  Back to Top
	/*----------------------------------------------------*/
	var pxShow = 600; // height on which the button will show
	var scrollSpeed = 500; // how slow / fast you want the button to scroll to top.

	$(window).scroll(function(){
	 if($(window).scrollTop() >= pxShow){
		$("#backtotop").addClass('visible');
	 } else {
		$("#backtotop").removeClass('visible');
	 }
	});

	$('#backtotop a').on('click', function(){
	 $('html, body').animate({scrollTop:0}, scrollSpeed);
	 return false;
	});


	/*----------------------------------------------------*/
	/*  Inline CSS replacement for backgrounds etc.
	/*----------------------------------------------------*/
	function inlineCSS() {

		// Common Inline CSS
		$(".main-search-container, section.fullwidth, .listing-slider .item, .listing-slider-small .item, .address-container, .img-box-background, .image-edge, .edge-bg").each(function() {
			var attrImageBG = $(this).attr('data-background-image');
			var attrColorBG = $(this).attr('data-background-color');

	        if(attrImageBG !== undefined) {
	            $(this).css('background-image', 'url('+attrImageBG+')');
	        }

	        if(attrColorBG !== undefined) {
	            $(this).css('background', ''+attrColorBG+'');
	        }
		});

	}

	// Init
	inlineCSS();

	function parallaxBG() {

		$('.parallax,.vc_parallax').prepend('<div class="parallax-overlay"></div>');

		$('.parallax,.vc_parallax').each(function() {
			var attrImage = $(this).attr('data-background');
			var attrColor = $(this).attr('data-color');
			var attrOpacity = $(this).attr('data-color-opacity');

	        if(attrImage !== undefined) {
	            $(this).css('background-image', 'url('+attrImage+')');
	        }

	        if(attrColor !== undefined) {
	            $(this).find(".parallax-overlay").css('background-color', ''+attrColor+'');
	        }

	        if(attrOpacity !== undefined) {
	            $(this).find(".parallax-overlay").css('opacity', ''+attrOpacity+'');
	        }

		});
	}

	parallaxBG();

    /*----------------------------------------------------*/
    /*  Image Box
    /*----------------------------------------------------*/
	$('.category-box').each(function(){

		// add a photo container
		$(this).append('<div class="category-box-background"></div>');

		// set up a background image for each tile based on data-background-image attribute
		$(this).children('.category-box-background').css({'background-image': 'url('+ $(this).attr('data-background-image') +')'});

		
	});


    /*----------------------------------------------------*/
    /*  Image Box
    /*----------------------------------------------------*/
	$('.img-box').each(function(){
		$(this).append('<div class="img-box-background"></div>');
		$(this).children('.img-box-background').css({'background-image': 'url('+ $(this).attr('data-background-image') +')'});
	});



	/*----------------------------------------------------*/
	/*  Parallax
	/*----------------------------------------------------*/

	/* detect touch */
	if("ontouchstart" in window){
	    document.documentElement.className = document.documentElement.className + " touch";
	}
	if(!$("html").hasClass("touch")){
	    /* background fix */
	    $(".parallax").css("background-attachment", "fixed");
	}

	/* fix vertical when not overflow
	call fullscreenFix() if .fullscreen content changes */
	function fullscreenFix(){
	    var h = $('body').height();
	    // set .fullscreen height
	    $(".content-b").each(function(i){
	        if($(this).innerHeight() > h){ $(this).closest(".fullscreen").addClass("overflow");
	        }
	    });
	}
	$(window).resize(fullscreenFix);
	fullscreenFix();

	/* resize background images */
	function backgroundResize(){
	    var windowH = $(window).height();
	    $(".parallax").each(function(i){
	        var path = $(this);
	        // variables
	        var contW = path.width();
	        var contH = path.height();
	        var imgW = path.attr("data-img-width");
	        var imgH = path.attr("data-img-height");
	        var ratio = imgW / imgH;
	        // overflowing difference
	        var diff = 100;
	        diff = diff ? diff : 0;
	        // remaining height to have fullscreen image only on parallax
	        var remainingH = 0;
	        if(path.hasClass("parallax") && !$("html").hasClass("touch")){
	            //var maxH = contH > windowH ? contH : windowH;
	            remainingH = windowH - contH;
	        }
	        // set img values depending on cont
	        imgH = contH + remainingH + diff;
	        imgW = imgH * ratio;
	        // fix when too large
	        if(contW > imgW){
	            imgW = contW;
	            imgH = imgW / ratio;
	        }
	        //
	        path.data("resized-imgW", imgW);
	        path.data("resized-imgH", imgH);
	        path.css("background-size", imgW + "px " + imgH + "px");
	    });
	}


	$(window).resize(backgroundResize);
	$(window).focus(backgroundResize);
	backgroundResize();

	/* set parallax background-position */
	function parallaxPosition(e){
	    var heightWindow = $(window).height();
	    var topWindow = $(window).scrollTop();
	    var bottomWindow = topWindow + heightWindow;
	    var currentWindow = (topWindow + bottomWindow) / 2;
	    $(".parallax").each(function(i){
	        var path = $(this);
	        var height = path.height();
	        var top = path.offset().top;
	        var bottom = top + height;
	        // only when in range
	        if(bottomWindow > top && topWindow < bottom){
	            //var imgW = path.data("resized-imgW");
	            var imgH = path.data("resized-imgH");
	            // min when image touch top of window
	            var min = 0;
	            // max when image touch bottom of window
	            var max = - imgH + heightWindow;
	            // overflow changes parallax
	            var overflowH = height < heightWindow ? imgH - height : imgH - heightWindow; // fix height on overflow
	            top = top - overflowH;
	            bottom = bottom + overflowH;


	            // value with linear interpolation
	            var value = 0;
				if ( $('.parallax').is(".titlebar") ) {
				    value = min + (max - min) * (currentWindow - top) / (bottom - top) *2;
				} else {
					value = min + (max - min) * (currentWindow - top) / (bottom - top);
				}

	            // set background-position
	            var orizontalPosition = path.attr("data-oriz-pos");
	            orizontalPosition = orizontalPosition ? orizontalPosition : "50%";
	            $(this).css("background-position", orizontalPosition + " " + value + "px");
	        }
	    });
	}
	if(!$("html").hasClass("touch")){
	    $(window).resize(parallaxPosition);
	    $(window).scroll(parallaxPosition);
	    parallaxPosition();
	}

	// Jumping background fix for IE
	if(navigator.userAgent.match(/Trident\/7\./)) { // if IE
	    $('body').on("mousewheel", function () {
	        event.preventDefault();

	        var wheelDelta = event.wheelDelta;
	        var currentScrollPosition = window.pageYOffset;
	        window.scrollTo(0, currentScrollPosition - wheelDelta);
	    });
	}


    /*----------------------------------------------------*/
    /*  Chosen Plugin
    /*----------------------------------------------------*/

    // var config = {
    //   '.chosen-select'           : {
    //   		disable_search_threshold: 10, 
    //   		width:"100%",
    //   		no_results_text: listeo_core.no_results_text,
    //   		placeholder_text_single:  listeo_core.placeholder_text_single,
    //   		placeholder_text_multiple: listeo_core.placeholder_text_multiple
    //   	},
    //   '.chosen-select-deselect'  : {
    //   		allow_single_deselect:true, 
    //   		width:"100%",
    //   		no_results_text: listeo_core.no_results_text
    //   	},
    //   '.chosen-select-no-single' : {
    //   		disable_search_threshold:100, 
    //   		width:"100%",
    //   		no_results_text: listeo_core.no_results_text,
    //   		placeholder_text_single:  listeo_core.placeholder_text_single,
    //   		placeholder_text_multiple: listeo_core.placeholder_text_multiple
    //   	},
    //   '.chosen-select-no-single.no-search' : {
    //   		disable_search_threshold:10, 
    //   		width:"100%",
    //   		no_results_text: listeo_core.no_results_text,
    //   		placeholder_text_single:  listeo_core.placeholder_text_single,
    //   		placeholder_text_multiple: listeo_core.placeholder_text_multiple
    //   	},
    //   '.chosen-select-no-results': {
    //   	no_results_text: listeo_core.no_results_text,
    //   	placeholder_text_single:  listeo_core.placeholder_text_single,
    //   	placeholder_text_multiple: listeo_core.placeholder_text_multiple
    //   },
    //   '.chosen-select-width'     : {
    //   	width:"95%",
    //   	no_results_text: listeo_core.no_results_text,
    //   	placeholder_text_single:  listeo_core.placeholder_text_single,
    //   		placeholder_text_multiple: listeo_core.placeholder_text_multiple
    //   }
    // };

    // for (var selector in config) {
	   // 	if (config.hasOwnProperty(selector)) {
	   //    $(selector).chosen(config[selector]);
	  	// }
    // }

    	// Single Select
    $('.select2-single').select2({
    	 dropdownPosition: 'below',
    	 
    	minimumResultsForSearch: 20,
     	width: "100%",
     	placeholder: $(this).data('placeholder')
    });

    // Multiple Select
	$(".select2-multiple").each(function() {
		$(this).select2({
			dropdownPosition: 'below',
			width: "100%",
			placeholder: $(this).data('placeholder')
		});
	});   

	$('.main-search-inner .select2-single').select2({
    	minimumResultsForSearch: 20,
    	dropdownPosition: 'below',
    	
     	width: "100%",
     	//placeholder: $(this).data('placeholder'),
     		dropdownParent: $('.main-search-input'),
    });

    // Multiple Select
	$(".main-search-inner .select2-multiple").each(function() {
		$(this).select2({
			width: "100%",
			dropdownPosition: 'below',
			placeholder: $(this).data('placeholder'),
				dropdownParent: $('.main-search-input'),
		});
	});


	  // Select on Home Search Bar
    $('.select2-sortby').select2({
      	dropdownParent: $('.sort-by'),
      	minimumResultsForSearch: 20,
     	width: "100%",
     	dropdownPosition: 'below',
     	placeholder: $(this).data('placeholder')
    });
	  // Select on Home Search Bar
    $('.select2-bookings').select2({
      	dropdownParent: $('.sort-by'),
      	minimumResultsForSearch: 20,
     	width: "100%",
     	dropdownPosition: 'below',
     	placeholder: $(this).data('placeholder')
    });

  	/*----------------------------------------------------*/
    /*  Magnific Popup
    /*----------------------------------------------------*/
      
	$('.mfp-gallery-container').each(function() { // the containers for all your galleries

		$(this).magnificPopup({
			 type: 'image',
			 delegate: 'a.mfp-gallery',

			 fixedContentPos: true,
			 fixedBgPos: true,

			 overflowY: 'auto',

			 closeBtnInside: false,
			 preloader: true,

			 removalDelay: 0,
			 mainClass: 'mfp-fade',

			 gallery:{enabled:true, tCounter: ''}
		});
	});

	$('.popup-with-zoom-anim').magnificPopup({
		 type: 'inline',

		 fixedContentPos: false,
		 fixedBgPos: true,

		 overflowY: 'auto',

		 closeBtnInside: true,
		 preloader: false,

		 midClick: true,
		 removalDelay: 300,
		 mainClass: 'my-mfp-zoom-in'
	});

	$('.mfp-image').magnificPopup({
		 type: 'image',
		 closeOnContentClick: true,
		 mainClass: 'mfp-fade',
		 image: {
			  verticalFit: true
		 }
	});

	$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
		 disableOn: 700,
		 type: 'iframe',
		 mainClass: 'mfp-fade',
		 removalDelay: 160,
		 preloader: false,

		 fixedContentPos: false
	});



   	/*----------------------------------------------------*/
    /*  Slick Carousel
    /*----------------------------------------------------*/

	$('.fullwidth-slick-carousel').slick({
	  centerMode: true,
	  centerPadding: '20%',
	  slidesToShow: 3,
	  dots: true,
	  arrows: false,
	  responsive: [
		{
		  breakpoint: 1920,
		  settings: {
		    centerPadding: '15%',
		    slidesToShow: 3
		  }
		},
		{
		  breakpoint: 1441,
		  settings: {
		    centerPadding: '10%',
		    slidesToShow: 3
		  }
		},
		{
		  breakpoint: 1025,
		  settings: {
		    centerPadding: '10px',
		    slidesToShow: 2,
		  }
		},
		{
		  breakpoint: 767,
		  settings: {
		    centerPadding: '10px',
		    slidesToShow: 1
		  }
		}
	  ]
	});


	$('.testimonial-carousel').slick({
	  centerMode: true,
	  centerPadding: '34%',
	  slidesToShow: 1,
	  dots: true,
	  arrows: false,
	  responsive: [
		{
		  breakpoint: 1025,
		  settings: {
		    centerPadding: '10px',
		    slidesToShow: 2,
		  }
		},
		{
		  breakpoint: 767,
		  settings: {
		    centerPadding: '10px',
		    slidesToShow: 1
		  }
		}
	  ]
	});


	 $('.listing-slider').slick({
		centerMode: true,
		centerPadding: '20%',
		slidesToShow: 2,
		responsive: [
			{
			  breakpoint: 1367,
			  settings: {
			    centerPadding: '15%'
			  }
			},
			{
			  breakpoint: 1025,
			  settings: {
			    centerPadding: '0'
			  }
			},
			{
			  breakpoint: 767,
			  settings: {
			    centerPadding: '0',
			    slidesToShow: 1
			  }
			}
		]
	});
	 $('.widget-listing-slider').slick({
		
		dots: true,
  		infinite: true,
  		arrows: false,
		slidesToShow: 1,
		
	});



   $('.listing-slider-small').slick({
    centerMode: true,
    centerPadding: '0',
    slidesToShow: 3,
    responsive: [
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });

	$('.simple-slick-carousel').slick({
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 3,
		dots: true,
		arrows: true,
		responsive: [
		    {
		      breakpoint: 992,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2
		      }
		    },
		    {
		      breakpoint: 769,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    }
	  ]
	}).on("init", function(e, slick) {
		
		console.log(slick);
            //slideautplay = $('div[data-slick-index="'+ slick.currentSlide + '"]').data("time");
            //$s.slick("setOption", "autoplaySpeed", slideTime);
    });
	


	$('.simple-fw-slick-carousel').slick({
		infinite: true,
		slidesToShow: 5,
		slidesToScroll: 1,
		dots: true,
		arrows: false,

		responsive: [
		{
		  breakpoint: 1610,
		  settings: {
			slidesToShow: 4,
		  }
		},
		{
		  breakpoint: 1365,
		  settings: {
			slidesToShow: 3,
		  }
		},
		{
		  breakpoint: 1024,
		  settings: {
			slidesToShow: 2,
		  }
		},
		{
		  breakpoint: 767,
		  settings: {
			slidesToShow: 1,
		  }
		}
		]
	}).on("init", function(e, slick) {

		console.log(slick);
            //slideautplay = $('div[data-slick-index="'+ slick.currentSlide + '"]').data("time");
            //$s.slick("setOption", "autoplaySpeed", slideTime);
    });


	$('.logo-slick-carousel').slick({
		infinite: true,
		slidesToShow: 5,
		slidesToScroll: 4,
		dots: true,
		arrows: true,
		responsive: [
		    {
		      breakpoint: 992,
		      settings: {
		        slidesToShow: 3,
		        slidesToScroll: 3
		      }
		    },
		    {
		      breakpoint: 769,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    }
	  ]
	});

	// Fix for carousel if there are less than 4 categories
    $(window).on('load resize', function(e) {
        var carouselListItems = $(".fullwidth-slick-carousel .fw-carousel-item").length;
        if (carouselListItems<4) {
            $('.fullwidth-slick-carousel .slick-slide').css({
                'pointer-events': 'all',
                'opacity': '1',
            });
        }
    });


	// Mobile fix for small listing slider
    $(window).on('load resize', function(e) {
        var carouselListItems = $(".listing-slider-small .slick-track").children().length
        if (carouselListItems<2) {
            $('.listing-slider-small .slick-track').css({
                transform: 'none'
            });
        }
    });

    

	// Number Picker - TobyJ
	(function ($) {
	  $.fn.numberPicker = function() {
	    var dis = 'disabled';
	    return this.each(function() {
	      var picker = $(this),
	          p = picker.find('button:last-child'),
	          m = picker.find('button:first-child'),
	          input = picker.find('input'),                 
	          min = parseInt(input.attr('min'), 10),
	          max = parseInt(input.attr('max'), 10),
	          inputFunc = function(picker) {
	            var i = parseInt(input.val(), 10);
	            if ( (i <= min) || (!i) ) {
	              input.val(min);
	              p.prop(dis, false);
	              m.prop(dis, true);
	            } else if (i >= max) {
	              input.val(max);
	              p.prop(dis, true); 
	              m.prop(dis, false);
	            } else {
	              p.prop(dis, false);
	              m.prop(dis, false);
	            }
	          },
	          changeFunc = function(picker, qty) {
	            var q = parseInt(qty, 10),
	                i = parseInt(input.val(), 10);
	            if ((i < max && (q > 0)) || (i > min && !(q > 0))) {
	              input.val(i + q);
	              inputFunc(picker);
	            }
	          };
	      m.on('click', function(e){e.preventDefault();changeFunc(picker,-1);});
	      p.on('click', function(e){e.preventDefault();changeFunc(picker,1);});
	      input.on('change', function(){inputFunc(picker);});
	      inputFunc(picker); //init
	    });
	  };
	}(jQuery));

	// Init
	$('.plusminus').numberPicker();



	/*----------------------------------------------------*/
	/*  Tabs
	/*----------------------------------------------------*/

	var $tabsNav    = $('.tabs-nav'),
	$tabsNavLis = $tabsNav.children('li');

	$tabsNav.each(function() {
		 var $this = $(this);

		 $this.next().children('.tab-content').stop(true,true).hide()
		 .first().show();

		 $this.children('li').first().addClass('active').stop(true,true).show();
	});

	$tabsNavLis.on('click', function(e) {
		 var $this = $(this);

		 $this.siblings().removeClass('active').end()
		 .addClass('active');

		 $this.parent().next().children('.tab-content').stop(true,true).hide()
		 .siblings( $this.find('a').attr('href') ).fadeIn();

		 e.preventDefault();
	});
	var hash = window.location.hash;
	var anchor = $('.tabs-nav a[href="' + hash + '"]');
	if (anchor.length === 0) {
		 $(".tabs-nav li:first").addClass("active").show(); //Activate first tab
		 $(".tab-content:first").show(); //Show first tab content
	} else {
		 anchor.parent('li').click();
	}


	/*----------------------------------------------------*/
	/*  Accordions
	/*----------------------------------------------------*/
	var $accor = $('.accordion');

	 $accor.each(function() {
		 $(this).toggleClass('ui-accordion ui-widget ui-helper-reset');
		 $(this).find('h3').addClass('ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all');
		 $(this).find('div').addClass('ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom');
		 $(this).find("div").hide();

	});

	var $trigger = $accor.find('h3');

	$trigger.on('click', function(e) {
		 var location = $(this).parent();

		 if( $(this).next().is(':hidden') ) {
			  var $triggerloc = $('h3',location);
			  $triggerloc.removeClass('ui-accordion-header-active ui-state-active ui-corner-top').next().slideUp(300);
			  $triggerloc.find('span').removeClass('ui-accordion-icon-active');
			  $(this).find('span').addClass('ui-accordion-icon-active');
			  $(this).addClass('ui-accordion-header-active ui-state-active ui-corner-top').next().slideDown(300);
		 }
		  e.preventDefault();
	});


	/*----------------------------------------------------*/
	/*	Toggle
	/*----------------------------------------------------*/

	$(".toggle-container").hide();

	$('.trigger, .trigger.opened').on('click', function(a){
		$(this).toggleClass('active');
		a.preventDefault();
	});

	$(".trigger").on('click', function(){
		$(this).next(".toggle-container").slideToggle(300);
	});

	$(".trigger.opened").addClass("active").next(".toggle-container").show();


	/*----------------------------------------------------*/
	/*  Tooltips
	/*----------------------------------------------------*/

	$(".tooltip.top").tipTip({
	  defaultPosition: "top"
	});

	$(".tooltip.bottom").tipTip({
	  defaultPosition: "bottom"
	});

	$(".tooltip.left").tipTip({
	  defaultPosition: "left"
	});

	$(".tooltip.right").tipTip({
	  defaultPosition: "right"
	});


    /*----------------------------------------------------*/
    /*  Searh Form More Options
    /*----------------------------------------------------*/
    $('.more-search-options-trigger').on('click', function(e){
    	e.preventDefault();
		$('.more-search-options, .more-search-options-trigger').toggleClass('active');
		$('.more-search-options.relative').animate({height: 'toggle', opacity: 'toggle'}, 300);
	});


    /*----------------------------------------------------*/
    /*  Half Screen Map Adjustments
    /*----------------------------------------------------*/
	$(window).on('load resize', function() {
		var winWidth = $(window).width();
		var headerHeight = $("#header-container").height(); // height on which the sticky header will shows
	
		$('.fs-inner-container, .fs-inner-container.map-fixed, #dashboard').css('padding-top', headerHeight);

		if(winWidth<992) {
			$('.fs-inner-container.map-fixed').insertBefore('.fs-inner-container.content');
		} else {
			$('.fs-inner-container.content').insertBefore('.fs-inner-container.map-fixed');
		}

	});


    /*----------------------------------------------------*/
    /*  Counters
    /*----------------------------------------------------*/
    $(window).on('load', function() {
		$('.dashboard-stat-content h4').counterUp({
	        delay: 100,
	        time: 800,
	         formatter: function (n) {
	         	if($('#waller-row').data('numberFormat') == 'euro'){
				      return n.replace(".", ",")
		         	} else {
		         		return n;
		         	}
			    }

	    });
    });


    /*----------------------------------------------------*/
    /*  Rating Script Init
    /*----------------------------------------------------*/

	// Leave Rating
	$('.leave-rating input').change(function () {
		var $radio = $(this);
		$('.leave-rating .selected').removeClass('selected');
		$radio.closest('label').addClass('selected');
		
	});


	/*----------------------------------------------------*/
	/* Dashboard Scripts
	/*----------------------------------------------------*/
    $('.dashboard-nav ul li a').on('click', function(){
		if ($(this).closest('li').has('ul').length) {
			$(this).parent('li').toggleClass('active');
		}
	});

    // Dashbaord Nav Scrolling
	$(window).on('load resize', function() {
		var wrapperHeight = window.innerHeight;
		var headerHeight = $("#header-container").height();
		var winWidth = $(window).width();

		if(winWidth>992) {
			$(".dashboard-nav-inner").css('max-height', wrapperHeight-headerHeight);
		} else {
			$(".dashboard-nav-inner").css('max-height', '');
		}
	});


    // Tooltip
	$(".tip").each(function() {
		var tipContent = $(this).attr('data-tip-content');
		$(this).append('<div class="tip-content">'+ tipContent + '</div>');
	});

	$(".verified-badge.with-tip").each(function() {
		var tipContent = $(this).attr('data-tip-content');
		$(this).append('<div class="tip-content">'+ tipContent + '</div>');
	});

	$(window).on('load resize', function() {
		var verifiedBadge = $('.verified-badge.with-tip');
		verifiedBadge.find('.tip-content').css({
		   'width' : verifiedBadge.outerWidth(),
		   'max-width' : verifiedBadge.outerWidth(),
		});
	});

	// Responsive Nav Trigger
    $('.dashboard-responsive-nav-trigger').on('click', function(e){
    	e.preventDefault();
		$(this).toggleClass('active');

		var dashboardNavContainer = $('body').find(".dashboard-nav");

		if( $(this).hasClass('active') ){
			$(dashboardNavContainer).addClass('active');
		} else {
			$(dashboardNavContainer).removeClass('active');
		}

	});

    // Dashbaord Messages Alignment
	$(window).on('load resize', function() {
		var msgContentHeight = $(".message-content").outerHeight();
		var msgInboxHeight = $(".messages-inbox ul").height();

		if( msgContentHeight > msgInboxHeight ){
			$(".messages-container-inner .messages-inbox ul").css('max-height', msgContentHeight);
		}
	});



	

	/*----------------------------------------------------*/
	/*  Notifications
	/*----------------------------------------------------*/
	$("a.close").removeAttr("href").on('click', function(){

		function slideFade(elem) {
			var fadeOut = { opacity: 0, transition: 'opacity 0.5s' };
			elem.css(fadeOut).slideUp();
		}
		slideFade($(this).parent());

	});


	/*----------------------------------------------------*/
	/* Panel Dropdown
	/*----------------------------------------------------*/
    function close_panel_dropdown() {
		$('.panel-dropdown').removeClass("active");
		$('.fs-inner-container.content').removeClass("faded-out");
    }

    $('.panel-dropdown a').on('click', function(e) {

		if ( $(this).parent().is(".active") ) {
            close_panel_dropdown();
        } else {
            close_panel_dropdown();
            $(this).parent().addClass('active');
			$('.fs-inner-container.content').addClass("faded-out");
        }

        e.preventDefault();
    });

    // Apply / Close buttons
    $('.panel-buttons button,.panel-buttons span.panel-cancel').on('click', function(e) {
	    $('.panel-dropdown').removeClass('active');
		$('.fs-inner-container.content').removeClass("faded-out");
    }); 

    var $inputRange = $('input[type="range"].distance-radius');
  
	$inputRange.rangeslider({
	    polyfill : false,
	    onInit : function() {
	        var radiustext = $('.distance-radius').attr('data-title');
	        this.output = $( '<div class="range-output" />' ).insertBefore( this.$range ).html( this.$element.val() ).after('<i class="data-radius-title">'+ radiustext + '</i>');;

		    
		    // $('.range-output')

	    },
	    onSlide : function( position, value ) {
	        this.output.html( value );
	    }
	});

   


    $('.sidebar .panel-disable').on('click', function(e) {
    	var to = $('.sidebar .range-slider');
    	var enable = $(this).data('enable');
    	var disable = $(this).data('disable');
	    to.toggleClass('disabled');
	    if(to.hasClass('disabled')){
	    	$(to).find("input").prop('disabled', true);
	    	$(this).html(enable);
	    } else {
	    	$(to).find("input").prop('disabled', false);
			$(this).html(disable);
	    }
	    $inputRange.rangeslider('update');
    });

    //disable radius in panels

     //disable radius in sidebar
     if(listeo_core.radius_state == 'disabled') {
     	$('.sidebar .panel-disable').each(function( index ) {
	    	var enable = $(this).data('enable');
	    	$('.sidebar .range-slider').toggleClass('disabled').find("input").prop('disabled', true);
	    	$inputRange.rangeslider('update');
			$(this).html(enable);
	    });
	    $('.panel-buttons span.panel-disable').each(function( index ) {
	      	var to = $(this).parent().parent();
	    	var enable = $(this).data('enable');
	    	var disable = $(this).data('disable');
		    to.toggleClass('disabled');
		    if(to.hasClass('disabled')){
		    	$(to).find("input").prop('disabled', true);
		    	$(this).html(enable);
		    } else {
		    	$(to).find("input").prop('disabled', false);
				$(this).html(disable);
		    }
		    $inputRange.rangeslider('update');
	  	});
     }
	    

    $('.panel-buttons span.panel-disable').on('click', function(e) {
    	var to = $(this).parent().parent();
    	var enable = $(this).data('enable');
    	var disable = $(this).data('disable');
	    to.toggleClass('disabled');
	    if(to.hasClass('disabled')){
	    	$(to).find("input").prop('disabled', true);
	    	$(this).html(enable);
	    } else {
	    	$(to).find("input").prop('disabled', false);
			$(this).html(disable);
	    }
	    $inputRange.rangeslider('update');
    });

    // Closes dropdown on click outside the conatainer
	var mouse_is_inside = false;

	$('.panel-dropdown').hover(function(){
	    mouse_is_inside=true;
	}, function(){
	    mouse_is_inside=false;
	});

	$("body").mouseup(function(){
	    if(! mouse_is_inside) close_panel_dropdown();
	});

    // "All" checkbox
    $('.checkboxes.categories input').on('change', function() {
        if($(this).hasClass('all')){
            $(this).parents('.checkboxes').find('input').prop('checked', false);
            $(this).prop('checked', true);
        } else {
            $('.checkboxes input.all').prop('checked', false);
        }
    });

	

/*--------------------------------------------------*/
	/*  Bootstrap Range Slider
	/*--------------------------------------------------*/

	// Thousand Separator for Tooltip
	function ThousandSeparator(nStr) {
	    nStr += '';
	    var x = nStr.split('.');
	    var x1 = x[0];
	    var x2 = x.length > 1 ? '.' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + ',' + '$2');
	    }
	    return x1 + x2;
	}

	// Bootstrap Range Slider
	var currencyAttr = $(".bootstrap-range-slider").attr('data-slider-currency');
	
	
	$(".bootstrap-range-slider").slider({
		formatter: function(value) {
			return ThousandSeparator(parseFloat(value[0])) + " - " + ThousandSeparator(parseFloat(value[1])) + " " + currencyAttr;
		}
	})
	
	if( !$(".range-slider-container").hasClass('no-to-disable') ) {
		
		$(".bootstrap-range-slider").slider("disable").prop('disabled', true).toggleClass('disabled');
	} else {
		var dis = $(".slider-disable").data('disable');
		$(".slider-disable").html(dis);
	}
	
	$('.range-slider-container:not(".no-to-disable")').toggleClass('disabled');
	
	$(".slider-disable").click(function() {
		var to = $('.range-slider-container');
    	var enable = $(this).data('enable');
    	var disable = $(this).data('disable');
	    to.toggleClass('disabled');
	    if(to.hasClass('disabled')){
	    	$(".bootstrap-range-slider").slider("disable");
	    	$(to).find("input").prop('disabled', true);
	    	$(this).html(enable);
	    } else {
	    	$(".bootstrap-range-slider").slider("enable");
	    	$(to).find("input").prop('disabled', false);
			$(this).html(disable);
	    }    
	});

    /*----------------------------------------------------*/
    /*  Show More Button
    /*----------------------------------------------------*/
    $('.show-more-button').on('click', function(e){
    	e.preventDefault();
    	$(this).toggleClass('active');

		$('.show-more').toggleClass('visible');
		if ( $('.show-more').is(".visible") ) {

			var el = $('.show-more'),
				curHeight = el.height(),
				autoHeight = el.css('height', 'auto').height();
				el.height(curHeight).animate({height: autoHeight}, 400);


		} else { $('.show-more').animate({height: '450px'}, 400); }

	});

	/*----------------------------------------------------*/
	/* Listing Page Nav
	/*----------------------------------------------------*/

 //  	$(window).on('resize load', function() {
	// 	var winWidth = $(window).width();
	// 	if (winWidth<992) {
	// 		$('.mobile-sidebar-container').insertBefore('.mobile-content-container');
	// 	} else {
	// 		$('.mobile-sidebar-container').insertAfter('.mobile-content-container');
	// 	}
	// });


	if(document.getElementById("listing-nav") !== null) {
		$(window).scroll(function(){
			var window_top = $(window).scrollTop();
			var div_top = $('.listing-nav').not('.listing-nav-container.cloned .listing-nav').offset().top + 90;
		    if (window_top > div_top) {
		        $('.listing-nav-container.cloned').addClass('stick');
		    } else {
		        $('.listing-nav-container.cloned').removeClass('stick');
		    }
		});
	}

	$( ".listing-nav-container" ).clone(true).addClass('cloned').prependTo("body");


    // Smooth scrolling using scrollto.js
	$('.listing-nav a, a.listing-address, .star-rating a').on('click', function(e) {
        e.preventDefault();
        $('html,body').scrollTo(this.hash, this.hash, { gap: {y: -20} });
    });

	$(".listing-nav li:first-child a, a.add-review-btn, a[href='#add-review']").on('click', function(e) {
        e.preventDefault();
        $('html,body').scrollTo(this.hash, this.hash, { gap: {y: -100} });
    });


    // Highlighting functionality.
	$(window).on('load resize', function() {
		var aChildren = $(".listing-nav li").children();
		var aArray = [];
		for (var i=0; i < aChildren.length; i++) {
		    var aChild = aChildren[i];
		    var ahref = $(aChild).attr('href');
		    aArray.push(ahref);
		}

		$(window).scroll(function(){
		    var windowPos = $(window).scrollTop();
		    for (var i=0; i < aArray.length; i++) {
		        var theID = aArray[i];
		        if( $(theID).length>0){
			        var divPos = $(theID).offset().top - 150;
			        var divHeight = $(theID).height();
			        if (windowPos >= divPos && windowPos < (divPos + divHeight)) {
			            $("a[href='" + theID + "']").addClass("active");
			        } else {
			            $("a[href='" + theID + "']").removeClass("active");
			        }
			    }
		    }
		});
	});


	var time24 = false;
		
	if(listeo_core.clockformat){
		time24 = true;
	}
	$(".listeo-flatpickr").flatpickr({
		enableTime: true,
		noCalendar: true,
		dateFormat: "H:i",
		time_24hr: time24,
		disableMobile: true
	});

	$('.day_hours_reset').on('click', function(e) {
		$(this).parent().parent().find('input').val('');
	});

	/*----------------------------------------------------*/
	/*  Payment Accordion
	/*----------------------------------------------------*/
	var radios = document.querySelectorAll('.payment-tab-trigger > input');

	for (var i = 0; i < radios.length; i++) {
		radios[i].addEventListener('change', expandAccordion);
	}

	function expandAccordion (event) {
	  var allTabs = document.querySelectorAll('.payment-tab');
	  for (var i = 0; i < allTabs.length; i++) {
	    allTabs[i].classList.remove('payment-tab-active');
	  }
	  event.target.parentNode.parentNode.classList.add('payment-tab-active');
	}


    /*----------------------------------------------------*/
    /*  Rating Overview Background Colors
    /*----------------------------------------------------*/
	function ratingOverview(ratingElem) {

		$(ratingElem).each(function() {
			var dataRating = $(this).attr('data-rating');

			// Rules
		    if (dataRating >= 4.0) {
		        $(this).addClass('high');
		   		$(this).find('.rating-bars-rating-inner').css({ width: (dataRating/5)*100 + "%", });
		    } else if (dataRating >= 3.0) {
		        $(this).addClass('mid');
		   		$(this).find('.rating-bars-rating-inner').css({ width: (dataRating/5)*80 + "%", });
		    } else if (dataRating < 3.0) {
		        $(this).addClass('low');
		   		$(this).find('.rating-bars-rating-inner').css({ width: (dataRating/5)*60 + "%", });
		    }

		});
	} ratingOverview('.rating-bars-rating');

	$(window).on('resize', function() {
		ratingOverview('.rating-bars-rating');
	});


    /*----------------------------------------------------*/
    /*  Recaptcha Holder
    /*----------------------------------------------------*/
	$('.message-vendor').on('click', function() {
		$('.captcha-holder').addClass('visible')
	});

	if(listeo_core.map_provider == 'google') {
		$('.show-map-button').on('click', function(event) {
		 event.preventDefault(); 
		 $(".hide-map-on-mobile").toggleClass("map-active"); 
		 var text_enabled = $(this).data('enabled');
		 var text_disabled = $(this).data('disabled');
		 if( $(".hide-map-on-mobile").hasClass('map-active')){
		 	$(this).text(text_disabled);
		 	//$( '#listeo-listings-container' ).triggerHandler('show_map');
		 } else {
			$(this).text(text_enabled);
		 }
		});
	}
	$(window).on('load resize', function() {
		$(".fs-inner-container.map-fixed").addClass("hide-map-on-mobile");
		$("#map-container").addClass("hide-map-on-mobile");
	});
	


/*----------------------------------------------------*/
/*  Ratings Script
/*----------------------------------------------------*/

/*  Numerical Script
/*--------------------------*/
$('.numerical-rating').numericalRating();

$('.star-rating').starRating();
// ------------------ End Document ------------------ //
});

})(this.jQuery);


/*!
 * jQuery UI Touch Punch 0.2.3
 *
 * Copyright 2011–2014, Dave Furfero
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * Depends:
 *  jquery.ui.widget.js
 *  jquery.ui.mouse.js
 */
!function(a){function f(a,b){if(!(a.originalEvent.touches.length>1)){a.preventDefault();var c=a.originalEvent.changedTouches[0],d=document.createEvent("MouseEvents");d.initMouseEvent(b,!0,!0,window,1,c.screenX,c.screenY,c.clientX,c.clientY,!1,!1,!1,!1,0,null),a.target.dispatchEvent(d)}}if(a.support.touch="ontouchend"in document,a.support.touch){var e,b=a.ui.mouse.prototype,c=b._mouseInit,d=b._mouseDestroy;b._touchStart=function(a){var b=this;!e&&b._mouseCapture(a.originalEvent.changedTouches[0])&&(e=!0,b._touchMoved=!1,f(a,"mouseover"),f(a,"mousemove"),f(a,"mousedown"))},b._touchMove=function(a){e&&(this._touchMoved=!0,f(a,"mousemove"))},b._touchEnd=function(a){e&&(f(a,"mouseup"),f(a,"mouseout"),this._touchMoved||f(a,"click"),e=!1)},b._mouseInit=function(){var b=this;b.element.bind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),c.call(b)},b._mouseDestroy=function(){var b=this;b.element.unbind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),d.call(b)}}}(jQuery);
