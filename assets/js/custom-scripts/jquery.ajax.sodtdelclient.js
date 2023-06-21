(function ($) {
  let ajax_url = $("#ajax_url").val();
  // console.log(ajax_url);
  $("#ajax_url").remove();
  $(document.body).on("click", ".delete", function () {
    let this_btn = $(this);
    let closest_row = $(this).closest("tr");
    let delete_id = $(this).attr("data-delete");
    let data = {
      delete_id: delete_id,
    };
    const reply = confirm_delete();
    console.log(reply);
    if (reply === true) {
      $.ajax({
        url: ajax_url,
        type: "POST",
        data: data,
        success: function (data) {
          let response = JSON.parse(data);
          for (const key in response) {
            if (response[key] === true) {
              $(closest_row).remove();
            }
          }
        },
        error: function (error) {
          window.alert(error);
        },
      });
    }
  });

  function confirm_delete() {
    let text = "Are you sure you want to Delete?";
    if (confirm(text) === true) {
      return true;
    } else {
      return false;
    }
  }
})(jQuery);
