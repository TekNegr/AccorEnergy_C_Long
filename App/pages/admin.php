<?php 
require_once "App/Controllers/AppHandler.php";
$app = new AppHandler();
if ($_SESSION['current_user']->getUserRole()!== "admin") {
    // Redirect to an appropriate page or display an error message
    exit("Access denied: not an admin user.");
}
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
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
    <div class="dashboard">
        <h1>Welcome <span id="username"><?php echo htmlspecialchars($_SESSION['current_user']->getUserName());?></span></h1>
            <div class="container">
                <h2>User List</h2>
                <ul id="list1">
                    <?php foreach($app->dbH->GetUserDB() as $user):?>
                        <li id="<?= $user->getId();?>">
                            <button action="<?$_SESSION['chosen_ID'] = $user->getId(); $app->pH->ChangePage("user"); ?>">
                                <?php echo "ID : " . $user->getId() . " - Name :" . $user->getName() . " - Firstname :" . $user->getFirstName() . " - Role : " . $user->getUserRole()?>
                            </button>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div class="container">
                <h2>Intervention List</h2>
                <ul id="list2">
                    <?php foreach($app->dbH->GetInternventionDB() as $intervention):?>
                        <li id="<?= $intervention->getId();?>">
                            <button action="<?$_SESSION['chosen_ID'] = $intervention->getId(); $app->pH->ChangePage("intervention"); ?>">
                                <?php echo "ID : " . $intervention->getId() . " - Date" . $intervention->getDate() . " - Completion : " . $intervention->getComption() ."%"?>
                            </button>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </body>
</html>
