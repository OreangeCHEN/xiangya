$('.layout-menu').on('click', function () {
  if ($('.layout-logo-txt').is(':hidden')) {
    $('.layout-logo-txt').show();
    $('.layout-logo-icon ').hide();
    $('.layout-side-item-label').show();
    $('.layout-side-item-icon').hide();
    $('body').removeClass('layout-mini');
  } else {
    $('.layout-logo-txt').hide();
    $('.layout-logo-icon').show();
    $(' .layout-side-item-label').hide();
    $(' .layout-side-item-icon').show();
    $('body').addClass('layout-mini');
  }
});
