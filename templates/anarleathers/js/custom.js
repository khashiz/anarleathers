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
    fullpage_api.setAllowScrolling(false);

    UIkit.util.on('#socialsDrop', 'hidden', function () {
        UIkit.scrollspy('#socialIcons', {target: "> div"});
    });

});