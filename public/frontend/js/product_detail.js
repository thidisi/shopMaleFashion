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

$("#comment-form").on("submit", function (e) {
    e.preventDefault();
    let userId = $("input[name=user_id]").val();
    let productId = $("input[name=product_id]").val();
    var content = $(this).find("textarea[name=content]").val();
    var checkStr = content.length >= 6;
    if (content.length === 0) {
        $(this).find(".text-danger").remove();
        $(this).append('<p class="text-danger ml-2 mt-1"></p>');
        $(this)
            .find(".text-danger")
            .text("Please enter content(*Required)")
            .show()
            .fadeOut(3000);
        return false;
    }
    if (!checkStr) {
        $(this).find(".text-danger").remove();
        $(this).append('<p class="text-danger ml-2 mt-1"></p>');
        $(this)
            .find(".text-danger")
            .text("Please enter more than 6 characters")
            .show()
            .fadeOut(3000);
        return false;
    }
    $(".button-comment").addClass("bg-secondary").prop("disabled", true);
    setTimeout(function () {
        $(".button-comment")
            .removeClass("bg-secondary")
            .prop("disabled", false);
    }, 3000);
    $.ajax({
        type: "POST",
        url: $(this).data("route"),
        data: {
            customer_id: userId,
            product_id: productId,
            content: content,
        },
        success: function (response, textStatus, xhr) {
            $.toast({
                heading: "Add Comments success!",
                text: response,
                showHideTransition: "slide",
                position: "top-right",
                icon: "success",
            });
            $(".textarea-comment").find("textarea").val("");
            window.location.reload(true);
        },
        error: function (response) {
            $.toast({
                heading: "Add Comments Error!",
                text: response,
                showHideTransition: "slide",
                position: "top-right",
                icon: "error",
            });
        },
    });
});

$(".comment-form2").on("submit", function (e) {
    e.preventDefault();
    let comment_id = $("input[name=comment_id]").val();
    let user_id = $("input[name=user_id]").val();
    var content = $(this).find("textarea[name=content]").val();
    var checkStr = content.length >= 6;
    if (content.length === 0) {
        $(this).find(".text-danger").remove();
        $(this).append('<p class="text-danger ml-2 mt-1"></p>');
        $(this)
            .find(".text-danger")
            .text("Please enter content(*Required)")
            .show()
            .fadeOut(3000);
        return false;
    }
    if (!checkStr) {
        $(this).find(".text-danger").remove();
        $(this).append('<p class="text-danger ml-2 mt-1"></p>');
        $(this)
            .find(".text-danger")
            .text("Please enter more than 6 characters")
            .show()
            .fadeOut(3000);
        return false;
    }
    $(".button-comment").addClass("bg-secondary").prop("disabled", true);
    setTimeout(function () {
        $(".button-comment")
            .removeClass("bg-secondary")
            .prop("disabled", false);
    }, 3000);
    $.ajax({
        type: "POST",
        url: $(this).data("route"),
        data: {
            comment_id: comment_id,
            customer_id: user_id,
            content: content,
        },
        success: function (response, textStatus, xhr) {
            $.toast({
                heading: "Add Comments success!",
                text: response,
                showHideTransition: "slide",
                position: "top-right",
                icon: "success",
            });
            window.location.href("#tabs-6");
        },
        error: function (response) {
            $.toast({
                heading: "Add Comments Error!",
                text: response,
                showHideTransition: "slide",
                position: "top-right",
                icon: "error",
            });
        },
    });
});

$("#image-comments").change(function (e) {
    e.preventDefault();
    var names = [];
    for (var i = 0; i < $(this).get(0).files.length; ++i) {
        names.push($(this).get(0).files[i].name);
    }
    $("#image-text").val(names);
});
