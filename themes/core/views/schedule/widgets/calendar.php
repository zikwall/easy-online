<style>
    .event-container {
        width: 90%;
        margin: auto;
    }

    .today-box {
        background: linear-gradient(to left, #4a76a8, rgba(83, 103, 255, 0.25)), #4a76a8;
        color: #FFF;
        padding: 37px 40px;
        position: relative;
        margin-bottom: 20px;
    }
    .today-box::before {
        content: "";
        background: linear-gradient(to left, #4a76a8, rgba(83, 103, 255, 0.25)), #4a76a8;
        opacity: 0.4;
        z-index: -1;
        display: block;
        width: 100%;
        height: 40px;
        margin: auto;
        position: absolute;
        bottom: -13px;
        left: 50%;
        transform: translatex(-50%);
        border-radius: 50%;
    }
    .today-box .event-breadcrumb {
        font-weight: 300;
        position: relative;
    }
    .today-box .event-breadcrumb::after {
        content: "\f3d1";
        font-family: 'Ionicons';
        vertical-align: middle;
        font-size: 12px;
        font-weight: 100;
        display: inline-block;
        color: #fff;
        text-align: center;
        position: absolute;
        left: 45px;
        top: 3px;
    }
    .today-box .date-title {
        font-size: 20px;
        margin: 7px 0 0 0;
        letter-spacing: 1px;
        font-weight: 600;
        text-shadow: 0px 0px 5px rgba(0, 0, 0, 0.15);
    }
    .today-box .plus-icon {
        border: 2px solid rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        box-shadow: 0px 10px 30px -14px #000;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 40px;
        cursor: pointer;
        transition: all 350ms ease;
        transition-timing-function: cubic-bezier(0.05, 1.8, 1, 1.57);
    }
    .today-box .plus-icon:hover {
        transform: translateY(-40%);
    }
    .today-box .plus-icon i {
        font-size: 22px;
        font-weight: 700;
        background: #fff;
        color: #777;
        width: 45px;
        height: 45px;
        border: 6px solid #4a76a8;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .today-box .plus-icon:active {
        top: 52%;
        transform: translatey(-52%);
        right: 38px;
        box-shadow: 0px 8px 30px -14px #000;
    }

    .upcoming-events .event-container .events-wrapper:last-child {
        margin-bottom: 0px!important;
        padding-bottom: -15px;
    }
    .upcoming-events .event-container h3 {
        color: #333;
        font-size: 17px;
        margin-bottom: 30px;
        position: relative;
    }
    .upcoming-events .event-container .events-wrapper .event {
        position: relative;
        padding-left: 30px;
        cursor: pointer;
    }
    .upcoming-events .event-container .events-wrapper .event:not(:last-child) {
        margin-bottom: 25px;
    }
    .upcoming-events .event-container .events-wrapper .event i {
        font-size: 24px;
        font-weight: 100;
        position: absolute;
        left: 0;
        top: -4px;
    }
    .upcoming-events .event-container .events-wrapper .event .event__point {
        margin: 0;
        color: #555;
        font-size: 15px;
        font-weight: 800;
        letter-spacing: 1px;
    }
    .upcoming-events .event-container .events-wrapper .event .event__duration {
        position: absolute;
        top: 5px;
        right: 0;
        color: #999;
        font-size: 10px;
        font-weight: 800;
        font-style: italic;
    }
    .upcoming-events .event-container .events-wrapper .event .event__description {
        margin-top: 10px;
        color: #919294;
        font-size: 13px;
        font-weight: 300;
    }
    .upcoming-events .event-container .events-wrapper .event.active {
        background: #e8e8e8;
        padding: 17px 0 5px 25px;
        margin-bottom: 38px;
        border-radius: 5px;
    }
    .upcoming-events .event-container .events-wrapper .event.active::after {
        content: "";
        display: block;
        width: 90%;
        height: 10px;
        background: #fff;
        border: 2px solid #ddd;
        border-top: 0;
        border-radius: 0 0 5px 5px;
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translatex(-50%);
    }
    .upcoming-events .event-container .events-wrapper .event.active i {
        position: absolute;
        left: 25px;
        top: 17px;
    }

    .hot {
        color: #ee6b51;
    }

    .done {
        color: #999 !important;
    }

    .icon-in-active-mode {
        color: #43ff28;
        font-size: 20px !important;
    }

    .upcoming {
        font-weight: bold;
        color: #777;
    }
</style>

<div class="page_block">
    <a href="/gifts146677013" onclick="" class="module_header">
        <div class="header_top clear_fix">
            <span class="header_label float_left">Ближайшие пары</span>
            <span class="header_count float_left" id="gifts_module_count">6</span>
        </div>
    </a>

    <section class="module_body upcoming-events">
        <div class="event-container">
            <div class="events-wrapper">
                <div class="event">
                    <i class="ion ion-ios-flame hot"></i>
                    <h4 class="event__point">11:00 am</h4>
                    <span class="event__duration">in 30 minutes.</span>
                    <p class="event__description">
                        Monday briefing with the team (...).
                    </p>
                </div>
                <div class="event">
                    <i class="ion ion-ios-flame done"></i>
                    <h4 class="event__point">12:00 pm</h4>
                    <span class="event__duration">in 1 hour.</span>
                    <p class="event__description">
                        Lunch with Paul Mccartney @Burgers House!
                    </p>
                </div>
                <div class="event active">
                    <i class="ion ion-ios-radio-button-on icon-in-active-mode"></i>
                    <h4 class="event__point">14:00 pm</h4>
                    <p class="event__description">
                        Meet clients from project.
                    </p>
                </div>
                <div class="event">
                    <i class="ion ion-ios-flame-outline upcoming"></i>
                    <h4 class="event__point">20:45 pm</h4>
                    <span class="event__duration">in 45 minutes.</span>
                    <p class="event__description">
                        Watch sci-fi series.
                    </p>
                </div>
                <div class="event">
                    <i class="ion ion-ios-flame-outline upcoming"></i>
                    <h4 class="event__point">23:15 pm</h4>
                    <span class="event__duration">in 20 minutes.</span>
                    <p class="event__description">
                        Customer dialog on Skype.
                    </p>
                </div>
            </div>
        </div>
    </section>

</div>

