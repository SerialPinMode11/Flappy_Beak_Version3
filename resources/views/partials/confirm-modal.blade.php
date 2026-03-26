<div id="confirm-modal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-md rounded-xl bg-white shadow-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-base font-semibold text-gray-800">Please confirm</h3>
            <button type="button" id="confirm-modal-close" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="px-5 py-4">
            <p id="confirm-modal-message" class="text-sm text-gray-700">Are you sure?</p>
        </div>
        <div class="px-5 py-3 border-t border-gray-200 flex justify-end gap-2">
            <button type="button" id="confirm-modal-cancel" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                Cancel
            </button>
            <button type="button" id="confirm-modal-confirm" class="px-4 py-2 text-sm font-medium rounded-lg bg-red-600 text-white hover:bg-red-700">
                Confirm
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('confirm-modal');
    const messageEl = document.getElementById('confirm-modal-message');
    const btnConfirm = document.getElementById('confirm-modal-confirm');
    const btnCancel = document.getElementById('confirm-modal-cancel');
    const btnClose = document.getElementById('confirm-modal-close');
    if (!modal || !messageEl || !btnConfirm || !btnCancel || !btnClose) return;

    let onConfirm = null;
    let triggerEl = null;

    function open(message, confirmAction, sourceEl) {
        onConfirm = typeof confirmAction === 'function' ? confirmAction : null;
        triggerEl = sourceEl || null;
        messageEl.textContent = message || 'Are you sure?';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function close() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        onConfirm = null;
        triggerEl = null;
    }

    window.showConfirmModal = open;

    btnConfirm.addEventListener('click', function () {
        if (onConfirm) onConfirm();
        close();
    });
    btnCancel.addEventListener('click', close);
    btnClose.addEventListener('click', close);
    modal.addEventListener('click', function (e) {
        if (e.target === modal) close();
    });

    // Generic handler for forms/buttons using data-confirm
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (!(form instanceof HTMLFormElement)) return;
        const msg = form.getAttribute('data-confirm');
        if (!msg || form.dataset.confirmed === 'true') return;

        e.preventDefault();
        open(msg, function () {
            form.dataset.confirmed = 'true';
            form.submit();
            delete form.dataset.confirmed;
        }, form);
    }, true);

    document.addEventListener('click', function (e) {
        const el = e.target.closest('[data-confirm]');
        if (!el) return;
        if (el.tagName === 'FORM') return;

        const msg = el.getAttribute('data-confirm');
        if (!msg) return;

        const form = el.closest('form');
        if (!form) return;

        e.preventDefault();
        open(msg, function () {
            form.dataset.confirmed = 'true';
            form.submit();
            delete form.dataset.confirmed;
        }, el);
    }, true);
})();
</script>
