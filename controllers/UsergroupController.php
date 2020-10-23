<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\controllers;

use app\components\Controller;
use app\components\ModelNotFoundException;
use app\models\Usergroup;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Response;

class UsergroupController extends Controller {

	public function behaviors() {
		return [
			"access" => [
				"class" => AccessControl::class,
				"rules" => [
					[
						"allow" => true,
						"roles" => ["usergroups"],
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
			"query" => Usergroup::find()
		]);

		return $this->render("index", [
			"dataProvider" => $dataProvider
		]);
	}

	/**
	 * @return string|Response
	 */
	public function actionCreate() {
		$model = new Usergroup();

		if($model->load(Yii::$app->request->post())) {
			if($model->save()) {
				return $this->redirect(["index"]);
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
		$model = Usergroup::findOne(["id" => $id]);

		if(!$model) {
			throw new ModelNotFoundException();
		}

		if($model->load(Yii::$app->request->post())) {
			if($model->save()) {
				return $this->redirect(["index"]);
			}
		}

		return $this->render("form", [
			"model" => $model,
		]);
	}

	/**
	 * @param $id
	 * @return string
	 * @throws ModelNotFoundException
	 */
	public function actionView($id) {
		$model = Usergroup::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		return $this->render("view", [
			"model" => $model,
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
		$model = Usergroup::findOne(["id" => $id]);

		if(!$model) {
			throw new ModelNotFoundException();
		}

		$model->delete();

		return $this->redirect(["index"]);
	}

}