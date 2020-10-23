<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\controllers;


use app\components\Controller;
use app\components\ModelNotFoundException;
use app\models\Formation;
use app\models\Frame;
use app\models\FramePosition;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class FrameController extends Controller {

	public function behaviors() {
		return [
			"access" => [
				"class" => AccessControl::class,
				"rules" => [
					[
						"allow" => true,
						"roles" => ["frames"],
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
	 * @param $id
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
	 * @return string
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

	/**
	 * @param $id
	 * @return Response
	 * @throws BadRequestHttpException
	 * @throws ModelNotFoundException
	 */
	public function actionSubmit($id) {
		if(!Yii::$app->request->isPost) {
			throw new BadRequestHttpException();
		}

		$frame = Frame::findOne(["id" => $id]);
		if(!$frame) {
			throw new ModelNotFoundException();
		}

		$framePositions = Yii::$app->request->post("FramePosition", []);

		$status = "success";
		$newIds = [];
		foreach($framePositions as $framePosition) {
			if(isset($framePosition["id"])) {
				$model = FramePosition::findOne(["id" => $framePosition["id"]]);
				if(!$model) {
					throw new ModelNotFoundException();
				}
			} else {
				$model = new FramePosition();
				$model->frameId = $frame->id;
			}

			$model->setAttributes($framePosition);

			if($model->isNewRecord) {
				if($model->save()) {
					$newIds[] = $model->id;
				} else {
					$status = "error";
				}
			} else {
				if(!$model->save()) {
					$status = "error";
				}
			}
		}

		return $this->asJson([
			"status" => "success",
			"newIds" => $newIds,
		]);
	}

	public function actionList($id) {
		$models = Frame::findAll(["formationId" => $id]);

		return $this->render("list", [
			"models" => $models,
		]);
	}

}