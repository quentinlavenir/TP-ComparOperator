<?php

class Tour_operateur {
    private $id;
    private $name;
    private $link;
    private $score;
    private $isPremium;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->link = $data['link'];
        $this->score = $data['score'];
        $this->isPremium = $data['isPremium'];
    }

    public function __tostring() {
        return "id: {$this->id},<br>
            name: {$this->name},<br>
            link: {$this->link},<br>
            score: {$this->score},<br>
            isPremium: {$this->getIsPremiumToString()}";
    }

    public function getIsPremiumToString() {
        if ($this->isPremium) {
            return "oui";
        } else {
            return "non";
        }
    }
}