(function ($) {
  $(function () {
    $("body").on("click", ".rvm-close-default-card-container", function () {
      $(this)
        .parents(".rvm-default-card-container")
        .addClass("rvm-hide-card-container"); //parents() ensure to search through all the ancestors
    });
  });
})(jQuery);
