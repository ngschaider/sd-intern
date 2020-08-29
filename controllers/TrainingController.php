<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\controllers;

use app\components\Controller;
use app\components\ModelNotFoundException;
use app\models\Training;
use Yii;
use yii\data\ActiveDataProvider;

class TrainingController extends Controller {

	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			"query" => Training::find()
		]);

		return $this->render("index", [
			"dataProvider" => $dataProvider
		]);
	}

	public function actionCreate() {
		$model = new Training();

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
	 * @return string|\yii\web\Response
	 * @throws ModelNotFoundException
	 */
	public function actionUpdate($id) {
		$model = Training::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		if($model->load(Yii::$app->request->post())) {
			if($model->save()) {
				return $this->redirect("index");
			}
		}

		return $this->render("form", [
			"model" => $model
		]);
	}

	/**
	 * @param $id
	 * @return \yii\web\Response
	 * @throws ModelNotFoundException
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 */
	public function actionDelete($id) {
		$model = Training::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		$model->delete();

		return $this->redirect("index");
	}

}
