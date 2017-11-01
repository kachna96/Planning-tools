<?php

require __DIR__ . '/../vendor/autoload.php';
use Nette\Application\UI\Form;

$configurator = new Nette\Configurator;

//$configurator->setDebugMode('23.75.345.200'); // enable for your remote IP
$configurator->enableDebugger(__DIR__ . '/../log');
\Nette\Diagnostics\Debugger::$productionMode = true;

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

Form::extensionMethod('addDatePicker', function(Form $_this, $name, $label, $cols = NULL, $maxLength = NULL)
{
    return $_this[$name] = new RadekDostal\NetteComponents\DateTimePicker\DatePicker($label, $cols, $maxLength);
});

Form::extensionMethod('addDateTimePicker', function(Form $_this, $name, $label, $cols = NULL, $maxLength = NULL)
{
    return $_this[$name] = new RadekDostal\NetteComponents\DateTimePicker\DateTimePicker($label, $cols, $maxLength);
});

return $container;
