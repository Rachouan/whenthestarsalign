$(function () {

  $("#email-optin").on("submit",function (e) {
    e.preventDefault();
    saveDesign();
  });

  $("#skip").on("click",function (e) {
    e.preventDefault();
    saved = true;
    saveDesign();
  });

  $(".download").on("click", function(e) {
    e.preventDefault();
    if (!saved) {
      openEmail();
      return false;
    } else {
      saveDesign();
    }
  });



  $(".buttons-mobile .button").on("click", function(e) {
    e.preventDefault();
    switch ($(this).attr("class")) {
      case "button prev":
        slide--;
        break;
      case "button next":
        slide++;
        break;
      default:
    }


    if (slide < 1) {
      slide = 1;
    }
    if (slide > $(".editor .slide").length) {
      slide = $(".editor fieldset").length;
    }

    slideshow();
  });

  $(window).on("resize", function(e) {
    slideshow();
  });

});
