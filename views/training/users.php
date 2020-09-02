<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var Training $model
 */

use app\models\Training;
use app\models\User;
use app\models\Usergroup;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\View;

echo "<h3>" . $model->start . " / " . $model->end . "</h3>";


echo Html::beginForm(["copy-user"], "get", [
	"class" => "form-inline"
]);
echo "Benutzer hinzufügen: ";
echo Html::dropDownList("user_id", null, ArrayHelper::map(User::find()->all(), "id", "username"), [
	"style" => "margin-left: 20px;",
	"class" => "form-control",
]);
echo Html::submitButton("Hinzufügen", [
	"style" => "margin-left: 20px;",
	"class" => "btn btn-primary",
]);
echo Html::endForm();



echo Html::beginForm(["copy-usergroup"], "get", [
	"class" => "form-inline"
]);
echo "Benutzer aus Gruppe hinzufügen: ";
echo Html::hiddenInput("trainingId", $model->id);
echo Html::dropDownList("usergroupId", null, ArrayHelper::map(Usergroup::find()->all(), "id", "name"), [
	"style" => "margin-left: 20px;",
	"class" => "form-control",
]);
echo Html::submitButton("Hinzufügen", [
	"style" => "margin-left: 20px;",
	"class" => "btn btn-primary",
]);
echo Html::endForm();

echo "<hr>";

foreach($model->userTrainings as $model) {
	echo $this->render("_userTraining", [
		"model" => $model,
	]);
}