<?php
class ExtraPointsCalc {
    private $tobbletpontok;
    private $graduationResults;

    public function __construct($tobbletpontok, $graduationResults)
    {
        $this->tobbletpontok = $tobbletpontok;
        $this->graduationResults = array_map(function ($result) {
            return new SubjectResult($result['nev'], $result['tipus'], $result['eredmeny'], true);
        }, $graduationResults);
    }

	public function calculateTotalExtraPoints($requiredSubject, $optionalSubjects){
		
    $totalEmeltPontszam = $this->calculateEmeltSubjectPoints($requiredSubject, $optionalSubjects);
    $totalNyelvVizsgaPontszam = $this->calculateLanguagePoints();		
		
		$sum = $totalEmeltPontszam + $totalNyelvVizsgaPontszam;
		if ($sum > 100) {
			$sum = 100;
		}
		return $sum;
	}

	private function calculateLanguagePoints()
	{
		$tobbletPont = [];
		foreach ($this->tobbletpontok as $exam) {
			if ($exam['kategoria'] === 'Nyelvvizsga') {
				$lang = $exam['nyelv'];
				$level = $exam['tipus'];
				$score = 0;
				if (!isset($tobbletPont[$lang])) {
					if ($level === 'B2') {
						$score = 28;
					} elseif ($level === 'C1') {
						$score = 40;
					}
					$tobbletPont[$lang] = $score;
				} else {
					if ($level === 'C1') {
						$tobbletPont[$lang] = 40;
					}
				}
			}
		}
		return array_sum($tobbletPont);
	}

    private function calculateEmeltSubjectPoints($requiredSubject, $optionalSubjects) {
        $requiredSubjectsScore = 0;
        $optionalSubjectsScore = 0;
		$totalEmeltPontszam = 0;
        foreach ($this->graduationResults as $result) {
            $isEmelt = false;
            if (in_array($result->getTipus(), ['emelt'])) {
                if ($result->getTipus() === 'emelt') {
                    $isEmelt = true;
                }

                if (in_array($result->getNev(), array_column($requiredSubject, 'nev')) && $isEmelt) {
                    $requiredSubjectsScore += 50;
                } elseif (in_array($result->getNev(), $optionalSubjects) && $isEmelt) {
                    $optionalSubjectsScore += 50;
                }
            }
        }
		$totalEmeltPontszam = $requiredSubjectsScore + $optionalSubjectsScore;
        return $totalEmeltPontszam;
    }

	
}