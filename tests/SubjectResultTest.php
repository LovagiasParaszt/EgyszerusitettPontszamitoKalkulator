<?php

require_once './src/index.php';
use PHPUnit\Framework\TestCase;

class SubjectResultTest extends TestCase
{
    public function testGetNev()
    {
        
        $result = new SubjectResult('matematika', 'közép', '90%', true);
        $this->assertEquals('matematika', $result->getNev());
    }

    public function testGetTipus() {
        $subjectResult = new SubjectResult('Magyar nyelv és irodalom', 'közép', '60%', true);
        $this->assertEquals('közép', $subjectResult->getTipus());
    }

    public function testGetEredmeny() {
        $subjectResult = new SubjectResult('Magyar nyelv és irodalom', 'közép', '60%', true);
        $this->assertEquals('60%', $subjectResult->getEredmeny());
    }

    public function testPassed() {
        $subjectResult = new SubjectResult('Magyar nyelv és irodalom', 'közép', '60%', true);
        $this->assertTrue($subjectResult->passed());
    }

    public function testIsMandatory() {
        $subjectResult = new SubjectResult('Magyar nyelv és irodalom', 'közép', '60%', true);
        $this->assertTrue($subjectResult->isMandatory());
    }
}