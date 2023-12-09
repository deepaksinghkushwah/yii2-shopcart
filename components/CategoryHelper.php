<?php

namespace app\components;

use yii;

class CategoryHelper {

    public function categoryChild($id) {
        $s = "SELECT id,cat_name FROM category WHERE parent_id =" . $id;
        $r = \app\models\Category::findBySql($s)->all();
        $children = array();
        if ($r) {
            #It has children, let's get them.
            foreach ($r as $row) {
                #Add the child to the list of children, and get its subchildren
                $children[]['id'] = $row['id'];
                $children[]['']['cat_name'] = $row['cat_name'];

                $arr = $this->categoryChild($row['id']);
                if (count($arr) > 0) {
                    $children[]['child'] = $this->categoryChild($row['id']);
                }
            }
        }
        return $children;
    }

    public function fetchCategoryTree($parent_id = 0, $excluded = array(), $spacing = '', $user_tree_array = '') {

        if (!is_array($user_tree_array))
            $user_tree_array = array();

        $sql = "SELECT `id`, `cat_name`, `parent_id` FROM `category` WHERE published='Yes' AND `parent_id` = $parent_id ORDER BY cat_name ASC";
        $query = \app\models\Category::findBySql($sql)->all();
        if ($query) {
            foreach ($query as $row) {
                if (!in_array($row->id, $excluded)) {
                    $user_tree_array[] = array("id" => $row->id, "cat_name" => $spacing . $row->cat_name);
                    $user_tree_array = $this->fetchCategoryTree($row->id, $excluded, str_repeat($spacing, 2), $user_tree_array);
                }
            }
        }
        return $user_tree_array;
    }

    public function drawTree() {
        \Yii::$app->view->registerJs("$('#zeroTree').simpleTree({startCollapsed: false});");
        echo "<div>";
        echo "<ul id='zeroTree'><li class='st-file'>".\yii\helpers\Html::a('All Products',  yii\helpers\Url::to(['/store/catalog/index'],true))."</li>";
        $res = $this->fetchTreeData();
        foreach ($res as $r) {
            echo $r;
        }
        echo "</ul>";
        echo "</div>";
        
    }

    function fetchTreeData($parent = 0, $user_tree_array = '') {

        if (!is_array($user_tree_array))
            $user_tree_array = array();

        $sql = "SELECT `id`, `cat_name`, `parent_id` FROM `category` WHERE published='Yes' AND `parent_id` = $parent ORDER BY cat_name ASC";
        $query = \app\models\Category::findBySql($sql)->all();
        $user_tree_array[] = "<ul>";
        if ($query) {
            
            foreach ($query as $row) {
                $user_tree_array[] = "<li class='st-file'>" . \yii\helpers\Html::a($row->cat_name.'['.$this->productsCount($row->id).']',  yii\helpers\Url::to(['/store/catalog/index','cat_id' => $row['id']],true),['class' => (Yii::$app->request->get('cat_id',0) == $row['id'] ? 'cat-active' : '')]);
                $user_tree_array = $this->fetchTreeData($row->id, $user_tree_array);
                $user_tree_array[] = '</li>';
                
            }
            
        }
        $user_tree_array[] = "</ul>";
        return $user_tree_array;
    }
    
    function productsCount($catid){
        $sql = "SELECT * FROM product where cat_id = '$catid'";
        $res = \app\models\Category::findBySql($sql)->count();
        return $res;
    }
    
    public static function getCategoryParent($catId){
        $arr = self::getCategoryParentRows($catId,[]);
        return array_reverse($arr);
        /*$str = "";
        if(count($arr) > 0){
            foreach($arr as $row){
                $str .= $row."->";
            }
        }
        return $str;*/
        
    }

    // backtrack category parent
    public static function getCategoryParentRows($catId, $arr = []){
        $p = \app\models\Category::findOne(['id' => $catId]);
        $arr[] = $p->cat_name;
        if($p->parent_id == 0){
            return $arr;
        } else {            
            //echo $p->parent_id."<Br>";
            $arr = self::getCategoryParentRows($p->parent_id, $arr);
        }
        return $arr;
    }
}
