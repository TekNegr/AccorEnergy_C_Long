<?php

require_once "User.php";
require_once "Intervention.php";

class DBHandler{
    private $dbFile ;
    private $pdo;

    public function __construct() {
        $this->dbFile = 'C:/xampp/htdocs/AccorEnergy_Last/App/database.sqlite';
        $this->pdo = new PDO("sqlite:". $this->dbFile);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->ConnectToDB();
    }

    //Connecte à la base de donnée ou la crée si inexistante
    protected function ConnectToDB(){
        try {
            $this->CreateUserTable();
            $this->CreateIntervationTable();
            echo "<script>alert('DB Connexion successful!');</script>";
        } catch(PDOException $e){
            "<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
    }


    //poste le user dans la database
    protected function PostUserToDB($userRole,$nom, $prenom, $username, $adress, $pwd){
        try {
            $stmt = $this->pdo->prepare("INSERT INTO CompteDB (userRole, nom, prenom, username, adress ,email, pwd) VALUES (:userRole, :nom, :prenom, :username, :adress ,:email, :pwd)");
            $stmt->bindParam(':userRole', $userRole);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':adress', $adress);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pwd', $pwd);
            $stmt->execute();
            echo "<script>alert('Sign Up successful!');</script>";
        } catch(PDOException $e){
            echo"<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
    
    }

    protected function UpdateUser(UserAE $user){
        if(CheckInUsers($user->getUsername)){
            $stmt = $this->pdo->prepare("UPDATE CompteDB SET user_role = :userRole, first_name = :firstName, last_name = :lastName, username = :username, adress = :adress WHERE id = :id");
            $stmt->bindParam(':userRole', $user->getRole());
            $stmt->bindParam(':firstName', $user->getFirstName());
            $stmt->bindParam(':lastName', $user->getName());
            $stmt->bindParam(':username', $user->getUsername());
            $stmt->bindParam(':address', $user->getAddress());
            $stmt->bindParam(':id', $user->getId(), PDO::PARAM_INT);

            return $stmt->execute();
        }
        return null;
    }

    //Get la base de données entière
    protected function GetUserDB(){
        try {
            $query = "SELECT * FROM CompteDB";
            $statement = $this->pdo->exec($query);
            $userObjs = [];
            while($userData = $statement->fetch(PDO::FETCH_ASSOC)){
                $userObjs[] = new User( $userData['ID'], $userData['userRole'], $userData['name'], $userData['firstname'], $userData['username'], $userData['email'], $userData['adress']);
            }
            $this->$pdo = NULL;
            return userObjs;
        } catch(PDOException $e){
            echo"<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
    }

    public function GetInterventionDB(){
        try {
            $query = "SELECT * FROM InterventionDB";
            $statement = $this->pdo->exec($query);
            $statement->execute();
            $interObjs = [];
            while ($interventionData = $statement->fetch(PDO::FETCH_ASSOC)) {
                $interventionObjs[] = new Intervention($interventionData['ID'], $interventionData['clientID'], $interventionData['standardID'], $interventionData['intervenantID'],$interventionData['dateIntervention'], $interventionData['completion']);
            }
            $this->$pdo = NULL;
            return $interObjs;
        } catch(PDOException $e){
            echo"<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
    }
    

    public function GetUserInterventions(UserAE $user) : array{
        $userId = $user->getId();
        try {
            if($user->getUserRole()=="client"){
                $query = "SELECT * FROM InterventionDB WHERE clientID = :ID";
            }
            else if($user->getUserRole()=="standardiste"){
                $query = "SELECT * FROM InterventionDB WHERE standardID = :ID";
            }
            else if($user->getUserRole()=="intervenant"){
                $query = "SELECT * FROM InterventionDB WHERE intervenantID = :ID";
            }
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':ID', $userId);
            $statement->execute();
            $interventionObjs = [];
            while ($interventionData = $statement->fetch(PDO::FETCH_ASSOC)) {
                $interventionObjs[] = new Intervention($interventionData['ID'], $interventionData['clientID'], $interventionData['standardID'], $interventionData['intervenantID'],$interventionData['dateIntervention'], $interventionData['completion']);
            }
            $this->$pdo = NULL;
            return $interventionObjs;
        } catch(PDOException $e){
            echo"<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }

    }


    //Check l'existence ou la disponibilité d'un username pour s'inscrire (return bool)
    public function CheckInUsersID($ID){
        try {
            $query = "SELECT * FROM CompteDB WHERE ID= (:ID)";
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':ID',$ID);
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);
            $verif = (count($users)>=1)? false:true;
            return $verif;
        } catch(PDOException $e){
            echo"<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
    
    }
    
    public function CheckInUsersNames($username){
        try {
            $query = "SELECT * FROM CompteDB WHERE username= (:username)";
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':username',$username);
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);
            $verif = (count($users)>=1)? false:true;
            return $verif;
        } catch(PDOException $e){
            echo"<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
    
    }


    //User Getters
    public function GetUserByName($username):UserAE{
        try {
            $query = "SELECT * FROM CompteDB WHERE username= (:username)";
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':username',$username);
            $userRes = $statement->fetchOne(PDO::FETCH_ASSOC);
            $user = new UserAE(intval($userRes['id']), $userRes['userRole'], $userRes['nom'], $userRes['prenom'], $userRes['username'], $userRes['adress']);
            return $user;
        } catch(PDOException $e){
            echo"<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
        return null;
    }

    public function GetUserByEmail($email):UserAE{
        try {
            $query = "SELECT * FROM CompteDB WHERE email= (:email)";
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':email',$email);
            $userRes = $statement->fetchOne(PDO::FETCH_ASSOC);
            $user = new UserAE(intval($userRes['id']), $userRes['userRole'], $userRes['nom'], $userRes['prenom'], $userRes['username'], $userRes['adress']);
            return $user;
        } catch(PDOException $e){
            echo"<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
        return null;
    }

    public function GetUserByID($ID):UserAE{
        try {
            $query = "SELECT * FROM CompteDB WHERE ID= (:ID)";
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':ID',$ID);
            $userRes = $statement->fetchOne(PDO::FETCH_ASSOC);
            $user = new UserAE(intval($userRes['id']), $userRes['userRole'], $userRes['nom'], $userRes['prenom'], $userRes['username'], $userRes['adress']);
            return $user;
        } catch(PDOException $e){
            echo"<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
        return null;
    }

    //Prend conncetion String (username ou email) et essaie de connecter à la session
    public function tryConnection(string $connectionString, string $password){
        try {
            if(!CheckInUsersNames($connectionString)){
                $query = "SELECT pwd FROM CompteDB WHERE username= (:parameter)";
                $connexion_type = "username";
            }
            else if(is_object(GetUserByEmail($connectionString))){
                $query = "SELECT pwd FROM CompteDB WHERE email= (:parameter)";
                $connexion_type = "email";
            }
            else{ $query = null;}
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':parameter', $connectionString);
            $pwd = $stmt->fetchOne();
            if($password == $pwd){
                $_SESSION['logged'] = true;
                if($connexion_type=="username"){
                    $_SESSION["current_user"] = GetUserByName($connectionString);
                }
                else if ($connexion_type=="email"){
                    $_SESSION["current_user"] = GetUserByEmail($connectionString);
                }
            }
        }catch(PDOException $e){
            echo "<script>alert('EPIC  CONNECTION FAIL')</script>";
        }
    }

    public function deconnect(){
        $_SESSION["current_user"] = null;
    }

    //INTERVENTION MANIPULATOR 

    protected function PostInterventionToDB(Intervention $int){
        try {
            $stmt = $this->pdo->prepare("INSERT INTO InterventionDB (clientID, standardID, intervenantID, dateIntervention, completion) VALUES (:client, :standardiste, :intervenant, :dateInt, :completion)");
            $stmt->bindParam(':client', $int->getClient()->getId());
            $stmt->bindParam(':standardiste', $int->getStandardist()->getId());
            $stmt->bindParam(':intervenant', $int->getIntervenant()->getId());
            $stmt->bindParam(':dateInt', $int->getDate());
            $stmt->bindParam(':completion', $int->getCompletion());

            return $stmt->execute();
        } catch(PDOException $e){
            echo"<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
        
    }

    protected function UpdateIntervention(Intervention $int){
        try{
            $stmt = $this->pdo->prepare("UPDATE InterventionDtID SET clientID = :clientID, standardID = :standardID, interventantID = :interventantID, dateInt = :dateInt, completion = :completion WHERE ID = :id ");
            $stmt->bindParam(':clientID', $int->getClient()->getId());
            $stmt->bindParam(':standardID', $int->getStandardist()->getId());
            $stmt->bindParam(':intervenantID', $int->getIntervenant()->getId());
            $stmt->bindParam(':dateInt', $int->getDate());
            $stmt->bindParam(':completion', $int->getCompletion());
            $stmt->bindParam(':id', $int->getId());
            
            return $stmt->execute();
        } catch(PDOException $e){
            echo"<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
    }

    public function getIntervention(int $Id): Intervention{
        try{
            $query = "SELECT * FROM Intervention WHERE ID= (:ID)";
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(":ID", $Id);
            $interRes = $statement->fetchOne();
            return new Intervention(intval($interRes["ID"]), intval($interRes["clientID"]), intval($interRes["standardID"]),intval($interRes["intervenatID"]), $interRes['dateIntervention'], $interRes['completion']);
        }catch(PDOException $e){
            echo"<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
        return null;
    }

    //Creation de tables
    public function CreateUserTable(){
        try {
            $this->pdo->exec("CREATE TABLE IF NOT EXISTS CompteDB(
                ID INTEGER PRIMARY KEY AUTOINCREMENT,
                userRole TEXT NOT NULL,
                nom TEXT NOT NULL,
                prenom TEXT NOT NULL,
                username TEXT NOT NULL,
                adress TEXT NOT NULL,
                email TEXT NOT NULL,
                pwd TEXT NOT NULL
            )");
            echo "<script>alert('Table User Created!');</script>";
        } catch(PDOException $e){
            "<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
    }

    public function CreateIntervationTable(){
        try {
            $this->pdo->exec("CREATE TABLE IF NOT EXISTS InterventionDB(
                ID INTEGER PRIMARY KEY AUTOINCREMENT,
                clientID INTEGER REFERENCES CompteDB(ID) NOT NULL;
                standardID INTEGER REFERENCES CompteDB(ID) NOT NULL;
                intervenantID INTEGER REFERENCES CompteDB(ID) NOT NULL;
                dateIntervention DATE NOT NULL;
                completion INTEGER NOT NULL;
            )");
            echo "<script>alert('Table Intervention Created!');</script>";
        } catch(PDOException $e){
            "<script>alert('EPIC FAIL!');</script>" . $e->getMessage();
        }
    }
}
