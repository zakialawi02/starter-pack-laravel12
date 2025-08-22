document.addEventListener("DOMContentLoaded", function () {
    // Cari semua elemen yang memiliki atribut data-collapse-toggle
    document.querySelectorAll("[data-collapse-toggle]").forEach((toggle) => {
        toggle.addEventListener("click", function () {
            // Toggle class 'open' pada tombol yang diklik
            toggle.classList.toggle("open");
        });
    });
});
