<?php

use PHPUnit\Framework\TestCase;

class TotalPointsCalcTest extends TestCase
{
	
	public function testCalculateTotalPointsWithExtraPointsAndMetRequirements()
	{
		$sampleData = [
			'valasztott-szak' => [
				'egyetem' => 'ELTE',
				'kar' => 'IK',
				'szak' => 'Programtervező informatikus'
			],
			'tobbletpontok' => [
				['kategoria' => 'Nyelvvizsga', 'tipus' => 'B2', 'nyelv' => 'angol',],
				['kategoria' => 'Nyelvvizsga', 'tipus' => 'C1', 'nyelv' => 'német',]
			],
			'erettsegi-eredmenyek' => [
				['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '70%',],
				['nev' => 'történelem', 'tipus' => 'közép', 'eredmeny' => '80%',],
				['nev' => 'matematika', 'tipus' => 'emelt', 'eredmeny' => '90%',],
				['nev' => 'angol nyelv', 'tipus' => 'közép', 'eredmeny' => '94%',],
				['nev' => 'informatika', 'tipus' => 'közép', 'eredmeny' => '95%',],
			]
		];
	
		$totalPointsCalc = new TotalPointsCalc($sampleData);
		$totalPoints = $totalPointsCalc->calculateTotalPoints();
		$this->assertEquals("470 (370 alappont + 100 többletpont)\n", $totalPoints);
	}
	
	public function testCalculateTotalPointsWithExtraPointsAndMetRequirementsAnglisztika()
	{
		$sampleData = [
			'valasztott-szak' => [
				'egyetem' => 'PPKE',
				'kar' => 'BTK',
				'szak' => 'Anglisztika'
			],
			'tobbletpontok' => [
				['kategoria' => 'Nyelvvizsga', 'tipus' => 'B2', 'nyelv' => 'angol',],
				['kategoria' => 'Nyelvvizsga', 'tipus' => 'C1', 'nyelv' => 'német',]
			],
			'erettsegi-eredmenyek' => [
				['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '70%',],
				['nev' => 'történelem', 'tipus' => 'közép', 'eredmeny' => '80%',],
				['nev' => 'matematika', 'tipus' => 'emelt', 'eredmeny' => '90%',],
				['nev' => 'angol nyelv', 'tipus' => 'közép', 'eredmeny' => '94%',],
				['nev' => 'informatika', 'tipus' => 'közép', 'eredmeny' => '95%',],
			]
		];
	
		$totalPointsCalc = new TotalPointsCalc($sampleData);
	
		$this->expectException(Exception::class);
		$this->expectExceptionMessage("hiba, nem lehetséges a pontszámítás a kötelező érettségi tárgy nem megfelelő szintje miatt. (tárgy: angol nyelv, szintje: közép, elvárt szint: emelt)\n");
		$totalPoints = $totalPointsCalc->calculateTotalPoints();
	}	
	
	public function testCalculateTotalPointsWithExtraPointsAndMetRequirementsAnglisztikaSameLanguage()
	{
		$sampleData = [
			'valasztott-szak' => [
				'egyetem' => 'PPKE',
				'kar' => 'BTK',
				'szak' => 'Anglisztika'
			],
			'tobbletpontok' => [
				['kategoria' => 'Nyelvvizsga', 'tipus' => 'B2', 'nyelv' => 'angol',],
				['kategoria' => 'Nyelvvizsga', 'tipus' => 'C1', 'nyelv' => 'angol',]
			],
			'erettsegi-eredmenyek' => [
				['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '70%',],
				['nev' => 'történelem', 'tipus' => 'közép', 'eredmeny' => '80%',],
				['nev' => 'matematika', 'tipus' => 'emelt', 'eredmeny' => '90%',],
				['nev' => 'angol nyelv', 'tipus' => 'emelt', 'eredmeny' => '94%',],
				['nev' => 'informatika', 'tipus' => 'közép', 'eredmeny' => '95%',],
			]
		];
	
		$totalPointsCalc = new TotalPointsCalc($sampleData);
		$totalPoints = $totalPointsCalc->calculateTotalPoints();

		$this->assertEquals("438 (348 alappont + 90 többletpont)\n", $totalPoints);
	}	
	
	public function testCalculateTotalPointsWithExtraPointsAndMetRequirementsAnglisztikaOneLanguage()
	{
		$sampleData = [
			'valasztott-szak' => [
				'egyetem' => 'PPKE',
				'kar' => 'BTK',
				'szak' => 'Anglisztika'
			],
			'tobbletpontok' => [
				['kategoria' => 'Nyelvvizsga', 'tipus' => 'B2', 'nyelv' => 'angol',]
			],
			'erettsegi-eredmenyek' => [
				['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép', 'eredmeny' => '70%',],
				['nev' => 'történelem', 'tipus' => 'közép', 'eredmeny' => '80%',],
				['nev' => 'matematika', 'tipus' => 'emelt', 'eredmeny' => '90%',],
				['nev' => 'angol nyelv', 'tipus' => 'emelt', 'eredmeny' => '94%',],
				['nev' => 'informatika', 'tipus' => 'közép', 'eredmeny' => '95%',],
			]
		];

		$totalPointsCalc = new TotalPointsCalc($sampleData);
		$totalPoints = $totalPointsCalc->calculateTotalPoints();

		$this->assertEquals("426 (348 alappont + 78 többletpont)\n", $totalPoints);
	}	
}