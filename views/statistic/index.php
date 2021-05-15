<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<b>
    Generell: <?= Html::a("Hier", ["general"]) ?>
</b>
<br>



<b>
    Pro Benutzer:
</b>

<ul>
	<?php
	foreach(User::find()->all() as $user) {
		echo "<li>";
		echo Html::a($user->username, ["user", "id" => $user->id]);
		echo "</li>";
	}
	?>
</ul>

