$(document).ready(function() {
  const tabs = $('.tabs');

  if (tabs.length) {
    // console.log('tabs init');

    tabs.each(function() {
      $(this).addClass('init');

      $(this).find('.tabs-header--item').each(function(index) {
        if ($(this).hasClass('active')) {
          // animated
          // $(this).closest('.tabs').find('.tab').eq(index).slideDown(280);
          // w/o animation
          $(this).closest('.tabs').find('.tab').eq(index).show();
        }
      });
    });

    // handle click event
    tabs.find('.tabs-header--item').each(function(index) {
      $(this).on('click', function() {
        // tabs container header
        const header = $(this).closest('.tabs-header');
        // tabs container content
        const content = header.siblings('.tabs-content');

        if (!$(this).hasClass('active')) {
          header.find('.tabs-header--item').removeClass('active');
          $(this).addClass('active');
          // animated
          // content.find('.tab').slideUp(280).eq(index).slideDown(280);
          // w/o animation
          content.find('.tab').hide().eq(index).show();
        }
      })
    })
  }
});