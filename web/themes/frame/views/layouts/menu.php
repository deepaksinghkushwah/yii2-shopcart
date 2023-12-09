<?php

/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->registerCss("#login-form{padding: 15px; min-width:300px;}");
$this->beginBlock('login');
echo "<div class='dropdown-menu'><div class='row'>
                            <div class='container-fluid'>";
$model= new app\models\LoginForm();
$form = ActiveForm::begin(['id' => 'login-form', 'action' => yii\helpers\Url::to(['/site/login'], true)]);
echo $form->field($model, 'username');
echo $form->field($model, 'password')->passwordInput();
echo $form->field($model, 'rememberMe')->checkbox();
echo '<div style="color:#999;margin:1em 0">
                    If you forgot your password you can' . Html::a('reset it', ['site/request-password-reset']) . '
                </div>
                <div class="form-group">
                    ' . Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) . '
                </div>';

ActiveForm::end();
echo "</div></div></div>";
$this->endBlock();

yii\bootstrap\NavBar::begin([
    'brandLabel' => \yii\helpers\Html::img(yii\helpers\Url::to(['/images/logo.png']), ['style' => 'height: 36px; margin-top: -12px;']),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo \yii\bootstrap\Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => [
        ['label' => 'Home', 'url' => Yii::$app->homeUrl],
        ['label' => 'Store', 'url' => ['/store/catalog/index']],
        ['label' => 'About Us', 'url' => ['/page/about-us']],
        ['label' => 'Contact Us', 'url' => ['/site/contact']],
        ['label' => 'Signup', 'url' => array('/site/signup'), 'visible' => Yii::$app->user->isGuest],
        Yii::$app->user->isGuest ? ['label' => 'Login',
            'url' => 'javascript:void(0)',
            'items' => $this->blocks['login']
        ] :
                [
            'label' => ucfirst(Yii::$app->user->identity->username),
            'visible' => !Yii::$app->user->isGuest,
            'url' => ['#'],
            'items' => [
                ['label' => 'Wishlist', 'url' => ['/store/catalog/wishlist']],
                ['label' => 'Order History', 'url' => ['/store/catalog/order-history'], 'visible' => !Yii::$app->user->isGuest && \app\models\Setting::findOne(['key' => 'catalog_mode'])->value == 'No'],
                ['label' => 'My Profile', 'url' => ['/userprofile/index'], 'visible' => !Yii::$app->user->isGuest],
                ['label' => 'Change Password', 'url' => ['/userprofile/changepassword'], 'visible' => !Yii::$app->user->isGuest],
                ['label' => 'Backend', 'url' => ['/backend/default/index'], 'visible' => key_exists("Super Admin", Yii::$app->getAuthManager()->getRolesByUser(Yii::$app->user->identity->id))],
                ['label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
            ],
                ],
    ],
]);
$items = app\models\OrderDetail::find()->where("order_id = '" . Yii::$app->session->get('orderId', NULL) . "'")->count();
echo \yii\bootstrap\Nav::widget([
    'options' => ['class' => 'navbar-nav pull-right'],
    'items' => [
        ['label' => 'View Cart - ' . $items . ' item(s)', 'url' => ['/store/catalog/cart'], 'visible' => \app\models\Setting::findOne(['key' => 'catalog_mode'])->value == 'No'],
    ],
]);
yii\bootstrap\NavBar::end();
?>