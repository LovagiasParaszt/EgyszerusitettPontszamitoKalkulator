<?php
//input
require_once('homework_input.php');

//reqfiles
require_once 'includes/SubjectResult.php';
require_once 'includes/BasicPointsCalc.php';
require_once 'includes/ExtraPointsCalc.php';
require_once 'includes/RequirementsForChosenCourse.php';
require_once 'includes/TotalPointsCalc.php';

//debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
	$totalPointsCalc = new TotalPointsCalc($exampleData1);
	$totalPoints = $totalPointsCalc->calculateTotalPoints();
	print_r($totalPoints);
} 
catch(Exception $e) {
  echo $e->getMessage();
}