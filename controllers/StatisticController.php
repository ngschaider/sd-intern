<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\controllers;


use app\components\Controller;
use app\components\ModelNotFoundException;
use app\models\Training;
use app\models\User;
use yii\filters\AccessControl;

class StatisticController extends Controller {

	public function behaviors() {
		return [
			"access" => [
				"class" => AccessControl::class,
				"rules" => [
					[
						"allow" => true,
						"roles" => ["statistics"],
					]
				]
			]
		];
	}

	public function actionUser($id) {
		$model = User::findOne(["id" => $id]);

		if(!$model) {
			throw new ModelNotFoundException();
		}

		return $this->render("user", [
			"model" => $model,
		]);
	}

	public function actionGeneral() {
		$trainings = Training::find()->all();

		return $this->render("general", [
			"trainings" => $trainings,
		]);
	}

	public function actionIndex() {
		return $this->render("index");
	}

}