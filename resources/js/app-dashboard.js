document.addEventListener("DOMContentLoaded", function () {
    // Cari semua elemen yang memiliki atribut data-collapse-toggle
    document.querySelectorAll("[data-collapse-toggle]").forEach((toggle) => {
        toggle.addEventListener("click", function () {
            // Toggle class 'open' pada tombol yang diklik
            toggle.classList.toggle("open");
        });
    });

    const themeToggle = document.getElementById("theme-toggle");
    const iconSun = document.getElementById("icon-sun");
    const iconMoon = document.getElementById("icon-moon");
    function applyTheme(theme) {
        document.documentElement.classList.toggle("dark", theme === "dark");
        localStorage.setItem("theme", theme);
        iconSun.classList.toggle("hidden", theme !== "dark");
        iconMoon.classList.toggle("hidden", theme === "dark");
    }
    // Cek tema saat ini
    const savedTheme = localStorage.getItem("theme") || "light";
    applyTheme(savedTheme);
    // Toggle tema saat tombol diklik
    themeToggle.addEventListener("click", function () {
        const newTheme = document.documentElement.classList.contains("dark")
            ? "light"
            : "dark";
        applyTheme(newTheme);
    });
});
