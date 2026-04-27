<?php
include('../backend/database.php');

$query = "SELECT amount FROM company_transactions ORDER BY transaction_id DESC LIMIT 2";
$result = mysqli_query($conn, $query);

// New Value
$row1 = mysqli_fetch_assoc($result);
$newValue = $row1['amount'] ?? 0;

// Old Value
$row2 = mysqli_fetch_assoc($result);
$oldValue = $row2['amount'] ?? 0;

// Calculate Percentage Change: ((New - Old) / Old) * 100
$percentChange = 0;
if ($oldValue != 0) {
    $percentChange = (($newValue - $oldValue) / $oldValue) * 100;
}
?>

<div class="w-56 flex flex-col justify-center bg-gradient-to-b from-green-500 to-green-800 rounded-lg p-5 flex-grow-1">
    <div class="mb-3 relative isolate">
        <div class="absolute -top-6 -right-15 opacity-35 -z-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
                class="size-40">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <h1 class="text-white font-extrabold text-2xl" id="companyMoneyDashboard">
            ₱
        </h1>
        <h1 class="text-white text-sm">Company Revenue</h1>
    </div>
    <div class="flex gap-1 relative z-10">
        <p class="px-4 py-1 text-center rounded-lg font-bold <?php
        echo ($percentChange > 0)
            ? "text-green-700 bg-green-50"
            : (($percentChange < 0) ? "text-red-700 bg-red-50" : "text-zinc-700 bg-zinc-50");
        ?>" id="companyMoneyPercent">
            <?php echo round($percentChange, 2); ?>%
        </p>
        <button onclick="openModalDeposit()"
            class="px-4 py-1 bg-green-50 text-green-700 text-center rounded-lg font-bold cursor-pointer hover:bg-green-200 transition-all">Deposit</button>
    </div>
</div>