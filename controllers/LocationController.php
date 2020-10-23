<?php

namespace app\controllers;

use app\components\Controller;
use app\components\ModelNotFoundException;
use app\models\Location;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * @oackage app.controllers
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */
class LocationController extends Controller {

	public function behaviors() {
		return [
			"access" => [
				"class" => AccessControl::class,
				"rules" => [
					[
						"allow" => true,
						"roles" => ["locations"],
					]
				]
			]
		];
	}

	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			"query" => Location::find()
		]);

		return $this->render("index", [
			"dataProvider" => $dataProvider
		]);
	}

	public function actionCreate() {
		$model = new Location();

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
		$model = Location::findOne(["id" => $id]);
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
	 * @return Response
	 * @throws ModelNotFoundException
	 * @throws Throwable
	 * @throws StaleObjectException
	 */
	public function actionDelete($id) {
		$model = Location::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		$model->delete();

		return $this->redirect("index");
	}

}
