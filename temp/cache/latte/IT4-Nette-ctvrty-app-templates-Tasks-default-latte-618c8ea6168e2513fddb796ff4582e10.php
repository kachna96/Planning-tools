<?php
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5315453801', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb397156029c_content')) { function _lb397156029c_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <div class="container">
<?php $iterations = 0; foreach ($publicHolidays as $pH) { ?>
            <input type="hidden" class="hidden" value="<?php echo Latte\Runtime\Filters::escapeHtml($pH->datum, ENT_COMPAT) ?>">
<?php $iterations++; } call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars())  ?>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["addTaskForm"], array()) ?>

            <div class="row">
                <div class="six columns">
<?php $iterations = 0; foreach ($form->errors as $error) { ?>                    <p class="p_error"><?php echo Latte\Runtime\Filters::escapeHtml($error, ENT_NOQUOTES) ?></p>
<?php $iterations++; } ?>
                    <?php echo $_form["name"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php echo $_form["task"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
<?php $_formStack[] = $_form; $formContainer = $_form = $_form["checks"] ?>
                        <?php echo $_form["weekends"]->getControl() ?><br>
                        <?php echo $_form["saturday"]->getControl() ?><br>
                        <?php echo $_form["sunday"]->getControl() ?>

<?php $_form = array_pop($_formStack) ?>
                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["duration"]->getLabel()) echo $_label ; echo $_form["duration"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="two-thirds columns">
                    <?php if ($_label = $_form["start"]->getLabel()) echo $_label  ?>

                </div>
                <div class="six columns">
                    <?php echo $_form["start"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="two-thirds columns">
                    <?php if ($_label = $_form["end"]->getLabel()) echo $_label  ?>

                </div>
                <div class="six columns">
                    <?php echo $_form["end"]->getControl() ?>

                </div>
            </div>
            <div class="row">
<?php if (count($id_task)) { ?>
                    <div class="three columns">
                        <?php echo $_form["delete"]->getControl() ?>

                    </div>
                    <div class="three columns">
                        <?php echo $_form["send"]->getControl() ?>

                    </div>
<?php } else { ?>
                    <div class="six columns">
                        <?php echo $_form["send"]->getControl() ?>

                    </div>
<?php } ?>
            </div>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>

    </div>
<?php
}}

//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lbb0299b2e36_title')) { function _lbb0299b2e36_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>        <h3><?php if (count($id_task)) { ?>Uprav úkol<?php } else { ?>Přidej úkol<?php } ?></h3>
<?php
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb2124a4141e_scripts')) { function _lb2124a4141e_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/task_scripts.js"></script>
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
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars())  ?>

<?php call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars()) ; 