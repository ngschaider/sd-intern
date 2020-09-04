<?php
/**
 * @package app.views.frame
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var Frame $model
 */

use app\models\Formation;
use app\models\Frame;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap4\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model); ?>

<?= $form->field($model, "name") ?>
<?= $form->field($model, "formationId")->dropDownList(ArrayHelper::map(Formation::find()->all(), "id", "name")) ?>

	<div class="form-group">
		<?= Html::submitButton("Submit", ["class" => "btn btn-primary"]) ?>
	</div>
<?php ActiveForm::end(); ?>