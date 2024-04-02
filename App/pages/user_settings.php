<?php 
require_once "App/Controllers/AppHandler.php";
$app = new AppHandler();
$app->init("user");
$chosenUser = ($app->dbH->GetUserByID($_SESSION[chosen_ID]))
?>

<html>
    
<head>
    <title>User Settings</title>
</head>
<!-- NAVBAR -->
<header>
    <nav>
        <ul>
            <li>
                <button class="nav-button" id="dashboard-button">Dashboard</button>
            </li>
            <li>
                <button class="nav-button" id="user-settings-button">User Settings</button>
            </li>
        </ul>
    </nav>
    <script>
        const dashboardButton = document.getElementById("dashboard-button");
        const userSettingsButton = document.getElementById("user-settings-button");

        dashboardButton.addEventListener("click", () => {
                // Change the page to the dashboard
                const appHandler = <?php echo serialize($app);?>;
                <?php $_SESSION[chosen_ID] = $_SESSION[current_user]->getId();?>
                if( <?php echo $_SESSION[current_user]->getUserRole() == "admin"; ?> ) {
                    appHandler.pH.ChangePage("admin");
                } else {
                    appHandler.pH.ChangePage("dashboard");
                }
            });

        userSettingsButton.addEventListener("click", () => {
        // Change the page to the user settings
        const appHandler = <?php echo serialize($app);?>;
        <?php $_SESSION[chosen_ID] = $_SESSION[current_user]->getId();?>
        appHandler.pH.ChangePage("user");

        });
    </script>
</header>

<body>
    <h1>User Settings</h1>
    <form>
        <?php if ($_SESSION['current_user']->getUserRole() == "admin"){?>
            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="client">Client</option>
                <option value="standardiste">Standardiste</option>
                <option value="intervenant">Intervenant</option>
                <option value="admin">Admin</option>
            </select><br>
        <?php }?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $chosenUser->username;?>" disabled><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $chosenUser->email;?>" disabled><br>

        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo $chosenUser->firstName;?>" disabled><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo $chosenUser->lastName;?>" disabled><br>

        <label for="adresse">Adresse:</label>
        <input type="tel" id="adresse" name="adresse" value="<?php echo $chosenUser->phoneNumber;?>" disabled><br>

        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="save_user_submit">
            Save Changes   
        </button>

    </form>
</body>
</html>

