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

    public function getTourOperatorWithId($tourOperatorId) {
        $query = $this->db->prepare('SELECT * FROM tour_operator WHERE id = :tour_operator_id');
        $query->execute([
            'tour_operator_id' => $tourOperatorId
        ]);
        $response = $query->fetch(PDO::FETCH_ASSOC);

        $array = [];
        $array['id'] = $response['id'];
        $array['name'] = $response['name'];
        $array['link'] = $response['link'];
        $array['score'] = $this->getScoreWithTourOperatorId($response['id']);
        $array['isPremium'] = $this->getIsPremiumWithTourOperatorId($response['id']);

        return new Tour_operateur($array);
    }

    public function addDestinationToTourOperator($tourOperatorId, $destinationId) {
        $query = $this->db->query('SELECT * FROM destination_tour_operator');
        $destinationTO = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($destinationTO as $i) {
            if ($i['destination_id'] == $destinationId && $i['tour_operator_id'] == $tourOperatorId) {
                return "Cette destination est deja ajoutée";
            }
        }

        $query = $this->db->prepare('INSERT INTO destination_tour_operator (destination_id, tour_operator_id)
            VALUES (:destination_id, :tour_operator_id)');
        $query->execute([
            'destination_id' => $destinationId,
            'tour_operator_id' => $tourOperatorId
        ]);

        return "Destination ajoutée";
    }

    public function passTourOperatorPremium($tourOperatorId) {
        $query = $this->db->query('SELECT * FROM certificate');
        $certificates = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($certificates as $i) {
            if ($i['tour_operator_id'] == $tourOperatorId) {
                return "Ce tour opérateur est deja passé en premium";
            }
        }

        $date = new DateTime();
        $date->modify('+1 year');

        $query = $this->db->prepare('INSERT INTO certificate (tour_operator_id, expires_at, signatory)
            VALUES (:tour_operator_id, :expires_at, :signatory)');
        $query->execute([
            'tour_operator_id' => $tourOperatorId,
            'expires_at' => $date->format('Y-m-d H:i:s'),
            'signatory' => 'admin'
        ]);

        return "Tour opérateur passé en premium";
    }

    public function addTourOperator($name, $link) {
        $query = $this->db->prepare('INSERT INTO tour_operator (name, link) VALUES (:name, :link)');
        $query->execute([
            'name' => $name,
            'link' => $link
        ]);

        return "Tour opérateur ajouté";
    }
}