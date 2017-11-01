<?php
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5759246981', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lb086ab00295_title')) { function _lb086ab00295_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    Smazat dovolenou
<?php
}}

//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb9ee7e35aef_content')) { function _lb9ee7e35aef_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <div class="container">
        <h3>Smazat dovolenou</h3>
<?php if ($vacation) { if ($vacation->do != NULL) { ?>
                <p>Jste si jistí, že chcete smazat dovolenou od <?php echo Latte\Runtime\Filters::escapeHtml($template->date($vacation->datum, 'j. n. Y'), ENT_NOQUOTES) ?>
 do <?php echo Latte\Runtime\Filters::escapeHtml($template->date($vacation->do, 'j. n. Y'), ENT_NOQUOTES) ?>?</p>
<?php } else { ?>
                <p>Jste si jistí, že chcete smazat dovolenou z <?php echo Latte\Runtime\Filters::escapeHtml($template->date($vacation->datum, 'j. n. Y'), ENT_NOQUOTES) ?>?</p>
<?php } $_l->tmp = $_control->getComponent("deleteVacationForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;} else { ?>
            <p>Záznam nenalezen.</p>
<?php } ?>
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
call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars()) ; call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 