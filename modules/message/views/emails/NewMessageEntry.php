<?php

use yii\helpers\Url;
use yii\helpers\Html;
use humhub\widgets\MarkdownView;
?>
<tr>
    <td align="center" valign="top"   class="fix-box">

        <!-- start  container width 600px -->
        <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container"  style="background-color: #ffffff; ">


            <tr>
                <td valign="top">

                    <!-- start container width 560px -->
                    <table width="540"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" bgcolor="#ffffff" style="background-color:#ffffff;">


                        <!-- start text content -->
                        <tr>
                            <td valign="top">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
                                    <tr>
                                        <td valign="top" width="auto" align="center">
                                            <!-- start button -->
                                            <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="auto"  align="center" valign="middle" height="28" style=" background-color:#ffffff; background-clip: padding-box; font-size:26px; font-family: <?= Yii::$app->view->theme->variable('mail-font-family', 'Open Sans, Arial, Tahoma, Helvetica, sans-serif') ?>; text-align:center;  color:#a3a2a2; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                                        <span style="color: #555555; font-weight: 300;">
                                                            <?php echo Yii::t('MessageModule.views_emails_NewMessage', '<strong>New</strong> message'); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- end button -->
                                        </td>
                                    </tr>



                                </table>
                            </td>
                        </tr>
                        <!-- end text content -->


                    </table>
                    <!-- end  container width 560px -->
                </td>
            </tr>
        </table>
        <!-- end  container width 600px -->
    </td>
</tr>

<!-- END LAYOUT-1/1 -->


<!-- START LAYOUT-1/2 -->
<tr>
    <td align="center" valign="top" class="fix-box">

        <!-- start  container width 600px -->
        <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="container" bgcolor="#ffffff"
               style="background-color: #ffffff; border-bottom-left-radius: 4px; border-bottom-left-radius: 4px;">
            <tr>
                <td valign="top">

                    <!-- start container width 560px -->
                    <table width="560" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"
                           bgcolor="#ffffff" style="background-color:#ffffff;">

                        <!-- start image and content -->
                        <tr>
                            <td valign="top" width="100%">

                                <!-- start content left -->
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">

                                    <!--start space height -->
                                    <tr>
                                        <td height="20"></td>
                                    </tr>
                                    <!--end space height -->


                                    <!-- start content top-->
                                    <tr>
                                        <td valign="top" align="left">

                                            <table border="0" cellspacing="0" cellpadding="0" align="left">
                                                <tr>

                                                    <td valign="top" align="left" style="padding-right:20px;">
                                                        <!-- START: USER IMAGE -->
                                                        <a href="<?php echo $sender->createUrl(null, [], true); ?>">
                                                            <img
                                                                src="<?php echo $sender->getProfileImage()->getUrl("", true); ?>"
                                                                width="50"
                                                                alt=""
                                                                style="max-width:50px; display:block !important; border-radius: 4px;"
                                                                border="0" hspace="0" vspace="0"/>
                                                        </a>
                                                        <!-- END: USER IMAGE -->
                                                    </td>


                                                    <td valign="top">

                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                               align="left">

                                                            <tr>
                                                                <td style="font-size: 13px; line-height: 22px; font-family: <?= Yii::$app->view->theme->variable('mail-font-family', 'Open Sans, Arial, Tahoma, Helvetica, sans-serif') ?>; color:#555555; font-weight:300; text-align:left; ">

                                                                    <strong><?php echo Html::encode($sender->displayName); ?></strong> <?php echo Yii::t('MessageModule.views_emails_NewMessageEntry', 'sent you a new message in'); ?> <strong><?php echo Html::encode($message->title); ?></strong>
                                                                    <br>
                                                                    <br>
                                                                    <?php echo MarkdownView::widget(array('markdown' => $entry->content)); ?>

                                                                </td>
                                                            </tr>

                                                        </table>

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- end  content top-->

                                    <!--start space height -->
                                    <tr>
                                        <td height="15" class="col-underline"></td>
                                    </tr>
                                    <!--end space height -->


                                    <tr>
                                        <td valign="top" width="auto" align="center">
                                            <!-- start button -->
                                            <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="auto"  align="center" valign="middle" height="32" style=" background-color:<?= $this->theme->variable('primary'); ?>;  border-radius:5px; background-clip: padding-box;font-size:14px; font-family: <?= Yii::$app->view->theme->variable('mail-font-family', 'Open Sans, Arial, Tahoma, Helvetica, sans-serif') ?>; text-align:center;  color:#ffffff; font-weight: 600; padding-left:30px; padding-right:30px; padding-top: 5px; padding-bottom: 5px;">

                                                        <span style="color: #ffffff; font-weight: 300;">
                                                            <a href="<?php echo Url::to(['/mail/mail/index', 'id' => $message->id], true); ?>" style="text-decoration: none; color: #ffffff; font-weight: 300;">
                                                                <strong><?php echo Yii::t('MessageModule.views_emails_NewMessage', 'Reply now'); ?></strong>
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
                                        <td height="15" class="col-underline"></td>
                                    </tr>
                                    <!--end space height -->


                                </table>
                                <!-- end content left -->


                            </td>
                        </tr>
                        <!-- end image and content -->

                    </table>
                    <!-- end  container width 560px -->
                </td>
            </tr>
        </table>
        <!-- end  container width 600px -->
    </td>
</tr>