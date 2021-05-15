<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 *
 *
 * @var View $this
 * @var Usergroup $model
 */

use app\models\Usergroup;
use yii\web\View;

?>


    <h3>Benutzergruppe <?= $model->name ?></h3>

    <b>Mitglieder:</b> <?= count($model->users) === 0 ? "Keine" : "" ?>
<?php if(count($model->users) > 0) {
	echo "<ul>";
	foreach($model->users as $user) {
		echo "<li>" . $user->username . "</li>";
	}
	echo "</ul>";
}
