<?php

namespace app\controllers;

use app\components\Controller;
use app\components\ModelNotFoundException;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class UserController extends Controller {

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
	 * @return string|\yii\web\Response
	 */
	public function actionCreate() {
		$model = new User();

		if($model->load(Yii::$app->request->post())) {
			if($model->save()) {
				return $this->redirect("index");
			}
		}

		return $this->render("_form", [
			"model" => $model,
		]);
	}

	/**
	 * @param $id
	 * @return string|\yii\web\Response
	 * @throws NotFoundHttpException
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

		return $this->render("_form", [
			"model" => $model,
		]);
	}

	/**
	 * @param $id
	 * @return \yii\web\Response
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
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