<div class="notifications pull-right">
    <div id="notification_widget" data-ui-widget="notification.NotificationDropDown" class="btn-group">
        <a href="#" id="icon-notifications" data-action-click="toggle" aria-label="Open the notification dropdown menu" data-toggle="dropdown">
            <i class="fa fa-bell animated swing"></i>
        </a>

        <span id="badge-notifications" style="" class="label label-danger label-notifications">9</span>

        <!-- container for ajax response -->
        <ul id="dropdown-notifications" class="dropdown-menu">
            <li class="dropdown-header">
                <div class="arrow"></div> Уведомления
                <div class="dropdown-header-link">
                    <a id="mark-seen-link" data-action-click="markAsSeen" data-action-url="/notification/list/mark-as-seen">
                        Пометить всё как прочитанное
                    </a>
                </div>
            </li>
            <ul class="media-list" tabindex="0" style="overflow: hidden; outline: none;">
                <li class="placeholder">
                    Уведомлений пока нет.
                </li>
            </ul>
            <li id="loader_notifications">
                <div class="loader encore-ui-loader ">
                    <div class="sk-spinner sk-spinner-three-bounce">
                        <div class="sk-bounce1"></div>
                        <div class="sk-bounce2"></div>
                        <div class="sk-bounce3"></div>
                    </div>
                </div>        </li>
            <li>
                <div class="dropdown-footer">
                    <a class="btn btn-default col-md-12" href="/notification/overview">
                        Показать все уведомления
                    </a>
                </div>
            </li>
        </ul>
    </div>
    <div class="btn-group">
        <a href="#" id="icon-messages" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope"></i></a>
        <span id="badge-messages" style="display:none;" class="label label-danger label-notification">1</span>
        <ul id="dropdown-messages" class="dropdown-menu">
        </ul>
    </div>
</div>