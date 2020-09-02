<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\models;

use app\components\ActiveRecord;
use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use arogachev\ManyToMany\validators\ManyToManyValidator;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "usergroups".
 *
 * @property int $id
 * @property string $name
 * @property-read User[] $users
 */
class Usergroup extends ActiveRecord {

	public $userIds;

	public function behaviors() {
		return ArrayHelper::merge(parent::behaviors(), [
			"manytomany" => [
				"class" => ManyToManyBehavior::class,
				"relations" => [
					[
						"editableAttribute" => "userIds",
						"name" => "users",
					],
				],
			],
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[["userIds"], ManyToManyValidator::class],
			[['name'], 'string', 'max' => 255],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'name' => 'Name',
		];
	}

	/**
	 * @return ActiveQuery
	 * @throws InvalidConfigException
	 */
	public function getUsers() {
		return $this->hasMany(User::class, ["id" => "userId"])->viaTable("userUsergroups", ["usergroupId" => "id"]);
	}

}