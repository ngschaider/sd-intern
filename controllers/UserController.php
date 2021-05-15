<?php

namespace app\controllers;

use app\components\Controller;
use app\components\ModelNotFoundException;
use app\models\User;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserController extends Controller {

	public function behaviors() {
		return [
			"access" => [
				"class" => AccessControl::class,
				"rules" => [
					[
						"allow" => true,
						"roles" => ["users"],
					]
				]
			]
		];
	}

	/**
	 * @return string
	 */
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			"query" => User::find(),
		]);

		return $this->render("index", [
			"dataProvider" => $dataProvider,
		]);
	}

	/**
	 * @return string|Response
	 */
	public function actionCreate() {
		$model = new User();

		if($model->load(Yii::$app->request->post())) {
			if($model->save()) {
				return $this->redirect("index");
			}
		}

		return $this->render("form", [
			"model" => $model,
		]);
	}

	/**
	 * @param $id
	 * @return string|Response
	 * @throws ModelNotFoundException
	 */
	public function actionUpdate($id) {
		$model = User::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		if($model->load(Yii::$app->request->post())) {
			if($model->save()) {
				return $this->redirect("index");
			}
		}

		return $this->render("form", [
			"model" => $model,
		]);
	}

	/**
	 * @param $id
	 * @return Response
	 * @throws Throwable
	 * @throws StaleObjectException
	 */
	public function actionDelete($id) {
		$model = User::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}


		$model->delete();

		return $this->redirect("index");
	}

}