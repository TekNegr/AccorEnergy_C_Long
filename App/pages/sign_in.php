<?php 
require_once "App/Controllers/AppHandler.php";
$app = new AppHandler();

?>

<head>
    <title>Sign In</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 border-r">
        <div class="max-w-md w-full p-6 bg-white border border-gray-300 rounded-md">
            <h2 class="text-2xl font-semibold mb-6">Sign In</h2>
            <form>
                
                <!-- BLOCK EMAIL-->
                <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email" >
                    Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="text" placeholder="Email">
                </div>
                
                <!-- BLOCK PASSWORD-->
                <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="Password">
                </div>
                
                <!-- BLOCK SUBMIT-->
                <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="signin_submit">
                    Sign In
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="App/pages/sign_up.php" id="GoToSignup">
                    No account yet? Sign Up
                </a>
                </div>

            </form>
        </div>
    </div>
</body>
