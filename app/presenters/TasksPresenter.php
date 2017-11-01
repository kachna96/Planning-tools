<?php
/**
 * Created by PhpStorm.
 * User: kachna96
 * Date: 8.11.2014
 * Time: 16:06
 */

namespace App\Presenters;

use Nette,
    App\Model,
    Nette\Application\UI\Form,
    Nette\Security\User,
    Nette\Application\BadRequestException,
    Nette\Utils\Arrays,
    Tracy\Debugger;

class TasksPresenter extends BasePresenter
{
    public $tasksModel;
    public $id;
    public $user_data;
    private $record;
    private $userManager;
    private $id_task_com;

    protected function startup()
    {
        parent::startup();

        if (!$this->user->isLoggedIn()) {
            if ($this->user->logoutReason === Nette\Security\IUserStorage::INACTIVITY) {
                $this->flashMessage('Byl jste kvůli své neaktivitě odhlášen, prosím přihlašte se znovu.');
            }
            $this->redirect('Sign:in', array('backlink' => $this->storeRequest()));
        }else {
            if(!$this->user->id) {
                throw new BadRequestException;
            }else{
                $this->id = $this->user->id;
                $this->user_data = $this->user->getIdentity()->getData();
                $this->template->publicHolidays = $this->userManager->getHolidayForJquery($this->id);
            }
        }
    }

    /**
     * @param Model\UserManager $userManager
     */
    public function injectUserManager(Model\UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param Model\TasksModel $tasksModel
     */
    public function __construct(Model\TasksModel $tasksModel)
    {
        $this->tasksModel = $tasksModel;
    }

    public function beforeRender()
    {
        parent::beforeRender();
        $this->template->template_com_name = $this->userManager->findCompanyId($this->user_data['spolecnost_idspolecnost']);
    }

    public function actionDefault($id){
        $this->template->id_task = NULL;
        $this->record = $this->tasksModel->findCompanyId($this->user_data['spolecnost_idspolecnost']);
        if($id){
            $this->id_task_com = $this->userManager->findCompanyByIdTask($id);
            if(!$this->id_task_com){
                throw new BadRequestException;
            }
            if($this->id_task_com->spolecnost_idspolecnost != $this->record->idspolecnost){
                throw new Nette\Application\ForbiddenRequestException;
            }
            $this->template->id_task = $id;
            $duration_hours = $this->id_task_com->narocnost->h;
            $duration_minutes = $this->id_task_com->narocnost->i;
            $form = $this['addTaskForm'];
            if (!$form->isSubmitted()) {
                $form->setDefaults(array(
                    'name' => $this->id_task_com->nazev,
                    'task' => $this->id_task_com->ukol,
                    'sat' => $this->id_task_com->saturday,
                    'sun' => $this->id_task_com->sunday,
                    'duration' => $duration_hours.':'.$duration_minutes,
                    'start' => substr($this->id_task_com->zacatek, 0, -3),
                    'end' => substr($this->id_task_com->konec, 0, -3),
                ));
            }
        }
        if (!$this->record)
            throw new BadRequestException;
        $this->record = $this->userManager->findWeekendWork($this->id);
        if (!$this->record)
            throw new BadRequestException;
    }

    public function renderDefault($id){
        if(!$id) {
            $form = $this['addTaskForm'];
            if (!$form->isSubmitted()) {
                $form->setDefaults(array(
                    'sat' => $this->record->saturday_work,
                    'sun' => $this->record->sunday_work,
                ));
            }
        }else{
            $db_hours = $this->userManager->getWorkHours($this->id);
            $start = date('d.m.Y '.$db_hours->work_start);
            $end = date('d.m.Y '.$db_hours->work_end);
            $form = $this['addTaskForm'];
            if (!$form->isSubmitted()) {
                $form->setDefaults(array(
                    'start_hidden' => $start,
                    'end_hidden' => $end,
                ));
            }
        }
    }

    /**
     * @param $form
     * @return bool
     */
    public function validateDate($form){
        $values = $form->getValues();
        $start = strtotime($values->start);
        $end = strtotime($values->end);
        if($end < $start){
            $this->flashMessage('Tato kombinace dat není možná.','error');
            $form->addError('Tato kombinace dat není možná.');
            return false;
        }else if($values->duration == '00:00'){
            $this->flashMessage('Doba trvání úkolu nemůže být nulová.','error');
            $form->addError('Doba trvání úkolu nemůže být nulová.');
            return false;
        }
        else {
            return true;
        }
    }

    protected function createComponentAddTaskForm(){
        $form = new Form();

        $db_hours = $this->userManager->getWorkHours($this->id);
        $start = date('d.m.Y '.$db_hours->work_start);
        $end = date('d.m.Y '.$db_hours->work_end);

        $form->addHidden('sat');

        $form->addHidden('sun');

        $form->addHidden('start_hidden');

        $form->addHidden('end_hidden');

        $form->addText('name')
            ->setAttribute('placeholder', 'Název úkolu')
            ->setAttribute('class', 'u-full-width')
            ->addRule(Form::MAX_LENGTH, 'Název úkolu je příliš dlouhý.', 115)
            ->setRequired('Název úkolu je povinné pole.');

        $form->addTextArea('task', NULL, 55, 10)
            ->setAttribute('placeholder', 'Úkol')
            ->setAttribute('class', 'u-full-width')
            ->setRequired('Popis úkolu je povinné pole.')
            ->addRule(Form::MAX_LENGTH, 'Popis úkolu je příliš dlouhý.', 10000);

        $sub1 = $form->addContainer('checks');

        $sub1->addCheckbox('weekends', ' Pracovat o víkendech');

        $sub1->addCheckbox('saturday', ' Sobota')
            ->setAttribute('class', 'checkbox_15px');

        $sub1->addCheckbox('sunday', ' Neděle');

        $form->addText('duration', 'Doba trvání: ')
            ->setAttribute('class', 'u-full-width')
            ->setRequired('Přibližná doba trvání úkolu je povinné pole.')
            ->addRule(Form::PATTERN, 'Maximální doba trvání úkolu je 999h.', '^(([0-9]?[0-9]?[0-9])):([0-5]?[0-9])(:([0-5]?[0-9]))?$')
            ->setDefaultValue('00:00');

        $form->addDateTimePicker('start', 'Začátek: ', 16, 16)
            ->setAttribute('class', 'u-full-width')
            ->setRequired('Začátek úkolu je povinné pole.')
            ->setDefaultValue($start);

        $form->addDateTimePicker('end', 'Konec: ', 16, 16)
            ->setAttribute('class', 'u-full-width')
            ->setRequired('Konec úkolu je povinné pole.')
            ->setDefaultValue($end);

        $form->addSubmit('send', 'Odeslat')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addSubmit('delete', 'Smazat')
            ->setAttribute('class', 'login login-submit u-full-width')
            ->onClick[] = $this->deleteTaskFormSucceeded;

        $form->addProtection('Vypršel časový limit, odešlete prosím tento formulář znovu.');

        $form->onValidate[] = array($this, 'validateDate');

        $form->onSuccess[] = $this->addTaskFormSucceeded;

        return $form;
    }

    public function deleteTaskFormSucceeded(){
        $this->userManager->findCompanyByIdTask($this->getParameter('id'))->delete();
        $this->flashMessage('Úkol byl smazán.');
        $this->redirect('Homepage:default');
    }

    public function addTaskFormSucceeded($form){
        if ((int) $this->getParameter('id') and (!$this->id_task_com))
            throw new BadRequestException;

        $values = $form->getValues();
        if($this->id_task_com) {
            $this->tasksModel->updateTask($values, $this->user_data['jmeno'], $this->user_data['spolecnost_idspolecnost'], $this->id_task_com);
            $this->flashMessage('Úkol byl upraven.');
            $this->redirect('Homepage:default');
        }else {
            $this->tasksModel->insertTask($values, $this->user_data['jmeno'], $this->user_data['spolecnost_idspolecnost']);
            $this->flashMessage('Úkol by úspěšně přidán.');
            $this->redirect('this');
        }
    }

}