<?php

namespace app\modules\backend\controllers;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort= ['defaultOrder' => ['id' =>SORT_DESC]];
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new \app\models\SignupForm();
        $profile = new \app\models\Userprofile();
        $profile->scenario = 'create';

        if ($model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $user = $model->signup(10, $profile);
                if ($user) { // if user created
                    $mail = Yii::$app->mailer->compose(['html' => 'registermailAdmin'], ['user' => $user]);
                    $sub = 'Welcome to ' . Yii::$app->name;
                    $mail->setTo($user->email);
                    $mail->setFrom(Yii::$app->params['settings']['admin_email']);
                    $mail->setSubject($sub);
                    $data = $mail->send();


                    return $this->redirect(['/backend/user/index']);
                }
            } else {
                Yii::$app->getSession()->setFlash('danger', 'Error at creating user');
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'profile' => $profile,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = \app\models\User::find()->where("id='$id'")->one();
        $profile = \app\models\Userprofile::find()->where("user_id = '$id'")->one();
        if ($model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
            $model->updated_at = date('Y-m-d H:i');
            if ($model->validate()) {
                if ($model->save()) { // if user saved                    
                    $profile->image = \yii\web\UploadedFile::getInstance($profile, 'image');
                    if ($profile->image) {
                        $name = uniqid() . '.' . $profile->image->extension;
                        $profile->image->saveAs(Yii::$app->basePath . '/web/images/profile/' . $name);
                        $profile->image = $name;
                    } else {
                        $profile->image = \app\models\Userprofile::find()->where("user_id='" . $model->id . "'")->one()->image;
                    }
                    if ($profile->validate()) {
                        $profile->save();
                        return $this->redirect(['/backend/user/index']);
                    } else {
                        Yii::$app->getSession()->setFlash('danger', 'Error at updating profile');
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->getSession()->setFlash('danger', 'Error at updating user');
            }
        }
        return $this->render('update', [
                    'model' => $model,
                    'profile' => $profile,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
