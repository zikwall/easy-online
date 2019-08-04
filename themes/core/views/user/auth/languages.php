<style>
    .languages-list {
        padding: 20px 0 20px 30px;
    }
    .language-column {
        margin: 0 3px;
        float: left;
        width: 160px;
    }
    .language-column a, .language-column b {
        padding: 3px 7px;
        display: block;
    }
</style>


<div class="modal-box-message">
    <b>
        <?= Yii::t('UserModule.views_auth_recoverPassword', 'Just enter your e-mail address. We´ll send you recovery instructions!'); ?>
    </b>
</div>

<div class="languages-list clear_fix"><div class="language-column float-left">
        <div onmouseover="Language.showEngName(this);" data-eng-name="Azerbaijani">
            <a class="" onclick="Language.changeLang(this, 57, '0b49595a1b1d4b9f3d')"><span class="language_title">Azərbaycan dili</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Indonesian">
            <a class="" onclick="Language.changeLang(this, 69, '0b49595a1b1d4b9f3d')"><span class="language_title">Bahasa Indonesia</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Bosnian">
            <a class="" onclick="Language.changeLang(this, 72, '0b49595a1b1d4b9f3d')"><span class="language_title">Bosanski</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Danish">
            <a class="" onclick="Language.changeLang(this, 64, '0b49595a1b1d4b9f3d')"><span class="language_title">Dansk</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="German">
            <a class="" onclick="Language.changeLang(this, 6, '0b49595a1b1d4b9f3d')"><span class="language_title">Deutsch</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Estonian">
            <a class="" onclick="Language.changeLang(this, 22, '0b49595a1b1d4b9f3d')"><span class="language_title">Eesti</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="English">
            <a class="" onclick="Language.changeLang(this, 3, '0b49595a1b1d4b9f3d')"><span class="language_title">English</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Spanish">
            <a class="" onclick="Language.changeLang(this, 4, '0b49595a1b1d4b9f3d')"><span class="language_title">Español</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Esperanto">
            <a class="" onclick="Language.changeLang(this, 555, '0b49595a1b1d4b9f3d')"><span class="language_title">Esperanto</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="French">
            <a class="" onclick="Language.changeLang(this, 16, '0b49595a1b1d4b9f3d')"><span class="language_title">Français</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Croatian">
            <a class="" onclick="Language.changeLang(this, 9, '0b49595a1b1d4b9f3d')"><span class="language_title">Hrvatski</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Italian">
            <a class="" onclick="Language.changeLang(this, 7, '0b49595a1b1d4b9f3d')"><span class="language_title">Italiano</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Karelian">
            <a class="" onclick="Language.changeLang(this, 379, '0b49595a1b1d4b9f3d')"><span class="language_title">Karjalan kieli</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Swahili">
            <a class="" onclick="Language.changeLang(this, 95, '0b49595a1b1d4b9f3d')"><span class="language_title">Kiswahili</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Latvian">
            <a class="" onclick="Language.changeLang(this, 56, '0b49595a1b1d4b9f3d')"><span class="language_title">Latviešu</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Lithuanian">
            <a class="" onclick="Language.changeLang(this, 19, '0b49595a1b1d4b9f3d')"><span class="language_title">Lietuvių</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Latin">
            <a class="" onclick="Language.changeLang(this, 666, '0b49595a1b1d4b9f3d')"><span class="language_title">Lingua Latina</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Hungarian">
            <a class="" onclick="Language.changeLang(this, 10, '0b49595a1b1d4b9f3d')"><span class="language_title">Magyar</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Mirandese">
            <a class="" onclick="Language.changeLang(this, 270, '0b49595a1b1d4b9f3d')"><span class="language_title">Mirandés</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Moldavian">
            <a class="" onclick="Language.changeLang(this, 66, '0b49595a1b1d4b9f3d')"><span class="language_title">Moldovenească</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Dutch">
            <a class="" onclick="Language.changeLang(this, 61, '0b49595a1b1d4b9f3d')"><span class="language_title">Nederlands</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Norwegian">
            <a class="" onclick="Language.changeLang(this, 55, '0b49595a1b1d4b9f3d')"><span class="language_title">Norsk</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Uzbek">
            <a class="" onclick="Language.changeLang(this, 65, '0b49595a1b1d4b9f3d')"><span class="language_title">O‘zbek</span> </a>
        </div>
    </div><div class="language-column float-left">
        <div onmouseover="Language.showEngName(this);" data-eng-name="Polish">
            <a class="" onclick="Language.changeLang(this, 15, '0b49595a1b1d4b9f3d')"><span class="language_title">Polski</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Portuguese">
            <a class="" onclick="Language.changeLang(this, 12, '0b49595a1b1d4b9f3d')"><span class="language_title">Português</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Brazilian Portuguese">
            <a class="" onclick="Language.changeLang(this, 73, '0b49595a1b1d4b9f3d')"><span class="language_title">Português brasileiro</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Romanian">
            <a class="" onclick="Language.changeLang(this, 54, '0b49595a1b1d4b9f3d')"><span class="language_title">Română</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Albanian">
            <a class="" onclick="Language.changeLang(this, 59, '0b49595a1b1d4b9f3d')"><span class="language_title">Shqip</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Slovenian">
            <a class="" onclick="Language.changeLang(this, 71, '0b49595a1b1d4b9f3d')"><span class="language_title">Slovenščina</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Finnish">
            <a class="" onclick="Language.changeLang(this, 5, '0b49595a1b1d4b9f3d')"><span class="language_title">Suomi</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Swedish">
            <a class="" onclick="Language.changeLang(this, 60, '0b49595a1b1d4b9f3d')"><span class="language_title">Svenska</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Tagalog">
            <a class="" onclick="Language.changeLang(this, 79, '0b49595a1b1d4b9f3d')"><span class="language_title">Tagalog</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Kabyle">
            <a class="" onclick="Language.changeLang(this, 457, '0b49595a1b1d4b9f3d')"><span class="language_title">Taqbaylit</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Vietnamese">
            <a class="" onclick="Language.changeLang(this, 75, '0b49595a1b1d4b9f3d')"><span class="language_title">Tiếng Việt</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Talysh">
            <a class="" onclick="Language.changeLang(this, 373, '0b49595a1b1d4b9f3d')"><span class="language_title">Tolışə zıvon</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Turkmen">
            <a class="" onclick="Language.changeLang(this, 62, '0b49595a1b1d4b9f3d')"><span class="language_title">Türkmen</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Turkish">
            <a class="" onclick="Language.changeLang(this, 82, '0b49595a1b1d4b9f3d')"><span class="language_title">Türkçe</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Czech">
            <a class="" onclick="Language.changeLang(this, 21, '0b49595a1b1d4b9f3d')"><span class="language_title">Čeština</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Greek">
            <a class="" onclick="Language.changeLang(this, 14, '0b49595a1b1d4b9f3d')"><span class="language_title">Ελληνικά</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Slovak">
            <a class="" onclick="Language.changeLang(this, 53, '0b49595a1b1d4b9f3d')"><span class="language_title">Slovenčina</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Adyghe">
            <a class="" onclick="Language.changeLang(this, 106, '0b49595a1b1d4b9f3d')"><span class="language_title">Адыгабзэ</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Kabardian">
            <a class="" onclick="Language.changeLang(this, 102, '0b49595a1b1d4b9f3d')"><span class="language_title">Адыгэбзэ</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Bashkir">
            <a class="" onclick="Language.changeLang(this, 51, '0b49595a1b1d4b9f3d')"><span class="language_title">Башҡортса</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Belarusian">
            <a class="" onclick="Language.changeLang(this, 114, '0b49595a1b1d4b9f3d')"><span class="language_title">Беларуская</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Belarusian (Tarashkevitsa)">
            <a class="" onclick="Language.changeLang(this, 2, '0b49595a1b1d4b9f3d')"><span class="language_title">Беларуская (тарашкевiца)</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Buryat">
            <a class="" onclick="Language.changeLang(this, 67, '0b49595a1b1d4b9f3d')"><span class="language_title">Буряад</span> </a>
        </div>
    </div><div class="language-column float-left">
        <div onmouseover="Language.showEngName(this);" data-eng-name="Bulgarian">
            <a class="" onclick="Language.changeLang(this, 8, '0b49595a1b1d4b9f3d')"><span class="language_title">Български</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="imperial">
            <a class="" onclick="Language.changeLang(this, 100, '0b49595a1b1d4b9f3d')"><span class="language_title">Дореволюцiонный</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Ossetian">
            <a class="" onclick="Language.changeLang(this, 91, '0b49595a1b1d4b9f3d')"><span class="language_title">Ирон</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Komi-Zyrian">
            <a class="" onclick="Language.changeLang(this, 375, '0b49595a1b1d4b9f3d')"><span class="language_title">Коми кыв</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Kirghiz">
            <a class="" onclick="Language.changeLang(this, 87, '0b49595a1b1d4b9f3d')"><span class="language_title">Кыргыз тили</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Kumyk">
            <a class="" onclick="Language.changeLang(this, 236, '0b49595a1b1d4b9f3d')"><span class="language_title">Къумукъ тил</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Lezgian">
            <a class="" onclick="Language.changeLang(this, 118, '0b49595a1b1d4b9f3d')"><span class="language_title">Лезги чІал</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Mari">
            <a class="" onclick="Language.changeLang(this, 108, '0b49595a1b1d4b9f3d')"><span class="language_title">Марий йылме</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Mongolian">
            <a class="" onclick="Language.changeLang(this, 80, '0b49595a1b1d4b9f3d')"><span class="language_title">Монгол</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Rusyn">
            <a class="" onclick="Language.changeLang(this, 298, '0b49595a1b1d4b9f3d')"><span class="language_title">Русинськый</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Russian">
            <a class="language_selected" onclick="Language.changeLang(this, 0, '0b49595a1b1d4b9f3d')"><span class="language_title">Русский</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Tatar">
            <a class="" onclick="Language.changeLang(this, 50, '0b49595a1b1d4b9f3d')"><span class="language_title">Татарча</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Yakut">
            <a class="" onclick="Language.changeLang(this, 105, '0b49595a1b1d4b9f3d')"><span class="language_title">Саха тыла</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Soviet">
            <a class="" onclick="Language.changeLang(this, 777, '0b49595a1b1d4b9f3d')"><span class="language_title">Советский</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Tajik">
            <a class="" onclick="Language.changeLang(this, 70, '0b49595a1b1d4b9f3d')"><span class="language_title">Тоҷикӣ</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Tuva">
            <a class="" onclick="Language.changeLang(this, 344, '0b49595a1b1d4b9f3d')"><span class="language_title">Тыва дыл</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Serbian">
            <a class="" onclick="Language.changeLang(this, 11, '0b49595a1b1d4b9f3d')"><span class="language_title">Српски</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Chuvash">
            <a class="" onclick="Language.changeLang(this, 52, '0b49595a1b1d4b9f3d')"><span class="language_title">Чăвашла</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Erzya">
            <a class="" onclick="Language.changeLang(this, 101, '0b49595a1b1d4b9f3d')"><span class="language_title">Эрзянь кель</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Kalmyk-Oirat">
            <a class="" onclick="Language.changeLang(this, 357, '0b49595a1b1d4b9f3d')"><span class="language_title">Хальмг келн</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Udmurt">
            <a class="" onclick="Language.changeLang(this, 107, '0b49595a1b1d4b9f3d')"><span class="language_title">Удмурт</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Ukrainian">
            <a class="" onclick="Language.changeLang(this, 1, '0b49595a1b1d4b9f3d')"><span class="language_title">Українська</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Ukrainian (Galician)">
            <a class="" onclick="Language.changeLang(this, 454, '0b49595a1b1d4b9f3d')"><span class="language_title">Українська (Галицка)</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div>
    </div>
    <div class="language-column float-left">
        <div onmouseover="Language.showEngName(this);" data-eng-name="Ukrainian (traditional)">
            <a class="" onclick="Language.changeLang(this, 452, '0b49595a1b1d4b9f3d')"><span class="language_title">Українська (клясична)</span>  <span class="lang_beta" onmouseover="Language.showBetaTooltip(this, event);">β</span></a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Kazakh">
            <a class="" onclick="Language.changeLang(this, 97, '0b49595a1b1d4b9f3d')"><span class="language_title">Қазақша</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Nepali">
            <a class="" onclick="Language.changeLang(this, 83, '0b49595a1b1d4b9f3d')"><span class="language_title">नेपाली</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Hindi">
            <a class="" onclick="Language.changeLang(this, 76, '0b49595a1b1d4b9f3d')"><span class="language_title">हिन्दी</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Bengali">
            <a class="" onclick="Language.changeLang(this, 78, '0b49595a1b1d4b9f3d')"><span class="language_title">বাংলা</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Kannada">
            <a class="" onclick="Language.changeLang(this, 94, '0b49595a1b1d4b9f3d')"><span class="language_title">ಕನ್ನಡ</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Singhalese ">
            <a class="" onclick="Language.changeLang(this, 77, '0b49595a1b1d4b9f3d')"><span class="language_title">සිංහල</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Thai">
            <a class="" onclick="Language.changeLang(this, 68, '0b49595a1b1d4b9f3d')"><span class="language_title">ภาษาไทย</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Georgian">
            <a class="" onclick="Language.changeLang(this, 63, '0b49595a1b1d4b9f3d')"><span class="language_title">ქართული</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Burmese">
            <a class="" onclick="Language.changeLang(this, 81, '0b49595a1b1d4b9f3d')"><span class="language_title">ဗမာစာ</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Japanese">
            <a class="" onclick="Language.changeLang(this, 20, '0b49595a1b1d4b9f3d')"><span class="language_title">日本語</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Chinese">
            <a class="" onclick="Language.changeLang(this, 18, '0b49595a1b1d4b9f3d')"><span class="language_title">汉语</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Taiwanese">
            <a class="" onclick="Language.changeLang(this, 119, '0b49595a1b1d4b9f3d')"><span class="language_title">臺灣話</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Korean">
            <a class="" onclick="Language.changeLang(this, 17, '0b49595a1b1d4b9f3d')"><span class="language_title">한국어</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Armenian">
            <a class="" onclick="Language.changeLang(this, 58, '0b49595a1b1d4b9f3d')"><span class="language_title">Հայերեն</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Hebrew">
            <a class="" onclick="Language.changeLang(this, 99, '0b49595a1b1d4b9f3d')"><span class="language_title">עברית</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Urdu">
            <a class="" onclick="Language.changeLang(this, 85, '0b49595a1b1d4b9f3d')"><span class="language_title">اردو</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Arabic">
            <a class="" onclick="Language.changeLang(this, 98, '0b49595a1b1d4b9f3d')"><span class="language_title">العربية</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Persian">
            <a class="" onclick="Language.changeLang(this, 74, '0b49595a1b1d4b9f3d')"><span class="language_title">فارسی</span> </a>
        </div><div onmouseover="Language.showEngName(this);" data-eng-name="Punjabi (western)">
            <a class="" onclick="Language.changeLang(this, 90, '0b49595a1b1d4b9f3d')"><span class="language_title">پنجابی</span> </a>
        </div>
    </div>
</div>

