<?php
/**
 * @package app.views.user
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var User $model
 */

use app\models\User;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap4\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model); ?>

<?= $form->field($model, "username") ?>
<?= $form->field($model, "firstname") ?>
<?= $form->field($model, "lastname") ?>
<?= $form->field($model, "password") ?>
<?= $form->field($model, "allowLogin")->checkbox() ?>

    <div class="form-group">
		<?= Html::submitButton("Submit", ["class" => "btn btn-primary"]) ?>
    </div>
<?php ActiveForm::end(); ?>