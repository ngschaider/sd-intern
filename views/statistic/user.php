<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 * @package app.views.statistic
 *
 * @var \yii\web\View $this
 * @var \app\models\User $model
 */

use miloschuman\highcharts\Highcharts;


?>
    <h3>Statistiken zu Benutzer <?= $model->username ?></h3>

<?php
$data = [];
foreach($model->attendancePercentages as $timestamp => $percentage) {
	$data[] = [
		$timestamp * 1000,
		$percentage * 100
	];
}
echo Highcharts::widget([
	'options' => [
		"chart" => ["zoomType" => "x"],
		'title' => ['text' => 'Durchschnittliche Trainingsanwesenheit'],
		'xAxis' => [
			"type" => "datetime",
		],
		'yAxis' => [
			'title' => ['text' => '']
		],
		'series' => [
			['name' => $model->username, 'data' => $data]
		]
	]
]);

$attendedCount = [];
$trainingCount = [];
foreach($model->userTrainings as $userTraining) {
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

$series = [];
$categories = [];
foreach($trainingCount as $weekday => $count) {
	$percentage = 0;
	if(isset($attendedCount[$weekday])) {
		$percentage = $attendedCount[$weekday] / $trainingCount[$weekday] * 100;
	}

	$categories[] = $weekday;
	$series[] = [
		"name" => $weekday,
		"data" => [$percentage],
	];
}

echo Highcharts::widget([
	'options' => [
		"chart" => ["type" => "column"],
		'title' => ['text' => 'Trainingsanwesenheit nach Wochentag'],
		'xAxis' => [
			"title" => ["text" => "Wochentag"],
			'categories' => $categories
		],
		'yAxis' => [
			'title' => ['text' => '']
		],
		'series' => $series
	]
]);