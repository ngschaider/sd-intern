<?php

use yii\db\Migration;

/**
 * Class m201022_223317_init_rbac
 */
class m201022_223317_init_rbac extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$auth = Yii::$app->authManager;

		$users = $auth->createPermission("users");
		$users->description = "Create/update/delete users";
		$auth->add($users);

		$usergroups = $auth->createPermission("usergroups");
		$usergroups->description = "Create/update/delete usergroups";
		$auth->add($usergroups);

		$trainings = $auth->createPermission("createTraining");
		$trainings->description = "Create/update/delete trainings";
		$auth->add($trainings);

		$statistics = $auth->createPermission("statistics");
		$statistics->description = "View statistics";
		$auth->add($statistics);

		$userTrainings = $auth->createPermission("userTrainings");
		$userTrainings->description = "Add/remove users to trainings and modify their states";
		$auth->add($userTrainings);

		$formations = $auth->createPermission("formations");
		$formations->description = "Create/update/delete formations";
		$auth->add($formations);

		$frames = $auth->createPermission("frames");
		$frames->description = "Create/update/delete frames";
		$auth->add($frames);

		$locations = $auth->createPermission("locations");
		$locations->description = "Create/update/delete locations";
		$auth->add($locations);

		$admin = $auth->createRole("admin");
		$auth->add($admin);
		$auth->addChild($admin, $users);
		$auth->addChild($admin, $usergroups);
		$auth->addChild($admin, $trainings);
		$auth->addChild($admin, $statistics);
		$auth->addChild($admin, $userTrainings);
		$auth->addChild($admin, $formations);
		$auth->addChild($admin, $frames);
		$auth->addChild($admin, $locations);

		$auth->assign($admin, 1);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$auth = Yii::$app->authManager;
		$auth->removeAll();
	}

}
