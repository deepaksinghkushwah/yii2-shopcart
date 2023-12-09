<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->registerCss("#login-form{padding: 15px; min-width:300px;}");
$items = app\models\OrderDetail::find()->where("order_id = '" . Yii::$app->session->get('orderId', NULL) . "'")->count();
?>
<nav class="navbar navbar-expand-lg bg-primary text-light">
  <div class="container">
    <a class="navbar-brand" href="#"><?= \yii\helpers\Html::img(yii\helpers\Url::to(['/images/logo.png']), ['style' => 'height: 36px; margin-top: -12px;']) ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active text-light" aria-current="page" href="<?= Yii::$app->homeUrl ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" text-light href="<?= Url::to(['/store/catalog/index'], true) ?>">Store</a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-light" href="<?= Url::to(['/page/about-us'], true) ?>">About Us</a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-light" href="<?= Url::to(['/site/contact'], true) ?>">Contact Us</a>
        </li>

        <?php if (Yii::$app->user->isGuest) { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Sign In
            </a>
            <div class="dropdown-menu">
              <div class='row'>
                <div class='container-fluid'>
                  <?php
                  $model = new app\models\LoginForm();
                  $form = ActiveForm::begin(['id' => 'login-form', 'action' => yii\helpers\Url::to(['/site/login'], true)]);
                  echo $form->field($model, 'username');
                  echo $form->field($model, 'password')->passwordInput();
                  echo $form->field($model, 'rememberMe')->checkbox();
                  echo '<div style="color:#999;margin:1em 0">
                                      If you forgot your password you can ' . Html::a('reset it', ['site/request-password-reset']) . '
                                  </div>
                                  <div class="form-group">
                                      ' . Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) . '
                                  </div>';

                  ActiveForm::end();
                  ?>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="<?= Url::to(['/site/signup'], true) ?>">Sign Up</a>
          </li>

        <?php } else { ?>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= ucfirst(Yii::$app->user->identity->username) ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= Url::to(['/store/catalog/wishlist'], true) ?>">Wishlist</a></li>
              <li><a class="dropdown-item" href="<?= Url::to(['/store/catalog/order-history'], true) ?>">Order History</a></li>
              <li><a class="dropdown-item" href="<?= Url::to(['/userprofile/index'], true) ?>">Profile</a></li>
              <li><a class="dropdown-item" href="<?= Url::to(['/userprofile/changepassword'], true) ?>">Change Password</a></li>
              <?php if (key_exists("Super Admin", Yii::$app->getAuthManager()->getRolesByUser(Yii::$app->user->identity->id))) { ?>
                <li><a class="dropdown-item" href="<?= Url::to(['/backend/default/index'], true) ?>">Admin Panel</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
              <?php } ?>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" data-method="post" href="<?= Url::to(['/site/logout'], true) ?>">Logout</a></li>
            </ul>
          </li>

        <?php } ?>
      </ul>
      <div>
        <a class="nav link text-light" href="<?=Url::to(['/store/catalog/cart'],true)?>"><?='View Cart - ' . $items . ' item(s)';?></a>
      </div>
    </div>
  </div>
</nav>