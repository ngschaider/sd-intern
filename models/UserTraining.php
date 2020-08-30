<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\models;

use app\components\ActiveRecord;

/**
 *
 * @property-read mixed $trainings
 * @property-read mixed $users
 */
class UserTraining extends ActiveRecord {

	public static function tableName() {
		return "users_trainings";
	}

	public function getUsers() {
		return $this->hasMany(User::class, ["user_id" => "id"]);
	}

	public function getTrainings() {
		return $this->hasMany(Training::class, ["training_id" => "id"]);
	}

}