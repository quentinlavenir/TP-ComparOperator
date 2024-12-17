<?php
class Manager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDestinations() {
        $query = $this->db->query('SELECT * FROM destination');
        $response = $query->fetchAll(PDO::FETCH_ASSOC);

        $destinationsValue = [];
        foreach ($response as $i) {
            $array = [];
            $array['id'] = $i['id'];
            $array['location'] = $i['location'];
            $array['price'] = $i['price'];
            $array['tourOperatorId'] = $this->getTourOperatorIdWithDestinationId($i['id']);
            $destinationsValue[] = $array; 
        }

        $destinations = [];
        foreach ($destinationsValue as $i) {
            $destinations[] = new Destination($i);
        }

        return $destinations;
    }

    public function getTourOperatorIdWithDestinationId($destinationId) {
        $query = $this->db->prepare('SELECT tour_operator_id FROM destination_tour_operator
            WHERE destination_id = :destination_id');
        $query->execute([
            'destination_id' => $destinationId
        ]);
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getTourOperators() {
        $query = $this->db->query('SELECT * FROM tour_operator');
        $response = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $tourOperatorsValue = [];
        foreach ($response as $i) {
            $array = [];
            $array['id'] = $i['id'];
            $array['name'] = $i['name'];
            $array['link'] = $i['link'];
            $array['score'] = $this->getScoreWithTourOperatorId($i['id']);
            $array['isPremium'] = $this->getIsPremiumWithTourOperatorId($i['id']);
            $tourOperatorsValue[] = $array;
        }

        $tourOperators = [];
        foreach ($tourOperatorsValue as $i) {
            $tourOperators[] = new Tour_operateur($i);
        }

        return $tourOperators;
    }

    public function getScoreWithTourOperatorId($tourOperatorId) {
        $query = $this->db->prepare('SELECT value FROM score
            WHERE tour_operator_id = :tour_operator_id');
        $query->execute([
            'tour_operator_id' => $tourOperatorId
        ]);
        $response = $query->fetchAll(PDO::FETCH_COLUMN);

        $score = 0;
        foreach ($response as $i) {
            $score += $i;
        }

        if (count($response) != 0) {
            $score = $score / count($response);
        }

        return $score;
    }

    public function getIsPremiumWithTourOperatorId($tourOperatorId) {
        $query = $this->db->prepare('SELECT * FROM certificate
            WHERE tour_operator_id = :tour_operator_id');
        $query->execute([
            'tour_operator_id' => $tourOperatorId
        ]);
        $response = $query->fetchAll(PDO::FETCH_COLUMN);
        
        return count($response) > 0 ? true : false;
    }

    public function getReviews() {
        $query = $this->db->query('SELECT * FROM review');
        $response = $query->fetchAll(PDO::FETCH_ASSOC);

        $reviewsValue = [];
        foreach ($response as $i) {
            $array = [];
            $array['id'] = $i['id'];
            $array['message'] = $i['message'];
            $array['authorId'] = $i['author_id'];
            $array['tourOperatorId'] = $i['tour_operator_id'];
            $reviewsValue[] = $array;
        }

        $reviews = [];
        foreach ($reviewsValue as $i) {
            $reviews[] = new Review($i);
        }

        return $reviews;
    }
}