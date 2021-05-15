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
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class FrameEditor extends Widget {

	/**
	 * @var Frame $model
	 */
	public $model;
	public $width = 0;
	public $height = 0;
	public $readonly = false;

	protected $data = null;

	public function init() {
		FrameEditorAsset::register($this->view);

		$this->data = ArrayHelper::getColumn($this->model->framePositions, "attributes");
		$this->data = json_encode($this->data);
	}

	public function run() {
		if(!$this->readonly) {
			echo "<div class='row'>";
			echo "<div class='col-md-8'>";
		}

		echo Html::tag("canvas", "", [
			"id" => $this->id,
		]);

		if(!$this->readonly) {
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
			echo Html::input("number", "", "", [
				"class" => "form-control d-none",
				"id" => $this->id . "-number",
				"min" => 0,
				"max" => 99,
			]);
			echo Html::dropDownList("", null, ["cyan" => "Herr", "pink" => "Dame"], [
				"class" => "form-control d-none",
				"id" => $this->id . "-color",
			]);
			echo Html::input("number", "", "", [
				"class" => "form-control d-none",
				"id" => $this->id . "-position-x",
				"step" => 0.01,
				"min" => 0,
				"max" => 1,
			]);
			echo Html::input("number", "", "", [
				"class" => "form-control d-none",
				"id" => $this->id . "-position-y",
				"step" => 0.01,
				"min" => 0,
				"max" => 1,
			]);
			echo Html::input("number", "", "", [
				"class" => "form-control d-none",
				"id" => $this->id . "-rotation",
				"step" => 1,
				"min" => 0,
				"max" => 360,
			]);
			echo "<br>";
			echo Html::button("Speichern", [
				"class" => "btn btn-primary",
				"id" => $this->id . "-submit",
			]);
			echo "</div>";
			echo "</div>";
		}


		// add javascript for the canvas
		$submitUrl = Url::to(["/frame/submit", "id" => $this->model->id]);
		$this->view->registerJs("new FrameEditor('" . $this->id . "', " . $this->data . ", '" . $submitUrl . "', " . $this->readonly . ")");
	}

}