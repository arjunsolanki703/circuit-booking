$(document).ready(function () {
  const input = $('#header-search--input');
  const filter = $('#header-filter');

  if (input && filter) {
    input.focus(function() {
      input.addClass('active');
      filter.addClass('active');
    });

    const checkForPersist = function(check, event) {
      return !check.is(event.target) && check.has(event.target).length === 0
    };

    $(document).on('click', function(e) {
      // if the target of the click isn't the container nor a descendant of the container
      if (checkForPersist(input, e) && checkForPersist(filter, e)) {
        input.removeClass('active');
        filter.removeClass('active');
      }
    });
  }
});