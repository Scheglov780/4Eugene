/*
 Theme Name: Virki2 HTML Template
 Version: 1.0
 */

scripts = document.getElementsByTagName('script');
thisFilePath = scripts[scripts.length - 1].src.split('?')[0];      // remove any ?query
var themePath = thisFilePath.split('/').slice(0, -2).join('/');  // remove last filename part of path
delete scripts;
delete thisFilePath;

(function ($) {
    'use strict';
    if ($(".sliderSection").length > 0) {
       var mainBanner = $('.tp-banner').show().revolution({
            autoHeight:"off",
            delay: 9000,
            dottedOverlay:"none",					//twoxtwo, threexthree, twoxtwowhite, threexthreewhite
            drag_block_vertical:false,               // Prevent Vertical Scroll during Swipe
            forceFullWidth:"off",                   // Force The FullWidth
            fullScreen:"on",
            fullScreenAlignForce: "on",
            //fullScreenOffset:"0",					// Size for FullScreen Slider minimising
            fullScreenOffsetContainer: "#headersGroup",   // Size for FullScreen Slider minimising Calculated on the Container sizes
            fullWidth:"off",                        // Turns On or Off the Fullwidth Image Centering in FullWidth Modus
            hideAllCaptionAtLimit:0,                // Hide all The Captions if Width of Browser is less then this value
            hideArrowsOnMobile:"on",
            hideBulletsOnMobile:"on",
            hideCaptionAtLimit:640,                   // It Defines if a caption should be shown under a Screen Resolution ( Basod on The Width of Browser)
            hideNavDelayOnMobile:10,
            hideSliderAtLimit:0,                    // Hide the whole slider, and stop also functions if Width of Browser is less than this value
			hideThumbs:0,
            hideThumbsOnMobile:"on",
            hideThumbsUnderResolution:0,
            hideTimerBar:"on",
            isJoomla:false,
            keyboardNavigation:"on",
            minFullScreenHeight:0,					// The Minimum FullScreen Height
            minHeight:0,
            navigationArrows:"solo",				// nextto, solo, none
            navigationHAlign:"center",				// Vertical Align top,center,bottom
            navigationHOffset:30,
            navigationInGrid:"off",					// on/off
            navigationStyle:"round",				// round,square,navbar,round-old,square-old,navbar-old, or any from the list in the docu (choose between 50+ different item),
            navigationType:"bullet",				// bullet, thumb, none
            navigationVAlign:"bottom",				// Horizontal Align left,center,right
            navigationVOffset:30,
            nextSlideOnWindowFocus:"off",
            onHoverStop:"off",                      // Stop Banner Timet at Hover on Slide on/off
            panZoomDisableOnMobile:"off",
            parallax:"off",
            parallaxBgFreeze: "off",
            parallaxDisableOnMobile:"off",
            parallaxLevels: [10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85],
            parallaxOpacity:"on",
            shadow:0,								//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows  (No Shadow in Fullwidth Version !)
            simplifyAll:"on",
            soloArrowLeftHalign:"left",
            soloArrowLeftHOffset:20,
            soloArrowLeftValign:"center",
            soloArrowLeftVOffset:100,
            soloArrowRightHalign:"right",
            soloArrowRightHOffset:20,
            soloArrowRightValign:"center",
            soloArrowRightVOffset:100,
            spinner:"spinner4",
            startDelay:0,		// Delay before the first Animation starts.
            startheight: 750,
            startwidth: 1170,
            stopAfterLoops:1,						// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic
            stopAtSlide:1,							// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
            swipe_min_touches : 1,					// Min Finger (touch) used for swipe
            swipe_treshold : 45,					// The number of pixels that the user must move their finger by before it is considered a swipe.
            thumbAmount:0,
            thumbHeight:0,
            thumbWidth:0,
            touchenabled:"off"
        });
       mainBanner.on('revolution.slide.onloaded', function() {
           //Scroll to banner onLoad
           /*
           if ($('#siteHeader').length > 0) {
               $(document).scrollTop($('#siteHeader').offset().top);
           }
           */
           if ($('.preloader').length > 0) {
               $('.preloader').delay(400).fadeOut('fast');
           }
       });
    }

    //=========================
    // Mixer
    //=========================
    if ($('.filterCont').length > 0) {
        $('.filterCont').themeWar();
    }

    //========================
    // Mobile Menu
    //========================
    if ($('.mobileMenu').length > 0) {
        $('.mobileMenu').on('click', function () {
            $(this).toggleClass('active');
            $('.mainnav > ul').slideToggle('slow');
        });
        if ($(window).width() <= 1200) {
            $(".mainnav .has-menu-items > a").on('click', function () {
                //$(this).parent().toggleClass('active');
                $(this).parent().children('.sub-menu').slideToggle('slow');
                return false;
            });
            $(".mainnav .has-menu-items > i").on('click', function () {
                //$(this).parent().toggleClass('active');
                $(this).parent().children('.sub-menu').slideToggle('slow');
                return false;
            });
            $(window).on('scroll', function () {
                $('.mobileMenu.active').removeClass('active');
                $('.mainnav > ul:visible').slideUp('fast');
                /* if ($(window).width() <= 768) {
                    //$('.mainnav .has-menu-items > a').parent('.active') .removeClass('active');
                    $('.mainnav .has-menu-items > a').parent().children('.sub-menu:visible').slideUp('fast');
                } */
            });
        }
    }
    //=======================================================
    // Color Preset
    //=======================================================
    if ($(".colorPresetArea").length > 0) {
        var switchs = true;
        $(".gearBtn").on('click', function (e) {
            e.preventDefault();
            if (switchs) {
                $(this).addClass('active');
                $(".colorPresetArea").animate({'left': '0px'}, 400);
                switchs = false;
            } else {
                $(this).removeClass('active');
                $(".colorPresetArea").animate({'left': '-290px'}, 400);
                switchs = true;
            }
        });

        $("#patterns a").on('click', function (e) {
            e.preventDefault();
            var bg = $(this).attr('href');

            if ($(".boxed").hasClass('active')) {
                //alert(bg);
                $('#patterns a').removeClass('active');
                $(this).addClass('active');
                $('body').removeClass('pat1 pat2 pat3 pat4 pat5 pat6 pat7 pat8 pat9 pat10');
                $('body').addClass(bg);
            } else {
                alert('Please, active box layout First.');
            }

        });

        $(".layout").on('click', function (e) {
            e.preventDefault();
            var layout = $(this).attr('href');
            if (layout == 'wide') {
                $('body').removeClass('pat1 pat2 pat3 pat4 pat5 pat6 pat7 pat8 pat9 pat10');
            }
            $('.layout').removeClass('active');
            $(this).addClass('active');
            var cssUrl = themePath + '/css/lay_colors/' + layout + '.css';
            console.log(cssUrl);
            $("#layout").attr('href', cssUrl);
        });

        $(".lightDark a").on('click',function (e) {
            e.preventDefault();
            var colorsch = $(this).attr('href');
            $('.lightDark a').removeClass('active');
            $(this).addClass('active');
            var cssUrl = themePath + '/css/lay_colors/' + colorsch + '.css';
            console.log(cssUrl);
            $("#lightDark").attr('href', cssUrl);
        });

        $(".mainColors a").on('click', function (e) {
            e.preventDefault();
            var color = $(this).attr('href');
            $(".mainColors a").removeClass('active');
            $(this).addClass('active');
            var cssUrl = themePath + '/css/lay_colors/' + color + '.css';
            console.log(cssUrl);
            $("#colorChem").attr('href', cssUrl);
        });
    }


    //========================
    // Back To Top
    //========================
    if ($('#backToTop').length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#backToTop').addClass('showit');
                } else {
                    $('#backToTop').removeClass('showit');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('#backToTop').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }

    //========================
    // Loader 
    //========================
    $(window).on('load',function () {
        //Scroll to banner onLoad
        /*
        if ($('#siteHeader').length > 0) {
            $(document).scrollTop($('#siteHeader').offset().top);
        }
        */
        if ($('.preloader').length > 0) {
            $('.preloader').delay(400).fadeOut('fast');
        }
    });



    //=======================================================
    // magnificPopup
    //=======================================================
    if ($('a.popUp').length > 0) {
        $("a.popUp").magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    }

    //=======================================================
    // Testmonial
    //=======================================================
    $(".clientCaro").owlCarousel({
        nav: false,
        dots: false,
//===============
        loop: true,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
//===============
        responsiveClass: true,
        responsive: {
            0: {
                items: 2
            },
            767: {
                items: 4
            },
            1200: {
                items: 6
            }
        }
    });


    //========================
    // Wow Js
    //========================
    //Alexys new WOW().init();
})(jQuery);
