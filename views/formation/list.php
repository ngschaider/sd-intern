<?php
/**
 * @package app.views.formation
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

use yii\data\ActiveDataProvider;
use app\components\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;


echo GridView::widget([
	"dataProvider" => $dataProvider,
	"columns" => [
		"id",
		"name",
		[
			"class" => "app\components\ActionColumn",
			"template" => "{list-frames}",
			"buttons" => [
				"list-frames" => function($url, $model) {
					return Html::a("-->", ["/frame/list", "id" => $model->id]);
				}
			]
		],
	]
]);


echo Html::a("Formation erstellen", ["create"]);