<?php
foreach ($models as $k=>$model):?>
    <div class="cat <?=$k==0?"item1":""?>">
        <h3><?=\yii\helpers\Html::a($model->name,['address/list','id'=>$model->id])?> <b></b></h3>
        <div class="cat_detail">
            <?php foreach ($model->child as $k2=>$mode):?>
                <dl <?=$k2==0?'class="dl_1st"':''?>>
                    <dt><?=\yii\helpers\Html::a($mode->name,['address/list','id'=>$mode->id])?></dt>
                    <?php foreach ($mode->child as $mod):?>
                        <dd>
                            <?=\yii\helpers\Html::a($mod->name,['address/list','id'=>$mod->id])?>

                        </dd>
                    <?php endforeach;?>
                </dl>
            <?php endforeach;?>
        </div>

    </div>
<?php endforeach;?>