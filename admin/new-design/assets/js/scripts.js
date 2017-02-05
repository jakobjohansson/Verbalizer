$(document).ready(function() {
    $(".content").load("lib/overview.html");

    $(".loader li").click(function() {
        $(".content").load("lib/" + $(this).data("page") + ".html");
        $(".loader li").removeClass("active");
        $(this).addClass("active");
    });

    $(document).on("click", ".clicker", function() {
        $(this).parent().children(".reveal").slideToggle();
        $(this).children("h4").children("i").toggleClass("fa-arrow-down fa-arrow-right");
    });

    $(document).on("submit", "form", function(e) {
        e.preventDefault();
    });
    
});