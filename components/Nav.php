<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\components;


use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

class Nav extends \yii\bootstrap4\Nav {

	public function renderItem($item) {
		if($this->shouldRenderItem($item)) {
			return parent::renderItem($item);
		} else {
			return "";
		}
	}

	protected function shouldRenderItem($item) {
		$permission = ArrayHelper::getValue($item, "permission");

		if($permission === "?") {
			return Yii::$app->user->isGuest;
		}
		if($permission === "@") {
			return !Yii::$app->user->isGuest;
		}

		if($permission) {
			return Yii::$app->user->can($permission);
		}

		$items = ArrayHelper::getValue($item, "items", []);
		if(empty($items)) {
			return true;
		}

		return array_reduce($items, function($carry, $item) {
			if($carry) {
				return true;
			}
			return $this->shouldRenderItem($item);
		});
	}

}