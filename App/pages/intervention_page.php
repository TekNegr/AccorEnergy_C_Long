<?php 
require_once "App/Controllers/AppHandler.php";
$app = new AppHandler();

?>

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

