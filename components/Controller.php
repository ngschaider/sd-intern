<?php

namespace app\components;

use Yii;
use yii\base\Action;
use yii\web\BadRequestHttpException;

class Controller extends \yii\web\Controller {

	/**
	 * @param Action $action
	 * @return bool
	 * @throws BadRequestHttpException
	 */
	public function beforeAction($action) {
		$this->view->title = Yii::$app->name;

		return parent::beforeAction($action);
	}

}