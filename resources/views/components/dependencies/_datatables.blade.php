@push('css')
    <link href="https://cdn.datatables.net/2.2.2/css/dataTables.tailwindcss.css" rel="stylesheet">
@endpush

@push('javascript')
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.tailwindcss.js"></script>

    <script>
        function dt_showLoader(selector = "#myTable") {
            let tableContainer = document.querySelector(".table-container"); // Ambil container tabel
            let tableElement = document.querySelector(selector);

            if (!tableContainer || !tableElement) return;

            let overlay = document.createElement("div");
            overlay.id = "tableOverlay";
            overlay.style.position = "absolute";
            overlay.style.top = `${tableContainer.offsetTop}px`;
            overlay.style.left = `${tableContainer.offsetLeft}px`;
            overlay.style.width = `${tableContainer.offsetWidth}px`;
            overlay.style.height = `${tableContainer.offsetHeight}px`;
            overlay.style.background = "rgba(0, 0, 0, 0.2)"; // Transparan hitam
            overlay.style.zIndex = "10";
            overlay.style.pointerEvents = "none"; // Agar tidak menghalangi interaksi di dalamnya

            let loader = document.createElement("div");
            loader.id = "tableLoader";
            loader.style.position = "absolute";
            loader.style.width = "50px";
            loader.style.height = "50px";
            loader.style.background = "rgba(255, 255, 255, 0.8)";
            loader.style.borderRadius = "8px";
            loader.style.display = "flex";
            loader.style.alignItems = "center";
            loader.style.justifyContent = "center";
            loader.style.zIndex = "11";
            loader.style.boxShadow = "0px 2px 10px rgba(0,0,0,0.2)";

            let spinner = document.createElement("div");
            spinner.style.width = "30px";
            spinner.style.height = "30px";
            spinner.style.border = "4px solid #3498db";
            spinner.style.borderTop = "4px solid transparent";
            spinner.style.borderRadius = "50%";
            spinner.style.animation = "spin 1s linear infinite";

            loader.appendChild(spinner);
            document.body.appendChild(overlay);
            document.body.appendChild(loader);

            function updateLoaderPosition() {
                let rect = tableContainer.getBoundingClientRect();
                let scrollX = tableContainer.scrollLeft;
                let scrollY = tableContainer.scrollTop;

                overlay.style.top = `${rect.top + window.scrollY}px`;
                overlay.style.left = `${rect.left + window.scrollX}px`;
                overlay.style.width = `${tableContainer.clientWidth}px`;
                overlay.style.height = `${tableContainer.clientHeight}px`;

                loader.style.top = `${rect.top + window.scrollY + tableContainer.clientHeight / 2}px`;
                loader.style.left = `${rect.left + window.scrollX + tableContainer.clientWidth / 2 - scrollX}px`;
            }

            updateLoaderPosition();
            window.addEventListener("resize", updateLoaderPosition);
            tableContainer.addEventListener("scroll", updateLoaderPosition);
        }

        // Fungsi untuk menghapus loader
        function dt_hideLoader() {
            document.getElementById("tableLoader")?.remove();
            document.getElementById("tableOverlay")?.remove();
        }

        // Tambahkan animasi spin ke `<style>`
        let style = document.createElement("style");
        style.innerHTML = `
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;
        document.head.appendChild(style);
    </script>
@endpush
