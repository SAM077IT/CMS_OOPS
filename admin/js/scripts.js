$(document).ready(function () {
  $("#summernote").summernote({ height: 200 });
});

$(document).ready(function () {
  $("#selectAllBoxes").click(function (event) {
    if (this.checked) {
      $(".checkBoxes").each(function () {
        this.checked = true;
      });
    } else {
      $(".checkBoxes").each(function () {
        this.checked = false;
      });
    }
  });
  const div_box = "<div id='load-screen'><div id='loading'></div></div>";
  $("body").prepend(div_box);

  $("#load-screen")
    .delay(600)
    .fadeOut(300, function () {
      $(this).remove();
    });

  function loadUerOnline() {
    $.post("/cms_oops/admin/functions.php?onlineusers=result", function (data) {
      $(".usersonline").text(data);
    });
  }

  setInterval(function () {
    loadUerOnline();
  }, 1000);
});
