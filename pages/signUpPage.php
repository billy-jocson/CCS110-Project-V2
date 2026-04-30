<?php
include('../src/controllers/createAccount.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../assets/css/tailwindcss.js"></script>
    <?php include('../assets/fonts/fonts.php'); ?>
    <title>Signup | PayFlow</title>
    <style>
        * {
            font-family: 'DM Sans', sans-serif;
        }
    </style>
</head>

<body class="h-screen overflow-hidden bg-gray-50">
    <div class="flex items-center justify-center h-full p-5 gap-5">
        <div
            class="w-1/2 h-full bg-[url(../assets/images/buildings.jpg)] bg-cover flex flex-col rounded-xl overflow-hidden">
            <div class="h-full w-full bg-black/50 flex justify-end flex-col p-15 backdrop-blur-sm">
                <h1 class="text-slate-50 text-5xl mb-3 font-semibold">PayFlow</h1>
                <p class="text-slate-50 font-thin text-sm leading-relaxed">
                    Smart Payroll, Simplified. An end-to-end software service that eliminates manual errors.
                </p>
            </div>
        </div>

        <div class="w-1/2 flex flex-col justify-center px-20 gap-5">
            <div>
                <img src="../assets/images/PayFlow Logo.png" class="w-20 h-36 object-cover">
                <h1 class="text-5xl font-bold mb-2">Create Account</h1>
                <p>Welcome to PayFlow — Create an Account to Get Started.</p>
            </div>

            <hr class="text-zinc-300">

            <form class="relative overflow-hidden flex flex-col items-center justify-center w-full" method="post"
                enctype="multipart/form-data">
                <div class="w-full">
                    <div id="formSlider"
                        class="flex w-[200%] transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]">
                        <div class="w-1/2 flex flex-col gap-3 px-1 transition-all duration-500 ease-in-out transform"
                            id="employeeDetails">
                            <div class="flex flex-col">
                                <label class="font-semibold text-zinc-500">Department</label>
                                <select name="department" id="departments" onchange="changePositionsList(this)"
                                    class="px-3 py-2 border border-zinc-500 rounded-lg focus:outline-blue-500">

                                </select>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex flex-col w-full">
                                    <label class="font-semibold text-zinc-500">First Name</label>
                                    <input type="text" name="firstName"
                                        class="px-3 py-2 border border-zinc-500 rounded-lg focus:outline-blue-500"
                                        placeholder="Enter first name" required>
                                </div>
                                <div class="flex flex-col w-full">
                                    <label class="font-semibold text-zinc-500">Last Name</label>
                                    <input type="text" name="lastName"
                                        class="px-3 py-2 border border-zinc-500 rounded-lg focus:outline-blue-500"
                                        placeholder="Enter last name" required>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label class="font-semibold text-zinc-500">Contact Number</label>
                                <input type="tel" name="phone" placeholder="0000-000-0000"
                                    class="px-3 py-2 border border-zinc-500 rounded-lg focus:outline-blue-500" required>
                            </div>
                            <div class="flex flex-col">
                                <label class="font-semibold text-zinc-500">Position</label>
                                <select name="position" id="position"
                                    class="px-3 py-2 border border-zinc-500 rounded-lg focus:outline-blue-500">
                                </select>
                            </div>
                            <input onclick="validateNext(event)" type="submit" value="Next"
                                class="mt-5 px-2 py-2 bg-zinc-700 text-white hover:bg-zinc-800 transition-colors rounded-lg cursor-pointer font-semibold">
                            <a href="../login.php" class="text-center underline text-blue-800 mt-3 self-center">
                                Have an account?
                            </a>
                        </div>

                        <div class="w-1/2 flex flex-col h-fit gap-3 px-1 transition-all duration-500 ease-in-out transform opacity-50 scale-95"
                            id="accountDetails">
                            <div class="">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">
                                    Formal Picture
                                </label>

                                <div
                                    class="flex items-center w-full border border-gray-300 rounded-lg overflow-hidden bg-gray-50 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent">

                                    <input id="file_input" name="profilePicture" type="file" class="hidden peer"
                                        accept=".jpg, .jpeg, .png" required>

                                    <label for="file_input"
                                        class="cursor-pointer bg-gray-200 px-4 py-2 text-sm text-gray-700 font-medium hover:bg-gray-300 transition-colors border-r border-gray-300 shrink-0">
                                        Choose File
                                    </label>

                                    <span class="px-4 text-sm text-gray-600 truncate">
                                        No file chosen
                                    </span>
                                </div>

                                <p class="mt-2 text-xs text-gray-500">
                                    JPG/JPEG or PNG.
                                </p>
                            </div>
                            <div class="flex flex-col">
                                <label class="font-semibold text-zinc-500">Username</label>
                                <input type="text" name="username" placeholder="Enter username"
                                    class="px-3 py-2 border border-zinc-500 rounded-lg focus:outline-blue-500" required>
                            </div>
                            <div class="flex flex-col">
                                <label class="font-semibold text-zinc-500">Password</label>
                                <input type="password" name="password" placeholder="Enter password"
                                    class="px-3 py-2 border border-zinc-500 rounded-lg focus:outline-blue-500" required>
                            </div>

                            <div class="flex w-full gap-3">
                                <button type="button" onclick="goBack()"
                                    class="w-full border outline-zinc-500 hover:bg-zinc-500 hover:text-white text-sm text-zinc-500 rounded-lg cursor-pointer transition-all">Back</button>
                                <input type="submit" value="Create Account" name="createAccount"
                                    class="w-full border px-2 py-2 bg-blue-700 text-white hover:bg-blue-900 transition-all rounded-lg cursor-pointer font-semibold">
                            </div>
                            <a href="../login.php" class="text-center underline text-blue-800 mt-3 self-center">
                                Have an account?
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('file_input').addEventListener('change', function (e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : "No file chosen";
            e.target.nextElementSibling.nextElementSibling.innerText = fileName;
        });

        // Load departments and position after website loads
        document.addEventListener('DOMContentLoaded', async function () {
            await fetch('../src/controllers/getDepartments.php')
                .then(res => res.json())
                .then(data => renderDepartments(data));
        });

        // Get and display all position based on department id
        async function changePositionsList(data) {
            const selectedDept = data.value;
            await fetch('../src/controllers/getPositions.php',
                {
                    method: 'POST',
                    body: JSON.stringify({ dept_id: selectedDept })
                })
                .then(res => res.json())
                .then(data => renderList(data));
        }

        // Get and display all departments
        async function renderDepartments(data) {
            const departments = document.querySelector('#departments');
            departments.innerHTML = "";

            data.forEach(item => {
                departments.innerHTML += `<option value="${item.dept_id}">${item.dept_name}</option>`;
            });

            await changePositionsList(departments);
        }

        function renderList(data) {
            const position = document.querySelector('#position');
            position.innerHTML = "";

            data.forEach(item => {
                position.innerHTML += `<option value="${item.position_id}">${item.position_name}</option>`;
            });
        }

        function validateNext(event) {
            event.preventDefault();

            const employeeSection = document.querySelector('#employeeDetails');
            const accountSection = document.querySelector('#accountDetails');
            const slider = document.querySelector('#formSlider');

            const inputs = employeeSection.querySelectorAll('input, select');

            let isSectionValid = true;
            for (let input of inputs) {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    isSectionValid = false;
                    return;
                }
            }

            if (isSectionValid) {
                slider.style.transform = "translateX(-50%)";

                employeeSection.classList.add('opacity-0', 'scale-95');
                employeeSection.classList.remove('opacity-100', 'scale-100');

                accountSection.classList.remove('opacity-50', 'scale-95');
                accountSection.classList.add('opacity-100', 'scale-100');
            }
        }

        function goBack() {
            const slider = document.querySelector('#formSlider');
            const employeeSection = document.querySelector('#employeeDetails');
            const accountSection = document.querySelector('#accountDetails');

            slider.style.transform = "translateX(0%)";

            employeeSection.classList.remove('opacity-0', 'scale-95');
            employeeSection.classList.add('opacity-100', 'scale-100');

            accountSection.classList.add('opacity-50', 'scale-95');
            accountSection.classList.remove('opacity-100', 'scale-100');
        }
    </script>
</body>

</html>