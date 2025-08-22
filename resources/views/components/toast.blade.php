<div class="fixed end-4 top-8 z-40 flex flex-col space-y-2" id="zk-toast-container"></div>

@push('javascript')
    <script>
        class MyZkToast {
            static maxToasts = 2;
            static toasts = [];
            static duration = 5000; // Durasi toast dalam ms

            static show(message, type = "info", customIcon = null) {
                if (this.toasts.length >= this.maxToasts) {
                    this.removeOldest();
                }

                const toastId = `toast-${Date.now()}`;
                this.toasts.push(toastId);

                const toastContainer = document.getElementById("zk-toast-container");
                if (!toastContainer) return;

                toastContainer.insertAdjacentHTML("beforeend", this.getTemplate(toastId, message, type, customIcon));

                const toast = document.getElementById(toastId);
                if (!toast) return;

                // Animasi Slide-In
                setTimeout(() => {
                    toast.classList.add("translate-x-0", "opacity-100");
                }, 10);

                // Animasi Progress Bar
                const progressBar = toast.querySelector(".zk-progress-bar");
                if (progressBar) {
                    setTimeout(() => {
                        progressBar.style.width = "0%";
                    }, 50);
                }

                // Timer untuk auto-close
                setTimeout(() => this.close(toastId), this.duration);
            }

            static removeOldest() {
                const oldestToast = this.toasts.shift();
                if (oldestToast) this.close(oldestToast);
            }

            static close(toastId) {
                const toast = document.getElementById(toastId);
                if (toast) {
                    toast.classList.add("translate-x-5", "opacity-0"); // Animasi Slide-Out
                    setTimeout(() => toast.remove(), 300);
                }
            }

            static getTemplate(id, message, type, customIcon) {
                return `
                <div id="${id}" role="alert" class="toast relative flex max-w-xs items-center rounded-lg bg-background p-4 text-foreground shadow-md transition-all duration-300 transform translate-x-5 opacity-0">
                    <div class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg ${this.getBgColor(type)}">
                        ${customIcon || this.getIcon(type)}
                    </div>
                    <div class="ml-3 text-sm font-normal me-2">${message}</div>
                    <button onclick="MyZkToast.close('${id}')" class="ml-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-background p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 14 14">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                        </svg>
                    </button>
                    <div class="absolute bottom-0 left-0 h-1 w-full bg-gray-200 overflow-hidden">
                        <div class="zk-progress-bar h-full bg-blue-500 transition-all duration-[5000ms] ease-linear w-full"></div>
                    </div>
                </div>
                `;
            }

            static getBgColor(type) {
                return {
                    success: "bg-success/20 text-success",
                    error: "bg-error/20 text-error",
                    warning: "bg-warning/20 text-warning",
                    info: "bg-info/20 text-info",
                } [type] || "bg-blue-50 text-blue-500";
            }

            static getIcon(type) {
                return {
                    success: `<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>`,
                    error: `<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM8.293 8.293a1 1 0 0 1 1.414 0L10 9.586l1.293-1.293a1 1 0 1 1 1.414 1.414L11.414 11l1.293 1.293a1 1 0 0 1-1.414 1.414L10 12.414l-1.293 1.293a1 1 0 1 1-1.414-1.414L8.586 11 7.293 9.707a1 1 0 0 1 0-1.414Z"/></svg>`,
                    warning: `<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.293 3.293a1 1 0 0 1 1.414 0l6 6a1 1 0 0 1-1.414 1.414L11 6.414V15a1 1 0 1 1-2 0V6.414L4.707 10.707A1 1 0 0 1 3.293 9.293l6-6Z"/></svg>`,
                    info: `<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 1 1-8 8 8 8 0 0 1 8-8Zm0 3a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1Zm0 10a1.2 1.2 0 1 0 0-2.4A1.2 1.2 0 0 0 10 15Z"/></svg>`,
                } [type] || "";
            }

            static success(message, customIcon = null) {
                this.show(message, "success", customIcon);
            }

            static error(message, customIcon = null) {
                this.show(message, "error", customIcon);
            }

            static warning(message, customIcon = null) {
                this.show(message, "warning", customIcon);
            }

            static info(message, customIcon = null) {
                this.show(message, "info", customIcon);
            }
        }

        // MyZkToast.success("Data berhasil disimpan!", customIcon);
        // MyZkToast.error("Terjadi kesalahan!", customIcon);
        // MyZkToast.warning("Harap periksa kembali input Anda.", customIcon);
        // MyZkToast.info("Update terbaru telah tersedia.", customIcon);
    </script>
@endpush
