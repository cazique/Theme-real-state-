(function($){
    
    // Dashboard Sidebar
    // Dropdown menu
    $(".sidebar-dropdown > a").on("click", function(){
        $(".sidebar-submenu").slideUp(200);
        if ($(this).parent().hasClass("active")) {
            $(".sidebar-dropdown").removeClass("active");
            $(this).parent().removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this).next(".sidebar-submenu").slideDown(200);
            $(this).parent().addClass("active");
        }

    });

    // close sidebar 
    $("#close-sidebar").on("click", function(e){
        $(".page-wrapper").removeClass("toggled");
        e.preventDefault();
    });

    //show sidebar
    $("#show-sidebar").on("click", function(e){
        $(".page-wrapper").addClass("toggled");
        e.preventDefault();
    });
    
    // Hide Active Sidebar In Mobile
    var slbrowserWidth = window.innerWidth;
    var slbreakpoint = 768;

    if(slbrowserWidth <= slbreakpoint) {
        // mobile/tablet view
        $(".page-wrapper").removeClass("toggled");
        // e.preventDefault();

    } else {
        // Deskyop view
        $(".page-wrapper").addClass("toggled");
        // e.preventDefault();
    }
    
})(jQuery);