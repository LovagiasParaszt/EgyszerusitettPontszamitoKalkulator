<?php
class BasicPointsCalc {
    private $graduationResults;

    public function __construct($graduationResults) {
        $this->graduationResults = array_map(function ($result) {
            return new SubjectResult($result['nev'], $result['tipus'], $result['eredmeny'], true);
        }, $graduationResults);
    }

	public function mandatorySubjectsPassed($mandatorySubjects) {
		$passed = true;
		foreach ($mandatorySubjects as $subject) {
			$result = $this->getResultByName($subject['nev']);
			$subjectName = $subject['nev'];
			if (!$result) {
				throw new Exception("hiba, nem lehetséges a pontszámítás a kötelező érettségi tárgyak hiánya miatt. (hiányzó tárgy: $subjectName)\n");
			}
	
			if (!$result || !$result->passed()) {
				$passed = false;
				throw new Exception("hiba, nem lehetséges a pontszámítás a $subjectName tárgyból elért 20% alatti eredmény miatt\n");
			}
		}
		return $passed;
	}	
	

    public function requiredSubjectsScore($requiredSubject) {
        $requiredSubjectScore = 0;
        foreach ($this->graduationResults as $result) {
			foreach ($requiredSubject as $subject) {
				$subjectName = $subject['nev'];
				$subjectLevel = $subject['tipus'];
				if ($result->getNev() === $subject['nev'] ) {	
					switch ($subject['tipus']) {
						case 'közép':
							if ($result->getTipus() !== 'közép' && $result->getTipus() !== 'emelt') {
								echo '1';
							}
							break;
				
						case 'emelt':
							if ($result->getTipus() !== 'emelt') {
								$currentLevel = $result->getTipus();
								throw new Exception("hiba, nem lehetséges a pontszámítás a kötelező érettségi tárgy nem megfelelő szintje miatt. (tárgy: $subjectName, szintje: $currentLevel, elvárt szint: $subjectLevel)\n");
							}
							break;
				
						default:
							break;
					}
					$requiredSubjectScore = (int) rtrim($result->getEredmeny(), '%');
				}
			}	
		}

        return $requiredSubjectScore;
    }
	
	public function highestOptionalSubject($optionalSubjects) {
		$highestOptionalScore = 0;
		$highestOptionalSubject = '';
        foreach ($this->graduationResults as $result) {
			if (in_array($result->getNev(), $optionalSubjects)) {
				$eredmenyScore = (int) rtrim($result->getEredmeny(), '%');
				if ($eredmenyScore > $highestOptionalScore) {
					$highestOptionalSubject = $result->getNev();
					$highestOptionalScore = $eredmenyScore;
				}
			}			
		}	
		return ['name' => $highestOptionalSubject, 'score' => $highestOptionalScore];
	}

    private function getResultByName($name) {
        foreach ($this->graduationResults as $result) {
            if ($result->getNev() === $name) {
                return $result;
            }
        }
        return null;
    }
}
