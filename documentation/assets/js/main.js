(function($) {
    "use strict";

    document.querySelectorAll('[data-year]').forEach(function(el) {
        el.textContent = new Date().getFullYear();
    });

    var dropdown = document.querySelectorAll('[data-dropdown]');
    if (dropdown != null) {
        dropdown.forEach(function(el) {
            let dropdownMenu = el.querySelector(".drop-down-menu");

            function dropdownOP() {
                if (el.getBoundingClientRect().top + dropdownMenu.offsetHeight > window.innerHeight - 60 && el.getAttribute("data-dropdown-position") !== "top") {
                    dropdownMenu.style.top = "auto";
                    dropdownMenu.style.bottom = "40px";
                } else {
                    dropdownMenu.style.top = "40px";
                    dropdownMenu.style.bottom = "auto";
                }
            }
            window.addEventListener("click", function(e) {
                if (el.contains(e.target)) {
                    el.classList.toggle('active');
                    setTimeout(function() {
                        el.classList.toggle('animated');
                    }, 0);
                } else {
                    el.classList.remove('active');
                    el.classList.remove('animated');
                }
                dropdownOP();
            });
            window.addEventListener("resize", dropdownOP);
            window.addEventListener("scroll", dropdownOP);
        });
    }

    // Navbar Menu
    let navbarMenu = document.querySelector(".nav-bar-menu"),
        navbarMenuBtn = document.querySelector(".nav-bar-menu-btn");
    if (navbarMenu) {
        let navbarMenuClose = navbarMenu.querySelector(".nav-bar-menu-close"),
            navbarMenuOverlay = navbarMenu.querySelector(".overlay"),
            navUploadBtn = document.querySelector(".nav-bar-menu [data-upload-btn]");
        navbarMenuBtn.onclick = () => {
            navbarMenu.classList.add("show");
            document.body.classList.add("overflow-hidden");
        };

        navbarMenuClose.onclick = navbarMenuOverlay.onclick = () => {
            navbarMenu.classList.remove("show");
            document.body.classList.remove("overflow-hidden");
        };
        if (navUploadBtn) {
            navUploadBtn.addEventListener("click", () => {
                navbarMenu.classList.remove("show");
            });
        }
    }

    let articles = document.querySelectorAll(".doc-part"),
        sidebarLinks = document.querySelectorAll("[data-sublink]");
    if (sidebarLinks) {
        sidebarLinks.forEach((el) => {
            el.onclick = () => {
                let targetPoint = document.querySelector(`[data-sublink-target=${el.getAttribute("data-sublink")}]`).offsetTop - 20;
                window.scrollTo(0, targetPoint);
            };
        });
    }
    if (articles) {
        let activeLinks = () => {
            let endPoint = document.documentElement.offsetHeight - window.innerHeight,
                targets = document.querySelectorAll(`[data-sublink-target]`);
            if (window.scrollY == endPoint) {
                sidebarLinks.forEach((eRemove) => {
                    eRemove.classList.remove("active");
                    if (eRemove.getAttribute("data-sublink") === targets[targets.length - 1].getAttribute("data-sublink-target")) {
                        document.querySelector(`[data-sublink=${eRemove.getAttribute("data-sublink")}]`).classList.add("active");
                    }
                });
            } else {
                articles.forEach((el, id) => {
                    if ((el.offsetTop - (window.innerHeight * .16)) < window.scrollY) {
                        sidebarLinks.forEach((e) => {
                            if (e.getAttribute("data-sublink") == el.getAttribute("data-sublink-target")) {
                                sidebarLinks.forEach((eRemove) => {
                                    eRemove.classList.remove("active");
                                });
                                sidebarLinks[id].classList.add("active");
                            }
                        });
                    }
                });
            }
        };
        window.addEventListener("scroll", activeLinks);
        window.addEventListener("load", activeLinks);
    }

    let code = document.querySelectorAll(".code");
    if (code) {
        code.forEach((el) => {
            el.querySelector(".copy").onclick = () => {
                var range = document.createRange();
                range.selectNode(el.querySelector("code>.pre"));
                window.getSelection().removeAllRanges();
                window.getSelection().addRange(range);
                document.execCommand("copy");
                window.getSelection().removeAllRanges();
                el.querySelector(".copy").innerHTML = '<i class="fa fa-check"></i>';
                el.querySelector(".copy").classList.add("copied");
                setTimeout(() => {
                    el.querySelector(".copy").innerHTML = '<i class="far fa-clone"></i>';
                    el.querySelector(".copy").classList.remove("copied");
                }, 500);
            };
        });
    }

    let page = document.querySelector(".page"),
        sidebarToggle = document.querySelector(".sidebar-toggle");
    if (sidebarToggle) {
        sidebarToggle.onclick = () => {
            if (sidebarToggle.classList.contains("active")) {
                page.classList.remove("toggle");
                sidebarToggle.classList.remove("active");
            } else {
                page.classList.add("toggle");
                sidebarToggle.classList.add("active");
            }
        };
    }
})(jQuery);