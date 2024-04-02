<?php 
require_once 'User.php';
//Class d'intervention maleable
class Intervention{

    private int $ID;
    private UserAE $client;
    private UserAE $standardiste;
    private UserAE $intervant;
    private Date $date;
    private int $completion;


    public function __construct(int $ID ,UserAE $client, UserAE $standardiste, UserAE $intervant, Date $date, int $completion){
        $this->ID = $id;
        $this->client = $client;
        $this->standardiste = $standardiste;
        $this->intervant = $intervant;
        $this->date = $date;
        $this->completion = $completion;
    }

    private function getId(){
        return $this->ID;
    }

    public function getClient(): UserAE {
        return $this->client;
    }

    public function setClient(UserAE $client): void {
        $this->client = $client;
    }

    public function getStandardist(): UserAE {
        return $this->standardist;
    }

    public function setStandardist(UserAE $standardist): void {
        $this->standardist = $standardist;
    }

    public function getIntervenant(): UserAE {
        return $this->intervenant;
    }

    public function setIntervenant(UserAE $intervenant): void {
        $this->intervenant = $intervenant;
    }

    public function getDate(): DateTime {
        return $this->date;
    }

    public function setDate(DateTime $date): void {
        $this->date = $date;
    }

    public function getCompletion(): int {
        return $this->completion;
    }

    public function setCompletion(int $completion): void {
        $this->completion = $completion;
    }

}