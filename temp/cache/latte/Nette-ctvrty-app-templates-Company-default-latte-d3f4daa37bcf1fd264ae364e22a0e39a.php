<?php
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5331261154', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lb79a652602b_title')) { function _lb79a652602b_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    Společnost
<?php
}}

//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb949b534f6c_content')) { function _lb949b534f6c_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <div class="container">
        <h3 id="addUser">Přidat uživatele do společnosti</h3>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["addUserForm"], array()) ?>

            <div class="row">
                <div class="six columns">
<?php $iterations = 0; foreach ($form->errors as $error) { ?>                    <p class="p_error"><?php echo Latte\Runtime\Filters::escapeHtml($error, ENT_NOQUOTES) ?></p>
<?php $iterations++; } ?>
                    <?php if ($_label = $_form["username"]->getLabel()) echo $_label ; echo $_form["username"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["password"]->getLabel()) echo $_label ; echo $_form["password"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["passwordVerify"]->getLabel()) echo $_label ; echo $_form["passwordVerify"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php echo $_form["send"]->getControl() ?>

                </div>
            </div>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>

        <h3 id="renameCom">Přejmenovat společnost</h3>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["renameCompanyForm"], array()) ?>

            <div class="row">
                <div class="six columns">
<?php $iterations = 0; foreach ($form->errors as $error) { ?>                    <p class="p_error"><?php echo Latte\Runtime\Filters::escapeHtml($error, ENT_NOQUOTES) ?></p>
<?php $iterations++; } ?>
                    <?php if ($_label = $_form["com_name"]->getLabel()) echo $_label ; echo $_form["com_name"]->getControl() ?>

                </div>
            </div>
            <div class="row">
                <div class="six columns">
                    <?php if ($_label = $_form["send"]->getLabel()) echo $_label ; echo $_form["send"]->getControl() ?>

                </div>
            </div>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>


<?php if ($user_role >= '1') { ?>
            <h3 id="addAdmin">Přidat správce</h3>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["addAdminForm"], array()) ?>

                <div class="row">
                    <div class="three columns">
                        <?php echo $_form["users"]->getControl() ?>

                    </div>
                </div>
                <div class="row">
                    <div class="six columns">
                        <?php if ($_label = $_form["send"]->getLabel()) echo $_label ; echo $_form["send"]->getControl() ?>

                    </div>
                </div>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>


            <h3 id="changePassw">Změnit heslo uživateli</h3>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["changeUserPasswordForm"], array()) ?>

                <div class="row">
                    <div class="three columns">
                        <?php echo $_form["users"]->getControl() ?>

                    </div>
                </div>
                <div class="row">
                    <div class="six columns">
                        <?php echo $_form["new_passw"]->getControl() ?>

                    </div>
                </div>
                <div class="row">
                    <div class="six columns">
                        <?php echo $_form["passwordVerify"]->getControl() ?>

                    </div>
                </div>
                <div class="row">
                    <div class="six columns">
                        <?php if ($_label = $_form["send"]->getLabel()) echo $_label ; echo $_form["send"]->getControl() ?>

                    </div>
                </div>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>


            <h3 id="changeWorkHours">Změnit pracovní dobu všem uživatelům</h3>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["changeUsersWorkHoursForm"], array()) ?>

                <div class="row">
                    <div class="six columns">
<?php $iterations = 0; foreach ($form->errors as $error) { ?>                        <p class="p_error"><?php echo Latte\Runtime\Filters::escapeHtml($error, ENT_NOQUOTES) ?></p>
<?php $iterations++; } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="three columns">
                        <?php if ($_label = $_form["start"]->getLabel()) echo $_label  ?>

                        <?php echo $_form["start"]->getControl() ?>

                    </div>
                </div>
                <div class="row">
                    <div class="three columns">
                        <?php if ($_label = $_form["end"]->getLabel()) echo $_label  ?>

                        <?php echo $_form["end"]->getControl() ?>

                    </div>
                </div>
                <div class="row">
                    <div class="six columns">
                        <?php echo $_form["submit"]->getControl() ?>

                    </div>
                </div>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>


            <h3>Přidat závodní dovolenou</h3>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["addCompanyVacationForm"], array()) ?>

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
                        <?php if ($_label = $_form["description"]->getLabel()) echo $_label ; echo $_form["description"]->getControl()->addAttributes(array('cols' => 40)) ?>

                    </div>
                </div>
                <div class="row">
                    <div class="six columns">
                        <?php echo $_form["send"]->getControl() ?>

                    </div>
                </div>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>


<?php if (count($vacation)) { ?>
                <h3 id="editVacation">Upravit závodní dovolenou</h3>
                <div class="eleven columns">
                    <section id="vacation_list_header">
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Latte\Runtime\CachingIterator($vacation) as $row) { if ($iterator->isFirst()) { ?>
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
                                    <td><?php echo Latte\Runtime\Filters::escapeHtml($template->date($row->datum, 'j. n. Y'), ENT_NOQUOTES) ?></td>
                                    <td><?php echo Latte\Runtime\Filters::escapeHtml($template->date($row->do, 'j. n. Y'), ENT_NOQUOTES) ?></td>
                                    <td><?php echo Latte\Runtime\Filters::escapeHtml($template->truncate($row->popis, 50), ENT_NOQUOTES) ?></td>
                                    <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Company:edit", array($row->idvolno)), ENT_COMPAT) ?>
"><input type="submit" value="Upravit" class="edit_vacation_buttons"></a></td>
                                    <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Company:delete", array($row->idvolno)), ENT_COMPAT) ?>
"><input type="submit" value="Smazat" class="edit_vacation_buttons"></a></td>
                                </tr>
<?php } else { ?>
                                <tr class="vacation_even">
                                    <td><?php echo Latte\Runtime\Filters::escapeHtml($iterator->counter, ENT_NOQUOTES) ?></td>
                                    <td><?php echo Latte\Runtime\Filters::escapeHtml($template->date($row->datum, 'j. n. Y'), ENT_NOQUOTES) ?></td>
                                    <td><?php echo Latte\Runtime\Filters::escapeHtml($template->date($row->do, 'j. n. Y'), ENT_NOQUOTES) ?></td>
                                    <td><?php echo Latte\Runtime\Filters::escapeHtml($template->truncate($row->popis, 50), ENT_NOQUOTES) ?></td>
                                    <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Company:edit", array($row->idvolno)), ENT_COMPAT) ?>
"><input type="submit" value="Upravit" class="edit_vacation_buttons"></a></td>
                                    <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Company:delete", array($row->idvolno)), ENT_COMPAT) ?>
"><input type="submit" value="Smazat" class="edit_vacation_buttons"></a></td>
                                </tr>
<?php } if ($iterator->isLast()) { ?>
                                    </tbody>
                                </table>
<?php } $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>
                    </section>
                </div>
<?php } ?>

            <h3 id="giveAdminFunction">Předat funkci správce jinému uživateli</h3>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["roleForm"], array()) ?>

                <div class="row">
                    <div class="three columns">
                        <?php echo $_form["users"]->getControl() ?>

                    </div>
                </div>
                <div class="row">
                    <div class="six columns">
                        <?php echo $_form["send"]->getControl() ?>

                    </div>
                </div>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>


            <h3 id="deleteUser">Smazat uživatele</h3>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["deleteUserAccountForm"], array()) ?>

                <div class="row">
                    <div class="three columns">
                        <?php echo $_form["users"]->getControl() ?>

                    </div>
                </div>
                <div class="row">
                    <div class="six columns">
                        <?php echo $_form["send"]->getControl() ?>

                    </div>
                </div>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>


<?php } if ($admin_role > '1') { ?>
            <h3 id="giveUp">Vzdát se funkce správce</h3>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["giveUpForm"], array()) ?>

                <div class="row">
                    <div class="six columns">
<?php $iterations = 0; foreach ($form->errors as $error) { ?>                        <p class="p_error"><?php echo Latte\Runtime\Filters::escapeHtml($error, ENT_NOQUOTES) ?></p>
<?php $iterations++; } ?>
                        <?php echo $_form["send"]->getControl() ?>

                    </div>
                </div>
            <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>

<?php } ?>

        <h3 id="deleteAdmin">Smazat účet</h3>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["deleteAccountForm"], array()) ?>

            <div class="row">
                <div class="six columns">
<?php $iterations = 0; foreach ($form->errors as $error) { ?>                    <p class="p_error"><?php echo Latte\Runtime\Filters::escapeHtml($error, ENT_NOQUOTES) ?></p>
<?php $iterations++; } ?>
                    <?php echo $_form["delete"]->getControl() ?>

                </div>
            </div>
        <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>

    </div>
<?php
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb7ac4b77286_scripts')) { function _lb7ac4b77286_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/company_scripts.js"></script>
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
call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars()) ; call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars())  ?>

<?php call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars()) ; 