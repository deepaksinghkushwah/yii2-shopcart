<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;

class SiteController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {            
            return $this->goHome();
        }

        $model = new LoginForm();

        if (isset($_GET['regtoken']) and $_GET['regtoken'] != '') {

            $regkey = trim($_GET['regtoken']);
            $data = $model->getregkey($regkey);

            if ($data != '' and $data['status'] == '10') {
                Yii::$app->session->setFlash('success', 'Your account has been activated now');
            }
            //$this->goHome();
        }

        
        
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {            
            return $this->goBack();
        } else {
            Yii::$app->session['last_session_id'] = Yii::$app->session->id;
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    public function actionAbout() {
        return $this->render('about');
    }

    public function actionSignup() {
        $model = new SignupForm();
        $profile = new \app\models\Userprofile();
        $profile->scenario = 'create';
        if ($model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {

            if ($user = $model->signup(0, $profile)) {
                //if (Yii::$app->getUser()->login($user)) {
                $this->sendregistrationMail($user);
                Yii::$app->getSession()->setFlash('success', 'You are registered successfully, please check your mail for further instructions.');
                return $this->goHome();
                //}
            }
        }

        return $this->render('signup', [
                    'model' => $model,
                    'profile' => $profile,
        ]);
    }

    function sendregistrationMail($user) {
        $mail = Yii::$app->mailer->compose(['html' => 'registermail'], ['user' => $user]);
        $sub = Yii::$app->name . ' user registration';
        $mail->setTo($user->email);
        $mail->setFrom(Yii::$app->params['settings']['admin_email']);
        $mail->setSubject($sub);
        $data = $mail->send();

        if ($data == true) {
            Yii::$app->session->setFlash('success', 'Thank you for register with us! Login details with an activation link has been sent to your mail id to activate your account.');
        } else {
            Yii::$app->session->setFlash('error', 'Error at sending mail please try again.');
        }
    }

    public function actionRequestPasswordReset() {
        $model = new \app\models\PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        try {
            $model = new \app\models\ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionPage($alias) {
        //$alias = $_REQUEST['alias'];
        $model = \app\models\Page::find()->where("alias='$alias'")->one();
        return $this->render('page', ['model' => $model]);
    }

    public function actionEnquiry() {
        $model = new \app\models\EnquiryForm();
        $alias = Yii::$app->request->get('alias');
        
        $p = \app\models\Product::findOne(['alias' => $alias]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {            
            $model->body = 'Product For Enquiry: '.\yii\helpers\Html::a($p->title,  \yii\helpers\Url::to(['/shop/product-detail/'.$p->alias],true))."<br/>".$model->body;
            if ($model->sendEmail(Yii::$app->params['settings']['admin_email'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('enquiry', [
                        'model' => $model,
                        'alias' => $alias,
                'p' => $p,
            ]);
        }
    }
    
    public function actionImage() {
        \app\components\timthumb::start();
        Yii::$app->exit;
    }

public function actionGetCounties(){
        $countryId = Yii::$app->request->get('country_id');
        $model = \app\models\GeoState::findAll(['country_id' => $countryId]);
        $arr[] = ['id' => '0','name' => 'Select Any'];
        if($model){
            foreach($model as $row){
                $arr[] = ['id' => $row->id, 'name' => $row->name];
            }
        }
        return json_encode(['items' => $arr]);
    }
    
    public function actionGetCities(){
        $countyId = Yii::$app->request->get('county_id');
        $model = \app\models\GeoCity::findAll(['state_id' => $countyId]);
        $arr[] = ['id' => '0','name' => 'Select Any'];
        if($model){
            foreach($model as $row){
                $arr[] = ['id' => $row->id, 'name' => $row->name];
            }
        }
        return json_encode(['items' => $arr]);
    }

}
