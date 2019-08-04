<nav class="tabs">
    <div class="selector"></div>
    <a href="#" class="active"><i class="fas fa-home"></i></a>
    <a href="#"><i class="fab fa-accusoft"></i></a>
    <a href="#"><i class="fas fa-apple-alt"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
    <a href="#"><i class="fas fa-align-justify"></i></a>
</nav>
<script>
    var tabs = $('.tabs');
    var items = $('.tabs').find('a').length;
    var selector = $(".tabs").find(".selector");
    var activeItem = tabs.find('.active');
    var activeWidth = activeItem.innerWidth();
    $(".selector").css({
        "left": activeItem.position.left + "px",
        "width": activeWidth + "px"
    });

    $(".tabs").on("click","a",function(e){
        e.preventDefault();
        $('.tabs a').removeClass("active");
        $(this).addClass('active');
        var activeWidth = $(this).innerWidth();
        var itemPos = $(this).position();
        $(".selector").css({
            "left":itemPos.left + "px",
            "width": activeWidth + "px"
        });
    });
</script>
