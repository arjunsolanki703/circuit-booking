$(document).ready(function () {
  const header = $('.homepage-tabs--controls');
  const content = $('.homepage-tabs--content');

  const setTabActive = function(id: string) {
    const selector = '#' + id;
    const tab = $(content).find(selector);
    content.find('.tab-page').removeClass('active');
    tab.addClass('active');
  };

  if (header.length && content.length) {
    let active:boolean = false;
    // tabs init
    header.find('.tab-control').each(function() {
      let id = $(this).data('target');
      // check if page exist
      const selector = '#' + id;
      if ($(content).find(selector).length) {
        if ($(this).hasClass('active')) {
          active = true;
          setTabActive(id);
        }
      } else {
        $(this).addClass('disabled');
        console.warn(`Cannot init tab with target id - ${selector}: no tab page with this id`);
      }

    });

    if (!active) {
      let id = header.find('.tab-control').first().data('target');
      setTabActive(id);
    }

    // event handling
    header.find('.tab-control').on('click', function() {
      if (!$(this).hasClass('disabled')) {
        const id = $(this).data('target');

        setTabActive(id);
        $(header).find('.tab-control').removeClass('active');
        $(this).addClass('active');
      }
    });
  }
});