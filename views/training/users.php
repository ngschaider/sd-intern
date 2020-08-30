<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var Training $model
 */

use app\models\Training;
use app\models\Usergroup;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

echo Html::beginForm(["copyUsergroup"]);
echo Html::hiddenInput("training_id", $model->id);
echo Html::dropDownList("usergroup_id", ArrayHelper::map(Usergroup::find()->all(), "id", "name"));
echo Html::endForm();

foreach($model->userTrainings as $user) {
	echo $this->renderFile("_user", [
		"user" => $user,
		"model" => $model,
	]);
}