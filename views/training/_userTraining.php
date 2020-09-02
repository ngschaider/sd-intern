<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var UserTraining $model
 */

use app\models\UserTraining;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
			<?= Html::a("X", ["delete-user", "id" => $model->id], [
				"class" => "btn btn-danger",
			]); ?>
        </div>
        <input type="text" class="form-control" value="<?= $model->user->username ?>" disabled>
        <div class="input-group-append">
            <div class="input-group-text">
                <input type="checkbox" class="trainer" data-id="<?= $model->id ?>" <?= $model->isTrainer ? "checked" : "" ?>>&nbsp;Trainer
            </div>
        </div>
        <div class="input-group-append btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-success active">
                <input type="radio" name="options" class="attended" autocomplete="off" <?= $model->attended ? "checked" : "" ?>
                       data-id="<?= $model->id ?>"
                       data-value="true"> Yes
            </label>
            <label class="btn btn-danger">
                <input type="radio" name="options" class="attended" autocomplete="off" <?= $model->attended ? "" : "checked" ?>
                       data-id="<?= $model->id ?>"
                       data-value="false"> No
            </label>
        </div>
    </div>


<?php ob_start() ?>
    $(".attended").change(function(e) {
        const $el = $(this);
        const id = $el.data("id");
        const value = $el.data("value");

        console.log(id + "=" + value);
        $.get("<?= Url::to(["attended"]) ?>?id=" + id + "&value=" + value, function(data, status) {
            console.log(data);
        });
    });
    $(".trainer").change(function(e) {
        const $el = $(this);
        const id = $el.data("id");
        const value = $el.prop("checked");

        console.log(id + "=" + value);
        $.get("<?= Url::to(["trainer"]) ?>?id=" + id + "&value=" + value, function(data, status) {
            console.log(data);
        });
    });
<?php
$js = ob_get_clean();
$this->registerJs($js);