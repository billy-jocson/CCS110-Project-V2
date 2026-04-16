<div class="w-screen h-screen invisible bg-black/0 backdrop-blur-sm z-50 fixed inset-0 flex transition-all duration-400 ease-out"
    id="blurBgMoney">
    <div class="w-[30%] h-fit scale-95 opacity-0 rounded-2xl m-auto p-5 z-51 relative transition-all duration-400 ease-out"
        id="moneyDepositModal">
        <button onclick="closeModalDeposit()"
            class="absolute right-5 bg-white p-1 rounded-lg shadow-sm border border-zinc-400 hover:bg-zinc-200 transition-all cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        <h1 class="text-2xl mb-3 font-bold flex items-center gap-1">
            Deposit
            <svg onmouseover="openToolTip()" onmouseout="closeToolTip()" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>

            <div id="tooltip"
                class="shadow-lg absolute -top-3 left-33 scale-0 z-50 bg-zinc-900 rounded-tl-2xl rounded-tr-2xl rounded-br-2xl p-2 transition-all duration-300 ease-[cubic-bezier(0,1.5,0.7,1)] origin-bottom-left">
                <p class="text-[8pt] text-white font-light">Deposit a money.</p>
            </div>
        </h1>
        <hr class="text-zinc-300">
        <h1 class="w-full text-center text-xl bg-white p-5 rounded-lg my-2 flex flex-col">
            <span class="text-sm">Company Money After Deposit</span>
            <span class="font-bold text-2xl" id="companyMoney" onload="changeMoneyPreview(e, null)">
                ₱
            </span>
        </h1>
        <div class="bg-white flex flex-col gap-1 rounded-lg p-5">
            <label>I want to deposit</label>
            <div class="flex w-full">
                <span class="px-3 py-1 rounded-s-md bg-zinc-300 text-zinc-600">₱</span>
                <input oninput="changeMoneyPreview(event, this)" type="number" placeholder="Enter amount"
                    class="border border-zinc-300 px-3 py-1 rounded-e-lg w-full">
            </div>
            <button
                class=" mt-2 px-3 py-1 bg-sky-600 rounded-lg hover:bg-sky-700 transition-all text-white cursor-pointer">Deposit</button>
        </div>
    </div>
</div>

<script>
    function openToolTip() {
        const tooltip = document.querySelector('#tooltip');
        tooltip.classList.remove('ease-[cubic-bezier(0,0.8,0.9,1)]', 'opacity-0');
        tooltip.classList.add('ease-[cubic-bezier(0,1.5,0.7,1)]');
        tooltip.classList.remove('scale-0');
        tooltip.classList.add('scale-95');
    }

    function closeToolTip() {
        const tooltip = document.querySelector('#tooltip');
        tooltip.classList.remove('scale-95');
        tooltip.classList.add('scale-0');
        tooltip.classList.remove('ease-[cubic-bezier(0,1.5,0.7,1)]');
        tooltip.classList.add('ease-[cubic-bezier(0,0.8,0.9,1)]', 'opacity-0');
    }

    async function changeMoneyPreview(event, input) {
        event.preventDefault();
        const companyMoneyDisplay = document.querySelector('#companyMoney');
        const depositValue = parseFloat(input.value) || 0;

        try {
            const response = await fetch('../src/controllers/getCompanyMoney.php');
            const data = await response.json();
            const currentBalance = parseFloat(data.amount);
            const previewTotal = currentBalance - depositValue;

            companyMoneyDisplay.innerText = `₱${previewTotal.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
        } catch (error) {
            console.error("Error fetching balance:", error);
        }
    }

    function closeModalDeposit() {
        const blurBg = document.querySelector('#blurBgMoney');
        const modal = document.querySelector('#moneyDepositModal');

        blurBg.classList.add('invisible', 'bg-black/0');
        blurBg.classList.remove('backdrop-blur-sm', 'bg-black/50');

        modal.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('scale-100', 'bg-zinc-100');

        const tooltip = document.querySelector('#tooltip');
        if (tooltip.classList.contains('scale-95')) {
            tooltip.classList.remove('scale-95');
            tootltip.classList.add('scale-0');
        }
    }

    function openModalDeposit() {
        const blurBg = document.querySelector('#blurBgMoney');
        const modal = document.querySelector('#moneyDepositModal');

        blurBg.classList.remove('invisible', 'bg-black/0');
        blurBg.classList.add('backdrop-blur-sm', 'bg-black/50');

        modal.classList.remove('scale-95', 'opacity-0');
        modal.classList.add('scale-100', 'bg-zinc-100');
    }
</script>