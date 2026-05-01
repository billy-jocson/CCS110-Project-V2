<!-- ADD EMPLOYEE MODAL (2-step) -->
<div id="addModalBg"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center invisible opacity-0 transition-all duration-300">
    <div id="addModal"
        class="bg-white rounded-2xl p-7 w-full max-w-md shadow-xl scale-95 opacity-0 transition-all duration-300">

        <h2 class="text-2xl font-bold text-zinc-900 mb-5">Add Employee</h2>

        <!-- STEP 1 -->
        <div id="addStep1">
            <div class="flex flex-col gap-4">
                <div>
                    <label class="text-xs text-zinc-500 mb-1 block">Department</label>
                    <select id="addDept" onchange="loadAddPositions(this.value)"
                        class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400 bg-white">
                        <option value="">Select Department</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <div class="flex-1">
                        <label class="text-xs text-zinc-500 mb-1 block">First Name</label>
                        <input id="addFirstName" type="text"
                            class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400"
                            placeholder="Billy John">
                    </div>
                    <div class="flex-1">
                        <label class="text-xs text-zinc-500 mb-1 block">Last Name</label>
                        <input id="addLastName" type="text"
                            class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400"
                            placeholder="Jocson">
                    </div>
                </div>
                <div>
                    <label class="text-xs text-zinc-500 mb-1 block">Contact Number</label>
                    <input id="addContact" type="text"
                        class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400"
                        placeholder="09XXXXXXXXX">
                </div>
                <div>
                    <label class="text-xs text-zinc-500 mb-1 block">Position</label>
                    <select id="addPosition"
                        class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400 bg-white">
                        <option value="">Select Position</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button onclick="closeAddModal()"
                    class="flex-1 border border-zinc-300 text-zinc-600 text-sm font-medium py-2.5 rounded-lg hover:bg-zinc-100 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button onclick="goToStep2()"
                    class="flex-1 bg-zinc-900 hover:bg-zinc-700 text-white text-sm font-medium py-2.5 rounded-lg transition-colors cursor-pointer">
                    Next
                </button>
            </div>
        </div>

        <!-- STEP 2 -->
        <div id="addStep2" class="hidden">
            <div class="flex flex-col gap-4">
                <div>
                    <label class="text-xs text-zinc-500 mb-1 block">Portrait Picture</label>
                    <input id="addProfilePicture" type="file" accept="image/*"
                        class="w-full text-sm text-zinc-500 border border-zinc-200 rounded-lg px-3 py-2
                               file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0
                               file:bg-zinc-100 file:text-zinc-600 hover:file:bg-zinc-200 cursor-pointer">
                </div>
                <div>
                    <label class="text-xs text-zinc-500 mb-1 block">Username</label>
                    <input id="addUsername" type="text"
                        class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400"
                        placeholder="Enter username">
                </div>
                <div>
                    <label class="text-xs text-zinc-500 mb-1 block">Password</label>
                    <input id="addPassword" type="password"
                        class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400"
                        placeholder="Enter password">
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button onclick="goToStep1()"
                    class="flex-1 border border-zinc-300 text-zinc-600 text-sm font-medium py-2.5 rounded-lg hover:bg-zinc-100 transition-colors cursor-pointer">
                    Back
                </button>
                <button onclick="submitAdd()"
                    class="flex-1 bg-sky-600 hover:bg-sky-700 text-white text-sm font-medium py-2.5 rounded-lg transition-colors cursor-pointer">
                    Add Employee
                </button>
            </div>
        </div>

    </div>
</div>
