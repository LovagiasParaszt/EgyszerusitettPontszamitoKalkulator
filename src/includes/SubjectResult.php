<?php
class SubjectResult {
    private $nev;
    private $tipus;
    private $result;
	private $mandatory = false;

    public function __construct($nev, $tipus, $result, $mandatory) {
        $this->nev = $nev;
        $this->tipus = $tipus;
        $this->result = $result;
		$this->mandatory = $mandatory;
    }

    public function getNev() {
        return $this->nev;
    }

    public function getTipus() {
        return $this->tipus;
    }

    public function getEredmeny() {
        return $this->result;
    }

    public function passed() {
        $result = rtrim($this->result, '%');
        return (int) $result >= 20;
    }
	
    public function isMandatory() {
        return $this->mandatory;
    }	
}
