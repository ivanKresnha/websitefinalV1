document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".food_menu_nav a:not(.prev-tab):not(.next-tab)");
    const prevTab = document.querySelector(".prev-tab");
    const nextTab = document.querySelector(".next-tab");
    const itemsPerPage = 2;

    let currentPage = 0;

    function renderTabs() {
        tabs.forEach((tab, index) => {
            const start = currentPage * itemsPerPage;
            const end = start + itemsPerPage;

            if (index >= start && index < end) {
                tab.style.display = "inline-block";
            } else {
                tab.style.display = "none";
            }
        });

        updateButtons();
    }

    function updateButtons() {
        prevTab.classList.toggle("disabled", currentPage === 0);
        nextTab.classList.toggle("disabled", (currentPage + 1) * itemsPerPage >= tabs.length);
    }

    prevTab.addEventListener("click", (e) => {
        e.preventDefault();
        if (currentPage > 0) {
            currentPage--;
            renderTabs();
        }
    });

    nextTab.addEventListener("click", (e) => {
        e.preventDefault();
        if ((currentPage + 1) * itemsPerPage < tabs.length) {
            currentPage++;
            renderTabs();
        }
    });

    renderTabs();
});
