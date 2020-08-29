<?php
/**
 * @package app.views.location
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;


echo GridView::widget([
	"dataProvider" => $dataProvider,
]);


echo Html::a("Location erstellen", ["create"]);