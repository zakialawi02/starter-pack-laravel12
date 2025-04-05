import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(document).ready(function () {
    (function () {
        const placeholder = "https://placehold.co/200";
        // Fungsi untuk menangani error gambar
        function handleImageError() {
            if (this.src !== placeholder) {
                this.src = placeholder;
            }
        }
        // Fungsi untuk menambahkan event listener ke gambar
        function addImageErrorListener(img) {
            img.addEventListener("error", handleImageError);

            // Periksa gambar yang sudah error sebelum event listener terpasang
            if (
                img.complete &&
                (img.naturalWidth === 0 || img.naturalHeight === 0)
            ) {
                img.src = placeholder;
            }
        }
        // Pasang listener ke semua gambar yang ada
        document.querySelectorAll("img").forEach(addImageErrorListener);
        // Observer untuk memantau penambahan gambar baru
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    // Cek node langsung yang merupakan gambar
                    if (node.tagName === "IMG") {
                        addImageErrorListener(node);
                    }
                    // Cek gambar di dalam subtree node yang ditambahkan
                    if (node.querySelectorAll) {
                        node.querySelectorAll("img").forEach(
                            addImageErrorListener,
                        );
                    }
                });
            });
        });
        // Mulai observasi perubahan DOM
        observer.observe(document.documentElement, {
            childList: true,
            subtree: true,
        });
    })();
});
