<?php 
    require_once "App/Controllers/AppHandler.php";
    $App = new AppHandler();
?>
    
    <head>
        <title>Sign up</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <div class="min-h-screen flex items-center justify-center bg-gray-100 border-r">
            <div class="max-w-md w-full p-6 bg-white border border-gray-300 rounded-md">
                <h2 class="text-2xl font-semibold mb-6">Sign Up</h2>
                <form id="signup-form" method="POST" >
                
                <!-- BLOCK NAME -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" type="text" placeholder="Name">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="firstname">
                    Firstname
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="firstname" name="firstname" type="text" placeholder="Firstname">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    Username
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text" placeholder="Username">
                </div>

                <!-- BLOCK EMAIL -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="text" placeholder="Email">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="adresse">
                    Adresse
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="adresse" name="adresse" type="text" placeholder="Adresse">
                </div>
                
                <!-- BLOCK PASSWORD -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="Password">
                </div>
                
                <!-- BLOCK CONFIRM PASSWORD -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm-password">
                    Confirm Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="confirm-password" name="c-password" type="password" placeholder="Confirm Password">
                </div>
                
                <!-- BLOCK SUBMIT -->
                <div id="btnBlock"class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="signup_submit">
                    Sign Up     
                    </button>
                    <button id="goToSignin" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" onclick="document.getElementById('page-container').innerHTML = ''; $App->ChangePage('signin');">
                    Already have an account? Sign In
                    </button>
                </div>

                </form>
            </div>
        </div>
    </body>



