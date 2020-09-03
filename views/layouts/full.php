<?php
/**
 * @var $this View
 * @var $content string
 */

use app\components\UTF8;
use yii\helpers\Html;
use app\components\Nav;
use yii\bootstrap4\NavBar;
use app\assets\AppAsset;
use yii\web\View;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
	<?php
	NavBar::begin([
		'brandLabel' => Yii::$app->name,
		'brandUrl' => Yii::$app->homeUrl,
		'options' => [
			'class' => 'bg-sd-mixed navbar-dark navbar-expand-md',
		],
	]);
	echo Nav::widget([
		"options" => ["class" => "navbar-nav ml-auto"],
		"items" => [
			["label" => "Home", 'url' => ['/site']],
			["label" => "Statistiken", "url" => ["/statistic"], "adminOnly" => true],
			["label" => "Trainings", "url" => ["/training"], "adminOnly" => true],
			["label" => "Locations", "url" => ["/location"], "adminOnly" => true],
			["label" => "Admin", "adminOnly" => true, "items" => [
				["label" => "Benutzer", 'url' => ["user"]],
				["label" => "Benutzergruppen", 'url' => ["usergroup"]],
			]],
			Yii::$app->user->isGuest ? (
			["label" => "Login", "url" => ["/site/login"]]
			) : (
				'<li>'
				. Html::beginForm(['/site/logout'], 'post')
				. Html::submitButton(
					"Logout (" . Yii::$app->user->identity->username . ")",
					["class" => "nav-link btn btn-link logout"]
				)
				. Html::endForm()
				. '</li>'
			)
		],
	]);
	NavBar::end();
	?>

	<?= $content ?>
</div>

<footer class="footer">
    <div class="container">
        <p class="float-sm-left">&copy; Show & Dance Triestingtal <?= date('Y') ?></p>
        <p class="float-sm-right">Made with <?= UTF8::HEAVY_BLACK_HEART ?> by <a href="https://ngschaider.at/">Niklas Gschaider</a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
