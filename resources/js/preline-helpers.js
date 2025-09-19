/**
 * Opens a modal dialog by its ID using HSOverlay library
 *
 * @param {string} modalId - The ID of the modal element to open
 * @returns {void}
 */
function openModal(modalId) {
    if (window.HSOverlay && modalId) {
        window.HSOverlay.open(modalId);
    }
}
window.openModal = openModal;

/**
 * Closes a modal dialog by its ID using HSOverlay library
 *
 * @param {string} modalId - The ID of the modal element to close
 * @returns {void}
 */
function closeModal(modalId) {
    if (window.HSOverlay && modalId) {
        window.HSOverlay.close(modalId);
    }
}
window.closeModal = closeModal;

/**
 * Toggles a modal dialog by its ID using HSOverlay library
 *
 * @param {string} modalId - The ID of the modal element to toggle
 * @returns {void}
 */
function toggleModal(modalId) {
    if (window.HSOverlay && modalId) {
        window.HSOverlay.toggle(modalId);
    }
}
window.toggleModal = toggleModal;
