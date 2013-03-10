// CONSOLE ERRORS CURE - Avoid 'console' errors in browsers that lack a console.
(function() {
    var noop = function noop() {};
    var methods = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error', 'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log', 'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd', 'timeStamp', 'trace', 'warn'];
    var length = methods.length;
    var console = window.console || {};

    while(length--) {
        // Only stub undefined methods.
        console[methods[length]] = console[methods[length]] || noop;
    }
}());


// TODO - STICKY MENUS
// http://www.jay-han.com/2011/11/10/simple-smart-sticky-navigation-bar-with-jquery/
// http://webdesign.tutsplus.com/tutorials/javascript-tutorials/create-a-sticky-navigation-header-using-jquery-waypoints/
// http://codecanyon.net/item/jquery-css3-sticky-mega-menu-bar/239093

// DROPDOWNS
function dropDowns() {
    $(document).click(function(e) {
        if($(e.target).is('.mm-label, .body-label')) {
            return;
        }
        $('.mm-dropdown, .body-dropdown').hide();
        $('.mm-label, .body-label').removeClass('down');
    });
    $('html').click(function() {
        $('.mm-dropdown, .body-dropdown').hide();
        $('.mm-label, .body-label').removeClass('down');
    });
    $('.mm-dropdown, .body-dropdown').click(function(event) {
        event.stopPropagation();
    });
    $(document).keydown(function(e) {
        if(e.keyCode == 27) {
            $('.mm-dropdown, .body-dropdown').hide();
            $('.mm-label, .body-label').removeClass('down');
        }
    });
    $('.mm-label, .body-label').click(function(event) {
        $('.mm-dropdown, .body-dropdown').hide();
        $(this).parents('.mm-menu, .body-menu').children('.mm-dropdown, .body-dropdown').toggle();
        $('.mm-label, .body-label').removeClass('down');
        $(this).addClass('down');
        $('#billboard').append('<div class="overlay"></div>');
        return false;
    });
}

// TODO - add swipe event with hammer.js
// SLIDE-OUT MENU. Modified version of snippet by Aldo Lugo — https://github.com/aldomatic/FB-Style-Page-Slide-Menu
$(function slideOut() {
    var menuStatus;
    $('.btn-menu').click(function() {
        if(menuStatus !== true) {
            $('.page, .doc-header').animate({
                marginLeft: '240px'
            }, 300, function() {
                menuStatus = true;
            });

            if($('#slide-out').css('visibility') != 'visible') {
                $('#slide-out').css('visibility', 'visible');
            }
            return false;
        } else {
            $('.page, .doc-header').animate({
                marginLeft: '0'
            }, 300, function() {
                menuStatus = false;
            });
            return false;
        }
    });

    $('#slide-out li a').click(function() {
        var p = $(this).parent();
        if($(p).hasClass('current')) {
            $('#slide-out li').removeClass('current');
        } else {
            $('#slide-out li').removeClass('current');
            $(p).addClass('current');
        }
    });
});

// TODO - combine with Title utilizier(), refactoring
// TOOLTIP
function toolTip() {
    $('.dfn').hover(
    function () {
        $(this).siblings('.tooltip').show('fast');
    }, function () {
        $(this).siblings('.tooltip').hide('fast');
    });
}

// Title utilizier
// function toolTip() {
//     if(window.matchMedia('(min-width: 769px)').matches) {
//         $('.dfn').hover(
//         function() {
//             var txtTitle = $(this).prop("title");
//             $(this).after('<p class="tooltip">' + txtTitle + '</p>');

//             $(this).siblings('.tooltip').show('fast'); //common
//             $(this).data('title', $(this).prop('title'));
//             $(this).removeAttr('title');
//         }, function() {
//             $('.tooltip').hide('fast').remove(); //non-commom
//             $(this).prop('title', $(this).data('title'));
//         });
//     }
// }


// Rotator
(function($) {
    $.fn.extend({
        //plugin name - rotaterator
        rotaterator: function(options) {

            var defaults = {
                fadeSpeed: 600,
                pauseSpeed: 100,
                child: null
            };

            var options = $.extend(defaults, options);

            return this.each(function() {
                var o = options;
                var obj = $(this);
                var items = $(obj.children(), obj);
                var next;
                items.each(function() {
                    $(this).hide();
                });
                if(!o.child) {
                    next = $(obj).children(':first');
                } else {
                    next = o.child;
                }
                $(next).fadeIn(o.fadeSpeed, function() {
                    $(next).delay(o.pauseSpeed).fadeOut(o.fadeSpeed, function() {
                        var next = $(this).next();
                        if(next.length === 0) {
                            next = $(obj).children(':first');
                        }
                        $(obj).rotaterator({
                            child: next,
                            fadeSpeed: o.fadeSpeed,
                            pauseSpeed: o.pauseSpeed
                        });
                    });
                });
            });
        }
    });
})(jQuery);

// TODO - it doesn't work, fix it
function mobileHeaderImg() {
    $(window).bind('scroll', function(){
        $('.sec-usp h2:after, .sec-usp h2 .after').toggle($(this).scrollTop() > 200);
    });
}

// TODO - combine with galeryOld(), refactoring
function gallery() {
    $('a[data-role="gallerycontrol"], a[data-widget="gallery"], a[rel*="gallery"]').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        var href = $(this).attr('href');
        var title;
        //Create figcaption text
        if ($(this).attr('title') && $('figure.gallery p')[0]) {
            title = $(this).attr('title');
        } else {
            title = '';
        }
        var figure = $('figure.gallery');
        var img = $('figure.gallery img');
        var figcaption = $('figure.gallery p');
        img.remove();
        figcaption.empty();
        figure.append('<img src="' + href + '" alt="' + title + '" />');
        figcaption.append(title);
    });
}

function galeryOld() {
    $('a.loadinto-gallery').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        var href = $(this).attr('href');
        //Load HTML in gallery frame
        $('#gallery').load(href);
    });
}

// TODO - combine with modalBoxOld(), refactoring
function modalBox() {
    $('a[data-role="modal-launcher"], a[rel*="extra"]').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        var title;
        //Create modal box container and overlay
        if ($('#modal_box').length === 0) {
            $('body').append('<div id="modal_box" class="section"></div><div id="overlay" style="filter: alpha(opacity=64)"></div>');
        }
        var href = $(this).attr('href');
        //Create figcaption text
        if ($(this).attr('title')) {
            title = $(this).attr('title');
        } else {
            title = ':-)';
        }
        //Check href to separate html and pics
        if ($(this).is('a[href$=.png], a[href$=.jpg], a[href$=.gif], a[href$=.gif]')) {
            //Create figure, figcaption and open image in modal box
            $('#modal_box').append('<div class="single figure"><div class="figcaption">' + title + '<button class="close">Закрыть</button></div><img src="' + href + '" alt="" /></div><div class="footer"></div>');
            $.getScript('/a/js/modal-box.js');
            $('#modal_box').fadeIn('300');
            $('#overlay').fadeIn('300');
        } else {
            //Load HTML in modal box
            $('#modal_box').load(href, function () {
                $.getScript('/a/js/modal-box.js');
            });
            $('#modal_box').fadeIn('300');
            $('#overlay').fadeIn('300');
        }
        $(document).keydown(function (e) {
            if (e.keyCode == 27) {
                $('#modal_box').fadeOut('fast');
                $('#overlay').fadeOut('fast');
                $('#modal_box').empty();
            }
        });
    });
}

function modalBoxOld() {
    $('a.loadinto-modal_box').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        //Create modal box container and overlay
        if ($('#modal_box').length === 0) {
            $('body').append('<div id="modal_box" class="section"></div><div id="overlay" style="filter: alpha(opacity=64)"></div>');
        }
        var href = $(this).attr('href');
        $('#modal_box').load(href, function () {
            $.getScript('/a/js/modal-box.js');
        });
        $('#modal_box').fadeIn('300');
        $('#overlay').fadeIn('300');
        //Close modal box on escape key press
        $(document).keydown(function (e) {
            if (e.keyCode == 27) {
                $('#modal_box').fadeOut('fast');
                $('#overlay').fadeOut('fast');
                $('#modal_box').empty();
            }
        });
    });
}

function collapsibles() {
    //$('.first_opened div.first').show();
    $('.on_demand H3').click(function(event) {
        $(this).next('div').slideToggle();
        $(this).toggleClass('opened');
    });
}

$(document).ready(function(){
    $('iframe[src^="http://player.vimeo.com"], iframe[src^="http://www.youtube.com"], iframe[src*="dailymotion.com"], object:not([class*="not-video"]):not(:has(embed)), embed:not([class*="not-video"])').wrap('<figure class="video" />');
    $('ol, ul').prev('p').css('margin-bottom', '0'); //lists captions
    dropDowns();
    toolTip();
    $('.rotator').rotaterator({fadeSpeed:1200, pauseSpeed:8000});
    slideOut();
    // mobileHeaderImg();

    collapsibles();
    modalBox();
    gallery();
    modalBoxOld();
    galeryOld();
});

function noError() {
    return true;
}
window.onerror = noError;

// TOUCH EVENTS - https://github.com/eightmedia/hammer.js

// JS 'MEDIA QUERIES'
// 01-a) if(window.matchMedia('(min-width: 769px)').matches)
// 01-b) var mq = window.matchMedia('(min-width: 769px)');
//       if(mq.matches)
// 02) if(document.documentElement.clientWidth < 768)
// 03) http://wickynilliams.github.com/enquire.js/

// A RESPONSIVE IMAGES approach including Retina image replacement — Picturefill - https://github.com/scottjehl/picturefill.
