<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class UserTraining
 *
 * @property-read integer $id
 * @property boolean $attended
 * @property boolean $is_trainer
 * @property integer $training_id
 * @property integer $user_id
 * @property-read mixed $users
 * @property-read mixed $training
 */
class UserTraining extends ActiveRecord {

	public static function tableName() {
		return "users_trainings";
	}

	public function getUsers() {
		return $this->hasOne(User::class, ["user_id" => "id"]);
	}

	public function getTraining() {
		return $this->hasOne(Training::class, ["training_id" => "id"]);
	}

}