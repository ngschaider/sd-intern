<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

use app\components\FrameEditor;

echo FrameEditor::widget([
	"model" => $model,
]);