$('.grid').masonry({
  // options
  itemSelector: '.card',
  // use element for option
  columnWidth: '.grid-sizer',
  gutter: '.gutter-sizer',
  percentPosition: true
});
$('.grid').imagesLoaded().progress( function() {
  $('.grid').masonry('layout');
});