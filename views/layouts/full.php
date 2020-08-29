<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\assets\AppAsset;

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
			'class' => 'bg-sd-secondary navbar-dark navbar-expand-md',
		],
	]);
	echo Nav::widget([
		'options' => ['class' => 'navbar-nav ml-auto'],
		'items' => [
			['label' => 'Home', 'url' => ['/site/index']],
			["label" => "Admin", "items" => [
				['label' => 'Benutzer', 'url' => ['/user/index']],
			]],
			Yii::$app->user->isGuest ? (
			['label' => 'Login', 'url' => ['/site/login']]
			) : (
				'<li>'
				. Html::beginForm(['/site/logout'], 'post')
				. Html::submitButton(
					'Logout (' . Yii::$app->user->identity->username . ')',
					['class' => 'nav-link btn btn-link logout']
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
        <p class="pull-left">&copy; Niklas Gschaider <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
