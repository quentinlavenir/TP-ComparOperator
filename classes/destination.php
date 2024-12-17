<?php
class Destination {
    private $id;
    private $location;
    private $price;
    private $tourOperatorId;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->location = $data['location'];
        $this->price = $data['price'];
        $this->tourOperatorId = $data['tourOperatorId'];
    }

    public function __tostring() {
        return "id: {$this->id},<br>
            location: {$this->location},<br>
            price: {$this->price},<br>
            tourOperatorId: {$this->getTourOperatorToString()}";
    }

    public function getTourOperatorToString() {
        $tourOperators = "";
        foreach ($this->tourOperatorId as $i) {
            $tourOperators .= "{$i}, ";
        }
        $tourOperators = substr($tourOperators, 0, -2);
        return $tourOperators;
    }

    public function getLocation() {
        return $this->location;
    }
}