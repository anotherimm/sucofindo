<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-cover min-h-screen flex items-center justify-center" style="background-image: url('/images/bg.png');">
    <div class="p-4 w-full max-w-lg sm:max-w-md mx-auto bg-white bg-opacity-80 rounded-xl shadow-md space-y-4">
        <div class="flex justify-center">
            <img src="/images/logosci.png" alt="Logo" class="h-20">
        </div>
        <h1 class="text-center text-3xl font-bold text-gradient" style="background-image: linear-gradient(to right, #03C0C3, #0286CA); color: transparent; -webkit-background-clip: text; background-clip: text;">Register</h1>
        <div class="flex items-center justify-center">
            <div class="w-8 h-1 rounded-full mb-2" style="background-image: linear-gradient(to right, #03C0C3, #0286CA);"></div>
        </div>

        <!-- Error Notification -->
        <?php if (session()->getFlashdata('msg_error')) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"><?= session()->getFlashdata('msg_error') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('msg_success')) : ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline"><?= session()->getFlashdata('msg_success') ?></span>
            </div>
        <?php endif; ?>

        <!-- Form register -->
        <form action="/auth/registerProcess" method="post" class="space-y-4 px-2">
            <div class="flex flex-col">
                <input type="email" name="email" placeholder="Email" class="w-full border border-gray-300 p-2 rounded-md" required>
            </div>
            <div class="flex flex-col">
                <input type="text" name="username" placeholder="Username" class="w-full border border-gray-300 p-2 rounded-md" required>
            </div>
            <div class="flex flex-col">
                <input type="password" name="password" placeholder="Password" class="w-full border border-gray-300 p-2 rounded-md" required>
            </div>
            <div class="flex items-center justify-center mt-4">
                <div class="flex items-center">
                    <img src="/images/logoDownload.png" alt="Download Icon" class="h-4 mr-1">
                    <a href="/user_manual.pdf" class="text-black-500 font-bold">User Manual</a>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="submit" class="bg-gradient-to-r from-blue-300 to-blue-600 text-white rounded-full py-2 px-6 font-bold w-full sm:w-56" style="background: linear-gradient(to right, #03C0C3, #0286CA);">Register</button>
            </div>
        </form>

        <div class="text-center">
            <span class="text-gray-500">Sudah punya akun?</span>
            <a href="/auth/login" class="text-gradient font-bold" style="background-image: linear-gradient(to right, #03C0C3, #0286CA); color: transparent; -webkit-background-clip: text; background-clip: text;">Login</a>
        </div>
    </div>
</body>

</html>