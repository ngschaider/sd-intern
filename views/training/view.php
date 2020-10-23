<?php
/**
 * @package app.views.training
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 *
 * @var View $this
 * @var Training $model
 */

use app\models\Training;
use yii\web\View;

?>


    <h3>Training #<?= $model->id ?></h3>

    <b>Ort: </b><?= $model->location->name ?> (#<?= $model->location->id ?>)<br>
    <b>Teilnehmer: </b><?= count($model->userTrainings) === 0 ? "Keine" : "" ?>
<?php if(count($model->userTrainings) > 0) {
	echo "<ul>";
	foreach($model->userTrainings as $userTraining) {
	    $attendedStr = "";
	    if($userTraining->attended) {
	        $attendedStr = "<span style='background-color: green; color: white;'>Anwesend</span>";
        } else {
	        $attendedStr = "<span style='background-color: red; color: white;'>Abwesend</span>";
        }

		echo "<li>" . $userTraining->user->username . " (" . $attendedStr . ")</li>";
	}
	echo "</ul>";
} ?>
