<?php

use \yii\helpers\Html;

?>

<div class="more_div"></div>
<?php foreach ($this->context->getItems() as $item): ?>
    <?php if ($item['label'] == '---'): ?>
        <div class="more_div"></div>
    <?php else: ?>
        <li class="l_comm">
            <a href="<?= $item['url']; ?>" class="sidebar-left-row">
                <span class="sidebar-left-fixer">
                    <object type="internal/link">
                        <a href="gim127730759" class="sidebar-right-counter-wrap float_right sidebar-right-counter-wrap-hovered">
                            <span class="sidebar-inline-bl sidebar-right-count">17</span>
                        </a>
                    </object>
                    <span class="sidebar-left-icon float_left"></span>
                    <span class="sidebar-left-label sidebar-inline-bl"><?= $item['label']; ?></span>
                </span>
            </a>
            <div class="sidebar-left-settings">
                <div class="sidebar-left-settings-inner"></div>
            </div>
        </li>
    <?php endif; ?>
<?php endforeach; ?>
