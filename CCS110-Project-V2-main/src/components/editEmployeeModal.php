<!-- EDIT EMPLOYEE MODAL -->
<div id="editModalBg"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center invisible opacity-0 transition-all duration-300">
    <div id="editModal"
        class="bg-white rounded-2xl p-7 w-full max-w-2xl shadow-xl scale-95 opacity-0 transition-all duration-300">

        <h2 class="text-2xl font-bold text-zinc-900 mb-1">Edit Employee</h2>
        <p class="text-xs text-zinc-400 mb-5">Update the employee's information below.</p>

        <form id="editForm" onsubmit="submitEdit(event)" enctype="multipart/form-data">
            <input type="hidden" id="editEmployeeId">
            <input type="hidden" id="editUserId">

            <div class="flex gap-6">
                <!-- Fields -->
                <div class="flex-1 flex flex-col gap-3">
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <label class="text-xs text-zinc-500 mb-1 block">First Name</label>
                            <div class="flex items-center border border-zinc-200 rounded-lg px-3 py-2 gap-2 focus-within:border-sky-400">
                                <span class="text-zinc-400 text-xs">A.</span>
                                <input id="editFirstName" type="text" class="w-full text-sm outline-none" placeholder="Juan" required>
                            </div>
                        </div>
                        <div class="flex-1">
                            <label class="text-xs text-zinc-500 mb-1 block">Last Name</label>
                            <div class="flex items-center border border-zinc-200 rounded-lg px-3 py-2 gap-2 focus-within:border-sky-400">
                                <span class="text-zinc-400 text-xs">A.</span>
                                <input id="editLastName" type="text" class="w-full text-sm outline-none" placeholder="Dela Cruz" required>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 mb-1 block">Contact Number</label>
                        <div class="flex items-center border border-zinc-200 rounded-lg px-3 py-2 gap-2 focus-within:border-sky-400">
                            <i class="fa-solid fa-phone text-zinc-300 text-xs"></i>
                            <input id="editContact" type="text" class="w-full text-sm outline-none" placeholder="09XXXXXXXXX" required>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 mb-1 block">Username</label>
                        <div class="flex items-center border border-zinc-200 rounded-lg px-3 py-2 gap-2 focus-within:border-sky-400">
                            <span class="text-zinc-300 text-xs">@</span>
                            <input id="editUsername" type="text" class="w-full text-sm outline-none" placeholder="username123" required>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 mb-1 block">Password</label>
                        <div class="flex items-center border border-zinc-200 rounded-lg px-3 py-2 gap-2 focus-within:border-sky-400">
                            <i class="fa-solid fa-lock text-zinc-300 text-xs"></i>
                            <input id="editPassword" type="password" class="w-full text-sm outline-none" placeholder="Leave blank to keep current">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 mb-1 block">Department</label>
                        <select id="editDept" onchange="loadEditPositions(this.value)"
                            class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400 bg-white">
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 mb-1 block">Position</label>
                        <select id="editPosition"
                            class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-sky-400 bg-white">
                        </select>
                    </div>
                </div>

                <!-- Profile picture -->
                <div class="flex flex-col items-center gap-3 w-36 pt-2">
                    <img id="editProfilePreview" src="../assets/images/DefaultPFP.png" alt="Profile"
                        class="w-28 h-28 rounded-full object-cover shadow-md border border-zinc-200">
                    <label class="text-xs text-sky-600 cursor-pointer hover:underline text-center">
                        Change Profile Picture
                        <input id="editProfilePicture" name="profilePicture" type="file" accept="image/*"
                            class="hidden" onchange="previewEditPhoto(this)">
                    </label>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="button" onclick="closeEditModal()"
                    class="text-sm border border-zinc-300 text-zinc-600 rounded-lg px-5 py-2 hover:bg-zinc-100 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="submit"
                    class="text-sm bg-sky-600 text-white rounded-lg px-5 py-2 hover:bg-sky-700 transition-colors cursor-pointer">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
