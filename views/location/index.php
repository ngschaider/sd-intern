<?php
/**
 * @package app.views.location
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

use yii\data\ActiveDataProvider;
use app\components\GridView;
use yii\helpers\Html;
use yii\web\View;


echo GridView::widget([
	"dataProvider" => $dataProvider,
	"columns" => [
		"id",
		"name",
		[
			"class" => "app\components\ActionColumn",
			"visibleButtons" => [
				"view" => false,
			],
		],
	]
]);


echo Html::a("Location erstellen", ["create"]);