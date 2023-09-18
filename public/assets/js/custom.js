// Switch between login form and register form
$(".switch-login, .switch-register").on("click", function (e) {
    $(".login-form, .register-form").toggleClass("d-none");
});

$(document).on("click", ".page-switcher", function (e) {
    e.preventDefault();
    let linkTag = $(this);
    let page = linkTag.attr("data-switch-target");
    let sideBarItem = linkTag.parent(".sidebar-item");

    let targetDiv = $("#content");
    targetDiv.addClass("loading");

    if (page && page != "") {
        $.ajax({
            url: page,
            type: "GET",
            "X-Requested-With": "XMLHttpRequest",
            dataType: "html",
            success: function (data) {
                targetDiv.html(data);
                linkTag.addClass("active");
                targetDiv.removeClass("loading");
                history.pushState({ page: page }, null, page);
                if (sideBarItem) {
                    removeSelectorFromSideBars();
                    sideBarItem.addClass("selected");
                }
            },
            error: function (xhr, status, error) {
                targetDiv.removeClass("loading");
                console.error("Error loading content:", error);
            },
        });
    }
});

function removeSelectorFromSideBars() {
    let sideBarItems = $("#sidebarnav").find(".sidebar-item");
    sideBarItems.each(function (index, element) {
        if (element) {
            $(element).removeClass("selected");
            $(element).find("sidebar-link").removeClass("active");
        }
    });
}

$(".sidebar-item.multiple").on("click", function (e) {
    $(this).toggleClass("active");
    $(this).find(".base-level-line").toggleClass("in");
});

$(".toggle-sidebar").click(function (e) {
    if ($("#main-wrapper").attr("data-sidebartype") == "full") {
        $("#main-wrapper").attr("data-sidebartype", "false");
        $(".left-sidebar").css("width", "0");
    } else {
        $("#main-wrapper").attr("data-sidebartype", "full");
        $(".left-sidebar").css("width", "260px");
    }
});


$(document).on("submit", "#editForm", function (e) {
    e.preventDefault();
    let formBtn = $(this).find(":submit");
    let formData = new FormData(this);
    let formID = "#" + $(this).attr("id");
    let formUrl = $(this).attr("action");

    $.ajax({
        type: "POST",
        dataType: "json",
        url: formUrl,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $(".edit-status").html(
                `<h6 class="text-muted"><i class="fas fa-circle-notch fa-spin"></i> Updating, please wait...</h6>`
            );
            formBtn.prop("disabled", true);
        },
        success: function (data) {
            $(".edit-status").html(
                `<h6 class="text-success"><i class="fas fa-check-circle"></i> Updated successfully!</h6>`
            );
            formBtn.prop("disabled", false);
            $(".dataTable").DataTable().ajax.reload();
        },
        error: function (xhr) {
            $(".edit-status").html("");
            formBtn.prop("disabled", false);
            $(".edit-status").append(
                `<h6 class="text-danger" style="max-width:70vw;"><i class="fas fa-exclamation-triangle"></i> ` +
                    JSON.stringify(xhr) +
                    `</h6>`
            );
        },
    });
});
