jQuery(document).ready(function () {
    jQuery('.fnum').persiaNumber('fa');
    jQuery('#anarContainer').fullpage({
        anchors: ['leather', 'main', 'style'],
        menu: '#menu',
        slidesNavigation: false,
        controlArrows: false,
        scrollingSpeed: 500,
        fitToSection:false,
        // afterLoad: function(origin, destination, direction){
        //     if(origin.anchor === "leather" || destination.anchor === "leather"){
        //         UIkit.scrollspy('div.sectionWrapper.leather > div', {target: "> div", cls: "uk-animation-fade", repeat: false, delay: 300});
        //     }
        //     if(origin.anchor === "style" || destination.anchor === "style"){
        //         UIkit.scrollspy('div.sectionWrapper.decor .animateShow', {target: ".animateShow", cls: "uk-animation-fade", repeat: false, delay: 300});
        //     }
        // }
    });
    // fullpage_api.setAllowScrolling(false);

    UIkit.util.on('#socialsDrop', 'hidden', function () {
        UIkit.scrollspy('#socialIcons', {target: "> div"});
    });
    UIkit.util.on('#utilitiesDrop', 'hidden', function () {
        UIkit.scrollspy('#utilityIcons', {target: "> div"});
    });


    // Navigation
    jQuery('ul.mainMenuWrapper > li  a + ul > li > a').on('click', function () {
        jQuery('ul.mainMenuWrapper > li').removeClass('expanded').addClass('collapsed');
        jQuery(this).parents('.level-1').addClass('expanded').removeClass('collapsed');
    });
    UIkit.util.on('#mainMenu', 'shown', function () {
        // UIkit.scrollspy('.mainMenuWrapper', {target: "> div"});
    });
    UIkit.util.on('#mainMenu', 'shown', function () {
        // UIkit.modal('.mainMenuWrapper').toggle();
    });
});

function shapeon(property) {
    jQuery('svg.homeMain').addClass(property);
}
function shapeoff() {
    jQuery('svg.homeMain').attr('class', ' homeMain uk-svg uk-height-1-1');
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