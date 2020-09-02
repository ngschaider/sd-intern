<?php /** @noinspection PhpIllegalPsrClassPathInspection */

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m200829_101016_create_users_table extends Migration {

	/**
	 * {@inheritdoc}
	 * @throws \yii\base\Exception
	 */
	public function safeUp() {
		$this->createTable("users", [
			"id" => $this->primaryKey(),
			"username" => $this->string()->notNull(),
			"firstname" => $this->string()->null(),
			"lastname" => $this->string()->null(),
			"passwordHash" => $this->string()->null(),
			"allowLogin" => $this->boolean()->notNull()->defaultValue(0),
		]);

		$this->insert("users", [
			"id" => 1,
			"username" => "admin",
			"passwordHash" => Yii::$app->security->generatePasswordHash("admin"),
			"allowLogin" => 1,
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("users");
	}

}
