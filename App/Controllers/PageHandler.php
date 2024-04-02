<?php
require_once 'User.php';
class PagesHandler{
    private ?UserAE $user;
    private $pages = [];

    public function __construct(){
        $this->set_pages();  
        if(isset($_SESSION['current_user']) && $_SESSION['current_user'] !=null){
            $this->user = $_SESSION['current_user'];
        }
        echo "<script>alert('PageHandler loaded')</script>";
    }

    public function set_pages(){
        $path = "App/pages/";
        $sign_in_page = $path . 'sign_in.php';
        $sign_up_page = $path . 'sign_up.php';
        $loadingPage = $path . 'Loading.php';
        $page404 = $path . '404.php'; 
        $adminDashboard = $path . 'admin.php';
        $dashboard = $path . 'dashboard.php';
        $interventionPage = $path . 'intervention_page.php';
        $userSettingsPage = $path . 'user_settings.php';
        $this->pages = [
            'signin' => $sign_in_page,
            'signup' => $sign_up_page,
            '404' => $page404,
            'loading'=>$loadingPage,
            'user' => $userSettingsPage,
            'dashboard' => $dashboard,
            'admin' => $adminDashboard,
            'intervention'=> $interventionPage
        ];
    }

    public function load_html($pagepath){
        //In the PageHandler Class
        if (file_exists($pagepath)){
            echo "<script>alert('Page found')</script>";
            $html_content = $this->includeFile($pagepath);
            if (!empty($html_content)) {
                return $html_content;
            } else {
                return "empty html " . $pagepath;
            }
        }
    }

    public function renderPage(string $pageName){
        //In the PageHandler Class
        $dom = new DOMDocument();
        $dom->loadHTMLFile('index.php');
        $pageContainer = $dom->getElementById('page-container');
        $pagePath = $this->pages[$pageName]?? $this->pages['404'];
        $content = $this->load_html($pagePath);
        $pageContainer->innerHTML = $content;
        echo "<script>alert('Loading page')</script>";
        echo $pageContainer->innerHTML;
    }

    private function includeFile($file) {
        ob_start();
        include($file);
        return ob_get_clean();
    }


}