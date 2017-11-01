<?php
/**
 * Created by PhpStorm.
 * User: kachna96
 * Date: 18.10.2014
 * Time: 15:17
 */

namespace App\Presenters;

use Nette,
    App\Model,
    Nette\Application\UI\Form,
    Nette\Application\BadRequestException,
    Nette\Application\ForbiddenRequestException,
    Nette\Utils\Arrays,
    Tracy\Debugger;

class SettingsPresenter extends BasePresenter
{

    /** @var Model\UserManager */
    public $userManager;
    public $id;
    private $record;
    private $weekend;
    private $user_data;

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
            }
        }
    }

    public function __construct(Model\UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function beforeRender()
    {
        parent::beforeRender();
        $this->template->template_com_name = $this->userManager->findCompanyId($this->user_data['spolecnost_idspolecnost']);
    }

    /******************************** view set *******************************/

    public function actionSet()
    {
        $this->weekend = $this->userManager->findWeekendWork($this->id);
        if (!$this->weekend)
            throw new BadRequestException;
    }

    public function renderSet()
    {
        $this->template->user_role = $this->user_data['role'];
        $this->template->vacation = $this->userManager->getVacation($this->id);
        $form = $this['weekendWork'];
        if (!$form->isSubmitted()) {
            $form->setDefaults(array(
                'saturday' => $this->weekend->saturday_work,
                'sunday' => $this->weekend->sunday_work,
            ));
        }
    }

    /******************************** view delete ****************************/

    public function actionDelete($id_vacation){
        $this->record = $this->userManager->findVacationById($id_vacation);
        if (!$this->record) {
            throw new BadRequestException;
        }elseif ($this->record->uzivatele_iduzivatele != $this->user->id) {
            throw new ForbiddenRequestException;
        }
    }

    public function renderDelete($id_vacation)
    {
        $this->template->vacation = $this->userManager->findVacationById($id_vacation);
        if (!$this->template->vacation) {
            $this->flashMessage('Záznam nebyl nalezen.');
        }
    }

    /******************************** view edit ******************************/

    public function actionEdit($id_vacation){
        $this->record = $this->userManager->findVacationById($id_vacation);
        if (!$this->record) {
            throw new BadRequestException;
        }elseif ($this->record->uzivatele_iduzivatele != $this->user->id) {
            throw new ForbiddenRequestException;
        }
    }

    public function renderEdit()
    {
        $form = $this['vacationForm'];
        if (!$form->isSubmitted()) {
            if($this->record->do != NULL) {
                $form->setDefaults(array(
                    'choice' => 'n',
                    'date_from' => substr($this->record->datum, 0, 10),
                    'date_to' => substr($this->record->do, 0, 10),
                    'description' => $this->record->popis
                ));
            }else{
                $form->setDefaults(array(
                    'choice' => '1',
                    'date_from' => substr($this->record->datum, 0, 10),
                    'description' => $this->record->popis
                ));
            }
        }
    }

    protected function createComponentChangePasswordForm()
    {
        $form = new Form();

        $form->addPassword('old_passw')
            ->setAttribute('placeholder', 'Současné heslo')
            ->addRule(Form::MIN_LENGTH, 'Tvé současné je alespoň %d znaků dlouhé.', 8)
            ->setAttribute('class', 'u-full-width')
            ->setRequired('Musíš zadat své současné heslo.');

        $form->addPassword('new_passw')
            ->setAttribute('placeholder', 'Nové heslo')
            ->setRequired('Prosím, zadej své nové heslo.')
            ->setAttribute('class', 'u-full-width')
            ->addRule(Form::MIN_LENGTH, 'Tvé nové heslo musí být alespoň %d znaků dlouhé.', 8);

        $form->addPassword('passwordVerify')
            ->setAttribute('placeholder', 'Ověření nového hesla')
            ->setRequired('Prosím, zadej své nové heslo znovu.')
            ->addRule(Form::MIN_LENGTH, 'Tvé nové heslo musí být alespoň %d znaků dlouhé.', 8)
            ->setAttribute('class', 'u-full-width')
            ->addRule(Form::EQUAL, 'Tvá hesla se neshodují.', $form['new_passw']);

        $form->addSubmit('send', 'Odeslat')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form->onSuccess[] = $this->changePasswordFormSucceeded;
        return $form;
    }

    public function changePasswordFormSucceeded($form)
    {
        $values = $form->getValues();
        if($this->userManager->changePassword($values,$this->id)) {
            $this->flashMessage('Změna hesla byla úspěšně provedena.');
            $this->redirect('this');
        }
        else {
            $this->flashMessage('Zadal jsi špatně své současné heslo.', 'error');
        }
    }

    protected function createComponentVacationForm()
    {
        $form = new Form();

        $choice = array(
            '1' => 'Jednodenní',
            'n' => 'Vícedenní',
        );

        $from = date('d.m.Y');
        $today = date('d.m.Y');
        $to = date('d.m.Y', strtotime($today .' +1 day'));

        $form->addRadioList('choice', NULL, $choice)
            ->setDefaultValue('1')
            ->addCondition($form::EQUAL, '1')
                ->toggle('toggle_date_from')
                ->endCondition()
            ->addCondition($form::EQUAL, 'n')
                ->toggle('date_to')
                ->endCondition();

        $form['choice']->getSeparatorPrototype()->setName(NULL);

        $form->addDatePicker('date_from', '', 10, 10)
            ->setOption('id', 'toggle_date_from')
            ->setAttribute('class', 'u-full-width')
            ->setRequired("Prosím, zadej datum své dovolené.")
            ->setDefaultValue($from);

        $form->addDatePicker('date_to', '', 10, 10)
            ->setOption('id', 'toggle_date_to')
            ->setAttribute('class', 'u-full-width')
            ->setDefaultValue($to)
            ->addConditionOn($form['choice'], $form::EQUAL, 'n')
                ->setRequired("Prosím, zadej datum své dovolené.");

        $form->addTextArea('description')
            ->setAttribute('class', 'u-full-width')
            ->setAttribute('placeholder', 'Popis dovolené')
            ->addRule(Form::MAX_LENGTH, 'Maximální délka popisu je %d znaků', 250);

        $form->addSubmit('send', 'Odeslat')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete formulář znovu.');

        $form->onValidate[] = array($this, 'validateVacation');

        $form->onSuccess[] = $this->vacationFormSucceeded;
        return $form;
    }

    public function validateVacation($form){
        $values = $form->getValues();
        if (!$values->date_to or ($values->choice == '1')) {
            return true;
        }else {
            $start = strtotime($values->date_from);
            $end = strtotime($values->date_to);
            if ($end < $start) {
                $form->addError('Tato kombinace dat není možná.');
                $this->flashMessage('Tato kombinace dat není možná.','error');
                return false;
            }else{
                return true;
            }
        }
    }

    public function vacationFormSucceeded($form)
    {
        if ((int) $this->getParameter('id_vacation') and (!$this->record))
            throw new BadRequestException;

        $values = $form->getValues();
        if ($values->choice == '1')
            $values->date_to = NULL;

        if($this->record) {
            $this->userManager->updateVacation($values, $this->record);
            $this->flashMessage('Dovolená byla upravena.');
            $this->redirect('set');
        }else {
            $this->userManager->addVacation($values, $this->id);
            $this->flashMessage('Dovolená byla přidána.');
            $this->redirect('this');
        }
    }

    protected function createComponentAddPublicHolidayForm()
    {
        $i = 0;
        $choice = array(
            '0' => "Volno",
            '1' => "Práce"
        );

        $set = array(
            'c' => "Vlastní",
            't' => "Volno všem",
            'f' => "Práce všem"
        );

        $free_button = 0;
        $work_button = 0;

        $list = $this->userManager->getHoliday($this->id);

        $form = new Form();

        $form->addRadioList('set', NULL, $set)
            ->setAttribute('class', 'set_change');

        $form['set']->getSeparatorPrototype()->setName(NULL);

        foreach($list as $description => $work) {
            $i++;

            $form->addSelect($i, $description, $choice)
                ->setAttribute('class', 'select_holidays u-full-width')
                ->setRequired("Toto pole nemůže být prázdné!");

            if ($work == 0) {
                $form[$i]->setDefaultValue('0');
                $free_button++;
            }
            else {
                $form[$i]->setDefaultValue('1');
                $work_button++;
            }
        }

        if($free_button == 0)
            $form['set']->setDefaultValue('f');
        if($work_button == 0)
            $form['set']->setDefaultValue('t');
        if(($free_button != 0) and ($work_button != 0))
            $form['set']->setDefaultValue('c');

        $form->addSubmit('send', 'Potvrdit')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form->onSuccess[] = $this->addPublicHolidayFormSucceeded;

        return $form;
    }

    public function addPublicHolidayFormSucceeded($form)
    {
        //return array of values
        $values = $form->getValues(TRUE);
        //get rid of radio value
        unset($values['set']);

        $this->userManager->setHolidays($values, $this->id);
        $this->flashMessage("Tvé nastavení státních svátků bylo uloženo.");
        $this->redirect('Settings:set');
    }

    protected function createComponentDeleteVacationForm()
    {
        $form = new Form;
        $form->addSubmit('cancel', 'Zrušit')
            ->setAttribute('class', 'login login-submit')
            ->onClick[] = $this->formCancelled;

        $form->addSubmit('delete', 'Smazat')
            ->setAttribute('class', 'default')
            ->setAttribute('class', 'login login-submit')
            ->onClick[] = $this->deleteVacationFormSucceeded;

        $form->addProtection('Vypršel časový limit, odešlete formulář znovu.');
        return $form;
    }

    public function deleteVacationFormSucceeded()
    {
        $this->userManager->findVacationById($this->getParameter('id_vacation'))->delete();
        $this->flashMessage('Dovolená byla smazána.');
        $this->redirect('set');
    }

    public function formCancelled()
    {
        $this->redirect('set');
    }

    protected function createComponentWeekendWork(){
        $form = new Form();

        $form->addCheckbox('saturday', ' Sobota');

        $form->addCheckbox('sunday', ' Neděle');

        $form->addCheckbox('tasks_at_weekend', ' Použít toto nastavení i pro aktuální úkoly')
            ->setAttribute('class', 'days');

        $form->addSubmit('submit', 'Odeslat')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete formulář znovu.');

        $form->onSuccess[] = $this->weekendWorkFormSucceeded;

        return $form;
    }

    public function weekendWorkFormSucceeded($form){
        $values = $form->getValues();
        $this->userManager->changeWeekendWork($values, $this->id);
        $this->flashMessage('Tvé nastavení práce o víkendech bylo uloženo');
        $this->redirect('this');
    }

    protected function createComponentDeleteUserAccountForm(){
        $form = new Form();

        $form->addSubmit('send', 'Smazat')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete prosím tento formulář znovu.');

        $form->onSuccess[] = $this->deleteUserAccountFormSucceeded;

        return $form;
    }

    public function deleteUserAccountFormSucceeded($form){
        $this->userManager->deleteUserByHimself($this->id);
        $this->flashMessage("Váš účet byl smazán.");
        $this->redirect('Sign:out');
    }

    protected function createComponentChangeWorkHoursForm(){
        $form = new Form();

        $hours = array(
            '00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00',
                '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
        );

        $db_hours = $this->userManager->getWorkHours($this->id);

        if($db_hours->work_start == '00:00'){
            $default_start = '0';
        }elseif(substr($db_hours->work_start,0,1) == '0'){
            $default_start = substr($db_hours->work_start,1,1);
        }else{
            $default_start = substr($db_hours->work_start,0,2);
        }

        if($db_hours->work_end == '00:00'){
            $default_end = '0';
        }elseif(substr($db_hours->work_end,0,1) == '0'){
            $default_end = substr($db_hours->work_end,1,1);
        }else{
            $default_end = substr($db_hours->work_end,0,2);
        }


        $form->addSelect('start', 'Začátek: ', $hours)
            ->setDefaultValue($default_start)
            ->setAttribute('class', 'u-full-width')
            ->setRequired('Toto je povinná položka');

        $form->addSelect('end', 'Konec: ', $hours)
            ->setDefaultValue($default_end)
            ->setAttribute('class', 'u-full-width')
            ->setRequired('Toto je povinná položka');

        $form->addSubmit('submit', 'Změnit')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete prosím tento formulář znovu.');

        $form->onValidate[] = array($this, 'validateHours');

        $form->onSuccess[] = $this->changeWorkHoursFormSucceeded;

        return $form;
    }

    public function validateHours($form){
        $values = $form->getValues();
        $start = strtotime($values->start.":00");
        $end = strtotime($values->end.":00");
        if ($end <= $start) {
            $form->addError('Tato kombinace dat není možná.');
            $this->flashMessage('Tato kombinace dat není možná.','error');
            return false;
        }else{
            return true;
        }
    }

    public function changeWorkHoursFormSucceeded($form){
        $values = $form->getValues();
        $values->start = str_pad($values->start, 2, '0', STR_PAD_LEFT);
        $values->end = str_pad($values->end, 2, '0', STR_PAD_LEFT);
        $this->userManager->updateWorkHours($values, $this->id);
        $this->flashMessage('Vaše pracovní hodiny se změnily: start '.$values->start.':00, konec '.$values->end.':00');
        $this->redirect('this');
    }

}