<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\models;

use app\components\ActiveRecord;

/**
 * Class UserTraining
 *
 * @property-read integer $id
 * @property boolean $attended
 * @property boolean $isTrainer
 * @property integer $trainingId
 * @property integer $userId
 * @property-read User $user
 * @property-read Training $training
 */
class UserTraining extends ActiveRecord {

	public function getUser() {
		return $this->hasOne(User::class, ["id" => "userId"]);
	}

	public function getTraining() {
		return $this->hasOne(Training::class, ["id" => "trainingId"]);
	}

}