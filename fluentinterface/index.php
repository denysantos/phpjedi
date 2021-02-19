<?php 
class Person {
    private $name;
    private $lastname;
    private $age;

    public function setName($n) {
        $this->name = $n;
        return $this;
    }

    public function setLastName($n) {
        $this->lastname = $n;
        return $this;
    }

    public function setAge($n) {
        $this->age = $n;
    }

    public function getFullName() {
        return $this->name.' '.$this->lastname.' = '.$this->age.' years';
    }


}

$person = new Person();
$person->setName('Deny')->setLastName('Santos')->setAge('44');

echo "Name: ".$person->getFullName();