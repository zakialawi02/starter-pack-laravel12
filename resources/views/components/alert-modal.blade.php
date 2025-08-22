@push('javascript')
    <script>
        class PopupAlert {
            constructor() {
                this.createPopup();
            }

            createPopup() {
                this.popup = document.createElement('div');
                this.popup.id = 'zk-popup-modal';
                this.popup.className = `fixed inset-0 z-99 hidden flex items-center justify-center`;

                this.backdrop = document.createElement('div');
                this.backdrop.id = 'zk-popup-backdrop';
                this.backdrop.className = `absolute inset-0 bg-gray-800 bg-opacity-50`;

                this.popupContent = document.createElement('div');
                this.popupContent.className = `relative z-10 max-w-md w-full p-4 rounded-lg shadow-sm bg-background text-foreground border border-border`;

                this.popupContent.innerHTML = `
                    <button id="zk-popup-close" class="absolute end-2.5 top-3 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-gray-400 hover:bg-gray-200 hover:text-gray-900" type="button">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 text-center md:p-5">
                        <div id="zk-popup-icon" class="mx-auto mb-4"></div>
                        <h3 id="zk-popup-message" class="mb-5 text-lg font-normal"></h3>
                        <button id="zk-popup-confirm" class="text-sm px-4 py-2 text-center rounded-lg">Yes</button>
                        <button id="zk-popup-cancel" class="ms-3 text-sm px-4 py-2 rounded-lg">No</button>
                    </div>
                `;

                this.popup.appendChild(this.backdrop);
                this.popup.appendChild(this.popupContent);
                document.body.appendChild(this.popup);
                this.addEventListeners();
            }

            addEventListeners() {
                document.getElementById('zk-popup-close').addEventListener('click', () => this.hide());
                document.getElementById('zk-popup-cancel').addEventListener('click', () => this.hide());
                this.backdrop.addEventListener('click', () => this.hide());
            }

            show({
                message,
                icon,
                confirmText,
                cancelText,
                confirmClass,
                cancelClass,
                popupClass,
                backdropClass,
                onConfirm
            }) {
                document.getElementById('zk-popup-message').textContent = message;

                const iconContainer = document.getElementById('zk-popup-icon');
                iconContainer.innerHTML = icon ? icon : '';

                const confirmButton = document.getElementById('zk-popup-confirm');
                confirmButton.textContent = confirmText || 'Yes';
                confirmButton.className = confirmClass || "text-sm px-4 py-2 text-white bg-error rounded-lg hover:bg-error/80 focus:outline-none focus:ring-4 focus:ring-error";

                const cancelButton = document.getElementById('zk-popup-cancel');
                cancelButton.textContent = cancelText || 'No';
                cancelButton.className = cancelClass || "ms-3 text-sm px-4 py-2 text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100";

                this.popupContent.className = `relative z-10 max-w-md w-full p-4 rounded-lg shadow-sm ${popupClass || 'bg-background text-foreground border border-border'}`;
                this.backdrop.className = `absolute inset-0 ${backdropClass || 'bg-gray-800/50'}`;

                confirmButton.onclick = () => {
                    if (onConfirm) onConfirm();
                    this.hide();
                };

                this.popup.classList.remove('hidden');
            }

            hide() {
                this.popup.classList.add('hidden');
            }
        }

        const ZkPopAlert = new PopupAlert();

        // Contoh penggunaan
        // ZkPopAlert.show({
        //     message: "Are you sure you want to delete this product?",
        //     icon: '<svg class="h-12 w-12 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 1a9 9 0 110 18 9 9 0 010-18zm1 5a1 1 0 00-2 0v4a1 1 0 002 0V6zm-1 6a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" /></svg>',
        //     confirmText: "Yes, delete it",
        //     cancelText: "No, cancel",
        //     confirmClass: "bg-green-600 text-white hover:bg-green-800",
        //     cancelClass: "bg-gray-300 text-black",
        //     popupClass: "bg-blue-100",
        //     backdropClass: "bg-gray-800 bg-opacity-75",
        //     onConfirm: () => console.log("Item deleted")
        // });
    </script>
@endpush
