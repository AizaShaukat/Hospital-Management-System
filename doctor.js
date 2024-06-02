

window.onload = function () {
    const sidebarLinks = document.querySelectorAll("#sidebar a");

    sidebarLinks.forEach((link) => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const targetPage = this.getAttribute("href");
            const contentFrame = document.querySelector("iframe[name='contentFrame']");
            contentFrame.src = targetPage;
        });
    });
};