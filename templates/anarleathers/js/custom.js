function appearChildren(wrapperID) {
    let elems = jQuery('#'+wrapperID).children();
    jQuery(elems).each(function(index) {
        jQuery(this).delay(100*index).fadeIn(500);
    });
}
function disappearChildren(wrapperID) {
    let elems = jQuery('#'+wrapperID).children();
    elems = elems.get().reverse();
    jQuery(elems).each(function(index) {
        jQuery(this).delay(100*index).fadeOut(500);
    });
}


jQuery(document).ready(function () {

    // Converting latin numbers to persian
    jQuery('.fnum').persiaNumber('fa');
    jQuery('#anarContainer').fullpage({
        anchors: ['leather', 'main', 'style'],
        menu: '#menu',
        slidesNavigation: false,
        controlArrows: false,
        scrollingSpeed: 500,
        fitToSection:false,
        // responsiveWidth: 939
    });

    // Social networks toggle
    UIkit.util.on('#socialsDrop', 'hidden', function () {
        UIkit.scrollspy('#socialIcons', {target: "> div"});
    });

    // Utility icons
    UIkit.util.on('#utilityIcons', 'hidden', function () {
        UIkit.scrollspy('#utilityIcons', {target: "> div"});
    });


    // Navigation
    jQuery('ul.mainMenuWrapper > li  a + ul > li > a.toggler').on('hover', function () {
        jQuery('ul.mainMenuWrapper > li').removeClass('expanded').addClass('collapsed');
        jQuery(this).parents('.level-1').addClass('expanded').removeClass('collapsed');
    });
    UIkit.util.on('#mainMenu', 'shown', function () {});
    UIkit.util.on('#mainMenu', 'hidden', function () {
        disappearChildren('utilityIconsWrapper');
        jQuery('#eye').attr('data-status','off');
    });
    jQuery('#mainMenuToggler').click(function(){
        jQuery('#mainMenuToggler > div').toggleClass('open');
    });
    jQuery('#mainMenuTogglerMobile').click(function(){
        jQuery('#mainMenuToggler > div').toggleClass('open');
    });


    let mobLevel1 = jQuery('ul.nav-links > li > a');
    let mobLevel2 = jQuery('ul.nav-links > li > a + ul > li > a');
    mobLevel1.click(function(e) {
        if (!jQuery(this).hasClass('direct')) {e.preventDefault();}
        if (jQuery(this).hasClass('open')) {
            jQuery(this).removeClass('open');
        } else {
            mobLevel1.removeClass('open');
            jQuery(this).toggleClass('open');
        }
    });
    mobLevel2.click(function(e) {
        if (!jQuery(this).hasClass('direct')) {e.preventDefault();}
        if (jQuery(this).hasClass('open')) {
            jQuery(this).removeClass('open');
        } else {
            mobLevel2.removeClass('open');
            jQuery(this).toggleClass('open');
        }
    });
});

function eyeAction() {
    let eye = jQuery('#eye');
    if (eye.attr('data-status') == 'off') {
        appearChildren('utilityIconsWrapper');
        eye.attr('data-status','on');
    } else {
        disappearChildren('utilityIconsWrapper');
        eye.attr('data-status','off');
    }
}

// Home side backgrounds toggle
function shapeon(property, side) {
    jQuery('svg.homeMain').addClass(property);
    jQuery('.'+side).fadeIn();
    jQuery('.hoverPrimary').css('color', '#fff');
}
function shapeoff(side) {
    jQuery('svg.homeMain').attr('class', ' homeMain uk-svg uk-height-1-1');
    jQuery('.'+side).fadeOut();
    jQuery('.hoverPrimary').css('color', '');
}

// Fullscreen Button
let elem = document.documentElement;
function openFullscreen() {
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) { /* Safari */
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) { /* IE11 */
        elem.msRequestFullscreen();
    }
}
function closeFullscreen() {
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.webkitExitFullscreen) { /* Safari */
        document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) { /* IE11 */
        document.msExitFullscreen();
    }
}

let svg = document.getElementsByName("leatherTriangle");
let gs = document.querySelectorAll("rect");
gs.forEach(g => {
    g.addEventListener("mouseenter", e => {
        svg.appendChild(g);
    });
});