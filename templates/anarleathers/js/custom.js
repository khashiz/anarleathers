jQuery(document).ready(function () {
    jQuery('#anarContainer').fullpage({
        anchors: ['leather', 'main', 'style'],
        menu: '#menu',
        slidesNavigation: false,
        controlArrows: false,
        scrollingSpeed: 500,
        fitToSection:false,
        afterLoad: function(origin, destination, direction){
            if(destination.anchor == "leather"){
                // alert("this is lether section");
            }
        }
    });
    fullpage_api.setAllowScrolling(false);

    UIkit.util.on('#socialsDrop', 'hidden', function () {
        UIkit.scrollspy('#socialIcons', {target: "> div"});
    });

});