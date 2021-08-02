$(document).ready(function() {
  const collapses = $('.collapses');

  if (collapses.length) {
    // console.log('collapses init');

    collapses.each(function() {
      $(this).addClass('init');
      $(this).find('.collapse').each(function() {
        if ($(this).hasClass('active')) {
          $(this).find('.collapse--content').slideDown(280);
        }
      });
    });

    // handle click event
    collapses.find('.collapse--header').on('click', function() {
      // its own collapse
      const collapse = $(this).closest('.collapse');
      // all siblings collapses
      const collapses = collapse.siblings('.collapse');

      // toggle active state
      if (collapse.hasClass('active')) {
        collapse.removeClass('active');
        collapse.find('.collapse--content').slideUp(280);
      } else {
        // remove active state from siblings and hide their content
        collapses.removeClass('active').find('.collapse--content').slideUp(280);
        // show clicked collapse content
        collapse.addClass('active');
        collapse.find('.collapse--content').slideDown(280);
      }
    });
  }
});