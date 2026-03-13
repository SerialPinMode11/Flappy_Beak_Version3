{{-- Global toast container: use window.showToast(message, 'success'|'error'|'info') --}}
<div id="toast-container" class="fixed top-4 right-4 z-[9999] flex flex-col gap-3 max-w-sm w-full pointer-events-none" aria-live="polite"></div>

<style>
#toast-container .toast-item {
    pointer-events: auto;
    animation: toast-slide-in 0.3s ease-out;
}
@keyframes toast-slide-in {
    from { opacity: 0; transform: translateX(100%); }
    to { opacity: 1; transform: translateX(0); }
}
#toast-container .toast-item.hiding {
    animation: toast-slide-out 0.25s ease-in forwards;
}
@keyframes toast-slide-out {
    to { opacity: 0; transform: translateX(100%); }
}
</style>

<script>
(function() {
    const container = document.getElementById('toast-container');
    if (!container) return;

    window.showToast = function(message, type) {
        type = type || 'info';
        const id = 'toast-' + Date.now();
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            info: 'fa-info-circle'
        };
        const bg = {
            success: 'bg-emerald-50 border-emerald-500 text-emerald-800',
            error: 'bg-red-50 border-red-500 text-red-800',
            info: 'bg-sky-50 border-sky-500 text-sky-800'
        };
        const el = document.createElement('div');
        el.id = id;
        el.className = 'toast-item shadow-lg rounded-lg border-l-4 p-4 flex items-start gap-3 ' + bg[type];
        el.setAttribute('role', 'alert');
        el.innerHTML = '<i class="fas ' + icons[type] + ' mt-0.5 flex-shrink-0"></i><span class="flex-1 text-sm font-medium">' + (message || '') + '</span><button type="button" class="toast-dismiss text-current opacity-60 hover:opacity-100" aria-label="Dismiss"><i class="fas fa-times"></i></button>';
        container.appendChild(el);

        const dismiss = function() {
            el.classList.add('hiding');
            setTimeout(function() { el.remove(); }, 260);
        };

        el.querySelector('.toast-dismiss').addEventListener('click', dismiss);
        setTimeout(dismiss, 5000);
    };

    // Show session flash as toasts on load
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showToast({{ json_encode(session('success')) }}, 'success');
        @endif
        @if(session('error'))
            showToast({{ json_encode(session('error')) }}, 'error');
        @endif
    });
})();
</script>
