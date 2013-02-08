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

// http://addyosmani.github.com/jquery-ui-bootstrap/

// STICKY MENUS
// http://www.jay-han.com/2011/11/10/simple-smart-sticky-navigation-bar-with-jquery/
// http://webdesign.tutsplus.com/tutorials/javascript-tutorials/create-a-sticky-navigation-header-using-jquery-waypoints/
// http://codecanyon.net/item/jquery-css3-sticky-mega-menu-bar/239093

// jQuery FlexSlider v1.8
// http://www.woothemes.com/flexslider/

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

// TOOLTIP
function toolTip() {
    if(window.matchMedia('(min-width: 769px)').matches) {
        $('.dfn').hover(

        function() {
            var txtTitle = $(this).prop("title");
            $(this).after('<p class="tooltip">' + txtTitle + '</p>');
            $(this).siblings('.tooltip').show('fast');
            $(this).data('title', $(this).prop('title'));
            $(this).removeAttr('title');
        }, function() {
            $('.tooltip').hide('fast').remove();
            $(this).prop('title', $(this).data('title'));
        });
    }
}

$(document).ready(function(){
    $('iframe[src^="http://player.vimeo.com"], iframe[src^="http://www.youtube.com"], iframe[src*="dailymotion.com"], object:not([class*="not-video"]):not(:has(embed)), embed:not([class*="not-video"])').wrap('<figure class="video" />');
    $('ol, ul').prev('p').css('margin-bottom', '0'); //lists captions
    dropDowns();
    toolTip();
    slideOut();

     $(".slideshow").slides({
        container: 'reel',
        slideSpeed: 440,
        pagination: false,
        effect: 'slide, fade',
        hoverPause: true
    });

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
