$(function () {
    "use strict";
    $(".nav-toggler").on("click", function () {
        $("#main-wrapper").toggleClass("show-sidebar"),
            $(".nav-toggler i").toggleClass("ti-menu");
    }),
        $(function () {
            $(".service-panel-toggle").on("click", function () {
                $(".customizer").toggleClass("show-service-panel");
            }),
                $(".page-wrapper").on("click", function () {
                    $(".customizer").removeClass("show-service-panel");
                });
        }),
        $(function () {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }),
        $(function () {
            $('[data-bs-toggle="popover"]').popover();
        }),
        $(
            ".message-center, .customizer-body, .scrollable, .scroll-sidebar"
        ).perfectScrollbar({ wheelPropagation: !0 }),
        $("body, .page-wrapper").trigger("resize"),
        $(".page-wrapper").delay(20).show(),
        $(".list-task li label").click(function () {
            $(this).toggleClass("task-done");
        }),
        $(".show-left-part").on("click", function () {
            $(".left-part").toggleClass("show-panel"),
                $(".show-left-part").toggleClass("ti-menu");
        })
});
