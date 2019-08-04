<?php


use yii\helpers\Html;

?>

<table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td width="auto"  align="center" valign="middle" height="28">
            <span>
                 <?= Yii::t('UserModule.views_mails_UserInviteSpace', 'You got an invite'); ?>
            </span>
        </td>
    </tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td valign="top" align="center">
            <a href="<?= $originator->createUrl('/user/profile', [], true); ?>">
               
               
            </a>
        </td>
    </tr>
</table>


<tr>
    <td height="15" class="col-underline"></td>
</tr>


<table width="100%" border="0" cellspacing="0" cellpadding="0"
       align="center">
    <tr>
        <td style="font-size: 18px; line-height: 22px; font-family:Open Sans, Arial,Tahoma, Helvetica, sans-serif; font-weight:300; text-align:center;">
             <span >
                  <a href="<?= $originator->createUrl('/user/profile', [], true); ?>"  style="text-decoration: none; font-weight: 300;">
                      <?= Html::encode($originator->displayName); ?>
                  </a>
             </span>
        </td>
    </tr>
</table>

<tr>
    <td height="5" class="col-underline"></td>
</tr>


<table border="0" cellspacing="0" cellpadding="0" align="center" >
    <tr>
        <td>
            <?= Yii::t('UserModule.views_mails_UserInviteSpace', 'invited you to join {name}.', ['name' => '<strong>' . Html::encode(Yii::$app->name) . '</strong>']); ?><br>
            <?= Yii::t('UserModule.views_mails_UserInviteSpace', 'Register now and participate!'); ?><br>
        </td>
    </tr>
</table>


<tr>
    <td valign="top" width="auto" align="center">
        <table border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td width="auto"  align="center" valign="middle" height="32" >
                    <span>
                         <a href="<?= $registrationUrl; ?>">
                              <strong><?= Yii::t('UserModule.views_mails_UserInviteSpace', 'Sign up now'); ?></strong>
                         </a>
                    </span>
                </td>

            </tr>
        </table>
    </td>
</tr>

