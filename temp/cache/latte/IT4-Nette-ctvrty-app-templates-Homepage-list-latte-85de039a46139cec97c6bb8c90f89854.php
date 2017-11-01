<?php
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('7819428596', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lbcaf568e1fa_title')) { function _lbcaf568e1fa_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    Výpis úkolů - seznam
<?php
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb7a679d8829_scripts')) { function _lb7a679d8829_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/list_scripts.js"></script>
<?php
}}

//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbd20880308e_content')) { function _lbd20880308e_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <div class="container">
        <div class="row">
            <div class="six columns">
                <div id='cssmenu'>
                    <ul>
                        <li class='active has-sub'>
                            <a href='#'>Zobrazení:
                                <?php try { $_presenter->link("Homepage:default"); } catch (Nette\Application\UI\InvalidLinkException $e) {}; if ($_presenter->getLastCreatedRequestFlag("current")) { ?>
Týdenní<?php } ?>

                                <?php try { $_presenter->link("Homepage:day"); } catch (Nette\Application\UI\InvalidLinkException $e) {}; if ($_presenter->getLastCreatedRequestFlag("current")) { ?>
Denní<?php } ?>

                                <?php try { $_presenter->link("Homepage:list"); } catch (Nette\Application\UI\InvalidLinkException $e) {}; if ($_presenter->getLastCreatedRequestFlag("current")) { ?>
Seznam<?php } ?>

                            </a>
                            <ul>
                                <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("day"), ENT_COMPAT) ?>
">Denní</a></li>
                                <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("default"), ENT_COMPAT) ?>
">Týdenní</a></li>
                                <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("list"), ENT_COMPAT) ?>
">Seznam</a></li>
                            </ul>
                        </li>
                        <li class='has-sub'>
                            <a href='#'>Kalendář:</a>
                            <ul>
                                <li>
                                    <table class="calendar">
<?php for ($i = 1; $i < 7; $i++) { ?>
                                            <tr>
<?php for ($j = 1; $j <= 7; $j++) { if ($i == 1) { ?>
                                                        <th><?php echo Latte\Runtime\Filters::escapeHtml($calendar[0][$i][$j], ENT_NOQUOTES) ?></th>
<?php } else { if ($calendar[0][$i][$j] == "&nbsp;") { ?>
                                                            <td class="free">&nbsp;</td>
<?php } else { if ($calendar[1][$i][$j] == 'red') { ?>
                                                                <td class="red"><?php echo Latte\Runtime\Filters::escapeHtml($calendar[0][$i][$j], ENT_NOQUOTES) ?></td>
<?php } elseif ($calendar[1][$i][$j] == 'blue') { ?>
                                                                <td class="blue"><?php echo Latte\Runtime\Filters::escapeHtml($calendar[0][$i][$j], ENT_NOQUOTES) ?></td>
<?php } else { ?>
                                                                <td><?php echo Latte\Runtime\Filters::escapeHtml($calendar[0][$i][$j], ENT_NOQUOTES) ?></td>
<?php } } } } ?>
                                            </tr>
<?php } ?>
                                    </table>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="twelve columns">
<?php if (count($tasksList)) { ?>
                    <table class="listOfTasks">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Název</th>
                                <th>Úkol</th>
                                <th>Začátek</th>
                                <th>Konec</th>
                                <th>Vložil</th>
                            </tr>
                        </thead>
                        <tbody>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Latte\Runtime\CachingIterator($tasksList) as $task) { ?>
                                <tr>
                                    <td><?php echo Latte\Runtime\Filters::escapeHtml($iterator->counter, ENT_NOQUOTES) ?></td>
                                    <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Tasks:default", array($task->idukoly)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($template->truncate($task->nazev, 20), ENT_NOQUOTES) ?></a></td>
                                    <td><?php echo Latte\Runtime\Filters::escapeHtml($template->truncate($task->ukol, 20), ENT_NOQUOTES) ?></td>
                                    <td><?php echo Latte\Runtime\Filters::escapeHtml($template->date($task->zacatek, 'j. n. Y'), ENT_NOQUOTES) ?></td>
                                    <td><?php echo Latte\Runtime\Filters::escapeHtml($template->date($task->konec, 'j. n. Y'), ENT_NOQUOTES) ?></td>
                                    <td><?php echo Latte\Runtime\Filters::escapeHtml($template->truncate($task->vlozil, 25), ENT_NOQUOTES) ?></td>
                                </tr>
<?php $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>
                        </tbody>
                    </table>
<?php } else { ?>
                    <h2>Zatím nemáte žádné úkoly.</h2>
<?php } ?>
            </div>
        </div>
    </div>
<?php
}}

//
// end of blocks
//

// template extending

$_l->extends = empty($_g->extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $_g->extended = TRUE;

if ($_l->extends) { ob_start();}

// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIMacros::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars()) ; call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars()) ; call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 