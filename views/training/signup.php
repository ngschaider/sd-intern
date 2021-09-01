<?php
/**
 * @package app.views.trainings
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 */


use app\models\Training;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/** @var Training[] $models */
$models = Training::find()->orderBy(["start" => SORT_DESC])->all();


foreach($models as $model) {
	?>
    <div class="card">
        <div class="card-body">
            <h5><?= $model->startEndReadable ?></h5>
            <h6><?= $model->location->name ?></h6>
            <div class="float-right">Teilnehmer: <?= count($model->attendedUsers) ?> / <?= $model->maxUsers ?></div>
            <div>
                <b>Status:</b> <?= Yii::$app->user->identity->didAttendTraining($model) ? "<span style='color: green'>Angemeldet</span>" : "<span style='color: red'>Nicht angemeldet</span>"; ?>
            </div>

	        <?php if(Yii::$app->user->identity->canSignup($model)) {
		        echo Html::beginForm();
		        echo Html::hiddenInput("trainingId", $model->id);
                echo Html::hiddenInput("status", "true");
		        echo Html::submitButton("Anmelden", [
			        "class" => "btn btn-primary"
                ]);
                echo Html::endForm();
	        } else if(Yii::$app->user->identity->canSignoff($model)) {
		        echo Html::beginForm();
		        echo Html::hiddenInput("trainingId", $model->id);
                echo Html::hiddenInput("status", "false");
		        echo Html::submitButton("Abmelden", [
			        "class" => "btn btn-danger"
                ]);
                echo Html::endForm();
	        } ?>
        </div>


    </div>
	<?php
}