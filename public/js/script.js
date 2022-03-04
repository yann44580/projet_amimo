$(document).ready(function () {
  $('.sidenav').sidenav();
  $(".dropdown-trigger").dropdown();
  $('.collapsible').collapsible();
  $('select').formSelect();
  $('.datepicker').datepicker();
  $('#presentation_picture').fadeIn(3600);
  $('.carousel').carousel(
    {
      dist:0,
      shift:0,
      padding:200,
      // fullWidth: true,
      numVisible:4,
      duration:200,
    }
  );
  autoplay();
  function autoplay(){
    $('.carousel').carousel('next');
    setTimeout(autoplay,4500);
  }
  $(function() {
    /**
    * Smooth scrolling to page anchor on click
    **/
    $("a[href*='#']:not([href='#'])").click(function() {
        if (
            location.hostname == this.hostname
            && this.pathname.replace(/^\//,"") == location.pathname.replace(/^\//,"")
        ) {
            var anchor = $(this.hash);
            anchor = anchor.length ? anchor : $("[name=" + this.hash.slice(1) +"]");
            if ( anchor.length ) {
                $("html, body").animate( { scrollTop: anchor.offset().top }, 1500);
            }
        }
    });
});
});


