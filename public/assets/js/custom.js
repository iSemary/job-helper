const loadingSpan = `<span><i class="fa fa-spinner fa-spin"></i> Processing, Please wait...</span>`;
const csrfToken = $('meta[name="_token"]').attr("content");
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
                targetDiv.removeClass("loading");
                history.pushState({ page: page }, null, page);
                linkTag.addClass("active");
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
// Global ajax edit form
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
                `<h6 class="text-success"><i class="fas fa-check-circle"></i> ${data.message}</h6>`
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
// Global ajax create form
$(document).on("submit", "#createForm", function (e) {
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
            $(".create-status").html(
                `<h6 class="text-muted"><i class="fas fa-circle-notch fa-spin"></i> Creating, Please wait...</h6>`
            );
            formBtn.prop("disabled", true);
        },
        success: function (data) {
            $(".create-status").html(
                `<h6 class="text-success"><i class="fas fa-check-circle"></i> ${data.message}</h6>`
            );
            formBtn.prop("disabled", false);
            $("input, textarea", formID)
                .not(
                    ":input[type=button], :input[type=submit], :input[type=hidden], :input[type=reset]"
                )
                .val("");
            $(".dataTable").DataTable().ajax.reload();
        },
        error: function (data) {
            $(".create-status").html("");
            formBtn.prop("disabled", false);
            console.log(data);
            // $.each(xhr.responseJSON.errors, function(key, value) {
            $(".create-status").append(
                `<h6 class="text-danger"><i class="fas fa-exclamation-triangle"></i> ` +
                    (data.responseJSON.message ?? "Something went wrong") +
                    `</h6>`
            );
            // });
            formBtn.prop("disabled", false);
        },
    });
});

// PDF Loader
// Function to load and display the PDF
function loadPDF(pdfUrl, viewElementId) {
    // Initialize PDF.js
    pdfjsLib.GlobalWorkerOptions.workerSrc =
        "/assets/plugins/pdfjs/js/worker.min.js";

    // Fetch the PDF document
    pdfjsLib.getDocument(pdfUrl).promise.then(function (pdfDocument) {
        // Set up a loop to render each page
        for (let pageNum = 1; pageNum <= pdfDocument.numPages; pageNum++) {
            pdfDocument.getPage(pageNum).then(function (pdfPage) {
                // Create a canvas element to render the page
                var canvas = document.createElement("canvas");
                canvas.id = "page-" + pageNum;

                // Append the canvas to the PDF viewer container
                document.getElementById(viewElementId).appendChild(canvas);

                // Set the canvas size to match the PDF page size
                var viewport = pdfPage.getViewport({ scale: 1.0 });
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                // Render the PDF page on the canvas
                pdfPage.render({
                    canvasContext: canvas.getContext("2d"),
                    viewport: viewport,
                });
            });
        }
    });
}

// Dynamic dataTable with date range filters
function filterTable(
    route,
    tableId,
    fromDate,
    toDate,
    init,
    cols,
    colDefs,
    dataExtra
) {
    // init
    if (init) {
        $(tableId).DataTable().destroy();
    }

    let data = {
        from_date: fromDate ?? null,
        to_date: toDate ?? null,
        dataTables: true,
    };
    if (dataExtra) {
        $.extend(data, dataExtra);
    }

    $(tableId).DataTable({
        order: [[0, "desc"]],
        processing: true,
        scrollX: true,
        responsive: true,
        serverSide: true,
        columnDefs: colDefs ?? null,
        ajax: {
            url: route,
            data: data,
        },
        columns: cols,
    });
}

// Global Modal Opener
function openModal(url) {
    $("#openModal").modal({
        backdrop: true,
        show: true,
    });
    $(".modal-dialog").draggable({
        handle: ".modal-header",
    });

    $("#openTargetModal")
        .html(loadingSpan)
        .load(url, function () {
            $("select.select2").select2({});
            $("body").tooltip({
                selector: '[data-toggle="tooltip"]',
            });
        });
}
$("#openModal").on("hidden.bs.modal", function () {
    $("#openTargetModal").html("");
});

/**
 *
 * ===== Delete Function Section
 *
 */

function deleteRow(link, type) {
    Swal.fire({
        title: "Are you sure?",
        text: "You will delete this " + type + " ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: link,
                type: "DELETE",
                data: {
                    _token: csrfToken,
                },
            })
                .done(function (data) {
                    Swal.fire({
                        text: type + " deleted successfully",
                        confirmButtonText: "ok",
                        type: "success",
                        toast: true,
                        position: "bottom",
                    });
                    $(".dataTable").DataTable().ajax.reload();
                })
                .fail(function (data) {
                    Swal.fire({
                        text: data.message,
                        type: "error",
                        toast: true,
                        position: "bottom",
                    });
                });
        }
    });
}

$(document).on("click", ".delete-btn", function (event) {
    event.preventDefault();
    deleteRow($(this).attr("data-url"), $(this).attr("data-delete-type"));
});

// Switch status to warning
function switchWarningStatus(elementId) {
    $(elementId).addClass("text-warning").removeClass("text-success");
    $(elementId)
        .find("i")
        .addClass("fa-exclamation-triangle")
        .removeClass("fa-check-circle");
}
// Switch status to success
function switchSuccessStatus(elementId) {
    $(elementId).addClass("text-success").removeClass("text-warning");
    $(elementId)
        .find("i")
        .addClass("fa-check-circle")
        .removeClass("fa-exclamation-triangle");
}

// view file modal
$(document).ready(function () {
    $(document).on("click", ".view-file", function (e) {
        e.preventDefault();
        var fileUrl = $(this).data("file-url");
        $("#fileViewerFrame").attr("src", fileUrl);
        loadPDF(fileUrl, "fileViewer");
        $("#viewFileModal").modal("show");
    });
});
