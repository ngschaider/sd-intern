<?php
/**
 * @package app.views.frame
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @var View $this
 * @var Frame[] $models
 */

use app\components\FrameEditor;
use app\models\Frame;
use yii\web\View;

foreach($models as $model) {
	echo FrameEditor::widget([
		"model" => $model,
		"readonly" => true,
	]);
}
