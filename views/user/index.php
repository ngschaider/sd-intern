<?php
/**
 * @package app.views.user
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

use app\models\User;
use yii\data\ActiveDataProvider;
use app\components\GridView;
use yii\helpers\Html;
use yii\web\View;

?>

<?= Html::a("Benutzer erstellen", ["create"], ["class" => "btn btn-success"]); ?>

<?= GridView::widget([
	"dataProvider" => $dataProvider,
	"columns" => [
		[
			"class" => "yii\grid\SerialColumn",
		],
		"username",
		"firstname",
		"lastname",
		"allowLogin:boolean",
		[
			"class" => "app\components\ActionColumn",
			"visibleButtons" => [
				"delete" => function($model, $key, $index) {
					/** @var User $model */
					return !$model->isSuperadmin;
				},
				"view" => false,
			]
		]
	]
]); ?>
