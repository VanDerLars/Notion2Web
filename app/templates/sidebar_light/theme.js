
// document loaded
$(document).ready(function () {
    // highlight selected page in sidebar
    let currentLocation = document.location.href;
    let cl_split = currentLocation.split("&id=");

    if (cl_split.length > 1) {
        let elementid = cl_split[1] + "_file";
        let menuelem = $('#' + elementid);
        $(menuelem).addClass('selected');
        openParentMenu($(menuelem).parent());
        document.getElementById(elementid).scrollIntoView();
    }


    // menu functionality
    $(".n2web_show_children").click(function () {
        let n2webid = $(this).data( "n2webid" );
        toggleMenuOpen(n2webid);
    });
    $("a.table_of_contents-link").click(function () {
        let n2webid = $(this).attr('href');
        let element = $(n2webid);
        highlightJumpMark(element);
    });

});



function toggleMenuOpen(n2webid){
    if($('#'+n2webid+'_dir').hasClass('opened')){
        $('#'+n2webid+'_dir').removeClass('opened');
        $('#'+n2webid+'_file').removeClass('opened');
    }else{
        $('#'+n2webid+'_dir').addClass('opened');
        $('#'+n2webid+'_file').addClass('opened');
    }
}

function openParentMenu(element){
    if ($(element).hasClass('n2web_group')){
        let n2webid = $(element).data( "n2webid" );
        toggleMenuOpen(n2webid);
        openParentMenu($(element).parent());
    }
}

function highlightJumpMark(element){
    $('a').removeClass('n2web_jumpmark_selected');
    $(element).addClass('n2web_jumpmark_selected');
}


