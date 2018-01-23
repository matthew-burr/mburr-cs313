var FADE_TIME = 1000;
var SHOW_TIME = 3000 + (2 * FADE_TIME);

$(document).ready(function() {
  $.getJSON("images.json", function(data, status) {
    if (status != "success") {
      return;
    }
    startCarousel(data.images);
    return;
  });
});

function startCarousel(images) {
  var play = true;
  var nextImage = 0;

  setInterval(function() {
    if (play) {
      $("#myPictureBox").fadeOut(FADE_TIME, function() {
        showNextImage(images[nextImage]);
        nextImage = (nextImage + 1) % images.length;
      });
    }
  }, SHOW_TIME);

  $("#pausePlayButton").click(function() {
    play = !play;
    $("#pausePlayButton > span").toggleClass("glyphicon-pause", play);
    $("#pausePlayButton > span").toggleClass("glyphicon-play", !play);
  });
}

function showNextImage(image) {
  $("#myPicture").attr({
    src: image.src,
    alt: image.alt
  });

  $("#myPictureCaption > p").text(image.caption);
  $("#pausePlayButton").show();
  $("#myPictureBox").fadeIn(FADE_TIME);
}
