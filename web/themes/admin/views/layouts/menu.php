<?php

use yii\helpers\Url;
echo \yii\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu treeview'],
    'items' => [
        ['label' => 'Navigation', 'url' => '#','options' => ['class' => 'header']],
        ['label' => "<i class='fa fa-home'></i> <span>Home</span>", 'url' => Url::to(['/backend/default/index'], true)],
        ['label' => "<i class='fa fa-gears'></i> <span>General Settings</span>", 'url' => Url::to(['/backend/setting'], true)],
        ['label' => "<i class='fa fa-users'></i> <span>User Manager</span>",
            'url' => ['#'],
            'template' => '<a href="{url}" >{label}<i class="glyphicon glyphicon-arrow-left pull-right"></i></a>',
            'items' => [
                ['label' => 'Create User', 'url' =>  Url::to(['/backend/user/create'], true)],
                ['label' => 'List All Users', 'url' => Url::to(['/backend/user/index'], true)],                
            ],
        ],
        ['label' => "<i class='fa fa-edit'></i> <span>Pages Manager</span>",
            'url' => ['#'],
            'template' => '<a href="{url}" >{label}<i class="glyphicon glyphicon-arrow-left pull-right"></i></a>',
            'items' => [
                ['label' => 'Create Page', 'url' =>  Url::to(['/backend/page/create'], true)],
                ['label' => 'List All Pages', 'url' => Url::to(['/backend/page/index'], true)],                
            ],
        ],
        ['label' => "<i class='fa fa-edit'></i> <span>Catalog Manager</span>",
            'url' => ['#'],
            'template' => '<a href="{url}" >{label}<i class="glyphicon glyphicon-arrow-left pull-right"></i></a>',
            'items' => [
                ['label' => 'Categories', 'url' =>  Url::to(['/backend/category'], true)],
                ['label' => 'Products', 'url' => Url::to(['/backend/product'], true)],                
                ['label' => 'Orders', 'url' => Url::to(['/backend/order'], true)],                
                ['label' => 'Discounts', 'url' => Url::to(['/backend/discount'], true)],        
            ],
        ],
        ['label' => "<i class='fa fa-minus'></i> <span>Logout</span>", 'url' => Url::to(['/site/logout'], true)],
    ],
    'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
    'encodeLabels' => false, //allows you to use html in labels
    'activateParents' => true,]);
?>
