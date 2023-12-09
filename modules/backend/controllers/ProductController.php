<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller {

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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Product();
        $model->scenario = "insert";
        $model->created_at = date('Y-m-d H:i');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $old = $this->findModel($id);
        $model->scenario = "update";
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->image == '') {
                $model->image = $old->image;
                $model->save();
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGallery() {
        $productId = Yii::$app->request->get('product_id');
        return $this->render('create-gallery', ['productId' => $productId]);
    }

    public function actionUploadGallery() {

        $path = Yii::$app->params['productPhotoPathOs'];
        @mkdir($path, 0777, true);
        $valid = ['jpg', 'jpeg', 'png', 'gif'];
        if (isset($_FILES['file'])) {
            $ext = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.') + 1);
            if (in_array($ext, $valid)) {
                $basename = substr($_FILES['file']['name'], 0, strrpos($_FILES['file']['name'], '.') - 1);
                $filename = uniqid() . $basename . '.' . $ext;
                if (move_uploaded_file($_FILES['file']['tmp_name'], $path . '/' . $filename)) {

                    $model = new \app\models\ProductGallery();
                    $model->image = $filename;
                    $model->product_id = Yii::$app->request->post('product_id');
                    $model->save();
                }
            } else {
                header("HTTP/1.0 400 Bad Request");
                echo 'Invalid filetype ' . $ext;
                exit;
            }
        }
    }

    public function actionRemoveGalleryImage() {
        $rowId = Yii::$app->request->get('row_id');
        \app\models\ProductGallery::findOne(['id' => $rowId])->delete();
        return json_encode(['msg' => 'Image removed from gallery']);
    }

    public function actionToggleProductFeatured() {
        $fp = \app\models\FeaturedProduct::findOne(['product_id' => Yii::$app->request->get('product_id')]);
        if (!$fp) {
            $fp = new \app\models\FeaturedProduct();
            $fp->product_id = Yii::$app->request->get('product_id');
            $fp->created_at = date('Y-m-d H:i');
            $fp->save();
            return json_encode(['msg' => 'Product added to featured list']);
        } else {
            $fp->delete();
            return json_encode(['msg' => 'Product removed form featured list']);
        }
    }

    public function actionRelatedProduct() {
        $this->layout = "empty";
        $pid = Yii::$app->request->get('pid');
        return $this->render('related-product', ['pid' => $pid]);
    }

    public function actionToggleRelatedProduct() {
        $values = Yii::$app->request->get('values');
        $status = Yii::$app->request->get('status');
        $x = explode("_", $values);
        $mainProduct = $x[0];
        $relProduct = $x[1];
        $msg = "";

        if ($status == 0) {
            $model1 = \app\models\RelatedProduct::findOne(['product_id' => $mainProduct, 'related_product_id' => $relProduct]);
            $model2 = \app\models\RelatedProduct::findOne(['product_id' => $relProduct, 'related_product_id' => $mainProduct]);
            if ($model1) {
                $model1->delete();
            }
            if ($model2) {
                $model2->delete();
            }
            $msg = "Related product removed";
        } else {
            $model = \app\models\RelatedProduct::findOne(['product_id' => $mainProduct, 'related_product_id' => $relProduct]);
            if (!$model) {
                $model = new \app\models\RelatedProduct();
                $model->product_id = $mainProduct;
                $model->related_product_id = $relProduct;
                $model->save();
                // vice-versa relations 
                $model = new \app\models\RelatedProduct();
                $model->product_id = $relProduct;
                $model->related_product_id = $mainProduct;
                $model->save();

                $msg = "Related product added";
            } else {
                $msg = "Related product already added";
            }
        }
        return json_encode(['msg' => $msg]);
    }

}
