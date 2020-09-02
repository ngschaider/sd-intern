<?php
/**
 * @package app.views.training
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

use app\components\UTF8;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;


echo GridView::widget([
	"dataProvider" => $dataProvider,
	"columns" => [
		"id",
		"location.name",
		"start:datetime",
		"end:datetime",
		[
			"class" => "app\components\ActionColumn",
			"template" => "{view}{update}{delete}{users}",
			"customButtons" => [
				"users" => function($url, $model, $key) {
					return Html::a(UTF8::MAN_DANCING . UTF8::WOMAN_DANCING, $url);
				}
			],
		],
		"attendedCount",
		"notAttendedCount",
	],
]);


echo Html::a("Training erstellen", ["create"]);