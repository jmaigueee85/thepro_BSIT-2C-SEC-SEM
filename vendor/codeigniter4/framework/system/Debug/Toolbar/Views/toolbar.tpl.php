<?php declare(strict_types=1);
/**
 * @var CodeIgniter\Debug\Toolbar $this
 * @var int                       $totalTime
 * @var int                       $totalMemory
 * @var string                    $url
 * @var string                    $method
 * @var bool                      $isAJAX
 * @var int                       $startTime
 * @var int                       $totalTime
 * @var int                       $totalMemory
 * @var float                     $segmentDuration
 * @var int                       $segmentCount
 * @var string                    $CI_VERSION
 * @var array                     $collectors
 * @var array                     $vars
 * @var array                     $styles
 * @var CodeIgniter\View\Parser   $parser
 */
?>
<style>
    <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . '/toolbar.css')) ?>
</style>

<script id="toolbar_js">
    var ciSiteURL = "<?= rtrim(site_url(), '/') ?>"
    <?= file_get_contents(__DIR__ . '/toolbar.js') ?>
</script>
<div id="debug-icon" class="debug-bar-ndisplay">
    <a id="debug-icon-link">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 155 200"><defs/><path fill="#dd4814" d="M73.7 3.7c2.2 7.9-.7 18.5-7.8 29-1.8 2.6-10.7 12.2-19.7 21.3-23.9 24-33.6 37.1-40.3 54.4-7.9 20.6-7.8 40.8.5 58.2C12.8 180 27.6 193 42.5 198l6 2-3-2.2c-21-15.2-22.9-38.7-4.8-58.8 2.5-2.7 4.8-5 5.1-5 .4 0 .7 2.7.7 6.1 0 5.7.2 6.2 3.7 9.5 3 2.7 4.6 3.4 7.8 3.4 5.6 0 9.9-2.4 11.6-6.5 2.9-6.9 1.6-12-5-20.5-10.5-13.4-11.7-23.3-4.3-34.7l3.1-4.8.7 4.7c1.3 8.2 5.8 12.9 25 25.8 20.9 14.1 30.6 26.1 32.8 40.5 1.1 7.2-.1 16.1-3.1 21.8-2.7 5.3-11.2 14.3-16.5 17.4-2.4 1.4-4.3 2.6-4.3 2.8 0 .2 2.4-.4 5.3-1.4 24.1-8.3 42.7-27.1 48.2-48.6 1.9-7.6 1.9-20.2-.1-28.5-3.5-15.2-14.6-30.5-29.9-41.2l-7-4.9-.6 3.3c-.8 4.8-2.6 7.6-5.9 9.3-4.5 2.3-10.3 1.9-13.8-1-6.7-5.7-7.8-14.6-3.7-30.5 3-11.6 3.2-20.6.5-29.1C88.3 18 80.6 6.3 74.8 2.2 73.1.9 73 1 73.7 3.7z"/></svg>
    </a>
</div>
<div id="debug-bar">
    <div class="toolbar">
        <span id="toolbar-position">&#8597;</span>
        <span id="toolbar-theme">&#128261;</span>
        <span id="hot-reload-btn" class="ci-label">
            <a id="debug-hot-reload" title="Toggle Hot Reload">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABNklEQVR4nN2US04CQRCGv/DaiBxEvYWuBRPDKSCIXsCdcg0ULqTI8xIGN7JwTCU/ScV5tTO64Us6maSq/7+nuqvgkLgHopTl+QAWwBToAg3+wMTzM7YBrihp4jkCToEB8OJyRkCFAB5yDDxVoAd8OpNMOkrcAeMAgz3nzsQ0EqkDayXZqXy5Qugrdy2tGNdKeNWv40xCqGpvJK0YEwXt8ooylMZzUnCh4EkJgzNpmFaMrYLNEgbH0thmGVhSUVrSeE8KLv+7RBMFb0oY3EnDeihGN+WZhmJ7ZlnPtKHB5RvtNwy0d5XWaGgqRmp7a/9QLjRevoDLvOSRM+nnlKumk++0xwZlLhVnEulOhnohTS37vnU1t5M/ho7rPR03/LKW1bxNQep6ETZb5mpGW2/Ak2KpF3oYfAPX9Xpc671kqwAAAABJRU5ErkJggg==" />
            </a>
        </span>
        <span class="ci-label">
            <a data-tab="ci-timeline">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAD7SURBVEhLY6ArSEtLK09NTbWHcvGC9PR0BaDaQiAdUl9fzwQVxg+AFvwHamqHcnGCpKQkeaDa9yD1UD09UCn8AKaBWJySkmIApFehi0ONwwRQBceBLurAh4FqFoHUAtkrgPgREN+ByYEw1DhMANVEMIhAYQ5U1wtU/wmILwLZRlAp/IBYC8gGw88CaFj3A/FnIL4ETDXGUCnyANSC/UC6HIpnQMXAqQXIvo0khxNDjcMEQEmU9AzDuNI7Lgw1DhOAJIEuhQcRKMcC+e+QNHdDpcgD6BaAANSSQqBcENFlDi6AzQKqgkFlwWhxjVI8o2OgmkFaXI8CTMDAAAAxd1O4FzLMaAAAAABJRU5ErkJggg==">
                <span class="hide-sm"><?= $totalTime ?> ms &nbsp; <?= $totalMemory ?> MB</span>
            </a>
        </span>

        <?php foreach ($collectors as $c) : ?>
            <?php if (! $c['isEmpty'] && ($c['hasTabContent'] || $c['hasLabel'])) : ?>
                <span class="ci-label">
                    <a data-tab="ci-<?= $c['titleSafe'] ?>">
                        <img src="<?= $c['icon'] ?>">
                        <span class="hide-sm">
                            <?= $c['title'] ?>
                            <?php if ($c['badgeValue'] !== null) : ?>
                                <span class="badge"><?= $c['badgeValue'] ?></span>
                            <?php endif ?>
                        </span>
                    </a>
                </span>
            <?php endif ?>
        <?php endforeach ?>

        <span class="ci-label">
            <a data-tab="ci-vars">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAACLSURBVEhLYxgFJIHU1NSraWlp/6H4T0pKSjRUijoAyXAwBlrYDpViAFpmARQrJwZDtWACoCROC4D8CnR5XBiqBRMADfyNprgRKkUdAApzoCUdUNwE5MtApYYIALp6NBWBMVQLJgAaOJqK8AOgq+mSio6DggjEBtLUT0UwQ5HZIADkj6aiUTAggIEBANAEDa/lkCRlAAAAAElFTkSuQmCC">
                <span class="hide-sm">Vars</span>
            </a>
        </span>

        <h1>
            <span class="ci-label">
                <a data-tab="ci-config">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 155 200"><defs/><path fill="#dd4814" d="M73.7 3.7c2.2 7.9-.7 18.5-7.8 29-1.8 2.6-10.7 12.2-19.7 21.3-23.9 24-33.6 37.1-40.3 54.4-7.9 20.6-7.8 40.8.5 58.2C12.8 180 27.6 193 42.5 198l6 2-3-2.2c-21-15.2-22.9-38.7-4.8-58.8 2.5-2.7 4.8-5 5.1-5 .4 0 .7 2.7.7 6.1 0 5.7.2 6.2 3.7 9.5 3 2.7 4.6 3.4 7.8 3.4 5.6 0 9.9-2.4 11.6-6.5 2.9-6.9 1.6-12-5-20.5-10.5-13.4-11.7-23.3-4.3-34.7l3.1-4.8.7 4.7c1.3 8.2 5.8 12.9 25 25.8 20.9 14.1 30.6 26.1 32.8 40.5 1.1 7.2-.1 16.1-3.1 21.8-2.7 5.3-11.2 14.3-16.5 17.4-2.4 1.4-4.3 2.6-4.3 2.8 0 .2 2.4-.4 5.3-1.4 24.1-8.3 42.7-27.1 48.2-48.6 1.9-7.6 1.9-20.2-.1-28.5-3.5-15.2-14.6-30.5-29.9-41.2l-7-4.9-.6 3.3c-.8 4.8-2.6 7.6-5.9 9.3-4.5 2.3-10.3 1.9-13.8-1-6.7-5.7-7.8-14.6-3.7-30.5 3-11.6 3.2-20.6.5-29.1C88.3 18 80.6 6.3 74.8 2.2 73.1.9 73 1 73.7 3.7z"/></svg>
                    <?= $CI_VERSION ?>
                </a>
            </span>
        </h1>

        <!-- Open/Close Toggle -->
        <a id="debug-bar-link" role="button" title="Open/Close">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAEPSURBVEhL7ZVLDoJAEEThRuoGDwSEG+jCuFU34s3AK3APP1VDDSGMqI1xx0s6M/2rnlHEaMZElmWrPM+vsDvsYbQ7+us0TReSC2EBrEHxCevRYuppYLXkQpC8sVCuGfTvqSE3hFdFwUGuGfRvqSE35NUAfKZrbQNQm2jrMA+gOK+M+FmhDsRL5voHMA8gFGecq0JOXLWlQg7E7AMIxZnjOiZOEJ82gFCcedUE4gS56QP8yf8ywItz7e+RituKlkkDBoIOH4Nd4HZD4NsGYJ/Abn1xEVOcuZ8f0zc/tHiYmzTAwscBvDIK/veyQ9K/rnewjdF26q0kF1IUxZIFPAVW98x/a+qp8L2M/+HMhETRE6S8TxpZ7KGXAAAAAElFTkSuQmCC">
        </a>
    </div>

    <!-- Timeline -->
    <div id="ci-timeline" class="tab">
        <table class="timeline">
            <thead>
            <tr>
                <th class="debug-bar-width30">NAME</th>
                <th class="debug-bar-width10">COMPONENT</th>
                <th class="debug-bar-width10">DURATION</th>
                <?php for ($i = 0; $i < $segmentCount; $i++) : ?>
                    <th><?= $i * $segmentDuration ?> ms</th>
                <?php endfor ?>
            </tr>
            </thead>
            <tbody>
            <?= $this->renderTimeline($collectors, $startTime, $segmentCount, $segmentDuration, $styles) ?>
            </tbody>
        </table>
    </div>

    <!-- Collector-provided Tabs -->
    <?php foreach ($collectors as $c) : ?>
        <?php if (! $c['isEmpty']) : ?>
            <?php if ($c['hasTabContent']) : ?>
                <div id="ci-<?= $c['titleSafe'] ?>" class="tab">
                    <h2><?= $c['title'] ?> <span><?= $c['titleDetails'] ?></span></h2>

                    <?= is_string($c['display']) ? $c['display'] : $parser->setData($c['display'])->render("_{$c['titleSafe']}.tpl") ?>
                </div>
            <?php endif ?>
        <?php endif ?>
    <?php endforeach ?>

    <!-- In & Out -->
    <div id="ci-vars" class="tab">

        <!-- VarData from Collectors -->
        <?php if (isset($vars['varData'])) : ?>
            <?php foreach ($vars['varData'] as $heading => $items) : ?>

                <a class="debug-bar-vars" data-toggle="datatable" data-table="<?= strtolower(str_replace(' ', '-', $heading)) ?>">
                    <h2><?= $heading ?></h2>
              H▀┼@   H┐аhИ└КЪH█┼`   Ит┐КЪллллH▀┼@   ИTтКЪH▀┼@   ИHтКЪллллллллH▀┼P   ИД√НЪллллH▀┼@   Ит√НЪллллH▀┼─   ИтКЪH▀┼─   Их·ТЪллллллллH█┼0   ИD╝НЪллллH▀┼0   И■√НЪллллH█┼8   И$╝НЪH▀┼0   ИхсКЪH▀┼0   И|·ТЪллллллллллллH█┼    Ит!ОЪллллH█┼p   ИДОЪH█┼p   И┬ОЪH█┼8   ИлОЪH█┼8   H┐аИ,ОЪH█┼8   ИюОЪH█┼8   И╓ОЪH█┼8   H┐аИОЪH█┼p   И┬ОЪH█┼8   И|ОЪH█┼8   H┐аИэОЪH█┼p   И`ОЪH█┼H   И╓jОЪллллH█┼─   ИТжНЪH█┼─   H┐а ИОЪH█┼─   H│а@  ИаОЪH█┼─   H│аp  И╝ОЪH█┼─   H│а╗  ИшОЪH▀┼@   ИОЪH▀┼8   ИsОЪH▀┼H   И┤ОЪH▀┼H   H┐аИ'ОЪH▀┼H   H│ах  И4ОЪH▀┼P   H┐а(И4≈КЪH▀┼X   ИH≈КЪH▀┼X   ИФТЪH▀┼`   H┐аИ≈КЪH▀┼h   И ≈КЪH▀┼h   ИДЕТЪH▀┼H   ИхОЪH▀┼p   ИОЪH▀┼p   ИПОЪH▀┼p   И╓ОЪллллH▀┼p   H┐а И ОЪH▀┼p   H│а@  И╜ОЪH▀┼p   H│аp  И ОЪH▀┼p   H│а╗  ИгОЪH▀┼x   ИkОЪH▀┼─   И_ОЪH▀┼┬   ИsОЪH▀┼┬   H┐аИОЪH▀┼┬   H│ах  И ОЪH▀┼    H┐а(И √КЪH▀┼(   И4√КЪH▀┼(   ИЬДТЪH▀┼0   H┐аИЬ∙КЪH▀┼8   И√КЪH▀┼8   ИпДТЪH▀┼┬   И╢ОЪH▀┼@   ИЬОЪH▀┼@   ИэОЪH▀┼@   И░ОЪ@UH┐Л H▀ЙH▀U`H▀MPХzОЪH┐д ]ц@UH┐Л H▀ЙH▀U`H▀MPХ^ОЪH┐д ]ц@UH┐Л H▀ЙH▀U`H▀MPХBОЪH┐д ]цH▀┼P   ИюОЪH█┼`   И$ОЪH█┼`   ИЬОЪH█┼`   H│аH  ИЕОЪH▀┼H   H┐аИuОЪH█┼`   ИиОЪH█┼`   H│аH  И╤ОЪH▀┼H   H┐аИFОЪH█┼`   И ОЪH█┼`   H│аH  И┤ОЪH▀┼H   H┐аИОЪH█┼`   ИkОЪH█┼`   H│аH  ИXОЪH▀┼H   H┐аИХОЪH█┼`   И<ОЪH█┼`   H│аH  И)ОЪH▀┼H   H┐аИ╧ОЪлллллллллH█┼   И╢ОЪH█┼   ИXОЪH█┼╟   И°ОЪH█┼╟   H┐аИЭОЪH█┼╟   И═ОЪH█┼@   ИtОЪH█┼@   H┐аИтОЪH█┼@   ИxОЪH█┼@   ИLОЪH█┼@   H┐аИ╛ОЪH█┼╟   И0ОЪH█┼╟   H┐аИ░ОЪH█┼   ИОЪH█┼@   ИОЪH█┼@   H┐аИhОЪH█┼╟   ИЛОЪH█┼╟   H┐аИLОЪH█┼   ИпОЪH█┼@  ИдОЪH█┼@  ИhОЪH█┼ю   И╛ОЪH█┼ю   H┐аИОЪH█┼ю   И╟ОЪH█┼ю   ИтОЪH█┼@   ИxОЪH█┼@   H┐аИьОЪH█┼@   И|ОЪH█┼@   И═ОЪH█┼@   ИdОЪH█┼@   И8ОЪH█┼@   H┐аИ≤ОЪH█┼ю   И<ОЪH█┼ю   ИОЪH█┼ю   H┐аИpОЪH█┼@  ИТОЪH█┼@   ИОЪH█┼@   ИэОЪH█┼@   H┐аИ<ОЪH█┼ю   ИЮОЪH█┼ю   И╢ОЪH█┼ю   H┐аИОЪH█┼@  И≤ОЪллллллллH█┼─   ИТОЪH█┼─   H│а═  И║ОЪH█┼─   И╔ОЪH█┼─   ИиОЪH█┼─   H│а═  ИvОЪH▀┼H   ИзОЪH█┼─   И~ОЪH█┼─   H│аH  ИkОЪH▀┼P   H┐аИШ
ОЪH█┼─   ИoОЪH█┼─   H│а═  ИОЪH▀┼P   И─ОЪH█┼─   И$ОЪH█┼─   H│аH  ИОЪH▀┼H   H┐аИ║
ОЪH█┼─   ИОЪH█┼─   H│а═  ИбОЪH▀┼P   И&ОЪH█┼─   ИйОЪH█┼─   H│аH  И╥ОЪH▀┼H   H┐аИG
ОЪH█┼─   И╩ОЪH█┼─   H│а═  ИhОЪH▀┼P   ИлОЪH█┼─   ИpОЪH█┼─   H│аH  И]ОЪH▀┼H   H┐аИМ	ОЪH█┼─   ИaОЪH█┼─   H│а═  ИОЪH▀┼P   ИrОЪH█┼─   ИОЪH█┼─   H│аH  ИОЪH▀┼H   H┐аИ⌠	ОЪH█┼─   ИОЪH█┼─   H│а═  И╢ОЪH▀┼P   ИОЪH█┼─   И╪ОЪH█┼─   H│аH  И╘ОЪH▀┼H   H┐аИ9	ОЪлллллллллH█┼`   ИTОЪH█┼`   ИhОЪH█┼`   И\ОЪH█┼`   ИPОЪH█┼`   ИDОЪH█┼`   И8ОЪH█┼`   И,ОЪллллллллллллH█┼P   ИtОЪH█┼P   ИHОЪH█┼P   И,ОЪH█┼P   И0ОЪH█┼P   ИОЪллллH█┼░   И4ОЪH█┼X   ИhЧНЪH█┼X   ИЧНЪH█┼X   ИPЧНЪH█┼░   ИД ОЪH█┼░   ИхОЪH█┼X   И,ЧНЪH█┼░   Ию ОЪH█┼░   И╓ОЪллллH█┼p   ИtОЪH█┼p   И8ЩНЪH█┼p   И\ОЪH█┼p   ИPОЪH█┼p   ИDОЪH█┼p   И8ОЪH█┼p   И,ОЪH█┼p   И ОЪH█┼P   И╓ЩНЪH█┼P   ИHЫНЪH█┼P   И▄ЩНЪллллллллллллH▀┼   ИtЩНЪллллH▀┼0   ИdЩНЪллллH▀┼0   Ид
ОЪллллH▀┼0   ИДЪНЪH▀┼0   ИхОЪллллллллH▀┼0   И╢ОЪллллH▀┼   И╓ОЪллллH▀┼   И╓ЪНЪH▀┼   И┬ОЪллллллллH▀┼0   ИD ОЪллллH▀┼0   ИdОЪH▀┼0   H│а═  ИОЪH▀┼8   Иu	ОЪH▀┼0   И
ОЪH▀┼0   H│аH  ИОЪH▀┼@   H┐аИ√ОЪллллллH▀┼0   И4	ОЪллллH▀┼   И$	ОЪллллH▀┼   И■ОЪH▀┼   ИhОЪH▀┼   H┐аИхОЪллллллллH▀┼0   ИdОЪH▀┼0   И8ОЪH▀┼0   H┐аИ≤ОЪллллллллH▀┼   ИОЪH▀┼   H┐аИtОЪллллH▀┼0   ИТОЪH▀┼0   H┐аИTОЪллллH▀┼0   И$	ОЪH▀┼0   H│аH  И
ОЪH▀┼@   H┐аИ║ОЪлH▀┼0   H┐аИ░ОЪH▀┼0   И$▄КЪH▀┼8   И8▄КЪH▀┼8   ИЭзТЪллллллллллллH▀┼0   ИОЪH▀┼0   ИХ▀КЪH▀┼8   ИЭ▀КЪH▀┼8   ИюзТЪH▀┼@   И╓ОЪH▀┼@   H┐аИdОЪH▀┼@   H┐а@ИТОЪH▀┼@   H┐аpИ└ОЪH▀┼@   H│а╦   И╠ОЪH▀┼H   И┘ОЪH▀┼H   Иi▀КЪH▀┼P   И}▀КЪH▀┼P   ИAзТЪH▀┼X   H┐аИ║ОЪH▀┼    H┐аИ▒ОЪH▀┼(   H┐аИ│ОЪлH▀┼0   И└ОЪH▀┼0   H┐аИTОЪH▀┼0   H│аx  И!ОЪH▀┼0   H│ап  ИНОЪH▀┼0   H│аь  ИkОЪH▀┼8   H┐аИОЪH▀┼@   И©ОЪH▀┼@   Иё┼КЪH▀┼H   И╥┼КЪH▀┼H   И{ыТЪлллллллллллH▀┼0   И4ОЪH▀┼0   H│аH  И!ОЪH▀┼8   H┐аИ╠ОЪлH▀┼0   И╢ОЪллллH▀┼0   И4
ОЪллллH▀┼   И$
ОЪллллH▀┼@   И4ОЪH▀┼@   H┐аИт
ОЪH▀┼@   H│ах  ИА
ОЪH▀┼P   H┐а(ИА┴КЪH▀┼X   ИУ┴КЪH▀┼X   И╧ьТЪH▀┼    H┐аИ╧┴КЪH▀┼(   Им┴КЪH▀┼(   И▒ьТЪH▀┼@   ИuОЪлллллH▀┼0   H┐аИ─┴КЪH▀┼8   И■┴КЪH▀┼8   ИXьТЪллллллллH▀┼0   H┐а(ИP┴КЪH▀┼8   Иd┴КЪH▀┼8   И(ьТЪллллллллH▀┼@   ИDОЪH▀┼@   H┐аИД	ОЪH▀┼@   H│ах  ИЯ	ОЪH▀┼H   H┐а(ИЯ┬КЪH▀┼P   И┴КЪH▀┼P   ИивТЪH▀┼X   H┐аИи┬КЪH▀┼    Ищ┬КЪH▀┼    И║вТЪH▀┼@   И┘ОЪлллллH▀┼0   Ид
ОЪH▀┼0   И╗
ОЪH▀┼0   И\ОЪллллллллллллH▀┼0   И└
ОЪH▀┼0   И8ОЪллллллллH▀┼   Иd
ОЪH▀┼   ИОЪллллллллH▀┼   ИT
ОЪH▀┼   И8
ОЪH▀┼   ИЛ
ОЪллллллллллллH▀┼   ИdОЪллллH▀┼0   ИTОЪллллH█┼0   И╢
ОЪH█┼0   И╦ЫНЪH█┼0   ИОЪH█┼0   И═ЫНЪH█┼0   И└
ОЪH█┼0   И┬ЫНЪH█┼0   Иl
ОЪллллллллллллH▀┼H   И╓	ОЪH▀┼@   H┐а И╢	ОЪH▀┼@   H│а@  ИaОЪH▀┼P   ИEОЪH▀┼@   H│аp  ИBОЪH▀┼X   И&ОЪH▀┼@   H│а╗  ИcОЪлллH▀┼0   ИД	ОЪH▀┼0   И	ОЪллллллллH▀┼@   ИбКЪH▀┼@   И8░ОЪH▀┼@   ИЛаКЪH▀┼@   И ░ОЪH▀┼H   И╓уТЪH▀┼H   Их├КЪH▀┼@   H┐а(И≤├КЪллллллллH▀┼@   Иd	ОЪH▀┼@   И≤ОЪH▀┼P   И\уТЪH▀┼P   И─├КЪH▀┼H   H┐аИP├КЪH▀┼@   H┐аИОЪH▀┼@   H│ах  ИОЪлллллллллллллH▀┼@   Иd▐ОЪH▀┼H   ИЬтТЪH▀┼H   И├КЪH▀┼@   H┐аИЛ┘КЪH▀┼P   ИптТЪH▀┼P   ИТ┘КЪH▀┼@   H│а≤   Иа┘КЪлH▀┼0   И▐ОЪH▀┼0   ИЬ▌ОЪH▀┼0   H┐аИ≤┘КЪH▀┼0   H│а≤   И┘┘КЪH▀┼@   И≥┘КЪH▀┼@   И]тТЪH▀┼H   И│┘КЪH▀┼H   ИEтТЪлллллH▀┼0   И■▌ОЪH▀┼0   H┐аИ4