<?php
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('6500795316', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lbd7c3a33606_title')) { function _lbd7c3a33606_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    Nastavení
<?php
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb3c23945f64_scripts')) { function _lb3c23945f64_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/setting_scripts.js"></script>
<?php
}}

//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb59658d696b_content')) { function _lb59658d696b_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <div class="container">
        <h3 id="changePassw">Změnit heslo</h3>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["changePasswordForm"], array()) ?>

            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["old_passw"]->getLabel()) echo $_label ; echo $_form["old_passw"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["new_passw"]->getLabel()) echo $_label ; echo $_form["new_passw"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["passwordVerify"]->getLabel()) echo $_label ; echo $_form["passwordVerify"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["send"]->getLabel()) echo $_label ; echo $_form["send"]->getControl() ?>

                </div>
            </div>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>


        <h3 id="addVacation">Přidat dovolenou</h3>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["vacationForm"], array()) ?>

            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["choice"]->getLabel()) echo $_label->addAttributes(array('class' => 'radio-item'))->startTag() ;echo $_form["choice"]->getControl() ;if ($_label) echo $_label->endTag() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["date_from"]->getLabel()) echo $_label ; echo $_form["date_from"]->getControl() ?>

                </div>
            </div>
            <div class="row" id="date_to">
                <div class="six columns">
                    <?php if ($_label = $_form["date_to"]->getLabel()) echo $_label ; echo $_form["date_to"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["description"]->getLabel()) echo $_label ; echo $_form["description"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["send"]->getLabel()) echo $_label ; echo $_form["send"]->getControl() ?>

                </div>
            </div>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>


<?php if (count($vacation)) { ?>
            <h3 id="editVacation">Upravit dovolenou</h3>
            <div class="eleven columns">
                <section id="vacation_list_header">

<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Latte\Runtime\CachingIterator($vacation) as $post) { if ($iterator->isFirst()) { ?>
                            <table cellspacing="0" class="u-full-width">
                                <thead>
                                    <tr class="vacation_header">
                                        <th>#</th>
                                        <th id="vacation_from">Od</th>
                                        <th id="vacation_to">Do</th>
                                        <th id="vacation_description">Popis</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php } if ($iterator->isOdd()) { ?>
                            <tr class="vacation_odd">
                                <td><?php echo Latte\Runtime\Filters::escapeHtml($iterator->counter, ENT_NOQUOTES) ?></td>
                                <td><?php echo Latte\Runtime\Filters::escapeHtml($template->date($post->datum, 'j. n. Y'), ENT_NOQUOTES) ?></td>
                                <td><?php echo Latte\Runtime\Filters::escapeHtml($template->date($post->do, 'j. n. Y'), ENT_NOQUOTES) ?></td>
                                <td><?php echo Latte\Runtime\Filters::escapeHtml($template->truncate($post->popis, 50), ENT_NOQUOTES) ?></td>
                                <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Settings:edit", array($post->idvolno)), ENT_COMPAT) ?>
"><input type="submit" value="Upravit" class="edit_vacation_buttons"></a></td>
                                <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Settings:delete", array($post->idvolno)), ENT_COMPAT) ?>
"><input type="submit" value="Smazat" class="edit_vacation_buttons"></a></td>
                            </tr>
<?php } else { ?>
                            <tr class="vacation_even">
                                <td><?php echo Latte\Runtime\Filters::escapeHtml($iterator->counter, ENT_NOQUOTES) ?></td>
                                <td><?php echo Latte\Runtime\Filters::escapeHtml($template->date($post->datum, 'j. n. Y'), ENT_NOQUOTES) ?></td>
                                <td><?php echo Latte\Runtime\Filters::escapeHtml($template->date($post->do, 'j. n. Y'), ENT_NOQUOTES) ?></td>
                                <td><?php echo Latte\Runtime\Filters::escapeHtml($template->truncate($post->popis, 50), ENT_NOQUOTES) ?></td>
                                <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Settings:edit", array($post->idvolno)), ENT_COMPAT) ?>
"><input type="submit" value="Upravit" class="edit_vacation_buttons"></a></td>
                                <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Settings:delete", array($post->idvolno)), ENT_COMPAT) ?>
"><input type="submit" value="Smazat" class="edit_vacation_buttons"></a></td>
                            </tr>
<?php } if ($iterator->isLast()) { ?>
                                </tbody>
                            </table>
<?php } $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>
                </section>
            </div>
<?php } ?>

        <h3 id="changeWorkHours">Změnit pracovní hodiny</h3>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["changeWorkHoursForm"], array()) ?>

<?php $iterations = 0; foreach ($form->errors as $error) { ?>            <p class="p_error"><?php echo Latte\Runtime\Filters::escapeHtml($error, ENT_NOQUOTES) ?></p>
<?php $iterations++; } ?>
            <div class="row">
                <div class="three columns">
                    <?php if ($_label = $_form["start"]->getLabel()) echo $_label ; echo $_form["start"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="three columns">
                    <?php if ($_label = $_form["end"]->getLabel()) echo $_label ; echo $_form["end"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php echo $_form["submit"]->getControl() ?>

                </div>
            </div>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>


        <h3 id="weekendWork">Práce o víkendech</h3>
        <div class="row">
            <div class="six columns">
                <p class="weekend_warning">Upozornění: Po odeslání původní nastavení zmizí.</p>
            </div>
        </div>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["weekendWork"], array()) ?>

            <div class="row">
                <div class="six columns">
                    <?php echo $_form["saturday"]->getControl() ;if ($_label = $_form["saturday"]->getLabel()) echo $_label  ?><br>
                    <?php echo $_form["sunday"]->getControl() ;if ($_label = $_form["sunday"]->getLabel()) echo $_label  ?><br>
                    <?php echo $_form["tasks_at_weekend"]->getControl() ;if ($_label = $_form["tasks_at_weekend"]->getLabel()) echo $_label  ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php echo $_form["submit"]->getControl() ?>

                </div>
            </div>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>


        <h3 id="publicHolidays">Státní svátky</h3>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["addPublicHolidayForm"], array()) ?>

            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["set"]->getLabel()) echo $_label->addAttributes(array('class' => 'radio-item'))->startTag() ;echo $_form["set"]->getControl() ;if ($_label) echo $_label->endTag() ?>

                </div>
            </div>
<?php for ($i = 1; $i <= 12; $i++) { ?>
                    <div class="row">
                        <div class="three columns">
                            <?php $_input = is_object($i) ? $i : $_form[$i]; echo $_input->getControl() ?>

                        </div>
                        <div class="eight columns">
                            <?php $_input = is_object($i) ? $i : $_form[$i]; if ($_label = $_input->getLabel()) echo $_label  ?>

                        </div>
                    </div>
<?php } ?>
            <div class="row">
                <div class="six columns">
                    <?php echo $_form["send"]->getControl() ?>

                </div>
            </div>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>


<?php if ($user_role == 'user') { ?>
            <h3 id="deleteAccount">Smazat účet</h3>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["deleteUserAccountForm"], array()) ?>

                <div class="row">
                    <div class="six columns">
                        <?php echo $_form["send"]->getControl() ?>

                    </div>
                </div>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>

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
call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars()) ; call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars()) ; call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 