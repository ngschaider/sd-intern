<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\models;

use Yii;

/**
 * This is the model class for table "usergroups".
 *
 * @property int $id
 * @property string $name
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 */
class Usergroup extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'usergroups';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['created_by', 'created_at', 'updated_at'], 'required'],
			[['created_by'], 'integer'],
			[['created_at', 'updated_at'], 'safe'],
			[['name'], 'string', 'max' => 255],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Name',
			'created_by' => 'Created By',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		];
	}
}