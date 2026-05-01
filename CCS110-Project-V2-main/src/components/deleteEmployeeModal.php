<!-- DELETE EMPLOYEE MODAL -->
<div id="deleteModalBg"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center invisible opacity-0 transition-all duration-300">
    <div id="deleteModal"
        class="bg-white rounded-2xl p-7 w-full max-w-sm shadow-xl scale-95 opacity-0 transition-all duration-300">
        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4">
            <i class="fa-solid fa-trash text-red-500 text-lg"></i>
        </div>
        <h2 class="text-xl font-bold text-zinc-900 mb-1">Delete Employee</h2>
        <p class="text-sm text-zinc-500 mb-6">Are you sure you want to remove
            <span id="deleteEmployeeName" class="font-semibold text-zinc-700"></span>?
            This action cannot be undone.
        </p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()"
                class="flex-1 border border-zinc-300 text-zinc-600 text-sm font-medium py-2.5 rounded-lg hover:bg-zinc-100 transition-colors cursor-pointer">
                Cancel
            </button>
            <button id="confirmDeleteBtn"
                class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-2.5 rounded-lg transition-colors cursor-pointer">
                Delete
            </button>
        </div>
    </div>
</div>
