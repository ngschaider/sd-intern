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
use http\Exception\InvalidArgumentException;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Response;

class TrainingController extends Controller {

	public function behaviors() {
		return [
			"access1" => [
				"class" => AccessControl::class,
				"only" => ["signup"],
				"rules" => [
					[
						"allow" => false,
						"actions" => ["signup"],
						"roles" => ["?"],
						"denyCallback" => function($rule, $action) {
							Yii::$app->user->setReturnUrl(Yii::$app->request->url);
							Yii::$app->response->redirect(["site/simple-login"]);
						}
					],
					[
						"allow" => true,
					]
				],

			],
			"access2" => [
				"class" => AccessControl::class,
				"except" => ["signup"],
				"rules" => [
					[
						"allow" => true,
						"roles" => ["trainings"],
					],
				],

			],
		];
	}

	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			"query" => Training::find(),
			"sort" => [
				"defaultOrder" => ["start" => SORT_DESC]
			]
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
	 * @param $value
	 * @return Response
	 * @throws ModelNotFoundException
	 */
	public function action3g($id, $value) {
		$model = UserTraining::findOne(["id" => $id]);
		if(!$model) {
			throw new ModelNotFoundException();
		}

		$value = $value === "true";

		$model->ggg = $value;
		$success = $model->save(false);

		return $this->asJson([
			"id" => $model->id,
			"key" => "3g",
			"value" => $model->attended,
			"success" => $success,
		]);
	}

	/**
	 * @param $id
	 * @return string
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

	/**
	 * @return string
	 * @throws ModelNotFoundException
	 * @throws InvalidArgumentException
	 */
	public function actionSignup() {
		if(Yii::$app->request->isPost) {
			$trainingId = Yii::$app->request->post("trainingId");
			if(!$trainingId) {
				throw new InvalidArgumentException();
			}

			$training = Training::findOne(["id" => $trainingId]);
			if(!$training) {
				throw new ModelNotFoundException();
			}

			if(Yii::$app->user->identity->canSignup($training)) {
				$training->addUser(Yii::$app->user, true);
			}
		}

		return $this->render("signup");
	}

}
