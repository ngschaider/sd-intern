<?php
/**
 * @package app.views.user
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

?>

<?php

echo GridView::widget([
	"dataProvider" => $dataProvider,
	"columns" => [
		[
			"class" => "yii\grid\SerialColumn",
		],
		"username",
		"enabled:boolean",
		"allow_login:boolean",
		[
			"class" => "app\components\ActionColumn",
		]
	]
]);

echo Html::a("Benutzer erstellen", ["create"]);

?>
