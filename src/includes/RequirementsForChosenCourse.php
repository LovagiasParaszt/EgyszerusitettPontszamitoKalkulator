<?php
class RequirementsForChosenCourse {
    private $chosenCourse;

    public function __construct($chosenCourse)
    {
        $this->chosenCourse = $chosenCourse;
    }

    public function getEgyetem()
    {
        return $this->chosenCourse['egyetem'];
    }

    public function getKar()
    {
        return $this->chosenCourse['kar'];
    }

    public function getSzak()
    {
        return $this->chosenCourse['szak'];
    }

	public function requirementsForTheCourse(){
		$requiredSubject = [];
		$optionalSubjects = [];
		
		$mandatorySubjects = [
			['nev' => 'magyar nyelv és irodalom', 'tipus' => 'közép'],
			['nev' => 'történelem', 'tipus' => 'közép'],
			['nev' => 'matematika', 'tipus' => 'közép'],
		];		

		
        switch (true) {
            case ($this->chosenCourse['szak'] == 'Programtervező informatikus' && $this->chosenCourse['kar'] == 'IK' && $this->chosenCourse['egyetem'] == 'ELTE'):
				$requiredSubject = array([
					'nev' => 'matematika',
					'tipus' => 'közép'
				]);
                $optionalSubjects = ['biológia', 'fizika', 'informatika', 'kémia'];
                break;
            case ($this->chosenCourse['szak'] == 'Anglisztika' && $this->chosenCourse['kar'] == 'BTK' && $this->chosenCourse['egyetem'] == 'PPKE'):
                $requiredSubject = array([
					'nev' => 'angol nyelv',
					'tipus' => 'emelt'
					]);	
                $optionalSubjects = ['francia', 'német', 'olasz', 'orosz', 'spanyol', 'történelem'];
                break;
			default:
				throw new Exception("hiba, nem lehetséges a pontszámítás az intézmény/kar/szak nem megfelelő\n");
				//echo 'hiba, nem lehetséges a pontszámítás az intézmény/kar/szak nem megfelelő';
				//exit;
				break;
            // ha több szak lenne
        }	

		$requirements = new stdClass();
		$requirements->kotelezoTantargy = $requiredSubject;
		$requirements->valasztottTantargyak = $optionalSubjects;
		$requirements->alapTantargyak = $mandatorySubjects;
		return $requirements;

	}
}