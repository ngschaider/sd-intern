<?php

namespace app\components;

use app\models\User;
use Yii;
use yii\base\Action;

/**
 * @property-read \app\models\User|null $user
 */
class Controller extends \yii\web\Controller {

	/**
	 * @var bool if this is true, guests will be redirected to the default route when accesing any action of this controller
	 */
	public $loggedInOnly = true;
	/**
	 * @var bool if this is true, non-admins will be redirected to the default route when accesing any action of this controller
	 */
	public $adminOnly = false;


	/**
	 * @return null|User
	 */
	public function getUser() {
		return Yii::$app->user;
	}

	/**
	 * @param Action $action
	 * @return bool
	 * @throws \yii\web\BadRequestHttpException
	 */
	public function beforeAction($action) {
		$this->view->title = Yii::$app->name;

		if($this->adminOnly) {
			$this->loggedInOnly = true;
		}

		if($this->loggedInOnly) {
			if(Yii::$app->user->isGuest) {
				$this->goHome()->send();
				return false;
			}
		}
		if($this->adminOnly) {
			if(!Yii::$app->user->identity->isAdmin) {
				$this->goHome()->send();
				return false;
			}
		}

		return parent::beforeAction($action);
	}

}