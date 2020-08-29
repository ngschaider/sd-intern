<?php
/**
 * @package app.views.training
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var Training $model
 */

use app\models\Training;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap4\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model); ?>

<?= $form->field($model, "name") ?>
<?= $form->field($model, "location_id")->dropDownList(ArrayHelper::map(Training::find()->all(), "id", "name")); ?>

	<div class="form-group">
		<?= Html::submitButton("Submit", ["class" => "btn btn-primary"]) ?>
	</div>
<?php ActiveForm::end(); ?>