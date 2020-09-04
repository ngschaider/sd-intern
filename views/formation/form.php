<?php
/**
 * @package app.views.formation
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var Formation $model
 */

use app\models\Formation;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap4\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model); ?>

<?= $form->field($model, "name") ?>

	<div class="form-group">
		<?= Html::submitButton("Submit", ["class" => "btn btn-primary"]) ?>
	</div>
<?php ActiveForm::end(); ?>