$("#review-form").on("submit", function (e) {
    var content = $(this).find("textarea[name='review_content']");
    var checkStr = content.val().length >= 6;
    if (content.val().length === 0) {
        $(this).find(".text-danger").remove();
        $(this)
            .find(".content-review")
            .append('<p class="text-danger ml-2 mt-2"></p>');
        $(this)
            .find(".text-danger")
            .text("Please enter content(*Required)")
            .show()
            .fadeOut(3000);
        e.preventDefault();
        return false;
    }
    if (!checkStr) {
        $(this).find(".text-danger").remove();
        $(this)
            .find(".content-review")
            .append('<p class="text-danger ml-2 mt-2"></p>');
        $(this)
            .find(".text-danger")
            .text("Please enter more than 6 characters")
            .show()
            .fadeOut(3000);
        e.preventDefault();
        return false;
    }
    $(".btn-review").prop("disabled", true);
});

$("#image-comments").change(function (e) {
    e.preventDefault();
    var names = [];
    for (var i = 0; i < $(this).get(0).files.length; ++i) {
        names.push($(this).get(0).files[i].name);
    }
    $("#image-text").val(names);
});
