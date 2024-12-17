<?php

class Tour_operateur {
    private $id;
    private $name;
    private $link;
    private $score;
    private $isPremium;
    private $description;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->link = $data['link'];
        $this->score = $data['score'];
        $this->isPremium = $data['isPremium'];
        $this->description = $data['description'];
    }

    public function __tostring() {
        return "id: {$this->id},<br>
            name: {$this->name},<br>
            link: {$this->link},<br>
            score: {$this->score},<br>
            isPremium: {$this->getIsPremiumToString()}
            description: {$this->description}";
    }

    public function getIsPremiumToString() {
        if ($this->isPremium) {
            return "oui";
        } else {
            return "non";
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getLink() {
        return $this->link;
    }

    public function getScore() {
        return $this->score;
    }

    public function getIsPremium() {
        return $this->isPremium;
    }

    public function getDescription() {
        return $this->description;
    }
}