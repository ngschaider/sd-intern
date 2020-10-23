<?php

/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 * @package app.views
 *
 * @var \yii\web\View $this
 * @var array $items
 */


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\User;

$this->title = "Login";
$this->params["breadcrumbs"][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-4">

	    <?= Html::beginForm(); ?>

        <p>Bitte Name auswählen:</p>

        <div class="form-group">
			<?= Html::dropdownList("username", null, $items, [
				"class" => "form-control"
			]); ?>
        </div>

        <div class="form-group">
			<?= Html::submitButton("Login", ["class" => "btn btn-primary", "name" => "login-button"]) ?>
        </div>
        
	    <?= Html::endForm(); ?>

    </div>




</div>
