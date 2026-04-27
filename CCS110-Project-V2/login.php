<?php
session_start();
$username = $password = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="assets/css/tailwindcss.js"></script>
    <?php include('assets/fonts/fonts.php'); ?>
    <title>Login | PayFlow</title>
    <style>
        * {
            font-family: 'DM Sans', sans-serif;
        }
    </style>
</head>

<body class="h-screen overflow-hidden bg-gray-50">
    <div class="flex items-center justify-center h-full p-5 gap-5">
        <div
            class="flex-1 h-full bg-[url('assets/images/buildings.jpg')] bg-cover flex flex-col rounded-xl overflow-hidden">
            <div class="h-full w-full bg-black/50 flex justify-end flex-col p-15 backdrop-blur-sm">
                <h1 class="text-slate-50 text-5xl mb-3 font-semibold">PayFlow</h1>
                <p class="text-slate-50 font-thin text-sm leading-relaxed">
                    Smart Payroll, Simplified. An end-to-end software service that eliminates manual errors.
                </p>
            </div>
        </div>

        <div class="w-1/2 flex flex-col justify-center px-20 gap-5">
            <div>
                <img src="assets/images/PayFlow Logo.png" class="w-20 h-36 object-cover">
                <h1 class="text-5xl font-bold mb-2">Login</h1>
                <p>Welcome to PayFlow — Login to Get Started.</p>
            </div>

            <hr class="text-zinc-300">

            <form class="flex flex-col gap-2" id="formLogin">
                <label class="font-semibold text-zinc-500">Username</label>
                <input type="text" name="username"
                    class="px-3 py-2 border border-zinc-500 rounded-lg focus:outline-blue-500"
                    placeholder="Enter username" value="<?php echo $username ?>" required>

                <label class="font-semibold text-zinc-500">Password</label>
                <input type="password" name="password"
                    class="px-3 py-2 border rounded-lg border-zinc-500 focus:outline-blue-500"
                    placeholder="Enter password" value="<?php echo $password ?>" required>

                <p class="text-red-500 text-sm hidden mb-5" id="errorMsg"></p>
                <input type="submit" value="Login"
                    class="px-2 py-2 bg-blue-700 text-white text-center hover:bg-blue-900 transition-colors rounded-lg cursor-pointer font-semibold">
            </form>
            <a href="pages/signUpPage.php" class="text-center underline text-blue-800 w-fit mx-auto">Don't have an
                account?</a>
        </div>
    </div>

    <script>
        // Use AJAX to validate user's login credentials
        document.querySelector('#formLogin').addEventListener('submit', async function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            await fetch('src/controllers/validateLogin.php', { method: "POST", body: formData })
                .then(response => response.json())
                .then(data => validateLogin(data));
        });

        function validateLogin(data) {
            const errorMsg = document.querySelector('#errorMsg');
            if (data.status === "success") {
                errorMsg.classList.add('hidden');
                window.location.href = 'pages/dashboard.php';
            } else {
                errorMsg.classList.remove('hidden');
                errorMsg.innerText = data.msg;
            }
        }
    </script>
</body>

</html>