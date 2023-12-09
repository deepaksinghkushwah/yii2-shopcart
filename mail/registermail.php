
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr><td height='55'></td></tr>
    <tr>
        <td align='left'>
            <div class="contentEditableContainer contentTextEditable">
                <div class="contentEditable" align='center'>
                    <p  style='text-align:left;color:#333;font-size:24px;font-weight:normal;line-height:19px;'>Dear <?php echo ucwords($user['username']) ?>,</p>
                </div>
            </div>
        </td>
    </tr>

    <tr><td height='15'> </td></tr>

    <tr>
        <td align='left'>
            <div class="contentEditableContainer contentTextEditable">
                <div class="contentEditable" align='center'>

                    <p>Thank you for registering at <?= Yii::$app->name ?> . Your account is created and must be activated before you can use it. To activate the account click on the following link or copy-paste it in your browser:,</p>
                    <?php $regLink = Yii::$app->urlManager->createAbsoluteUrl(['site/login', 'regtoken' => $user['reg_key']]); ?> 
                    <a target='_blank' class='link1' href="<?= $regLink ?>"><?= $regLink ?></a>

                    <p  style='text-align:left;color:#dc2828;font-size:14px;font-weight:normal;line-height:19px;'>After activation you may login by using the following username and password:</p>

                    <p  style='text-align:left;color:#000;font-size:14px;font-weight:normal;line-height:19px;'><b>Username: <?php echo trim($user->username, ' '); ?></b>  </p>
                    <p  style='text-align:left;color:#000;font-size:14px;font-weight:normal;line-height:19px;'><b>Password: <?php echo trim($user['pass'], ' '); ?></b> </p>



                    <p  style='text-align:left;color:#000;font-size:14px;font-weight:normal;line-height:19px;'><b>Thanks and Regards</b>  </p>

                    <p  style='text-align:left;color:#999999;font-size:14px;font-weight:normal;line-height:19px;'><?= Yii::$app->name; ?> </p>
                </div>
            </div>
        </td>
    </tr>



    <tr>
        <td align='center'>

        </td>
    </tr>

</table>


