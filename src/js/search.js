var main = function() {
  $('.res-users').hide();
  $('#menu-users').click(function() {
    $('#menu-posts').removeClass('active');
    $('.res-posts').hide();

    $('#menu-users').addClass('active');
    $('.res-users').show();
  });
  $('#menu-posts').click(function() {
    $('#menu-users').removeClass('active');
    $('.res-users').hide();

    $('#menu-posts').addClass('active');
    $('.res-posts').show();
  });
}

$(document).ready(main);