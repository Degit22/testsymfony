$(document).ready(function(){
    $(".slider").click(function(){
        $(this).next('.short').slideToggle("slow");
        return false;
    });
});