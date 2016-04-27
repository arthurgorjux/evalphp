<?php

namespace UserLog;

use \DateTime;
/**
* Represents an Entry on the User Log table
*/
class Entry {
    private $id = null;
    private $datetime;
    private $sessionId;
    private $userId;
    private $ipAddress;
    private $country;
    private $category;
    private $type;
    private $element;
    private $additionnalInformations;

    function __construct($id, $datetime, $userId, $sessionId, $ipAddress, $country, $category, $type, $element, $additionnalInformations) {
        $this->id = $id;
        $this->datetime = $datetime;
        $this->userId = $userId;
        $this->sessionId = $sessionId;
        $this->ipAddress = $ipAddress;
        $this->country = $country;
        $this->category = $category;
        $this->type = $type;
        $this->element = $element;
        $this->additionnalInformations = $additionnalInformations;
    }

    public function getId() {
        return $this->id;
    }

    public function getDatetime() {
        return $this->datetime;
    }

    public function getDate() {
        return $this->datetime;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getSessionId() {
        return $this->sessionId;
    }

    public function getIpAddress() {
        return $this->ipAddress;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getType() {
        return $this->type;
    }

    public function getElement() {
        return $this->element;
    }

    public function getAdditionnalInformations() {
        return $this->additionnalInformations;
    }

}
