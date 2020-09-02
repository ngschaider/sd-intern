<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\controllers;

use app\components\Controller;
use app\components\ModelNotFoundException;
use app\models\Training;
use app\models\User;
use app\models\Usergroup;
use app\models\UserTraining;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\web\Response;

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
		$model = Training::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		if($model->load(Yii::$app->request->post())) {
			if($model->save()) {
				return $this->redirect(["index"]);
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
		$model = Training::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		$model->delete();

		return $this->redirect("index");
	}

	/**
	 * @param $id
	 * @return string
	 * @throws ModelNotFoundException
	 */
	public function actionUsers($id) {
		$model = Training::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		return $this->render("users", [
			"model" => $model,
		]);
	}

	/**
	 * @param $trainingId
	 * @param $usergroupId
	 * @return Response
	 * @throws ModelNotFoundException
	 */
	public function actionCopyUsergroup($trainingId, $usergroupId) {
		$training = Training::findOne(["id" => $trainingId]);
		$usergroup = Usergroup::findOne(["id" => $usergroupId]);

		if(!$training || !$usergroup) {
			throw new ModelNotFoundException();
		}

		foreach($usergroup->users as $user) {
			$training->addUser($user);
		}

		return $this->redirect(["users", "id" => $trainingId]);
	}

	/**
	 * @param $trainingId
	 * @param $userId
	 * @return Response
	 * @throws ModelNotFoundException
	 */
	public function actionCopyUser($trainingId, $userId) {
		$training = Training::findOne(["id" => $trainingId]);
		$user = User::findOne(["id" => $userId]);

		if(!$training || !$user) {
			throw new ModelNotFoundException();
		}

		$training->addUser($user);

		return $this->redirect(["users", "id" => $trainingId]);
	}

	/**
	 * @param $id
	 * @return Response
	 * @throws ModelNotFoundException
	 * @throws Throwable
	 * @throws StaleObjectException
	 */
	public function actionDeleteUser($id) {
		$model = UserTraining::findOne(["id" => $id]);

		if(!$model) {
			throw new ModelNotFoundException();
		}

		$model->delete();

		return $this->redirect(["users", "id" => $model->trainingId]);
	}

	/**
	 * @param $id
	 * @param $value
	 * @return Response
	 * @throws ModelNotFoundException
	 */
	public function actionTrainer($id, $value) {
		$model = UserTraining::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		$value = $value === "true";

		$model->isTrainer = $value;
		$success = $model->save(false);

		return $this->asJson([
			"id" => $model->id,
			"key" => "is_trainer",
			"value" => $model->isTrainer,
			"success" => $success,
		]);
	}

	/**
	 * @param $id
	 * @param $value
	 * @return Response
	 * @throws ModelNotFoundException
	 */
	public function actionAttended($id, $value) {
		$model = UserTraining::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		$value = $value === "true";

		$model->attended = $value;
		$success = $model->save(false);

		return $this->asJson([
			"id" => $model->id,
			"key" => "attended",
			"value" => $model->attended,
			"success" => $success,
		]);
	}

	/**
	 * @param $id
	 * @throws ModelNotFoundException
	 */
	public function actionView($id) {
		$model = Training::findOne(["id" => $id]);

		if(!$model) {
			throw new ModelNotFoundException();
		}

		return $this->render("view", [
			"model" => $model,
		]);
	}

}
