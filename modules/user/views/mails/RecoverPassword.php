<?php

use yii\helpers\Html;

?>

<table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td width="auto"  align="center" valign="middle" height="28" >
           <span>
               <?= Yii::t('UserModule.views_mails_RecoverPassword', '<strong>Password</strong> recovery'); ?>
           </span>
        </td>
    </tr>
</table>
<!-- end button -->

<table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container">


    <tr>
        <td valign="top">
            <table border="0" cellspacing="0" cellpadding="0" align="left" >


                <!--start space height -->
                <tr>
                    <td height="30" ></td>
                </tr>
                <!--end space height -->

                <tr>
                    <td  >

                        <?= Yii::t('UserModule.views_mails_RecoverPassword', 'Hello {displayName}', array('{displayName}' => Html::encode($user->displayName))); ?>
                        <br><br>
                        <?= Yii::t('UserModule.views_mails_RecoverPassword', 'Please use the following link within the next day to reset your password.'); ?>
                        <br>
                        <?= Yii::t('UserModule.views_mails_RecoverPassword', "If you don't use this link within 24 hours, it will expire."); ?>
                        <br>

                    </td>
                </tr>

                <!--start space height -->
                <tr>
                    <td height="30" ></td>
                </tr>
                <!--end space height -->



            </table>
        </td>
    </tr>
    <!-- end text content -->

    <tr>
        <td valign="top" width="auto" align="center">
            <!-- start button -->
            <table border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="auto"  align="center" valign="middle" height="32" >
                        <span>
                            <a href="<?= $linkPasswordReset; ?>">
                                <strong><?= Yii::t('UserModule.views_mails_RecoverPassword', 'Reset Password'); ?></strong>
                            </a>
                        </span>
                    </td>

                </tr>
            </table>
            <!-- end button -->
        </td>

    </tr>

</table>


