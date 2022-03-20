
// document loaded
$(document).ready(function () {
    // highlight selected page in sidebar
    let currentLocation = document.location.href;
    let cl_split = currentLocation.split("&id=");

    if (cl_split.length > 1) {
        let cl_splithash = cl_split[1].split("#");
        let elementid = cl_splithash[0] + "_file";
        let menuelem = $('#' + elementid);
        $(menuelem).addClass('selected');
        openParentMenu($(menuelem).parent(), false);

        // jump to selected page in sidebar
        document.getElementById(elementid).scrollIntoView();

        if(cl_splithash.length > 1){
            // when internal jumo mark clicked also jump to this position
            let elementid2 = cl_splithash[1];
            document.getElementById(elementid2).scrollIntoView();
            $('#' + elementid2).addClass('n2web_jumpmark_selected');
        }
    }
    	
    $( ".n2web_group" ).first().addClass('opened');
    $( ".n2web_file.has_children" ).first().addClass('opened');


    // menu functionality
    $(".n2web_show_children").click(function () {
        let n2webid = $(this).data( "n2webid" );
        toggleMenuOpen(n2webid, true);
    });
    $("a.table_of_contents-link").click(function () {
        let n2webid = $(this).attr('href');
        let element = $(n2webid);
        highlightJumpMark(element);
    });
    $(".n2web_header_mobile_menu_button").click(function (){
        var element =   $(".n2web_header_menu.menu_right");
        if($(element).hasClass('opened')){
            $(element).removeClass('opened');
            $(element).removeClass('opened');
        }else{
            $(element).addClass('opened');
            $(element).addClass('opened');
        }
    })

});



function toggleMenuOpen(n2webid, manual){
    var cl = '';
    if (manual == true){
        $('#'+n2webid+'_dir').addClass('manual');
        $('#'+n2webid+'_file').addClass('manual');
    }else{
        // cl = 'opened';
    }

    if($('#'+n2webid+'_dir').hasClass('opened')){
        $('#'+n2webid+'_dir').removeClass('opened');
        $('#'+n2webid+'_file').removeClass('opened');
    }else{
        $('#'+n2webid+'_dir').addClass('opened');
        $('#'+n2webid+'_file').addClass('opened');
    }
}

function openParentMenu(element, manual){
    if ($(element).hasClass('n2web_group')){
        let n2webid = $(element).data( "n2webid" );
        toggleMenuOpen(n2webid, manual);
        openParentMenu($(element).parent(), manual);
    }
}

function highlightJumpMark(element){
    $('a').removeClass('n2web_jumpmark_selected');
    $(element).addClass('n2web_jumpmark_selected');
}

//Smooth-Scrolling
$(function() {
    $('a[href*="#"]:not([href="#"])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          $('html, body').animate({
            scrollTop: target.offset().top
          }, 1000);
          return false;
        }
      }
    });
  });

