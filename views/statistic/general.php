<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var Training[] $trainings
 */

use app\models\Training;
use miloschuman\highcharts\Highcharts;
use yii\web\View;


$data = [];
foreach($trainings as $training) {
	$data[] = [
		strtotime($training->end) * 1000,
		$training->attendedPercentage * 100
	];
}
echo Highcharts::widget([
	'options' => [
		"chart" => ["zoomType" => "x",
			"type" => "spline"],
		'title' => ['text' => 'Trainingsanwesenheit'],
		'xAxis' => [
			"type" => "datetime",
		],
		'yAxis' => [
			'title' => ['text' => '']
		],
		'series' => [
			['name' => "", 'data' => $data]
		]
	]
]);


$data = [];
foreach($trainings as $training) {
	$data[] = [
		strtotime($training->end) * 1000,
		Training::getAttendancePercentage(strtotime($training->end)) * 100,
	];
}

echo Highcharts::widget([
	'options' => [
		"chart" => ["zoomType" => "x",
			"type" => "spline"],
		'title' => ['text' => 'Durchschnittliche Trainingsanwesenheit'],
		'xAxis' => [
			"type" => "datetime",
		],
		'yAxis' => [
			'title' => ['text' => '']
		],
		'series' => [
			['name' => "", 'data' => $data]
		]
	]
]);