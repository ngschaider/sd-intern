<?php

use yii\base\Component;

/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\components;

use app\assets\FrameEditorAsset;
use app\models\Frame;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class FrameEditor extends Widget {

	/**
	 * @var Frame $model
	 */
	public $model;
	public $width = 0;
	public $height = 0;

	protected $data = null;

	public function init() {
		FrameEditorAsset::register($this->view);

		$this->data = json_encode($this->model->framePositions);
	}

	public function run() {
		echo "<div class='row'>";
		echo "<div class='col-md-8'>";
		echo Html::tag("canvas", "", [
			"id" => $this->id,
		]);
		echo "</div>";
		echo "<div class='col-md-4'>";
		echo Html::button("Neue Position", [
			"class" => "btn btn-primary",
			"id" => $this->id . "-add-position",
		]);
		echo "<br>";
		echo Html::button(UTF8::PLUS, [
			"class" => "btn btn-success",
			"id" => $this->id . "-plus-grid",
		]);
		echo Html::button(UTF8::MINUS, [
			"class" => "btn btn-danger",
			"id" => $this->id . "-minus-grid",
		]);
		echo "</div>";
		echo "</div>";

		// add javascript for the canvas
		$this->view->registerJs("new FrameEditor('" . $this->id . "')");
	}

}