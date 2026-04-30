<?php
session_start();

if (!isset($_SESSION['fullName'])) {
    header('Location: ../login.php');
}

$fullName = $_SESSION["fullName"];
$isAdmin = $_SESSION["isAdmin"];
$position = $_SESSION['position'];
$employeeId = $_SESSION['employeeId'];

// Check for existing pending resignation on page load
include('../backend/database.php');
$hasPending = false;
$checkStmt = $conn->prepare("SELECT resign_id FROM resignation_request WHERE employee_id = ? AND status = 0");
$checkStmt->bind_param('i', $employeeId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();
if ($checkResult->num_rows > 0) {
    $hasPending = true;
}
$checkStmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Resignation</title>
    <?php include('../assets/fonts/fonts.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="../assets/css/tailwindcss.js"></script>
    <style>
        * {
            font-family: 'DM Sans', sans-serif;
            scrollbar-width: thin;
        }
    </style>
</head>

<body class="bg-zinc-100">
    <div class="flex items-start">
        <?php include '../src/components/sideBar.php'; ?>

        <!-- Main Content -->
        <div class="pt-10 px-10 bg-zinc-100 w-full md:flex-1 min-h-screen md:static md:overflow-y-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="font-bold text-3xl text-zinc-900">Request Resignation</h1>
                <p class="text-zinc-500 text-sm mt-1">Submit your resignation request with your letter of intent and
                    desired end date.</p>
            </div>

            <?php if ($hasPending): ?>
                <!-- Pending Request Banner -->
                <div
                    class="bg-amber-50 border border-amber-300 rounded-2xl p-6 shadow-sm w-full mb-6 flex gap-4 items-start">
                    <i class="fa-solid fa-clock text-amber-500 text-2xl mt-0.5"></i>
                    <div>
                        <h2 class="font-bold text-amber-800 text-lg">Pending Resignation Request</h2>
                        <p class="text-amber-700 text-sm mt-1">You already have a resignation request that is currently
                            under review. You cannot submit a new request until your current one
                            has been processed.</p>
                    </div>
                </div>

            <?php else: ?>
                <!-- Resignation Form Card -->
                <div class="bg-white rounded-2xl p-8 shadow-sm w-full">
                    <form id="resignationForm" onsubmit="submitResignation(event)" class="flex flex-col gap-6">

                        <!-- Request Date (Auto-filled, Read-only) -->
                        <div>
                            <label class="text-sm font-semibold text-zinc-700 mb-2 block">Request Date</label>
                            <input type="date" id="requestDate" readonly
                                class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-sm bg-zinc-50 text-zinc-600">
                        </div>

                        <!-- Letter of Intent -->
                        <div>
                            <label class="text-sm font-semibold text-zinc-700 mb-2 block">Letter of Intent <span
                                    class="text-red-500">*</span></label>
                            <textarea id="letterOfIntent" placeholder="Please write your resignation letter here..."
                                class="w-full border border-zinc-200 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 resize-none"
                                rows="8" required></textarea>
                            <p class="text-xs text-zinc-400 mt-1">Minimum 50 characters recommended</p>
                        </div>

                        <!-- Desired Resignation Date -->
                        <div>
                            <label class="text-sm font-semibold text-zinc-700 mb-2 block">Desired Resignation Date <span
                                    class="text-red-500">*</span></label>
                            <input type="date" id="desiredDate" required
                                class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100">
                            <p class="text-xs text-zinc-400 mt-1">Must be at least 30 days from today</p>
                        </div>

                        <!-- Error/Success Messages -->
                        <div id="messageBox" class="hidden p-4 rounded-lg border text-sm">
                            <p id="messageText"></p>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 pt-2">
                            <button type="button" onclick="resetForm()"
                                class="flex-1 border border-zinc-300 text-zinc-600 font-medium py-2.5 rounded-lg hover:bg-zinc-100 transition-colors cursor-pointer">
                                Clear
                            </button>
                            <button type="submit" id="submitBtn"
                                class="flex-1 bg-sky-600 hover:bg-sky-700 text-white font-medium py-2.5 rounded-lg transition-colors cursor-pointer">
                                Submit Resignation
                            </button>
                        </div>

                    </form>
                </div>
            <?php endif; ?>

            <!-- Info Box -->
            <div class="my-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex gap-3">
                    <i class="fa-solid fa-info-circle text-blue-600 text-lg mt-0.5"></i>
                    <div>
                        <h3 class="font-semibold text-blue-900 text-sm">Important Notice</h3>
                        <p class="text-blue-800 text-sm mt-1">Your resignation request will be reviewed by the Admin or
                            the HR
                            department. Please ensure your desired resignation date allows for a proper transition
                            period. A minimum of 30 days notice is typically required.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fix: use local date string to avoid timezone offset shifting the date
        function getTodayString() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        const today = getTodayString();

        // Set current date as request date
        const requestDateInput = document.getElementById('requestDate');
        if (requestDateInput) {
            requestDateInput.value = today;
        }

        // Set minimum date for desired date (30 days from today)
        const desiredDateInput = document.getElementById('desiredDate');
        if (desiredDateInput) {
            const minDate = new Date();
            minDate.setDate(minDate.getDate() + 30);
            const minYear = minDate.getFullYear();
            const minMonth = String(minDate.getMonth() + 1).padStart(2, '0');
            const minDay = String(minDate.getDate()).padStart(2, '0');
            desiredDateInput.min = `${minYear}-${minMonth}-${minDay}`;
        }

        function resetForm() {
            document.getElementById('resignationForm').reset();
            document.getElementById('requestDate').value = today;
            document.getElementById('messageBox').classList.add('hidden');
        }

        function showMessage(message, type) {
            const messageBox = document.getElementById('messageBox');
            const messageText = document.getElementById('messageText');

            messageText.textContent = message;

            // Clear previous state classes
            messageBox.classList.remove(
                'hidden',
                'bg-red-50', 'text-red-700', 'border-red-200',
                'bg-green-50', 'text-green-700', 'border-green-200'
            );

            if (type === 'error') {
                messageBox.classList.add('bg-red-50', 'text-red-700', 'border-red-200');
            } else {
                messageBox.classList.add('bg-green-50', 'text-green-700', 'border-green-200');
            }
        }

        async function submitResignation(event) {
            event.preventDefault();

            const letterOfIntent = document.getElementById('letterOfIntent').value.trim();
            const desiredDate = document.getElementById('desiredDate').value;
            const requestDate = document.getElementById('requestDate').value;
            const submitBtn = document.getElementById('submitBtn');

            if (!letterOfIntent || letterOfIntent.length < 20) {
                showMessage('Please write a resignation letter (at least 20 characters).', 'error');
                return;
            }

            if (!desiredDate) {
                showMessage('Please select a desired resignation date.', 'error');
                return;
            }

            // Disable button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            submitBtn.classList.add('opacity-60', 'cursor-not-allowed');

            const formData = new FormData();
            formData.append('employeeId', '<?php echo $employeeId; ?>');
            formData.append('letterOfIntent', letterOfIntent);
            formData.append('requestDate', requestDate);
            formData.append('desiredDate', desiredDate);

            try {
                const response = await fetch('../src/controllers/submitResignation.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.status === 'success') {
                    showMessage(data.msg, 'success');
                    submitBtn.textContent = 'Submitted';

                    setTimeout(() => {
                        window.location.href = 'dashboard.php';
                    }, 2000);
                } else {
                    showMessage(data.msg, 'error');
                    // Re-enable button on error
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Submit Resignation';
                    submitBtn.classList.remove('opacity-60', 'cursor-not-allowed');
                }
            } catch (error) {
                showMessage('An error occurred. Please try again.', 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Resignation';
                submitBtn.classList.remove('opacity-60', 'cursor-not-allowed');
            }
        }
    </script>
</body>

</html>