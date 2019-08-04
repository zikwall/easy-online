<?php

/**
 * HumHub
 * Copyright © 2014 The HumHub Project
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 */

namespace zikwall\easyonline\modules\community\commands;

use Yii;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\community\models\Community;
use yii\helpers\Console;

/**
 * Console tools for manage communitys
 *
 * @package humhub.modules_core.community.console
 * @since 0.5
 */
class CommunityController extends \yii\console\Controller
{

    public function actionAssignAllMembers($communityId)
    {
        $community = Community::findOne(['id' => $communityId]);
        if ($community == null) {
            print "Error: Community not found! Check id!\n\n";
            return;
        }

        $countMembers = 0;
        $countAssigns = 0;

        $this->stdout("\nAdding Members:\n\n");

        foreach (User::find()->active()->all() as $user) {
            if ($community->isMember($user->id)) {
                $countMembers++;
            } else {
                $this->stdout("\t" . $user->displayName . " added. \n", Console::FG_YELLOW);

                #Yii::app()->user->setId($user->id);

                Yii::$app->user->switchIdentity($user);
                $community->addMember($user->id);
                $countAssigns++;
            }
        }

        $this->stdout("\nAdded " . $countAssigns . " new members to community " . $community->name . "\n", Console::FG_GREEN);
    }

}
