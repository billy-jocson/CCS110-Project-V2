<?php
include('../backend/database.php');

$employeeId = $_SESSION['employeeId'];

// Determine which query to run based on user role
if ($isAdmin == 0) {
    $sql = "SELECT sh.transaction_id, sh.employee_id, sh.date, sh.salary_amount, 
                    sh.base_pay, sh.bonus, sh.deduction,
                    CONCAT(e.first_name, ' ', e.last_name) as full_name
                FROM salary_history sh
                JOIN employees e ON sh.employee_id = e.employee_id
                WHERE sh.employee_id = ?
                ORDER BY sh.date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $employeeId);
    $stmt->execute();
    $query = $stmt->get_result();
    $isEmployeeView = true;
} else {
    $sql = "SELECT sh.transaction_id, sh.employee_id, sh.date, sh.salary_amount, 
                    sh.base_pay, sh.bonus, sh.deduction,
                    CONCAT(e.first_name, ' ', e.last_name) as full_name
                FROM salary_history sh
                LEFT JOIN employees e ON sh.employee_id = e.employee_id
                ORDER BY sh.date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $query = $stmt->get_result();
    $isEmployeeView = false;
}

// Load jsPDF via CDN
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>';

if ($query->num_rows == 0) {
    echo "<img src='../assets/images/noHistoryFound.svg' alt='No History Found' class='w-52 relative -left-5 mx-auto'>";
    echo "<h1 class='text-zinc-600 font-medium text-center mt-5'>No history of payroll found.</h1>";
} else {
    // Collect all rows as JSON for JS use
    $rows = [];
    while ($row = $query->fetch_assoc()) {
        $rows[] = $row;
    }

    $companyName = "PayFlow";
    $rowsJson = json_encode($rows);
    $isEmployeeViewJson = $isEmployeeView ? 'true' : 'false';
    $currentEmployee = htmlspecialchars($fullName);

    echo '
    <div>
        <h1 class="font-bold text-3xl text-zinc-900">Payroll History</h1>
        <p class="text-zinc-500 text-sm mt-1">' . ($isEmployeeView ? 'Your Transaction History' : 'All Employees Transaction History') . '</p>
        <div class="overflow-x-auto bg-white shadow-md rounded-xl mt-10">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="bg-gradient-to-r from-sky-500 to-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Transaction ID</th>';

    if (!$isEmployeeView) {
        echo '<th class="px-6 py-3 font-semibold">Employee</th>';
    }

    echo '
                        <th class="px-6 py-3 font-semibold">Date</th>
                        <th class="px-6 py-3 font-semibold">Base Pay</th>
                        <th class="px-6 py-3 font-semibold">Bonus</th>
                        <th class="px-6 py-3 font-semibold">Deduction</th>
                        <th class="px-6 py-3 font-semibold">Net Salary</th>
                        <th class="px-6 py-3 font-semibold text-center">Payslip</th>
                    </tr>
                </thead>
                <tbody class="divide-y">';

    foreach ($rows as $row) {
        $transactionId = htmlspecialchars($row['transaction_id']);
        $fullNameEsc = htmlspecialchars($row['full_name']);
        $dateFormatted = date("M d, Y", strtotime($row['date']));
        $basePay = number_format($row['base_pay'], 2);
        $bonus = number_format($row['bonus'], 2);
        $deduction = number_format($row['deduction'], 2);
        $netSalary = number_format($row['salary_amount'], 2);

        // Encode data attributes for JS
        $dataAttrs = "data-id=\"{$transactionId}\"
                      data-name=\"{$fullNameEsc}\"
                      data-date=\"{$dateFormatted}\"
                      data-base=\"{$basePay}\"
                      data-bonus=\"{$bonus}\"
                      data-deduction=\"{$deduction}\"
                      data-net=\"{$netSalary}\"";

        echo "
            <tr class='hover:bg-blue-50 transition-all border-0'>
                <td class='px-6 py-4'>{$transactionId}</td>";

        if (!$isEmployeeView) {
            echo "<td class='px-6 py-4 font-medium text-gray-800'>{$fullNameEsc}</td>";
        }

        echo "
                <td class='px-6 py-4 text-gray-500'>{$dateFormatted}</td>
                <td class='px-6 py-4 text-gray-600'>₱{$basePay}</td>
                <td class='px-6 py-4 text-green-600'>₱{$bonus}</td>
                <td class='px-6 py-4 text-red-600'>₱{$deduction}</td>
                <td class='px-6 py-4 text-blue-600 font-semibold'>₱{$netSalary}</td>
                <td class='px-6 py-4 text-center'>
                    <button {$dataAttrs}
                        onclick='downloadSlip(this)'
                        class='cursor-pointer inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-xs font-semibold px-3 py-2 rounded-lg transition-all shadow-sm'>
                        <svg xmlns='http://www.w3.org/2000/svg' class='w-3.5 h-3.5' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2.5'>
                            <path stroke-linecap='round' stroke-linejoin='round' d='M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4'/>
                        </svg>
                        Download
                    </button>
                </td>
            </tr>";
    }

    echo '
                </tbody>
            </table>
        </div>
    </div>';

    // jsPDF Download Script
    echo "
    <script>
        const COMPANY_NAME = " . json_encode($companyName) . ";

        function downloadSlip(btn) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ unit: 'mm', format: 'a5' });

            const id         = btn.dataset.id;
            const empName    = btn.dataset.name;
            const date       = btn.dataset.date;
            const basePay    = btn.dataset.base;
            const bonus      = btn.dataset.bonus;
            const deduction  = btn.dataset.deduction;
            const net        = btn.dataset.net;

            const pageW = doc.internal.pageSize.getWidth();
            const pageH = doc.internal.pageSize.getHeight();
            const margin = 14;
            const contentW = pageW - margin * 2;

            // ── Header background ──
            doc.setFillColor(14, 116, 215); // blue-600
            doc.rect(0, 0, pageW, 38, 'F');

            // Company name
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(15);
            doc.setTextColor(255, 255, 255);
            doc.text(COMPANY_NAME, pageW / 2, 15, { align: 'center' });

            // Payslip label
            doc.setFontSize(9);
            doc.setFont('helvetica', 'normal');
            doc.setTextColor(186, 230, 253); // sky-200
            doc.text('PAYROLL SLIP', pageW / 2, 22, { align: 'center' });

            // Date badge
            doc.setFillColor(255, 255, 255, 0.15);
            doc.setDrawColor(255, 255, 255);
            doc.roundedRect(margin, 27, contentW, 8, 2, 2, 'S');
            doc.setFontSize(8);
            doc.setTextColor(255, 255, 255);
            doc.text('Pay Period: ' + date, pageW / 2, 32.5, { align: 'center' });

            // ── Employee Info box ──
            let y = 46;
            doc.setFillColor(241, 245, 249); // slate-100
            doc.roundedRect(margin, y, contentW, 16, 3, 3, 'F');

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(10);
            doc.setTextColor(30, 41, 59); // slate-800
            doc.text(empName, margin + 4, y + 7);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(8);
            doc.setTextColor(100, 116, 139); // slate-500
            doc.text('Transaction ID: #' + id, margin + 4, y + 13);

            // ── Earnings & Deductions ──
            y += 24;

            function sectionTitle(label, yPos) {
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(8);
                doc.setTextColor(14, 116, 215);
                doc.text(label.toUpperCase(), margin, yPos);
                doc.setDrawColor(14, 116, 215);
                doc.setLineWidth(0.3);
                doc.line(margin, yPos + 1.5, pageW - margin, yPos + 1.5);
            }

            function rowLine(label, value, yPos, valueColor) {
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(9);
                doc.setTextColor(60, 60, 60);
                doc.text(label, margin + 2, yPos);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(...valueColor);
                doc.text(value, pageW - margin - 2, yPos, { align: 'right' });
            }

            // Earnings
            sectionTitle('Earnings', y);
            y += 8;
            rowLine('Base Pay', 'PHP ' + basePay, y, [30, 41, 59]);
            y += 7;
            rowLine('Bonus', '+ PHP ' + bonus, y, [22, 163, 74]); // green
            y += 7;

            // Deductions
            sectionTitle('Deductions', y);
            y += 8;
            rowLine('Total Deduction', '- PHP ' + deduction, y, [220, 38, 38]); // red
            y += 7;

            // ── Net Salary box ──
            y += 4;
            doc.setFillColor(14, 116, 215);
            doc.roundedRect(margin, y, contentW, 18, 3, 3, 'F');

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(8);
            doc.setTextColor(186, 230, 253);
            doc.text('NET SALARY', margin + 5, y + 7);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(14);
            doc.setTextColor(255, 255, 255);
            doc.text('PHP ' + net, pageW - margin - 5, y + 12, { align: 'right' });

            // ── Footer ──
            doc.setFont('helvetica', 'italic');
            doc.setFontSize(7);
            doc.setTextColor(160, 160, 160);
            doc.text('This is a system-generated payslip and does not require a signature.', pageW / 2, pageH - 8, { align: 'center' });

            doc.save('Payslip_' + id + '_' + date.replace(/ /g, '_') + '.pdf');
        }
    </script>";
}
?>