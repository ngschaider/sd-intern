<?php

namespace app\components;

use Yii;

/**
 * @package app.components
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 * @property-read mixed $tablePrefix
 */
class Migration extends \yii\db\Migration {

	public function addCommentOnTable($table, $comment) {
		parent::addCommentOnTable($this->tablePrefix . $table, $comment);
	}
	public function createTable($table, $columns, $options = null) {
		parent::createTable($this->tablePrefix . $table, $columns, $options);
	}
	public function dropCommentFromTable($table) {
		parent::dropCommentFromTable($this->tablePrefix . $table);
	}
	public function dropTable($table) {
		parent::dropTable($this->tablePrefix . $table);
	}
	public function renameTable($table, $newName) {
		parent::renameTable($this->tablePrefix . $table, $newName);
	}
	public function truncateTable($table) {
		parent::truncateTable($this->tablePrefix . $table);
	}
	public function insert($table, $columns) {
		parent::insert($this->tablePrefix . $table, $columns);
	}
	public function batchInsert($table, $columns, $rows) {
		parent::batchInsert($this->tablePrefix . $table, $columns, $rows);
	}
	public function dropColumn($table, $column) {
		parent::dropColumn($this->tablePrefix . $table, $column);
	}
	public function dropCommentFromColumn($table, $column) {
		parent::dropCommentFromColumn($this->tablePrefix . $table, $column);
	}
	public function dropForeignKey($name, $table) {
		parent::dropForeignKey($name, $this->tablePrefix . $table);
	}
	public function dropIndex($name, $table) {
		parent::dropIndex($name, $this->tablePrefix . $table);
	}
	public function dropPrimaryKey($name, $table) {
		parent::dropPrimaryKey($name,$this->tablePrefix . $table);
	}
	public function addColumn($table, $column, $type) {
		parent::addColumn($this->tablePrefix . $table, $column, $type);
	}
	public function addCommentOnColumn($table, $column, $comment) {
		parent::addCommentOnColumn($this->tablePrefix . $table, $column, $comment);
	}
	public function addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete = null, $update = null) {
		parent::addForeignKey($name, $this->tablePrefix . $table, $columns, $this->tablePrefix . $refTable, $refColumns, $delete, $update);
	}
	public function addPrimaryKey($name, $table, $columns) {
		parent::addPrimaryKey($name, $this->tablePrefix . $table, $columns);
	}
	public function alterColumn($table, $column, $type) {
		parent::alterColumn($this->tablePrefix . $table, $column, $type);
	}
	public function createIndex($name, $table, $columns, $unique = false) {
		parent::createIndex($name, $this->tablePrefix . $table, $columns, $unique);
	}
	public function delete($table, $condition = '', $params = []) {
		parent::delete($this->tablePrefix . $table, $condition, $params);
	}
	public function renameColumn($table, $name, $newName) {
		parent::renameColumn($this->tablePrefix . $table, $name, $newName);
	}

	public function getTablePrefix() {
		return Yii::$app->db->tablePrefix;
	}

}