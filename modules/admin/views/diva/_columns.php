<?php
use yii\helpers\Url;
use kartik\helpers\Html;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
        'vAlign'=>'middle',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
        'vAlign'=>'middle',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'url',
        'vAlign'=>'middle',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'block_3',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'block_4',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'block_5',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'block_6',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'template' => '{view} {update} {seo} {delete}',
        'buttons' => [
            'view' => function ($url, $model) {
                return \yii\helpers\Html::a('<span class="fa fa-eye"></span>', $url, [
                            'title' => Yii::t('yii', 'View'),
                            'class' => 'btn btn-xs btn-primary btn-detail',
                            'data-pjax' => "0",
                            'role' => "modal-remote",
                            'data-toggle' => "tooltip",
                            'data-original-title' => "View",
                            'style' => 'height: 22px;',
                ]);
            },
            'update' => function ($url, $model) {
                return \yii\helpers\Html::a('<span class="fa fa-pencil"></span>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                            'class' => 'btn btn-xs btn-success btn-edit',
                            'data-pjax' => "0",
                            'role' => "modal-remote",
                            'data-toggle' => "tooltip",
                            'data-original-title' => "Update",
                            'style' => 'height: 22px;'
                ]);
            },
            'seo' => function ($url, $model) {
                return Html::a('<span class="fa fa-line-chart"></span>', [
                            "/admin/seo/update",
                            'target_id' => $model->id,
                            'type' => 'diva'
                        ], [
                            'title' => "SEO",
                            'data-pjax' => "0",
                            'class' => 'btn btn-xs btn-info btn-detail',
                            'role' => "modal-remote",
                            'data-toggle' => "tooltip",
                            'data-original-title' => "SEO",
                            'style' => 'height: 22px;',
                        ]);
            },
            'delete' => function ($url, $model) {
                return \yii\helpers\Html::a('<span class="fa fa-trash"></span>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'class' => 'btn btn-xs btn-warning btn-delete',
                            'data-pjax' => "0",
                            'role' => "modal-remote",
                            'data-toggle' => "tooltip",
                            'data-original-title' => "Delete",
                            'data-pjax-container' => "crud-datatable-pjax",
                            'data-request-method' => "post",
                            'data-confirm-title' => "Are you sure?",
                            'data-confirm-message' => "Are you sure want to delete this item",
                            'data-original-title' => "Delete",
                            'style' => 'height: 22px;'
                ]);
            }
        ],
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   