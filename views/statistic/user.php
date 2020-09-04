<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 * @package app.views.statistic
 *
 * @var \yii\web\View $this
 * @var \app\models\User $model
 */

use app\components\FormatUtil;
use miloschuman\highcharts\Highcharts;


?>
    <h3>Statistiken zu Benutzer <?= $model->username ?></h3>

<?php
$data = [];
$maxPercentage = 0;
foreach($model->attendancePercentages as $timestamp => $percentage) {
	$percentage = FormatUtil::formatPercentage($percentage);
	$data[] = [
		$timestamp * 1000,
		$percentage
	];
	if($percentage > $maxPercentage) {
		$maxPercentage = $percentage;
	}
}
echo Highcharts::widget([
	'options' => [
		"chart" => ["zoomType" => "x", "type" => "spline"],
		'title' => ['text' => 'Durchschnittliche Trainingsanwesenheit'],
		'xAxis' => [
			"type" => "datetime",
		],
		'yAxis' => [
			"max" => $maxPercentage,
			'title' => ['text' => ''],
		],
		'series' => [
			[
				'name' => $model->username,
				'data' => $data,
				"showInLegend" => false,
			]
		]
	]
]);


$attendedCount = [];
$trainingCount = [];
foreach($model->userTrainings as $userTraining) {
	if(strtotime($userTraining->training->start) > time()) {
		continue;
	}

	$weekday = date("l", strtotime($userTraining->training->end));

	if(!isset($trainingCount[$weekday])) {
		$trainingCount[$weekday] = 0;
	}
	$trainingCount[$weekday]++;

	if($userTraining->attended) {
		if(!isset($attendedCount[$weekday])) {
			$attendedCount[$weekday] = 0;
		}
		$attendedCount[$weekday]++;
	}
}
$data = [];
$categories = [];
foreach($trainingCount as $weekday => $count) {
	$percentage = 0;
	if(isset($attendedCount[$weekday])) {
		$percentage = FormatUtil::formatPercentage($attendedCount[$weekday] / $trainingCount[$weekday]);
	}

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
				"name" => $model->username,
				"data" => $data,
				"showInLegend" => false
			],
		]
	]
]);


$attendedCount = [];
$trainingCount = [];
foreach($model->userTrainings as $userTraining) {
	if(strtotime($userTraining->training->start) > time()) {
		continue;
	}
	$month = date("F", strtotime($userTraining->training->end));

	if(!isset($trainingCount[$month])) {
		$trainingCount[$month] = 0;
	}
	$trainingCount[$month]++;

	if($userTraining->attended) {
		if(!isset($attendedCount[$month])) {
			$attendedCount[$month] = 0;
		}
		$attendedCount[$month]++;
	}
}
$data = [];
$categories = [];
foreach($trainingCount as $month => $count) {
	$percentage = 0;
	if(isset($attendedCount[$month])) {
		$percentage = FormatUtil::formatPercentage($attendedCount[$month] / $trainingCount[$month]);
	}

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
				"name" => $model->username,
				"data" => $data,
				"showInLegend" => false
			],
		]
	]
]);