<?php
class Review {
    private $id;
    private $message;
    private $authorId;
    private $tourOperatorId;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->message = $data['message'];
        $this->authorId = $data['authorId'];
        $this->tourOperatorId = $data['tourOperatorId'];
    }

    public function __tostring() {
        return "id: {$this->id},<br>
            message: {$this->message},<br>
            authorId: {$this->authorId},<br>
            tourOperatorId: {$this->tourOperatorId}";
    } 

    public function getMessage() {
        return $this->message;
    }
}