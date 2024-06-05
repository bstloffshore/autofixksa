/*
Copyright (c) 2017
[Master Stylesheet]
Template Name : Handyman-Multipurpose Landing Page-UiSumo
Version    : 1.0
Author     : UISuMo Team
Author URI : https://uisumo.com
Support    : uisumo@gmail.com
*/


/*jslint browser: true*/
/*global $, jQuery, alert*/

$(document).ready(function () {


    "use strict";

    /* Page Pre Loading */
    $(window).load(function () { // makes sure the whole site is loaded
        $('#status').fadeOut(); // will first fade out the loading animation
        $('#preloader').delay(250).fadeOut('slow'); // will fade out the white DIV that covers the website.
    });
    /* end Page Pre Loading */

    //Initiat WOW JS
    new WOW().init();

    //Smooth Scroll
    $(function () {
        $('a[href*="#"]:not([href="#"])').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });


    /*Scroll To Top*/

    if (true) {
        if ($('.back-to-top').length) {
            var scrollTrigger = 1000, // px
                backToTop = function () {
                    var scrollTop = $(window).scrollTop();
                    if (scrollTop > scrollTrigger) {
                        $('.back-to-top').addClass('show');
                    } else {
                        $('.back-to-top').removeClass('show');
                    }
                };
            backToTop();
            $(window).on('scroll', function () {
                backToTop();
            });
            $('.back-to-top').on('click', function (e) {
                e.preventDefault();
                $('html,body').animate({
                    scrollTop: 0
                }, 700);
            });
        }
    }

    //Testimonial Slider
    if ($('.cs-testimonial-slider').length) {
        $(".cs-testimonial-slider").owlCarousel({
            items: 2,
            autoplay: false,
            loop: true,
            margin: 42,
            nav: true,
            navText: [
				"<i class='cs-slider-arrows fa fa-angle-left'></i>",
				"<i class='cs-slider-arrows fa fa-angle-right'></i>"
			],
            dots: false,
            responsive: {
                0: {
                    items: 1,
                    dots: true,
                    nav: false
                },
                600: {
                    items: 1,
                    dots: true
                },
                992: {
                    items: 2
                },
                1000: {
                    items: 2
                }
            }
        });
    }


    /* Magnific Gallgery*/
    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
            verticalFit: true,
            titleSrc: function (item) {
                return item.el.attr('title') + ' &middot; <a class="image-source-link" href="' + item.el.attr('data-source') + '" target="_blank">image source</a>';
            }
        },
        gallery: {
            enabled: true
        },
        zoom: {
            enabled: true,
            duration: 300, // don't foget to change the duration also in CSS
            opener: function (element) {
                return element.find('img');
            }
        }

    });


});
