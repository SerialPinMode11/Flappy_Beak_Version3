{{-- Admin logout confirmation modal --}}
<div id="admin-logout-modal" class="fixed inset-0 z-[9998] hidden" aria-modal="true" role="dialog" aria-labelledby="admin-logout-modal-title">
    <div class="absolute inset-0 bg-black/50" id="admin-logout-modal-backdrop"></div>
    <div class="fixed left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-2xl shadow-xl p-6 z-10">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-sign-out-alt text-amber-600 text-xl"></i>
            </div>
            <h2 id="admin-logout-modal-title" class="text-xl font-semibold text-gray-800">Log out of Admin?</h2>
        </div>
        <p class="text-gray-600 text-sm mb-6">Are you sure you want to log out? You can use this to confirm before signing out.</p>
        <div class="flex gap-3 justify-end">
            <button type="button" id="admin-logout-modal-cancel" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium transition-colors">Cancel</button>
            <button type="button" id="admin-logout-modal-confirm" class="px-4 py-2 rounded-lg bg-[#ff6b6b] text-white hover:bg-red-600 font-medium transition-colors">Yes, log out</button>
        </div>
    </div>
</div>
<script>
(function() {
    var modal = document.getElementById('admin-logout-modal');
    var form = document.getElementById('admin-logout-form');
    if (!modal || !form) return;
    function openModal() { modal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
    function closeModal() { modal.classList.add('hidden'); document.body.style.overflow = ''; }
    document.getElementById('admin-logout-trigger')?.addEventListener('click', openModal);
    document.getElementById('admin-logout-modal-cancel')?.addEventListener('click', closeModal);
    document.getElementById('admin-logout-modal-backdrop')?.addEventListener('click', closeModal);
    document.getElementById('admin-logout-modal-confirm')?.addEventListener('click', function() { closeModal(); form.submit(); });
})();
</script>
