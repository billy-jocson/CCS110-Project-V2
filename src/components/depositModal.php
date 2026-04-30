<<<<<<< HEAD
<div class="w-screen h-screen invisible bg-black/0 backdrop-blur-sm z-50 fixed inset-0 flex transition-all duration-300 ease-out shadow-lg"
    id="blurBgMoney">
    <div class="w-[30%] h-fit scale-95 opacity-0 rounded-2xl m-auto p-5 z-51 relative transition-all duration-300 ease-out"
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
                class="w-48 shadow-lg absolute -top-3 left-33 scale-0 z-50 bg-zinc-900 rounded-tl-xl rounded-tr-xl rounded-br-xl p-2 transition-all duration-300 ease-[cubic-bezier(0,1.5,0.7,1)] origin-bottom-left">
                <p class="text-[8pt] text-white font-light">The amount entered will be added to the
                    company's money.</p>
            </div>
        </h1>
        <hr class="text-zinc-300">
        <h1 class="w-full text-center text-xl bg-white p-5 rounded-lg my-2 flex flex-col">
            <span class="text-sm">Company Money After Deposit</span>
            <span class="font-bold text-2xl" id="companyMoney">
                ₱
            </span>
        </h1>
        <div class="bg-white flex flex-col gap-1 rounded-lg p-5">
            <label>I want to deposit</label>
            <div class="flex flex-col">
                <div class="flex w-full">
                    <span class="px-3 py-1 rounded-s-md bg-zinc-300 text-zinc-600">₱</span>
                    <input oninput="changeMoneyPreview(event, this)" id="depositValue" type="number"
                        placeholder="Enter amount" class="border border-zinc-300 px-3 py-1 rounded-e-lg w-full"
                        max="500000">
                </div>
                <small class="text-center my-2">₱500,000 deposit limit only.</small>
                <button onclick="depositMoney(event)"
                    class="px-3 py-1 bg-sky-600 rounded-lg hover:bg-sky-700 transition-all text-white cursor-pointer">Deposit</button>
            </div>
        </div>
    </div>
</div>

<div class="w-full h-screen bg-black/0 backdrop-blur-sm invisible fixed inset-0 z-65 transition-all duration-300 ease-out"
    id="successDepositBg">
    <div class="fixed inset-0 bg-white scale-95 top-0 z-55 w-fit h-fit p-15 m-auto shadow-lg rounded-xl flex flex-col transition-all duration-300 ease-out"
        id="successDepositModal">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-green-600 size-15 mx-auto mb-5">
                <path fill-rule="evenodd"
                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                    clip-rule="evenodd" />
            </svg>

            <h1 class="text-2xl">Deposit Successful!</h1>
            <p class="w-52 text-sm">Money has been deposited to the company's bank.</p>
        </div>
        <button onclick="closeSuccessModal()"
            class="mx-auto mt-5 px-3 py-1 bg-zinc-50 shadow-md rounded-full border border-zinc-400 cursor-pointer hover:bg-zinc-200 transition-all">Continue</button>
    </div>
</div>

<script>
    async function fetchCompanyMoney() {
        const responseCompanyMoney = await fetch('../src/controllers/getCompanyMoney.php');
        const companyMoney = await responseCompanyMoney.json();
        const currentBalance = parseFloat(companyMoney.amount) || 0;
        return currentBalance;
    }

    async function depositMoney(event) {
        event.preventDefault();
        const successDepositBg = document.querySelector('#successDepositBg');
        const successDepositModal = document.querySelector('#successDepositModal');
        const depositValue = document.querySelector('#depositValue').value;
        const currentBalance = await fetchCompanyMoney();

        const formData = new FormData();
        formData.append('deposit', depositValue);
        formData.append('companyMoney', currentBalance);

        const responseDeposit = await fetch('../src/controllers/depositMoney.php', { method: "POST", body: formData });
        const dataDeposit = await responseDeposit.json();

        if (dataDeposit.status === "success") {
            closeModalDeposit();
            successDepositBg.classList.remove('invisible', 'bg-black/0');
            successDepositBg.classList.add('bg-black/50', 'backdrop-blur-sm');

            successDepositModal.classList.remove('scale-95', 'opacity-0');
            successDepositModal.classList.add('scale-100');
        }
    }

    async function closeSuccessModal() {
        const successDepositBg = document.querySelector('#successDepositBg');
        const successDepositModal = document.querySelector('#successDepositModal');

        const updatedBalance = await fetchCompanyMoney();

        const formatted = updatedBalance.toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        document.querySelector('#companyMoneyDashboard').innerText = `₱${formatted}`;
        document.querySelector('#companyMoney').innerText = `₱${formatted}`;

        successDepositBg.classList.remove('bg-black/50', 'backdrop-blur-sm');
        successDepositBg.classList.add('invisible', 'bg-black/0');
        successDepositModal.classList.add('scale-95', 'opacity-0');
    }

    async function getMoney() {
        const companyMoneyDashboard = document.querySelector('#companyMoneyDashboard');
        const companyMoneyDisplay = document.querySelector('#companyMoney');
        try {
            const currentBalance = await fetchCompanyMoney();
            companyMoneyDisplay.innerText = `₱${currentBalance.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            companyMoneyDashboard.innerText = `₱${currentBalance.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        } catch (error) {
            console.error('Fetch/getMoney error:', error);
        }
    }

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
        tooltip.classList.add('ease-[cubic-bezier(1, 0.5, 0.4, 0)]', 'opacity-0');
    }

    let previewTimeout;

    async function changeMoneyPreview(event, input) {
        clearTimeout(previewTimeout);

        previewTimeout = setTimeout(async () => {
            const companyMoneyDisplay = document.querySelector('#companyMoney');
            const depositValue = parseFloat(input.value) || 0;

            try {
                const response = await fetch('../src/controllers/getCompanyMoney.php');
                const data = await response.json();
                const currentBalance = parseFloat(data.amount);

                const previewTotal = currentBalance + depositValue;
                companyMoneyDisplay.innerText = `₱${previewTotal.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            } catch (error) {
                console.error("JSON Parsing or Fetch Error:", error);
            }
        }, 500);
    }

    function closeModalDeposit() {
        const blurBg = document.querySelector('#blurBgMoney');
        const modal = document.querySelector('#moneyDepositModal');
        const inputField = document.querySelector('#depositValue');

        blurBg.classList.add('invisible', 'bg-black/0');
        blurBg.classList.remove('backdrop-blur-sm', 'bg-black/50');

        modal.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('scale-100', 'bg-zinc-100');
        document.querySelector('#depositValue').value = "";
    }

    function openModalDeposit() {
        const blurBg = document.querySelector('#blurBgMoney');
        const modal = document.querySelector('#moneyDepositModal');

        blurBg.classList.remove('invisible', 'bg-black/0');
        blurBg.classList.add('backdrop-blur-sm', 'bg-black/50');

        modal.classList.remove('scale-95', 'opacity-0');
        modal.classList.add('scale-100', 'bg-zinc-100');

        getMoney();
    }

    document.addEventListener('DOMContentLoaded', getMoney);
=======
<div class="w-screen h-screen invisible bg-black/0 backdrop-blur-sm z-50 fixed inset-0 flex transition-all duration-300 ease-out shadow-lg"
    id="blurBgMoney">
    <div class="w-[30%] h-fit scale-95 opacity-0 rounded-2xl m-auto p-5 z-51 relative transition-all duration-300 ease-out"
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
                class="w-48 shadow-lg absolute -top-3 left-33 scale-0 z-50 bg-zinc-900 rounded-tl-xl rounded-tr-xl rounded-br-xl p-2 transition-all duration-300 ease-[cubic-bezier(0,1.5,0.7,1)] origin-bottom-left">
                <p class="text-[8pt] text-white font-light">The amount entered will be added to the
                    company's money.</p>
            </div>
        </h1>
        <hr class="text-zinc-300">
        <h1 class="w-full text-center text-xl bg-white p-5 rounded-lg my-2 flex flex-col">
            <span class="text-sm">Company Money After Deposit</span>
            <span class="font-bold text-2xl" id="companyMoney">
                ₱
            </span>
        </h1>
        <div class="bg-white flex flex-col gap-1 rounded-lg p-5">
            <label>I want to deposit</label>
            <div class="flex flex-col">
                <div class="flex w-full">
                    <span class="px-3 py-1 rounded-s-md bg-zinc-300 text-zinc-600">₱</span>
                    <input oninput="changeMoneyPreview(event, this)" id="depositValue" type="number"
                        placeholder="Enter amount" class="border border-zinc-300 px-3 py-1 rounded-e-lg w-full"
                        max="500000">
                </div>
                <small class="text-center my-2">₱500,000 deposit limit only.</small>
                <button onclick="depositMoney(event)"
                    class="px-3 py-1 bg-sky-600 rounded-lg hover:bg-sky-700 transition-all text-white cursor-pointer">Deposit</button>
            </div>
        </div>
    </div>
</div>

<div class="w-full h-screen bg-black/0 backdrop-blur-sm invisible fixed inset-0 z-65 transition-all duration-300 ease-out"
    id="successDepositBg">
    <div class="fixed inset-0 bg-white scale-95 top-0 z-55 w-fit h-fit p-15 m-auto shadow-lg rounded-xl flex flex-col transition-all duration-300 ease-out"
        id="successDepositModal">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-green-600 size-15 mx-auto mb-5">
                <path fill-rule="evenodd"
                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                    clip-rule="evenodd" />
            </svg>

            <h1 class="text-2xl">Deposit Successful!</h1>
            <p class="w-52 text-sm">Money has been deposited to the company's bank.</p>
        </div>
        <button onclick="closeSuccessModal()"
            class="mx-auto mt-5 px-3 py-1 bg-zinc-50 shadow-md rounded-full border border-zinc-400 cursor-pointer hover:bg-zinc-200 transition-all">Continue</button>
    </div>
</div>

<script>
    async function fetchCompanyMoney() {
        const responseCompanyMoney = await fetch('../src/controllers/getCompanyMoney.php');
        const companyMoney = await responseCompanyMoney.json();
        const currentBalance = parseFloat(companyMoney.amount) || 0;
        return currentBalance;
    }

    async function depositMoney(event) {
        event.preventDefault();
        const successDepositBg = document.querySelector('#successDepositBg');
        const successDepositModal = document.querySelector('#successDepositModal');
        const depositValue = document.querySelector('#depositValue').value;
        const currentBalance = await fetchCompanyMoney();

        const formData = new FormData();
        formData.append('deposit', depositValue);
        formData.append('companyMoney', currentBalance);

        const responseDeposit = await fetch('../src/controllers/depositMoney.php', { method: "POST", body: formData });
        const dataDeposit = await responseDeposit.json();

        if (dataDeposit.status === "success") {
            closeModalDeposit();
            successDepositBg.classList.remove('invisible', 'bg-black/0');
            successDepositBg.classList.add('bg-black/50', 'backdrop-blur-sm');

            successDepositModal.classList.remove('scale-95', 'opacity-0');
            successDepositModal.classList.add('scale-100');
        }
    }

    async function closeSuccessModal() {
        const successDepositBg = document.querySelector('#successDepositBg');
        const successDepositModal = document.querySelector('#successDepositModal');

        const updatedBalance = await fetchCompanyMoney();

        const formatted = updatedBalance.toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        document.querySelector('#companyMoneyDashboard').innerText = `₱${formatted}`;
        document.querySelector('#companyMoney').innerText = `₱${formatted}`;

        successDepositBg.classList.remove('bg-black/50', 'backdrop-blur-sm');
        successDepositBg.classList.add('invisible', 'bg-black/0');
        successDepositModal.classList.add('scale-95', 'opacity-0');
    }

    async function getMoney() {
        const companyMoneyDashboard = document.querySelector('#companyMoneyDashboard');
        const companyMoneyDisplay = document.querySelector('#companyMoney');
        try {
            const currentBalance = await fetchCompanyMoney();
            companyMoneyDisplay.innerText = `₱${currentBalance.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            companyMoneyDashboard.innerText = `₱${currentBalance.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        } catch (error) {
            console.error('Fetch/getMoney error:', error);
        }
    }

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
        tooltip.classList.add('ease-[cubic-bezier(1, 0.5, 0.4, 0)]', 'opacity-0');
    }

    let previewTimeout;

    async function changeMoneyPreview(event, input) {
        clearTimeout(previewTimeout);

        previewTimeout = setTimeout(async () => {
            const companyMoneyDisplay = document.querySelector('#companyMoney');
            const depositValue = parseFloat(input.value) || 0;

            try {
                const response = await fetch('../src/controllers/getCompanyMoney.php');
                const data = await response.json();
                const currentBalance = parseFloat(data.amount);

                const previewTotal = currentBalance + depositValue;
                companyMoneyDisplay.innerText = `₱${previewTotal.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            } catch (error) {
                console.error("JSON Parsing or Fetch Error:", error);
            }
        }, 500);
    }

    function closeModalDeposit() {
        const blurBg = document.querySelector('#blurBgMoney');
        const modal = document.querySelector('#moneyDepositModal');
        const inputField = document.querySelector('#depositValue');

        blurBg.classList.add('invisible', 'bg-black/0');
        blurBg.classList.remove('backdrop-blur-sm', 'bg-black/50');

        modal.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('scale-100', 'bg-zinc-100');
        document.querySelector('#depositValue').value = "";
    }

    function openModalDeposit() {
        const blurBg = document.querySelector('#blurBgMoney');
        const modal = document.querySelector('#moneyDepositModal');

        blurBg.classList.remove('invisible', 'bg-black/0');
        blurBg.classList.add('backdrop-blur-sm', 'bg-black/50');

        modal.classList.remove('scale-95', 'opacity-0');
        modal.classList.add('scale-100', 'bg-zinc-100');

        getMoney();
    }

    document.addEventListener('DOMContentLoaded', getMoney);
>>>>>>> c282d3b091bf6f3005d7ecc2311a5d95b4063715
</script>