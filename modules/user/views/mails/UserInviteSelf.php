<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td valign="top" width="auto" align="center">
            <!-- start button -->
            <table border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="auto" align="center" valign="middle" height="28">
                        <span >
                           <?= Yii::t('UserModule.views_mails_UserInviteSelf', 'Welcome to %appName%', array('%appName%' => '<strong>' . Html::encode(Yii::$app->name) . '</strong>')); ?>
                        </span>
                    </td>
                </tr>
            </table>
            <!-- end button -->
        </td>
    </tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" align="center">


    <!--start space height -->
    <tr>
        <td height="15"></td>
    </tr>
    <!--end space height -->

    <tr>
        <td >
            <?=  Yii::t('UserModule.views_mails_UserInviteSelf', 'Welcome to %appName%. Please click on the button below to proceed with your registration.', array('%appName%' => Html::encode(Yii::$app->name))); ?>

        </td>
    </tr>

    <!--start space height -->
    <tr>
        <td height="15"></td>
    </tr>
    <!--end space height -->
</table>


<tr>
    <td valign="top" width="auto" align="center">
        <!-- start button -->
        <table border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td width="auto" align="center" valign="middle" height="32">
                    <span >
                       <a href="<?=  Url::toRoute(['/user/registration', 'token' => $token], true); ?>">
                          <strong>
                              <?=  Yii::t('UserModule.views_mails_UserInviteSelf', 'Sign up'); ?>
                          </strong>
                       </a>
                    </span>
                </td>

            </tr>
        </table>
        <!-- end button -->
    </td>

</tr>

<!--start space height -->
<tr>
    <td height="20"></td>
</tr>
<!--end space height -->


