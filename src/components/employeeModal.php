<!-- MODAL -->
<div class="flex invisible bg-black/0 w-full h-full absolute z-55 top-0 left-0 transition-all duration-400 ease-out"
    id="blurBg">
    <div class="bg-zinc-100 w-[30%] h-fit m-auto rounded-2xl p-4 overflow-hidden relative flex flex-col opacity-0 scale-95 transition-all duration-400 ease-out"
        id="employeeDetails">
        <button onclick="closeModal()"
            class="p-1 rounded-md text-zinc-500 transition-all absolute top-5 z-10 right-5 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6 hover:scale-80 transition-all duration-500 ease-out">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <img src="" alt=""
            class="bg-white rounded-full aspect-square object-cover w-20 mx-auto relative top-16 shadow-sm z-5"
            id="profilePicture">

        <div class="w-[94%] h-28 rounded-lg bg-cover bg-center absolute z-4 top-0 left-0 m-3"
            style="background-image: url('../assets/images/Cover_Photo.jpg');">
        </div>

        <div class="mt-20">
            <p class="text-center text-sm text-zinc-500/60" id="username"></p>
            <h1 class="text-2xl text-center" id="name"></h1>
            <p class="text-center text-sm italic text-zinc-500" id="position"></p>
        </div>

        <div class="bg-white mt-5 p-5 rounded-xl flex flex-col gap-1">
            <h1 class="text-2xl">Salary Structure</h1>

            <div class="flex justify-between text-sm">
                <h1 class="text-zinc-400">Base Pay</h1>
                <h1 id="basePay"></h1>
            </div>
            <div class="flex justify-between text-sm">
                <h1 class="text-zinc-400">Bonus</h1>
                <div
                    class="flex items-center rounded-xl border border-[#a9a4cc] overflow-hidden h-7 focus-within:border-[#6c65b0] focus-within:ring-1 focus-within:ring-[#6c65b0]/20 transition-all bg-white">
                    <div
                        class="flex items-center justify-center bg-[#9b96c8] text-white text-sm font-semibold w-9 h-full shrink-0">
                        $
                    </div>
                    <input type="text" id="bonusInput"
                        class="flex-1 h-full px-1 text-right text-sm text-gray-800 bg-transparent outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" />
                </div>
            </div>
            <div class="flex justify-between text-sm">
                <h1 class="text-zinc-400">Deduction</h1>
                <div
                    class="flex items-center rounded-xl border border-[#a9a4cc] overflow-hidden h-7 focus-within:border-[#6c65b0] focus-within:ring-1 focus-within:ring-[#6c65b0]/20 transition-all bg-white">
                    <div
                        class="flex items-center justify-center bg-[#9b96c8] text-white text-sm font-semibold w-9 h-full shrink-0">
                        $
                    </div>
                    <input type="text" id="deducInput"
                        class="flex-1 h-full px-1 text-right text-sm text-gray-800 bg-transparent outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" />
                </div>
            </div>
            <hr class="my-2 text-zinc-200">
            <div class="flex justify-between text-sm">
                <h1 class="text-zinc-400">Net Salary</h1>
                <h1 id="netSalary"></h1>
            </div>
            <div class="mt-10 flex justify-between">
                <button onclick="closeModal()"
                    class="text-sm border border-zinc-700 text-zinc-700 rounded-lg cursor-pointer px-3 py-1 hover:bg-zinc-800 hover:text-white transition-colors">
                    Close
                </button>
                <button id="givePayrollBtn"
                    class="text-sm bg-sky-700 text-white rounded-lg cursor-pointer px-3 py-1 hover:bg-sky-800 transition-colors flex items-center gap-2">Give
                    Payroll
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function closeModal() {
        blurBg.classList.add('bg-black/0', 'invisible');
        blurBg.classList.remove('bg-black/50', 'backdrop-blur-sm');

        employeeDetails.classList.add('opacity-0', 'scale-95');
        employeeDetails.classList.remove('opacity-100', 'scale-100');
    }
</script>