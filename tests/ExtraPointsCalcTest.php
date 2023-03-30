<?php

use PHPUnit\Framework\TestCase;

class ExtraPointsCalcTest extends TestCase
{
/* deprecated
	//calculateLanguagePoints
    public function testCalculateLanguagePointsWithSingleB2EnglishLanguageExam()
	{
		$extraPointsCalc = new ExtraPointsCalc([['kategoria' => 'Nyelvvizsga', 'nyelv' => 'Angol', 'tipus' => 'B2']], []);
		$this->assertEquals(28, $extraPointsCalc->calculateLanguagePoints());
	}
	
	public function testCalculateLanguagePointsWithSingleC1GermanExam()
	{
		$extraPointsCalc = new ExtraPointsCalc([['kategoria' => 'Nyelvvizsga', 'nyelv' => 'német', 'tipus' => 'C1']], []);
		$this->assertEquals(40, $extraPointsCalc->calculateLanguagePoints());
	}

	public function testCalculateLanguagePointsWithMultipleExams()
	{
		$extraLanguagePoints = new ExtraPointsCalc(
			[
				['kategoria' => 'Nyelvvizsga', 'nyelv' => 'angol', 'tipus' => 'B2'],
				['kategoria' => 'Nyelvvizsga', 'nyelv' => 'német', 'tipus' => 'C1'],
				['kategoria' => 'Nyelvvizsga', 'nyelv' => 'spanyol', 'tipus' => 'B2'],
				['kategoria' => 'Nyelvvizsga', 'nyelv' => 'francia', 'tipus' => 'C1'],
			],
			[]
		);
		$result = $extraLanguagePoints->calculateLanguagePoints();
		$this->assertEquals(28 + 40 + 28 + 40, $result);
	}
	
	public function testCalculateLanguagePointsWithMultipleWithExamsSameLanguae()
	{
		$extraLanguagePoints = new ExtraPointsCalc(
			[
				['kategoria' => 'Nyelvvizsga', 'nyelv' => 'angol', 'tipus' => 'B2'],
				['kategoria' => 'Nyelvvizsga', 'nyelv' => 'angol', 'tipus' => 'C1'],
			],
			[]
		);
		$result = $extraLanguagePoints->calculateLanguagePoints();
		$this->assertEquals(40, $result);
	}

	//calculateEmeltSubjectPoints
	public function testCalculateEmeltSubjectPointsWithRequiredSubjectPassedAtEmeltLevelAndNoOptionalSubjects() {
		$extraPointsCalc = new ExtraPointsCalc([], [
			['nev' => 'Magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '85%'],
			['nev' => 'Történelem', 'tipus' => 'emelt', 'eredmeny' => '75%'],
			['nev' => 'Angol nyelv', 'tipus' => 'emelt', 'eredmeny' => '90%'],
			['nev' => 'Német nyelv', 'tipus' => 'közép', 'eredmeny' => '80%']
		]);
		$requiredSubject = [
			['nev' => 'Magyar nyelv és irodalom', 'tipus' => 'közép'],
			['nev' => 'Történelem', 'tipus' => 'közép'],
			['nev' => 'Matematika', 'tipus' => 'közép'],
			['nev' => 'Idegen nyelv', 'tipus' => 'közép'],
			['nev' => 'Fizika', 'tipus' => 'közép'],
			['nev' => 'Kémia', 'tipus' => 'közép'],
			['nev' => 'Informatika', 'tipus' => 'közép']
		];
		$optionalSubjects = [];
		$this->assertEquals(50, $extraPointsCalc->calculateEmeltSubjectPoints($requiredSubject, $optionalSubjects));
	}

	public function testCalculateEmeltSubjectPointsWithOptionalSubjectPassedAtEmeltLevelAndNoRequiredSubjects()
	{
		$extraPointsCalc = new ExtraPointsCalc([], [
			['nev' => 'Magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '85%'],
			['nev' => 'Történelem', 'tipus' => 'közép', 'eredmeny' => '75%'],
			['nev' => 'Angol nyelv', 'tipus' => 'emelt', 'eredmeny' => '90%'],
			['nev' => 'Német nyelv', 'tipus' => 'közép', 'eredmeny' => '80%']
		]);
	
		$requiredSubject = [];
		$optionalSubjects = ['Angol nyelv', 'Történelem', 'Kémia'];
	
		$result = $extraPointsCalc->calculateEmeltSubjectPoints($requiredSubject, $optionalSubjects);
	
		$this->assertEquals(50, $result);
	}

	public function testCalculateEmeltSubjectPointsWithMultipleOptionalSubjectPassedAtEmeltLevelAndNoRequiredSubjects()
	{
		$extraPointsCalc = new ExtraPointsCalc([], [
			['nev' => 'Magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '85%'],
			['nev' => 'Történelem', 'tipus' => 'emelt', 'eredmeny' => '75%'],
			['nev' => 'Angol nyelv', 'tipus' => 'emelt', 'eredmeny' => '90%'],
			['nev' => 'Kémia', 'tipus' => 'emelt', 'eredmeny' => '90%'],
			['nev' => 'Német nyelv', 'tipus' => 'közép', 'eredmeny' => '80%']
		]);
	
		$requiredSubject = [];
		$optionalSubjects = ['Angol nyelv', 'Történelem', 'Kémia'];
	
		$result = $extraPointsCalc->calculateEmeltSubjectPoints($requiredSubject, $optionalSubjects);
	
		$this->assertEquals(150, $result);
	}

	public function testCalculateEmeltSubjectPointsWithRequiredAndOptionalEmeltSubjects()
	{
		$extraPointsCalc = new ExtraPointsCalc([], [
			['nev' => 'Magyar nyelv és irodalom', 'tipus' => 'emelt', 'eredmeny' => '85%'],
			['nev' => 'Történelem', 'tipus' => 'közép', 'eredmeny' => '75%'],
			['nev' => 'Angol nyelv', 'tipus' => 'közép', 'eredmeny' => '90%'],
			['nev' => 'Kémia', 'tipus' => 'emelt', 'eredmeny' => '90%'],
			['nev' => 'Német nyelv', 'tipus' => 'közép', 'eredmeny' => '80%']
		]);
	
		$requiredSubject = [['nev' => 'Magyar nyelv és irodalom', 'tipus' => 'közép']];
		$optionalSubjects = ['Angol nyelv', 'Történelem', 'Kémia'];
	
		$result = $extraPointsCalc->calculateEmeltSubjectPoints($requiredSubject, $optionalSubjects);
	
		$this->assertEquals(100, $result);
	}

	//calculateTotalExtraPoints
	public function testCalculateTotalExtraPointsWithValidInput()
	{
		$extraPointsCalc = new ExtraPointsCalc([], []);
	
		$totalEmeltPontszam = 2;
		$totalNyelvVizsgaPontszam = 7;
		
		$result = $extraPointsCalc->calculateTotalExtraPoints($totalEmeltPontszam, $totalNyelvVizsgaPontszam);
	
		$this->assertEquals(9, $result);
	}	
	
	public function testCalculateTotalExtraPointsWithEmeltPointsOnly()
	{
		$extraPointsCalc = new ExtraPointsCalc([], [
			['nev' => 'Matematika', 'tipus' => 'közép', 'eredmeny' => '70%'],
			['nev' => 'Fizika', 'tipus' => 'emelt', 'eredmeny' => '80%'],
			['nev' => 'Magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '60%'],
			['nev' => 'Angol nyelv', 'tipus' => 'közép', 'eredmeny' => '75%'],
			['nev' => 'Német nyelv', 'tipus' => 'közép', 'eredmeny' => '85%'],
		]);
	
		$totalEmeltPontszam = $extraPointsCalc->calculateEmeltSubjectPoints(
			[['nev' => 'Fizika', 'tipus' => 'emelt']],
			[]
		);
		$totalNyelvVizsgaPontszam = $extraPointsCalc->calculateLanguagePoints();
	
		$this->assertEquals(50, $extraPointsCalc->calculateTotalExtraPoints($totalEmeltPontszam, $totalNyelvVizsgaPontszam));
	}
	
	public function testCalculateTotalExtraPointsWithEmeltPointsAndLanguagePoints()
	{
		$extraPointsCalc = new ExtraPointsCalc([['kategoria' => 'Nyelvvizsga', 'nyelv' => 'Angol', 'tipus' => 'B2']], [
			['nev' => 'Matematika', 'tipus' => 'közép', 'eredmeny' => '70%'],
			['nev' => 'Fizika', 'tipus' => 'emelt', 'eredmeny' => '80%'],
			['nev' => 'Magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '60%'],
			['nev' => 'Angol nyelv', 'tipus' => 'közép', 'eredmeny' => '75%'],
			['nev' => 'Német nyelv', 'tipus' => 'közép', 'eredmeny' => '85%'],
		]);
	
		$totalEmeltPontszam = $extraPointsCalc->calculateEmeltSubjectPoints(
			[['nev' => 'Fizika', 'tipus' => 'emelt']],
			[]
		);
		$totalNyelvVizsgaPontszam = $extraPointsCalc->calculateLanguagePoints();
		$this->assertEquals(78, $extraPointsCalc->calculateTotalExtraPoints($totalEmeltPontszam, $totalNyelvVizsgaPontszam));
	}
	
	public function testCalculateTotalExtraPointsWithEmeltPointsAndLanguagePointsOverTheLimit()
	{
		$extraPointsCalc = new ExtraPointsCalc([['kategoria' => 'Nyelvvizsga', 'nyelv' => 'Angol', 'tipus' => 'B2']], [
			['nev' => 'Matematika', 'tipus' => 'közép', 'eredmeny' => '70%'],
			['nev' => 'Fizika', 'tipus' => 'emelt', 'eredmeny' => '80%'],
			['nev' => 'Magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '60%'],
			['nev' => 'Történelem', 'tipus' => 'emelt', 'eredmeny' => '75%'],
			['nev' => 'Német nyelv', 'tipus' => 'közép', 'eredmeny' => '85%'],
		]);
	
		$totalEmeltPontszam = $extraPointsCalc->calculateEmeltSubjectPoints(
			[['nev' => 'Fizika', 'tipus' => 'emelt']],
			['Történelem']
		);
		$totalNyelvVizsgaPontszam = $extraPointsCalc->calculateLanguagePoints();
		$this->assertEquals(100, $extraPointsCalc->calculateTotalExtraPoints($totalEmeltPontszam, $totalNyelvVizsgaPontszam));
	}

*/



}