<?php

use PHPUnit\Framework\TestCase;

class BasicPointsCalcTest extends TestCase
{
	//mandatorySubjectsPassed
	public function testMandatorySubjectsPassedWithAllPassedMandatorySubjects()
	{
		$graduationResults = [
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '90%', 'mandatory' => true],
			['nev' => 'történelem', 'tipus' => 'közép', 'eredmeny' => '85%', 'mandatory' => true],
			['nev' => 'matematika', 'tipus' => 'közép', 'eredmeny' => '75%', 'mandatory' => true],
			['nev' => 'fizika', 'tipus' => 'közép', 'eredmeny' => '40%', 'mandatory' => false],
			['nev' => 'informatika', 'tipus' => 'közép', 'eredmeny' => '50%', 'mandatory' => false],
		];

		$calculator = new BasicPointsCalc($graduationResults);

		$mandatorySubjects = [
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép'],
			['nev' => 'történelem', 'tipus' => 'közép'],
			['nev' => 'matematika', 'tipus' => 'közép'],
		];
	
		$this->assertTrue($calculator->mandatorySubjectsPassed($mandatorySubjects));
	}

	public function testMandatorySubjectsPassedWithSomePassedAndSomeFailedMandatorySubjects()
	{
		$graduationResults = [        
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '15%'],
			['nev' => 'történelem', 'tipus' => 'közép', 'eredmeny' => '90%'],
			['nev' => 'matematika', 'tipus' => 'közép', 'eredmeny' => '90%'],
		];
		$calculator = new BasicPointsCalc($graduationResults);
		$mandatorySubjects = [        
			['nev' => 'magyar nyelv és irodalom'],
			['nev' => 'történelem'],
			['nev' => 'matematika'],
		];
		$this->expectException(Exception::class);
		$this->expectExceptionMessage("hiba, nem lehetséges a pontszámítás a magyar nyelv és irodalom tárgyból elért 20% alatti eredmény miatt\n");
		$calculator->mandatorySubjectsPassed($mandatorySubjects);
	}

	public function testMandatorySubjectsPassedWithMissingMandatorySubject()
	{
		$graduationResults = [
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '80%'],
			['nev' => 'történelem', 'tipus' => 'közép', 'eredmeny' => '85%'],
			['nev' => 'angol nyelv', 'tipus' => 'közép', 'eredmeny' => '75%'],
		];
		
		$calculator = new BasicPointsCalc($graduationResults);
		
		$mandatorySubjects = [
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép'],
			['nev' => 'történelem', 'tipus' => 'közép'],
			['nev' => 'matematika', 'tipus' => 'közép'],
		];
		$this->expectException(Exception::class);
		$this->expectExceptionMessage("hiba, nem lehetséges a pontszámítás a kötelező érettségi tárgyak hiánya miatt. (hiányzó tárgy: matematika)\n");
		$this->assertFalse($calculator->mandatorySubjectsPassed($mandatorySubjects));
	}

	public function testMandatorySubjectWith20PercentResult()
	{
		$graduationResults = [        
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '20%'],
			['nev' => 'történelem', 'tipus' => 'közép', 'eredmeny' => '90%'],
			['nev' => 'matematika', 'tipus' => 'közép', 'eredmeny' => '90%'],
		];
		
		$calculator = new BasicPointsCalc($graduationResults);
		
		$mandatorySubjects = [        
			['nev' => 'magyar nyelv és irodalom'],
			['nev' => 'történelem'],
			['nev' => 'matematika'],
		];
		
		$this->assertTrue($calculator->mandatorySubjectsPassed($mandatorySubjects));
	}
	
	//requiredSubjectsScore
	public function testRequiredSubjectsScoreWithKozepLevelPassed()
	{
		$results = [
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '60%'],
		];
	
		$calculator = new BasicPointsCalc($results);
	
		$requiredSubject = ['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép'];
	
		$expectedScore = 60;
		$actualScore = $calculator->requiredSubjectsScore([$requiredSubject]);
	
		$this->assertEquals($expectedScore, $actualScore);
	}

	public function testRequiredSubjectScoreWithEmeltLevelSubject()
	{
		$graduationResults = [
			['nev' => 'matematika',	'tipus' => 'emelt',	'eredmeny' => '60%',]
		];
		
		$calculator = new BasicPointsCalc($graduationResults);
		
		$requiredSubject = ['nev' => 'matematika', 'tipus' => 'emelt'];

		$expectedScore = 60;
		$actualScore = $calculator->requiredSubjectsScore([$requiredSubject]);
		$this->assertEquals($expectedScore, $actualScore);
	}
	
	public function testRequiredSubjectScoreWithFailedEmeltLevelSubject()
	{
		$graduationResults = [
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '99%', 'mandatory' => true],
			['nev' => 'történelem', 'tipus' => 'közép', 'eredmeny' => '80%', 'mandatory' => true],
			['nev' => 'matematika', 'tipus' => 'közép', 'eredmeny' => '85%', 'mandatory' => true],
			['nev' => 'informatika', 'tipus' => 'emelt', 'eredmeny' => '80%', 'mandatory' => false],
			['nev' => 'fizika', 'tipus' => 'közép', 'eredmeny' => '75%', 'mandatory' => false],
			['nev' => 'angol nyelv', 'tipus' => 'közép', 'eredmeny' => '90%', 'mandatory' => false],
		];
	
		$calculator = new BasicPointsCalc($graduationResults);
		
		$requiredSubject = [['nev' => 'magyar nyelv és irodalom', 'tipus' => 'emelt']];
		
		$this->expectException(Exception::class);
		$this->expectExceptionMessage("hiba, nem lehetséges a pontszámítás a kötelező érettségi tárgy nem megfelelő szintje miatt. (tárgy: magyar nyelv és irodalom, szintje: közép, elvárt szint: emelt)\n");
		$calculator->requiredSubjectsScore($requiredSubject);
	}
	//highestOptionalSubject
	public function testOneOptionalSubjectPassed()
	{
		$graduationResults = [
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '80%'],
			['nev' => 'történelem', 'tipus' => 'közép', 'eredmeny' => '70%'],
			['nev' => 'matematika', 'tipus' => 'közép', 'eredmeny' => '60%'],
			['nev' => 'fizika', 'tipus' => 'közép', 'eredmeny' => '40%'],
			['nev' => 'informatika', 'tipus' => 'közép', 'eredmeny' => '85%'],
		];
		$calculator = new BasicPointsCalc($graduationResults);
	
		$optionalSubjects = ['biológia', 'fizika', 'informatika', 'kémia'];
		$highestOptionalSubject = $calculator->highestOptionalSubject($optionalSubjects);
		
		$this->assertContains('informatika', $highestOptionalSubject);
	}
	
	public function testHighestOptionalSubjectWithMultipleSubjectsPassed()
	{
		$graduationResults = [
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '60%'],
			['nev' => 'történelem', 'tipus' => 'közép', 'eredmeny' => '70%'],
			['nev' => 'matematika', 'tipus' => 'közép', 'eredmeny' => '80%'],
			['nev' => 'angol nyelv', 'tipus' => 'közép', 'eredmeny' => '90%'],
			['nev' => 'informatika', 'tipus' => 'emelt', 'eredmeny' => '95%'],
			['nev' => 'fizika', 'tipus' => 'emelt', 'eredmeny' => '25%']
		];
		$calculator = new BasicPointsCalc($graduationResults);
		$optionalSubjects = ['informatika', 'fizika', 'történelem'];
		$this->assertContains('informatika', $calculator->highestOptionalSubject($optionalSubjects));
	}

	public function testHighestOptionalSubjectWithNoOptionalSubjectsPassed()
	{
		$graduationResults = [
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '60%'],
			['nev' => 'történelem', 'tipus' => 'közép', 'eredmeny' => '80%'],
			['nev' => 'matematika', 'tipus' => 'közép', 'eredmeny' => '50%']
		];
	
		$calculator = new BasicPointsCalc($graduationResults);
		$optionalSubjects = ['biológia', 'fizika', 'informatika', 'kémia'];
		
		$highestOptionalSubject = $calculator->highestOptionalSubject($optionalSubjects);
		$this->assertContains(0, $highestOptionalSubject);
	}
	
}