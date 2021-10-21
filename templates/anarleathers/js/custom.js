jQuery(document).ready(function () {
    jQuery('#anarContainer').fullpage({
        anchors: ['leather', 'main', 'style'],
        menu: '#menu',
        slidesNavigation: false,
        controlArrows: false,
        scrollingSpeed: 500,
        fitToSection:false,
        afterLoad: function(origin, destination, direction){
            if(origin.anchor === "leather" || destination.anchor === "leather"){
                UIkit.scrollspy('div.sectionWrapper.leather > div', {target: "> div", cls: "uk-animation-fade", repeat: false, delay: 300});
            }
        }
    });
    // fullpage_api.setAllowScrolling(false);

    UIkit.util.on('#socialsDrop', 'hidden', function () {
        UIkit.scrollspy('#socialIcons', {target: "> div"});
    });
    UIkit.util.on('#utilitiesDrop', 'hidden', function () {
        UIkit.scrollspy('#utilityIcons', {target: "> div"});
    });
});

function shapeon(property) {
    jQuery('svg.homeMain').addClass(property);
}
function shapeoff() {
    jQuery('svg.homeMain').attr('class', ' homeMain uk-svg uk-height-1-1');
}