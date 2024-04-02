<?php 

//Class d'utilisateur maleable
class UserAE{

    private $id;
    private $userRole;
    private $name;
    private $firstName;
    private $username;
    private $email;
    private $address;

    public function __construct(int $id, string $userRole, string $name, string $firstName, string $username, string $email, string $address){
        $this->id = $id;
        $this->userRole = $userRole;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->username = $username;
        $this->address = $address;
        $this->email = $email;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserRole() {
        return $this->userRole;
    }

    public function getName() {
        return $this->name;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setId($value) {
        $this->id = $value;
    }

    public function setUserRole($value) {
        $this->userRole = $value;
    }

    public function setName($value) {
        $this->name = $value;
    }

    public function setFirstName($value) {
        $this->firstName = $value;
    }

    public function setUsername($value) {
        $this->username = $value;
    }

    public function setAddress($value) {
        $this->address = $value;
    }


}