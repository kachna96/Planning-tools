<?php
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('9819501724', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block css
//
if (!function_exists($_b->blocks['css'][] = '_lbf9cf5a2d9e_css')) { function _lbf9cf5a2d9e_css($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb9e241e38f7_scripts')) { function _lb9e241e38f7_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
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
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php if (isset($_b->blocks["title"])) { ob_start(); Latte\Macros\BlockMacros::callBlock($_b, 'title', $template->getParameters()); echo $template->striptags(ob_get_clean()) ?>
 | <?php } ?>Plánovač úkolů</title>

	<link rel="stylesheet" media="screen,projection,tv" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/screen.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/menu_normalize.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/menu_style.css">
	<link rel="stylesheet" media="print" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/print.css">
	<link rel="shortcut icon" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/images/favicon.ico">
    <script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery-ui-timepicker-addon.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/jquery-ui-1.9.2.custom.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/jquery-ui-timepicker-addon.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/skeleton.css">
    <script>
        $(function() {
            var pull = $('#pull');
            menu = $('nav ul');
            menuHeight = menu.height();

            $(pull).on('click', function(e) {
                e.preventDefault();
                menu.slideToggle();
            });

            $(window).resize(function(){
                var w = $(window).width();
                if(w > 320 && menu.is(':hidden')) {
                    menu.removeAttr('style');
                }
            });
        });
    </script>
<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['css']), $_b, get_defined_vars())  ?>

<?php call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>

</head>

<body>
	<script> document.documentElement.className+=' js' </script>

<?php if ($user -> loggedIn) { $user_data = $user->getIdentity()->getData() ?>
        <nav class="clearfix">
            <ul class="clearfix">
                <li><a <?php try { $_presenter->link("Homepage:*"); } catch (Nette\Application\UI\InvalidLinkException $e) {}; if ($_presenter->getLastCreatedRequestFlag("current")) { ?>
class="current"<?php } ?> href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Homepage:default"), ENT_COMPAT) ?>
">Domů</a></li>
                <li><a <?php try { $_presenter->link("Tasks:*"); } catch (Nette\Application\UI\InvalidLinkException $e) {}; if ($_presenter->getLastCreatedRequestFlag("current")) { ?>
class="current"<?php } ?> href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Tasks:default"), ENT_COMPAT) ?>
">Úkoly</a></li>
                <li><a <?php try { $_presenter->link("Settings:*"); } catch (Nette\Application\UI\InvalidLinkException $e) {}; if ($_presenter->getLastCreatedRequestFlag("current")) { ?>
class="current"<?php } ?> href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Settings:set"), ENT_COMPAT) ?>
">Nastavení</a></li>
<?php if ($user->isInRole('admin')) { ?>
                    <li><a <?php try { $_presenter->link("Company:*"); } catch (Nette\Application\UI\InvalidLinkException $e) {}; if ($_presenter->getLastCreatedRequestFlag("current")) { ?>
class="current"<?php } ?> href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Company:default"), ENT_COMPAT) ?>
">Společnost</a></li>
<?php } ?>
                <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Sign:out"), ENT_COMPAT) ?>
">Odhlásit</a></li>
                <li><a href="#" class="tooltip"><img class="img_center" src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/images/user_32.png">
                        <span>Přihlášen jako: <?php echo Latte\Runtime\Filters::escapeHtml($template->truncate($user_data['jmeno'], 25), ENT_NOQUOTES) ?>
<br>Společnost: <?php echo Latte\Runtime\Filters::escapeHtml($template->truncate($template_com_name['jmeno_spolecnosti'], 25), ENT_NOQUOTES) ?></span></a></li>
            </ul>
            <a href="#" id="pull">Menu</a>
        </nav>
<?php } ?>
    <div class="container">
<?php $iterations = 0; foreach ($flashes as $flash) { ?>	    <div class="flash <?php echo Latte\Runtime\Filters::escapeHtml($flash->type, ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; } ?>
    </div>

<?php Latte\Macros\BlockMacros::callBlock($_b, 'content', $template->getParameters()) ?>

    <script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/live-form-validation.js"></script>
    <script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/main.js"></script>
    <!--<script src="<?php echo Latte\Runtime\Filters::escapeHtmlComment($basePath) ?>/js/netteForms.js"></script>-->

</body>
</html>
