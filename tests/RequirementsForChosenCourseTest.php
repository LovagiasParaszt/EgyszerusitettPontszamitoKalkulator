<?php

use PHPUnit\Framework\TestCase;

class RequirementsForChosenCourseTest extends TestCase
{
    public function testGetEgyetemReturnsCorrectValue() 
	{
		$chosenCourse = [
			'egyetem' => 'ELTE',
			'kar' => 'IK',
			'szak' => 'Programtervező informatikus',
		];
		$requirementsForChosenCourse = new RequirementsForChosenCourse($chosenCourse);
		$this->assertEquals('ELTE', $requirementsForChosenCourse->getEgyetem());
	}
	
    public function testGetKarReturnsCorrectValue() 
	{
		$chosenCourse = [
			'egyetem' => 'ELTE',
			'kar' => 'IK',
			'szak' => 'Programtervező informatikus',
		];
		$requirementsForChosenCourse = new RequirementsForChosenCourse($chosenCourse);
		$this->assertEquals('IK', $requirementsForChosenCourse->getKar());
	}
	
    public function testGetSzakReturnsCorrectValue() 
	{
		$chosenCourse = [
			'egyetem' => 'ELTE',
			'kar' => 'IK',
			'szak' => 'Programtervező informatikus',
		];
		$requirementsForChosenCourse = new RequirementsForChosenCourse($chosenCourse);
		$this->assertEquals('Programtervező informatikus', $requirementsForChosenCourse->getSzak());
	}
	
	public function testRequirementsForTheCourseValidInputs()
	{
		$chosenCourse = [
			'szak' => 'Programtervező informatikus',
			'kar' => 'IK',
			'egyetem' => 'ELTE'
		];
		$requirements = new RequirementsForChosenCourse($chosenCourse);
	
		$expectedKotelezoTantargy = [['nev' => 'matematika', 'tipus' => 'közép']];
		$expectedValasztottTantargyak = ['biológia', 'fizika', 'informatika', 'kémia'];
		$expectedAlapTantargyak = [
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép'],
			['nev' => 'történelem', 'tipus' => 'közép'],
			['nev' => 'matematika', 'tipus' => 'közép']
		];
	
		$requirementsObject = $requirements->requirementsForTheCourse();
	
		$this->assertEquals($expectedKotelezoTantargy, $requirementsObject->kotelezoTantargy);
		$this->assertEquals($expectedValasztottTantargyak, $requirementsObject->valasztottTantargyak);
		$this->assertEquals($expectedAlapTantargyak, $requirementsObject->alapTantargyak);
	}	
	
	public function testRequirementsForTheCourseWithInvalidInputs()
	{
		$chosenCourse = [
			'egyetem' => 'ABC',
			'kar' => 'DEF',
			'szak' => 'GHI'
		];
		
		$requirements = new RequirementsForChosenCourse($chosenCourse);
		
		$this->expectException(Exception::class);
		$this->expectExceptionMessage("hiba, nem lehetséges a pontszámítás az intézmény/kar/szak nem megfelelő\n");
	
		$requirements->requirementsForTheCourse();
	}
	
	

	
	
	
}