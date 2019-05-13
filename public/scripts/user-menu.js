$(document).ready(function() {

    var avatar = $('.avatar');
    var userMenu = $('.user-menu');
    var exitButton = $('.user-menu .exit-btn')

    $(document).mousedown(function(event) {
        
        var target = $(event.target);
        if(!target.is(exitButton)) {
            userMenu.hide();
            if(target.is(avatar) && event.which == 1) {
                setUserMenuPosition();
                userMenu.show('fast'); 
            }
        }
    });

    $(window).resize(function() {
        setUserMenuPosition();
    });

    function setUserMenuPosition() {
        userMenu.css({
            left: avatar.offset().left - 15,
        });
    }
});