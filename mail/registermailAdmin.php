
<div class="contentEditableContainer contentTextEditable">
    <div class="contentEditable" align='center'>
        <p>This is to inform you that you have been successfully added to <?= Yii::$app->name; ?> and own an account for your future proceedings.</p>
        <br>
        <br>
        <p>Registration Details:</p>
        <p  style='text-align:left;color:#000;font-size:14px;font-weight:normal;line-height:19px;'><b>Username: <?= trim($user->username, ' '); ?></b>  </p>
        <p  style='text-align:left;color:#000;font-size:14px;font-weight:normal;line-height:19px;'><b>Password: <?= trim($user->pass, ' '); ?></b> </p>
        <br>
        <?php
        $loginUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);
        ?>

        <p  style='text-align:left;color:#000;font-size:14px;font-weight:normal;line-height:19px;'>Url :    <a target='_blank' class='link1' href="<?= $loginUrl ?>"><?= $loginUrl ?></a></p>
        <p  style='text-align:left;color:#000;font-size:14px;font-weight:normal;line-height:19px;'><b>Thanks and Regards</b>  </p>

        <p  style='text-align:left;color:#999999;font-size:14px;font-weight:normal;line-height:19px;'><?= Yii::$app->name; ?></p>
    </div>
</div>