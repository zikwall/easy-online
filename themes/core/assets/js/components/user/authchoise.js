document.addEventListener('DOMContentLoaded', function() {
    $("#btnAuthChoiceMore").on('click', function () {
        $("#btnAuthChoiceMore").hide();
        $(".authChoiceMore").show();
    });
});

function openForm(evt, formName) {

    $('.tab-a').each(function(index) {
        $(this).removeClass('ui_tab_sel');
    });
    
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(formName).style.display = "block";
    evt.currentTarget.className += " ui_tab_sel";
}