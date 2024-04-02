<?php 
require_once "App/Controllers/AppHandler.php";
$app = new AppHandler();
$app->init();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
    <header>
        <h1>Welcome <?php echo htmlspecialchars($_SESSION['current_user']->getUsername());?></h1>
        <button id="add-intervention-button">Add New Intervention</button>
    </header>
    <ul id="intervention-list">
        <?php foreach($app->dbH->GetUserInterventions($_SESSION['current_user']) as $intervention):?>
            <li id="<?= $intervention->getId();?>">
                <?php echo "ID : " . $intervention->getId() . " - Date" . $intervention->getDate() . " - Completion : " . $intervention->getComption() ."%"?>
            </li>
        <?php endforeach;?>
    </ul>
</body>
</html>

