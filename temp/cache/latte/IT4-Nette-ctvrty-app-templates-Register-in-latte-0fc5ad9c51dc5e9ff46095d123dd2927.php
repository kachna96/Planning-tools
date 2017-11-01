<?php
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5003836645', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbed980b72a0_content')) { function _lbed980b72a0_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <div class="container">
        <section class="six columns login-card">
            <h1><img src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/images/front.png" style="width: 30%"></h1>
            <div class="center">
<?php call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars())  ?>
                <?php Nette\Bridges\FormsLatte\FormMacros::renderFormBegin($form = $_form = $_control["registerForm"], array()) ?>

<?php $iterations = 0; foreach ($form->errors as $error) { ?>                    <p class="p_error"><?php echo Latte\Runtime\Filters::escapeHtml($error, ENT_NOQUOTES) ?></p>
<?php $iterations++; } ?>
                    <div class="row">
                        <?php if ($_label = $_form["username"]->getLabel()) echo $_label ; echo $_form["username"]->getControl() ?>

                    </div>
                    <div class="row">
                        <?php if ($_label = $_form["password"]->getLabel()) echo $_label ; echo $_form["password"]->getControl() ?>

                    </div>
                    <div class="row">
                        <?php if ($_label = $_form["passwordVerify"]->getLabel()) echo $_label ; echo $_form["passwordVerify"]->getControl() ?>

                    </div>
                    <div class="row">
                        <?php if ($_label = $_form["make_company"]->getLabel()) echo $_label ; echo $_form["make_company"]->getControl() ?>

                    </div>
                    <div class="row">
                        <?php echo $_form["send"]->getControl() ?>

                    </div>
                <?php Nette\Bridges\FormsLatte\FormMacros::renderFormEnd($_form) ?>

            </div>

            <section class="login-help">
                <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Sign:in"), ENT_COMPAT) ?>
">Přihlásit se</a>
            </section>
        </section>
    </div>

<?php
}}

//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lbfecad9f735_title')) { function _lbfecad9f735_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>                <h3 class="section-heading">Registrace</h3>
<?php
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb6accc2ddfd_scripts')) { function _lb6accc2ddfd_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/register_scripts.js"></script>
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