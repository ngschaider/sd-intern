<?php
/**
 * @package app.views.usergroup
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var User $model
 */

use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap4\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model); ?>

<?= $form->field($model, "name") ?>
<?= $form->field($model, "userIds")->dropdownList(ArrayHelper::map(User::find()->all(), "id", "username"), [
	"multiple" => true,
]) ?>

    <div class="form-group">
		<?= Html::submitButton("Submit", ["class" => "btn btn-primary"]) ?>
    </div>
<?php ActiveForm::end(); ?>