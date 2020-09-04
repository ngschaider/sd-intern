<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\controllers;


use app\components\Controller;
use app\components\ModelNotFoundException;
use app\models\Formation;
use app\models\Frame;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\web\Response;

class FrameController extends Controller {

	/**
	 * @return string
	 */
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			"query" => Frame::find(),
		]);

		return $this->render("index", [
			"dataProvider" => $dataProvider,
		]);
	}

	/**
	 * @return string|Response
	 */
	public function actionCreate() {
		$model = new Frame();

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
	 * @return string|Response
	 * @throws ModelNotFoundException
	 */
	public function actionUpdate($id) {
		$model = Frame::findOne(["id" => $id]);
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
	 * @throws ModelNotFoundException
	 * @throws Throwable
	 * @throws StaleObjectException
	 */
	public function actionDelete($id) {
		$model = Frame::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		$model->delete();

		return $this->redirect(["index"]);
	}

	/**
	 * @param $id
	 * @throws ModelNotFoundException
	 */
	public function actionEditor($id) {
		$model = Frame::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		return $this->render("editor", [
			"model" => $model,
		]);
	}

}