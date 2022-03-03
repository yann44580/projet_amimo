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
      padding:20,
    }
  );
});