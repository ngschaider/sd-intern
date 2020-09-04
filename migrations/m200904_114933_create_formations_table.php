<?php /** @noinspection PhpIllegalPsrClassPathInspection */

use app\components\Migration;

/**
 * Handles the creation of table `{{%locations}}`.
 */
class m200904_114933_create_formations_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("{{%formations}}", [
			"id" => $this->primaryKey(),
			"name" => $this->string(255)->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable("{{%formations}}");
	}

	/*
	// Use up()/down() to run migration code without a transaction.
	public function up()
	{

	}

	public function down()
	{
		echo "m200904_114933_add_formation_table cannot be reverted.\n";

		return false;
	}
	*/
}
