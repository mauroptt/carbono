(function ($, Drupal) {
    /*global jQuery:false */
    /*global Drupal:false */
    "use strict";

    Drupal.behaviors.carbonoLoader = {
        attach: function (context) {
            $(window).on('load', function() {
                // Animate loader off screen
                $('#loader').removeClass('enabled');

                $('#navbar').animate({
                    opacity: 1,
                }, 200, "linear", function() {
                    $('#navbar').removeClass('navbar-disabled');
                });


            });
        }
    };

    /**
     * Provide Bootstrap navbar preview.
     */
    Drupal.behaviors.carbonoNav = {
        attach: function (context) {


            AOS.init({
                offset: 0,
                duration: 600,
                easing: 'ease-in-sine',
                delay: 0,
            });
            //AOS.refresh();


            // Menu display
            var $scroll = $(window).scrollTop();
            var $nav_bar = $('#navbar');

            $('.navbar .nav-icon').once('carbono').on('click', function(e){
               if ($nav_bar.hasClass('expanded')) {
                   $nav_bar.removeClass('expanded');
                   if ($scroll > 10) {
                       console.log('add scrolled class')
                       $nav_bar.addClass('scrolled');
                   }
               } else {
                   $nav_bar.addClass('expanded');
                   if ($scroll > 10) {
                       console.log('remove scrolled class')
                       $nav_bar.removeClass('scrolled');
                   }
               }
               e.preventDefault();
            });

            // Retina logo
            if (window.matchMedia("(-webkit-device-pixel-ratio: 2)").matches) {
                var $retina_path = $('.site-logo img').attr('src');
                $('.site-logo img').once('carbono').attr('src', $retina_path.replace('.png', '@2x.png'))
            }

            $('header .nav-icon').once('carbono').click(function(e){
                if ($nav_bar.hasClass('expanded')) {
                    $nav_bar.removeClass('expanded');
                    if ($scroll > 10) {
                        $nav_bar.addClass('scrolled');
                    }
                } else {
                    $nav_bar.addClass('expanded');
                    if ($scroll > 10) {
                        $nav_bar.removeClass('scrolled');
                    }
                }
                $(this).toggleClass('open');
                e.preventDefault();
            });

            // Scroll support
            $(window).scroll(function (event) {
                $scroll = $(window).scrollTop();
                // Do something
                if ($scroll > 10 && !$('#navbar').hasClass('expanded')) {
                    $('#navbar').addClass('scrolled');
                } else {
                    $('#navbar').removeClass('scrolled');
                }

                if ($scroll > 150) {
                    if (!$('#scroll-indicator').hasClass('hidden')) {
                        $('#scroll-indicator').addClass('hidden');
                    }
                }
            });

            $('#block-carbono-main-menu li a').once('carbono').click( function(){
                $('header .nav-icon').trigger('click');
                $('#block-carbono-main-menu li').removeClass('active');
                $(this).parent().addClass('active');
            });

            $('#scroll-indicator').once('carbono').click( function(){
                var $scrollTo = $('div[role="heading"]').height();
                var $body = $("html, body");
                $body.once('carbono').stop().animate({scrollTop:$scrollTo}, '1500', 'linear', function() {
                });
            });
        }
    };

    /*
    Drupal.behaviors.barbaJS = {
        attach: function (context) {


            // Preventing Barba from being loaded when clicking the admin toolbar
            $('#toolbar-administration a, div[role="local-tasks"] a, div.contextual a').once('carbono').each( function(){
                //$(this).attr('target', '_blank');
                $(this).attr('href', $(this).attr('href')+'#e');
            });

            // Please note, the DOM should be ready
            Barba.Pjax.start();
            Barba.Dispatcher.on('linkClicked', function(HTMLElement, MouseEvent) {
                $('#loader').addClass('enabled');
                Drupal.detachBehaviors(context);
            });
            Barba.Dispatcher.on('transitionCompleted', function(currentStatus, prevStatus) {

                $('#loader').removeClass('enabled');

                //Drupal.behaviors.barbaJS.attachLibs(context, drupalSettings);
                context = context || document;
                var settings = settings || drupalSettings;
                var behaviors = Drupal.behaviors;
                delete behaviors.barbaJS;

                // Execute all of them.
                for (var i in behaviors) {
                    if (behaviors.hasOwnProperty(i) && typeof behaviors[i].attach === 'function') {
                        // Don't stop the execution of behaviors in case of an error.
                        try {
                            console.log(i);
                            behaviors[i].attach(context, settings);
                        }
                        catch (e) {
                            Drupal.throwError(e);
                        }
                    }
                }

                // Patch for isotope, load script at last
              var script = document.createElement('script');
              script.type = 'text/javascript';
              script.src = 'https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.js';
              document.head.appendChild(script);
            });
        },
    }; */

    /**
     * Provide multi-section region.
     */
    Drupal.behaviors.facebookSlick = {
        attach: function (context) {
            //alert('here');
            //$('#panels-ipe-content .row .col-md-6 div').each(function(){
            $('#slick-views-slide-facebook-block-1-1-slider .slick__slide').once('carbono').each(function(){
                var link = $(this).find('.slide__caption').html();
                var formattedLink = '';
                if (this.nodeType === Node.COMMENT_NODE) {
                    link.remove();
                } else {
                    formattedLink = $.trim(link);
                }
                formattedLink = formattedLink;
                $(this).find('.slide__media img').wrap('<a data-toggle="modal" data-target="#fb_image" data-image="'+formattedLink+'"></a>');
            });

            $('#slick-views-slide-facebook-block-1-1-slider .slick__slide').find('.slide__media a').once('facebookSlick').click(function(){
                $('#fb_image .row-image').html('<img src="'+$(this).attr('data-image')+'">');
            });
        }
    };

    Drupal.behaviors.empresasSlick = {
        attach: function (context) {
            //alert('here');
            //$('#panels-ipe-content .row .col-md-6 div').each(function(){
            $('#slick-views-slide-empresas-block-1-1-slider .slick__slide').once('carbono').each(function(){
                var link = $(this).find('.slide__caption').html();
                var formattedLink = '';
                if(this.nodeType === Node.COMMENT_NODE) {
                    link.remove();
                } else {
                    formattedLink = $.trim(link);
                }
                formattedLink = formattedLink;
                $(this).find('.slide__media img').wrap('<a data-toggle="modal" data-target="#fb_image" data-image="'+formattedLink+'"></a>');
            });

            $('#slick-views-slide-empresas-block-1-1-slider .slick__slide').find('.slide__media a').once('empresasSlick').click(function(){
                $('#fb_image .row-image').html('<img src="'+$(this).attr('data-image')+'">');
            });
        }
    };

    /**
     * Provide multi-section region.
     */
    Drupal.behaviors.gridAdjustment = {
        attach: function (context) {
            //alert('here');
            //$('#panels-ipe-content .row .col-md-6 div').each(function(){
            $('.block-region-second-below').once('carbono').each(function(){
                console.log($(this).attr('data-block-id'));
                if ($(this).children().length > 3) {
                    $(this).children().each(function(){
                        if ($(this).is("section")) {
                            $(this).addClass('col-md-4');
                        }
                    });
                }
            });
        }
    };

    /**
     * Provide Bootstrap navbar preview.
     */
    Drupal.behaviors.contactSubmission = {
        attach: function (context) {
            $(document).ajaxComplete(function( event, xhr, settings ) {
                var response = settings.data;
                if (typeof response !== "undefined")
                    if (response.includes("contact_message_feedback_form")) {
                        $(document).find('#contact-message-feedback-form').html('Tu mensaje fue enviado exitosamente.');
                    }
            });
        }
    };

  Drupal.behaviors.apliques = {
    attach: function (context) {

      $('.link_detail').on('click', function(e) {
        var src = $(this).attr('data-src');
        var width = $(this).attr('data-width') || 640;
        var height = $(this).attr('data-height') || 320;

        // Iframe properties
        $("#product_detail iframe").attr({
          'src': src,
          'height': 480,
          'width': '100%',
          'allowfullscreen':'',
          'id': 'cat-popup'
        });
      });


    }
  };

    /**
     * Provide modal for product detail.
     */
    Drupal.behaviors.productDetails = {
        attach: function (context) {
            $('.product_detail_button').on('click', function(e) {
                var src = $(this).attr('data-src');
                var width = $(this).attr('data-width') || 640;
                var height = $(this).attr('data-height') || 320;

                // stampiamo i nostri dati nell'iframe
                $("#product_detail iframe").attr({
                    'src': src,
                    'height': height,
                    'width': '100%',
                    'allowfullscreen':'',
                    'id': 'product-popup'
                });
            });

            $('#product_detail').on('hidden.bs.modal', function(){
                $(this).find('iframe').html("");
                $(this).find('iframe').attr("src", "");
            });

            // Slider for product details
            if (typeof $().slick == 'function') {
                $('.slider-for').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    asNavFor: '.slider-nav'
                });
                $('.slider-nav').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: '.slider-for',
                    dots: true,
                    centerMode: true,
                    focusOnSelect: true
                });
            }
        }
    };

})(jQuery, Drupal);