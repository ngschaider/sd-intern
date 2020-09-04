<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var Training[] $trainings
 */

use app\components\FormatUtil;
use app\models\Training;
use miloschuman\highcharts\Highcharts;
use yii\web\View;


$data = [];
$i = 0;
foreach($trainings as $training) {
	if(strtotime($training->start) > time()) {
		continue;
	}
	$data[] = [
		strtotime($training->end) * 1000,
		FormatUtil::formatPercentage($training->attendedPercentage),
	];
}
echo Highcharts::widget([
	'options' => [
		"chart" => ["zoomType" => "x", "type" => "column"],
		'title' => ['text' => 'Trainingsanwesenheit'],
		'xAxis' => [
			"type" => "datetime",
		],
		'yAxis' => [
			'title' => ['text' => '']
		],
		'series' => [
			[
				'name' => "",
				'data' => $data,
				"showInLegend" => false,
			]
		]
	]
]);


$data = [];
foreach($trainings as $training) {
	if(strtotime($training->start) > time()) {
		continue;
	}

	$percentage = Training::getAttendancePercentage(strtotime($training->end));
	$data[] = [
		strtotime($training->end) * 1000,
		FormatUtil::formatPercentage($percentage),
	];
}
echo Highcharts::widget([
	'options' => [
		"chart" => ["zoomType" => "x", "type" => "spline"],
		'title' => ['text' => 'Durchschnittliche Trainingsanwesenheit'],
		'xAxis' => [
			"type" => "datetime",
		],
		'yAxis' => [
			'title' => ['text' => '']
		],
		'series' => [
			[
				'name' => "",
				'data' => $data,
				"showInLegend" => false,
			]
		]
	]
]);


$attendedSum = [];
$trainingCount = [];
foreach($trainings as $training) {
	if(strtotime($training->start) > time()) {
		continue;
	}
	$weekday = date("l", strtotime($training->end));

	if(!isset($trainingCount[$weekday])) {
		$trainingCount[$weekday] = 0;
	}
	$trainingCount[$weekday]++;

	if(!isset($attendedSum[$weekday])) {
		$attendedSum[$weekday] = 0;
	}
	$attendedSum[$weekday] += $training->attendedPercentage;
}
$data = [];
$categories = [];
foreach($trainingCount as $weekday => $count) {
	$percentage = FormatUtil::formatPercentage($attendedSum[$weekday] / $trainingCount[$weekday]);

	$categories[] = $weekday;
	$data[] = $percentage;
}
echo Highcharts::widget([
	'options' => [
		"chart" => ["type" => "column"],
		'title' => ['text' => 'Trainingsanwesenheit nach Wochentag'],
		'xAxis' => [
			"title" => ["text" => "Wochentag"],
			'categories' => $categories,
		],
		'yAxis' => [
			"max" => 100,
			'title' => ['text' => ''],
		],
		'series' => [
			[
				"name" => "",
				"data" => $data,
				"showInLegend" => false
			],
		]
	]
]);


$attendedSum = [];
$trainingCount = [];
foreach($trainings as $training) {
	if(strtotime($training->start) > time()) {
		continue;
	}
	$month = date("F", strtotime($training->end));

	if(!isset($trainingCount[$month])) {
		$trainingCount[$month] = 0;
	}
	$trainingCount[$month]++;

	if(!isset($attendedSum[$month])) {
		$attendedSum[$month] = 0;
	}
	$attendedSum[$month] += $training->attendedPercentage;
}
$data = [];
$categories = [];
foreach($trainingCount as $month => $count) {
	$percentage = FormatUtil::formatPercentage($attendedSum[$month] / $trainingCount[$month]);

	$categories[] = $month;
	$data[] = $percentage;
}
echo Highcharts::widget([
	'options' => [
		"chart" => ["type" => "column"],
		'title' => ['text' => 'Trainingsanwesenheit nach Monat'],
		'xAxis' => [
			"title" => ["text" => "Monat"],
			'categories' => $categories,
		],
		'yAxis' => [
			"max" => 100,
			'title' => ['text' => ''],
		],
		'series' => [
			[
				"name" => "",
				"data" => $data,
				"showInLegend" => false
			],
		]
	]
]);