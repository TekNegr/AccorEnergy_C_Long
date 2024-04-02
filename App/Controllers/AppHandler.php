<?php
require_once "DBHandler.php";
require_once "PageHandler.php";
require_once 'User.php';
require_once 'Intervention.php';
class AppHandler{
    private DBHandler $dbH;
    private PagesHandler $pH;
    private ?UserAE $connectedUser;
    public function __construct(){
        if(isset($_SESSION['current_user']) && $_SESSION['current_user'] !=null){
            $this->user = $_SESSION['current_user'];
        }
        else $this->user = null;
        $this->dbH = new DBHandler();
        $this->pH = new PagesHandler($this->user);
    }

    public function init(string $pageName){
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION["current_user"])){
            $this->user = $_SESSION["current_user"];
        }
        $this->ChangePage($pageName);
    }

    public function HandleSignUp(){
        if(isset( $_POST['signup_submit'] )) {
            $name =$_POST["name"];
            $firstname =$_POST["firstname"];
            $username =$_POST["username"];
            $email =$_POST["email"];
            $adresse = $_POST["adresse"];
            $password =$_POST["password"];
            $confPwd = $_POST["c-password"];
    
            if($this->dbH->CheckInUsersName($username) && !is_object($this->dbH->GetUserByEmail($email))){
                if($password == $confPwd){
                    $this->dbH->PostUserToDB("client", $name, $firstname, $username, $adress, $password);
                    $this->ChangePage("signin");
                }
                else{
                    echo "<script>alert('Aie Password aren't the same');</script>";
                }
            }
            else{
                echo "<script>alert('Username or Email already used');</script>";
            }
        }
    }

    public function HandleSignIn(){
        if(isset($_POST['signin_submit'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $this->dbH->tryConnection($email, $password);
            if($_SESSION['current_user']->getUserRole( )== "admin"){
                $this->ChangePage("admin");
            }
            else{
                $this->ChangePage("dashboard");
            }
        }
    }

    public function HandleSaveUser(){
        if(isset($_POST['save_user_submit'])){
            if($_SESSION['current_user']->getUserRole()=="admin"){
                $role = $_POST['role'];
            }
            else{
                $role = $_SESSION['current_user']->getUserRole();
            }
            
            $username = $_POST['username'];
            $name = $_POST['name'];
            $firstname = $_POST['firstname'];
            $email = $_POST['email'];
            $adresse = $_POST['adresse'];
            $this->user = New  UserAE($_SESSION["current_user"]->getId(),$role, $name, $firstname, $username, $email, $adresse);
        }
    }

    public function ChangePage(string $pageName){
        //In the AppHandler Class
        ob_start();
        $this->pH->renderPage($pageName);
        $content = ob_get_clean();
        $pageContainer = '<div id="page-container">'. $content. '</div>';
        echo $pageContainer;
        ob_end_flush(); 

    }

}