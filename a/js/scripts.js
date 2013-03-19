/*
|--------------------------------------------------------------------------
| TODO - STICKY MENUS
|--------------------------------------------------------------------------
|
| http://www.jay-han.com/2011/11/10/simple-smart-sticky-navigation-bar-with-jquery/
| http://webdesign.tutsplus.com/tutorials/javascript-tutorials/create-a-sticky-navigation-header-using-jquery-waypoints/
| http://codecanyon.net/item/jquery-css3-sticky-mega-menu-bar/239093
|
|--------------------------------------------------------------------------
| TODO - TOUCH EVENTS - https://github.com/eightmedia/hammer.js
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| CONSOLE ERRORS CURE
|--------------------------------------------------------------------------
|
| Avoid 'console' errors in browsers that lack a console.
|
*/

(function() {
    var noop = function noop() {},
        methods = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error', 'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log', 'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd', 'timeStamp', 'trace', 'warn'],
        length = methods.length,
        console = window.console || {};

    while(length--) {
        // Only stub undefined methods.
        console[methods[length]] = console[methods[length]] || noop;
    }
}());

/*
|--------------------------------------------------------------------------
| CAROUSEL and TABS
|--------------------------------------------------------------------------
|
| By Maarten Baijs - http://baijs.nl/tinycarousel/
|
|--------------------------------------------------------------------------
| Variables: original and my custom
|
| h = a('.tbn-viewport:first', q),
| g = a('.tbn-viewport ul:first', q),
| f = a('.tbn-next:first', q),
| d = a('.tbn-prev:first', q),
| l = a('.tab-pager:first', q),
|
| i = this, k = g.children(), w = 0, u = 0, p = 0, j = undefined, o = false, n = true, s = e.axis === 'x';
|
*/
(function(a){a.tiny=a.tiny||{};a.tiny.carousel={options:{start:1,display:1,axis:'x',controls:true,pager:false,interval:false,intervaltime:3000,rewind:false,animation:true,duration:1000,callback:null}};a.fn.tinycarousel_start=function(){a(this).data('tcl').start()};a.fn.tinycarousel_stop=function(){a(this).data('tcl').stop()};a.fn.tinycarousel_move=function(c){a(this).data('tcl').move(c-1,true)};function b(q,e){var i=this,h=a('.tbn-viewport:first',q),g=a('.tbn-viewport ul:first',q),k=g.children(),f=a('.tbn-next:first',q),d=a('.tbn-prev:first',q),l=a('.tab-pager:first',q),w=0,u=0,p=0,j=undefined,o=false,n=true,s=e.axis==='x';function m(){if(e.controls){d.toggleClass('disable',p<=0);f.toggleClass('disable',!(p+1<u))}if(e.pager){var x=a('.tbn-page-num',l);x.removeClass('active');a(x[p]).addClass('active')}}function v(x){if(a(this).hasClass('tbn-page-num')){i.move(parseInt(this.rel,10),true)}return false}function t(){if(e.interval&&!o){clearTimeout(j);j=setTimeout(function(){p=p+1===u?-1:p;n=p+1===u?false:p===0?true:n;i.move(n?1:-1)},e.intervaltime)}}function r(){if(e.controls&&d.length>0&&f.length>0){d.click(function(){i.move(-1);return false});f.click(function(){i.move(1);return false})}if(e.interval){q.hover(i.stop,i.start)}if(e.pager&&l.length>0){a('a',l).click(v)}}this.stop=function(){clearTimeout(j);o=true};this.start=function(){o=false;t()};this.move=function(y,z){p=z?y:p+=y;if(p>-1&&p<u){var x={};x[s?'left':'top']=-(p*(w*e.display));g.animate(x,{queue:false,duration:e.animation?e.duration:0,complete:function(){if(typeof e.callback==='function'){e.callback.call(this,k[p],p)}}});m();t()}};function c(){w=s?a(k[0]).outerWidth(true):a(k[0]).outerHeight(true);var x=Math.ceil(((s?h.outerWidth():h.outerHeight())/(w*e.display))-1);u=Math.max(1,Math.ceil(k.length/e.display)-x);p=Math.min(u,Math.max(1,e.start))-2;g.css(s?'width':'height',(w*k.length));i.move(1);r();return i}return c()}a.fn.tinycarousel=function(d){var c=a.extend({},a.tiny.carousel.options,d);this.each(function(){a(this).data('tcl',new b(a(this),c))});return this}}(jQuery));


/*
|--------------------------------------------------------------------------
| FLASH
|--------------------------------------------------------------------------
|
| http://jquery.thewikies.com/swfobject/
|
*/
(function(F,C){var D=function(H){var G,I=[];for(G in H){if(/string|number/.test(typeof H[G])&&H[G]!==""){I.push(G+'="'+H[G]+'"')}}return I[A]("")},E=function(I){var G,K,J=[],H;if(typeof I=="object"){for(G in I){if(typeof I[G]=="object"){H=[];for(K in I[G]){H.push([K,"=",encodeURIComponent(I[G][K])][A](""))}I[G]=H[A]("&amp;")}if(I[G]){J.push(['<param name="',G,'" value="',I[G],'" />'][A](""))}}I=J[A]("")}return I},B=false,A="join";F[C]=(function(){try{var G="0,0,0",H=navigator.plugins["Shockwave Flash"]||ActiveXObject;G=H.description||(function(){try{return(new H("ShockwaveFlash.ShockwaveFlash")).GetVariable("$version")}catch(J){}}())}catch(I){}G=G.match(/^[A-Za-z\s]*?(\d+)[\.|,](\d+)(?:\s+[d|r]|,)(\d+)/);return{available:G[1]>0,activeX:H&&!H.name,version:{major:G[1]*1,minor:G[2]*1,release:G[3]*1},hasVersion:function(K){var N=this.version,L="major",M="minor",J="release";K=(/string|number/.test(typeof K))?K.toString().split("."):K||[0,0,0];K=[K[L]||K[0]||N[L],K[M]||K[1]||N[M],K[J]||K[2]||N[J]];return(K[0]<N[L])||(K[0]==N[L]&&K[1]<N[M])||(K[0]==N[L]&&K[1]==N[M]&&K[2]<=N[J])},expressInstall:"expressInstall.swf",create:function(J){if(!F[C].available||B||!typeof J=="object"||!J.swf){return false}if(J.hasVersion&&!F[C].hasVersion(J.hasVersion)){J={swf:J.expressInstall||F[C].expressInstall,attrs:{id:J.id||"SWFObjectExprInst",name:J.name,height:Math.max(J.height||137),width:Math.max(J.width||214)},params:{flashvars:{MMredirectURL:location.href,MMplayerType:(F[C].activeX)?"ActiveX":"PlugIn",MMdoctitle:document.title.slice(0,47)+" - Flash Player Installation"}}};B=true}else{J=F.extend(true,{attrs:{id:J.id,name:J.name,height:J.height||180,width:J.width||320},params:{wmode:J.wmode||"opaque",flashvars:J.flashvars}},J)}if(F[C].activeX){J.attrs.classid=J.attrs.classid||"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000";J.params.movie=J.params.movie||J.swf}else{J.attrs.type=J.attrs.classid||"application/x-shockwave-flash";J.attrs.data=J.attrs.data||J.swf}return["<object ",D(J.attrs),">",E(J.params),"</object>"][A]("")}}}());F.fn[C]=function(G){if(typeof G=="object"){this.each(function(){var I=document.createElement(C);var H=F[C].create(G);if(H){I.innerHTML=H;if(I.childNodes[0]){this.appendChild(I.childNodes[0])}}})}else{if(typeof G=="function"){this.find("object").andSelf().filter("object").each(function(){var I=this,H="jsInteractionTimeoutMs";I[H]=I[H]||0;if(I[H]<660){if(I.clientWidth||I.clientHeight){G.call(this)}else{setTimeout(function(){F(I)[C](G)},I[H]+66)}}})}}return this}}(jQuery,"flash"));

/*
|--------------------------------------------------------------------------
| DROPDOWNS
|--------------------------------------------------------------------------
*/
function dropDowns() {
    var label = $('.mm-label-4dd, .body-label-4dd, .hdr-label-4dd'),
        allDropDowns = $('.mm-dropdown, .body-dropdown, .hdr-dropdown');

    label.click(function(event) {
        allDropDowns.hide();
        $(this).parents('.mm-menu, .body-menu, .hdr-menu').children('.mm-dropdown, .body-dropdown, .hdr-dropdown').toggle();
        label.removeClass('down');
        $(this).addClass('down');
        return false;
    });

    $(document).click(function() {
        allDropDowns.hide();
        label.removeClass('down');
    });

    $(document).keydown(function(e) {
        if(e.keyCode == 27) {
            allDropDowns.hide();
            label.removeClass('down');
        }
    });

    // TODO: this did not work. Fix it
    if ($('.mm-label-4dd').hasClass('down')) {
        $('.sec-billboard a').click(function(e) {
                e.preventDefault();
            });
    }

    allDropDowns.click(function(event) {
        event.stopPropagation();
    });
}

/*
|--------------------------------------------------------------------------
| SLIDE-OUT MENU
|--------------------------------------------------------------------------
|
| Modified version of snippet by Aldo Lugo —
| https://github.com/aldomatic/FB-Style-Page-Slide-Menu
|
*/
function slideOut() {
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
}

/*
|--------------------------------------------------------------------------
| TOOLTIP
|--------------------------------------------------------------------------
|
| TODO - combine with Title utilizier(), refactoring
|
| Title utilizier
| function toolTip() {
|     if(window.matchMedia('(min-width: 769px)').matches) {
|         $('.dfn').hover(
|         function() {
|             var txtTitle = $(this).prop("title");
|             $(this).after('<p class="tooltip">' + txtTitle + '</p>');
|
|             $(this).siblings('.tooltip').show('fast'); //common
|             $(this).data('title', $(this).prop('title'));
|             $(this).removeAttr('title');
|         }, function() {
|             $('.tooltip').hide('fast').remove(); //non-commom
|             $(this).prop('title', $(this).data('title'));
|         });
|     }
| }
|
*/
function toolTip() {
    $('.dfn').hover(
    function () {
        $(this).siblings('.tooltip').show('fast');
    }, function () {
        $(this).siblings('.tooltip').hide('fast');
    });
}


/*
|--------------------------------------------------------------------------
| ROTATOR
|--------------------------------------------------------------------------
*/
(function($) {
    $.fn.extend({
        //plugin name - rotaterator
        rotaterator: function(settings) {

            var defaults = {
                fadeSpeed: 600,
                pauseSpeed: 100,
                child: null
            };

            var options = $.extend(defaults, settings);

            return this.each(function() {
                var o = options,
                    obj = $(this),
                    items = $(obj.children(), obj),
                    next;
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

/*
|--------------------------------------------------------------------------
| SCROLLING YURY DOLGOROKY in mobile version
|--------------------------------------------------------------------------
|
| TODO - check it, fix it.
|
*/
function mobileHeaderImg() {
    $(window).bind('scroll', function(){
        $('.sec-usp h2:after, .sec-usp h2 .after').toggle($(this).scrollTop() > 200);
    });
}

/*
|--------------------------------------------------------------------------
| GALLERY
|--------------------------------------------------------------------------
| TODO - Add loading animated placeholder
| http://stackoverflow.com/questions/1964839/jquery-please-wait-loading-animation
| http://www.queness.com/post/9150/9-javascript-and-animated-gif-loading-animation-solutions
| http://designmodo.com/css3-jquery-loading-animations/
|
*/
function gallery() {
    $('a[data-role="gallery-tbn"], a[data-role="gallerycontrol"], a[data-widget="gallery"], a[rel*="gallery"]').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        var href = $(this).attr('href'),
            figure = $(this).parents('figure.gallery, .sec-gallery'),
            figcaption = $(figure.children('p')),
            title;

        //Create figcaption text
        if ($(this).attr('title') && $(figcaption)[0]) {
            title = $(this).attr('title');
        } else {
            title = '';
        }

        $(figure.children('img')).remove();
        figcaption.empty();
        figure.prepend('<img src="' + href + '" alt="' + title + '">');
        figcaption.append(title);
    });
}

/*
|-------------------------------
| LEGACY: Gallery old
| Loading stripped HTML not
| the images
|-------------------------------
*/
function galeryOld() {
    $('a.loadinto-gallery').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        var href = $(this).attr('href');
        //Load HTML in gallery frame
        $('#gallery').load(href);
    });
}

/*
|--------------------------------------------------------------------------
| MODAL BOX
|--------------------------------------------------------------------------
|
| TODO - refactoring
|
*/
function modalBox() {
    $('a[data-role="modal-launcher"], a[rel*="extra"], a.loadinto-modal_box').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        var title;
        //Create modal box container and overlay
        if ($('.modal-box').length === 0) {
            $('body').append('<div class="modal-box section"></div><div class="overlay" style="filter: alpha(opacity=64)"></div>');
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
            $('.modal-box').append('<div class="single figure"><div class="figcaption">' + title + '<button class="btn-close">Закрыть</button></div><img src="' + href + '" alt="" /></div><div class="footer"></div>');
            $.getScript('/a/js/modal-box.js');
            $('.modal-box').fadeIn('300');
            $('.overlay').fadeIn('300');
        } else {
            //Load HTML in modal box
            $('.modal-box').load(href, function () {
                $.getScript('/a/js/modal-box.js');
            });
            $('.modal-box').fadeIn('300');
            $('.overlay').fadeIn('300');
        }
        $(document).keydown(function (e) {
            if (e.keyCode == 27) {
                $('.modal-box').fadeOut('fast').empty();
                // $('.modal-box').empty();
                $('.overlay').fadeOut('fast');
            }
        });
    });
}

/*
|--------------------------------------------------------------------------
| COLLAPSIBLES
|--------------------------------------------------------------------------
*/
function collapsibles() {
    //$('.first_opened div.first').show();
    $('.on_demand H3').click(function(event) {
        $(this).next('div').slideToggle();
        $(this).toggleClass('opened');
    });
}

/*
|--------------------------------------------------------------------------
| CALLING FUNCTIONS
|--------------------------------------------------------------------------
| After the DOM is loaded
|
*/
$(document).ready(function(){
    $('iframe[src^="http://player.vimeo.com"], iframe[src^="http://www.youtube.com"], iframe[src*="dailymotion.com"], object:not([class*="not-video"]):not(:has(embed)), embed:not([class*="not-video"])').wrap('<figure class="video" />');
    $('ol, ul').prev('p').css('margin-bottom', '0'); //lists captions
    dropDowns();
    toolTip();
    $('.rotator').rotaterator({fadeSpeed:1200, pauseSpeed:8000});
    slideOut();
    gallery();
    collapsibles();
    modalBox();
    $('.sec-gallery').tinycarousel();
    $('.tut01').flash({swf:'/a/video/01.swf',height:331,width:522});
    $('.bnr_msb div').flash({swf:'/a/img/banners/moscow-speakers-bureau-580.swf',height:100,width:580});
    galeryOld();
    // mobileHeaderImg();
});

/*
|-------------------------------
| On window resize
|-------------------------------
*/
$(window).resize(function(){
    $('.sec-gallery').tinycarousel();
});

/*
|--------------------------------------------------------------------------
| IE status bar error fix
|--------------------------------------------------------------------------
*/
function noError() {
    return true;
}
window.onerror = noError;
