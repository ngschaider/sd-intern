<?php
/**
 * @package app.views.frame
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

use app\components\UTF8;
use yii\data\ActiveDataProvider;
use app\components\GridView;
use yii\helpers\Html;
use yii\web\View;


echo GridView::widget([
	"dataProvider" => $dataProvider,
	"columns" => [
		"id",
		"name",
		"formation.name",
		[
			"class" => "app\components\ActionColumn",
			"visibleButtons" => [
				"view" => false,
			],
			"customButtons" => [
				"editor" => function($url, $model, $key) {
					return Html::a(UTF8::SQUARE_CROSSHATCH, $url);
				},
			],
			"template" => "{update}{delete}{editor}",
		],
	]
]);


echo Html::a("Formation erstellen", ["create"]);