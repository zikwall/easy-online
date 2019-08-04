$('.ui.dropdown').dropdown();

function showNav(show) {
    if (show) {
        document.getElementById('ts_cont_wrap').style.display = 'none';
    } else {
        document.getElementById('ts_cont_wrap').style.display = 'block';
    }

    $(this).keyup(function(e) {
        if (e.keyCode === 27) {
            document.getElementById('ts_cont_wrap').style.display = 'none';
            $(this).blur();
        }
    });
}

