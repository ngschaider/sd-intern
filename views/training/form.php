<?php
/**
 * @package app.views.training
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var Training $model
 */

use app\models\Location;
use app\models\Training;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap4\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model); ?>

<?= $form->field($model, "locationId")->dropDownList(ArrayHelper::map(Location::find()->all(), "id", "name")); ?>
<?= $form->field($model, "start")->widget(DateControl::class, [
	"type" => DateControl::FORMAT_DATETIME,
]); ?>
<?= $form->field($model, "end")->widget(DateControl::class, [
	"type" => DateControl::FORMAT_DATETIME
]); ?>
<?= $form->field($model, "isOptional")->checkbox(); ?>

    <div class="form-group">
		<?= Html::submitButton("Submit", ["class" => "btn btn-primary"]) ?>
    </div>
<?php ActiveForm::end(); ?>