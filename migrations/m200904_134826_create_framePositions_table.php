<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%framePositions}}`.
 */
class m200904_134826_create_framePositions_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable("{{%framePositions}}", [
			"id" => $this->primaryKey(),
			"frameId" => $this->integer()->notNull(),
			"number" => $this->integer()->null(),
			"x" => $this->float()->notNull()->defaultValue(0),
			"y" => $this->float()->notNull()->defaultValue(0),
			"rotation" => $this->float()->notNull()->defaultValue(0),
			"color" => $this->string()->notNull(),
		]);

		$this->addForeignKey("fk-framePositions-frameId", "{{%framePositions}}", "frameId", "{{%frames}}", "id");
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropForeignKey("fk-framePositions-frameId");
		$this->dropTable("{{%framePositions}}");
	}

}
