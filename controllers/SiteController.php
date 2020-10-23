<?php

namespace app\controllers;

use app\components\ModelNotFoundException;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use app\components\Controller;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller {

	public $loggedInOnly = false;

	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::class,
				'only' => ["login", "simpleLogin", "logout"],
				'rules' => [
					[
						"actions" => ["login", "simpleLogin"],
						"allow" => true,
						"roles" => ["?"], // guest users
					],
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'], // authenticated users
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex() {
		$this->layout = "full";

		return $this->render('index');
	}

	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin() {
		if(!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}

		$model->password = '';

		return $this->render('login', [
			'model' => $model,
		]);
	}

	/**
	 * @return Response|string
	 * @throws ModelNotFoundException
	 */
	public function actionSimpleLogin() {
		if(!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		/**
		 * @var User[] $users
		 */
		$users = User::find()->all();
		$nonAdminUsers = array_filter($users, function($user) {
			return !$user->isAdmin;
		});
		$items = ArrayHelper::getColumn(ArrayHelper::index($nonAdminUsers, "id"), "fullname");

		if(Yii::$app->request->isPost) {
			$id = Yii::$app->request->post("username");
			if($id) {
				$user = User::findOne(["id" => $id]);
				if(!$user) {
					throw new ModelNotFoundException();
				}

				if(!$user->isAdmin) {
					Yii::$app->user->login($user,  0);
					$this->goBack();
				}
			}
		}

		return $this->render("simple-login", [
			"items" => $items
		]);
	}

	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout() {
		Yii::$app->user->logout();

		return $this->goHome();
	}

}
