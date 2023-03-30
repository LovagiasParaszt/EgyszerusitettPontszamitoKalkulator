<?php
class TotalPointsCalc {
	private $sampleData;
    private $chosenCourse;
    private $graduationResults;	
    private $extraPoints;
    private $basicPointsCalc;

    public function __construct($sampleData) {
        $this->chosenCourse = $sampleData['valasztott-szak'];
        $this->extraPoints = $sampleData['tobbletpontok'];
        $this->graduationResults = $sampleData['erettsegi-eredmenyek'];
		$this->basicPointsCalc = new BasicPointsCalc($sampleData['erettsegi-eredmenyek']);
    }

    public function calculateTotalPoints() {
		$kovetelmeny = (new RequirementsForChosenCourse($this->chosenCourse))->requirementsForTheCourse();

		//alaptárgyak
		$requiredScore = $this->basicPointsCalc->requiredSubjectsScore($kovetelmeny->kotelezoTantargy);
		$highestOptionalSubject = $this->basicPointsCalc->highestOptionalSubject($kovetelmeny->valasztottTantargyak);	
		$basicScore = ($requiredScore+$highestOptionalSubject['score'])*2;
		
		if (!$this->basicPointsCalc->mandatorySubjectsPassed($kovetelmeny->alapTantargyak)) {
			exit;
		}
		
		//tobbletpontok
        $extraPointsCalc = new ExtraPointsCalc($this->extraPoints, $this->graduationResults);
		$extraScore = $extraPointsCalc->calculateTotalExtraPoints($kovetelmeny->kotelezoTantargy, $kovetelmeny->valasztottTantargyak);

		$totalScore = $basicScore+$extraScore;
		$finalResult = "$totalScore ($basicScore alappont + $extraScore többletpont)\n";
		//return $totalScore;
        return $finalResult;
    }
}