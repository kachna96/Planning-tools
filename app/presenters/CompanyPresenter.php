<?php
/**
 * Created by PhpStorm.
 * User: kachna96
 * Date: 7.11.2014
 * Time: 18:26
 */

namespace App\Presenters;

use Nette,
    App\Model,
    Nette\Application\UI\Form,
    Nette\Security\User,
    Nette\Application\BadRequestException,
    Nette\Application\ForbiddenRequestException,
    Nette\Utils\Arrays,
    Tracy\Debugger;

class CompanyPresenter extends BasePresenter
{
    public $userManager;
    public $database;
    public $id;
    public $user_data;
    private $record;
    private $com;

    protected function startup()
    {
        parent::startup();

        if (!$this->user->isLoggedIn()) {
            if ($this->user->logoutReason === Nette\Security\IUserStorage::INACTIVITY) {
                $this->flashMessage('Byl jste kvůli své neaktivitě odhlášen, prosím přihlašte se znovu.');
            }
            $this->redirect('Sign:in', array('backlink' => $this->storeRequest()));
        }else {
            if ($this->user->isInRole('admin')) {
                if(!$this->user->id) {
                    throw new BadRequestException;
                }else{
                    $this->id = $this->user->id;
                    $this->user_data = $this->user->getIdentity()->getData();
                }
            }
            else {
                $this->flashMessage('Na tuto stránku nemáš přístup.');
                $this->redirect('Sign:in', array('backlink' => $this->storeRequest()));
            }
        }
    }

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function injectUserManager(Model\UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function beforeRender()
    {
        parent::beforeRender();
        $this->template->template_com_name = $this->userManager->findCompanyId($this->user_data['spolecnost_idspolecnost']);
    }

    /******************************** view Company default ******************************/

    public function actionDefault(){
        $this->record = $this->userManager->findCompanyId($this->user_data['spolecnost_idspolecnost']);
        if (!$this->record)
            throw new BadRequestException;
    }

    public function renderDefault()
    {
        $this->template->user_role = $this->userManager->getUserRole($this->user_data['spolecnost_idspolecnost']);
        $this->template->admin_role = $this->userManager->getAdminRole($this->user_data['spolecnost_idspolecnost']);
        $this->template->vacation = $this->userManager->getCompanyVacation($this->user_data['spolecnost_idspolecnost']);
        $form = $this['renameCompanyForm'];
        if (!$form->isSubmitted()) {
            $form->setDefaults(array(
                'com_name' => $this->record->jmeno_spolecnosti,
            ));
        }
    }

    /******************************** view delete ****************************/

    public function actionDelete($id_vacation){
        $this->com = $this->userManager->findVacationById($id_vacation);
        if (!$this->com) {
            throw new BadRequestException;
        }elseif ($this->com->uzivatele_iduzivatele != $this->user->id) {
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
        $this->com = $this->userManager->findVacationById($id_vacation);
        if (!$this->com) {
            throw new BadRequestException;
        }elseif ($this->com->uzivatele_iduzivatele != $this->user->id) {
            throw new ForbiddenRequestException;
        }
    }

    public function renderEdit()
    {
        $form = $this['addCompanyVacationForm'];
        if (!$form->isSubmitted()) {
            if($this->com->do != NULL) {
                $form->setDefaults(array(
                    'choice' => 'n',
                    'date_from' => substr($this->com->datum, 0, 10),
                    'date_to' => substr($this->com->do, 0, 10),
                    'description' => $this->com->popis
                ));
            }else{
                $form->setDefaults(array(
                    'choice' => '1',
                    'date_from' => substr($this->com->datum, 0, 10),
                    'description' => $this->com->popis
                ));
            }
        }
    }

    public function validateUsername($input){
        if($this->database->table('uzivatele')->where(array('jmeno' => $input->value))->fetch()) {
            $this->flashMessage('Uživatelské jméno je již použito, zadejte prosím nové.', 'error');
        }
        return !$this->database->table('uzivatele')->where(array('jmeno' => $input->value))->fetch();
    }

    public function validateComName($input){
        if($this->database->table('spolecnost')->where(array('jmeno_spolecnosti' => $input->value))->fetch()) {
            $this->flashMessage('Toto jméno společnosti je již použito, zadejte prosím jiné.','error');
        }
        return !$this->database->table('spolecnost')->where(array('jmeno_spolecnosti' => $input->value))->fetch();
    }

    protected function createComponentAddUserForm(){
        $form = new Form();

        $form->addText('username')
            ->setRequired('Uživatelské jméno nebo email pozvaného je povinná položka.')
            ->setAttribute('class', 'u-full-width')
            ->setAttribute('placeholder', 'Uživatelské jméno / Email')
            ->addRule(Form::MIN_LENGTH, 'Uživatelské jméno musí mít alespoň %d znaky.', 4)
            ->addRule($this->validateUsername, 'Uživatelské jméno je již použito, zadejte prosím nové.');

        $form->addPassword('password')
            ->setRequired('Prosím, zadejte heslo pozvaného.')
            ->setAttribute('class', 'u-full-width')
            ->setAttribute('placeholder', 'Heslo')
            ->addRule(Form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků.', 8);

        $form->addPassword('passwordVerify')
            ->setRequired('Prosím, zadejte heslo pozvaného.')
            ->setAttribute('class', 'u-full-width')
            ->setAttribute('placeholder','Ověření hesla')
            ->addRule(Form::EQUAL, 'Hesla se neshodují', $form['password']);

        $form->addSubmit('send', 'Odeslat')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete prosím tento formulář znovu.');

        $form->onSuccess[] = $this->addUserFormSucceeded;

        return $form;
    }

    public function addUserFormSucceeded($form)
    {
        $values = $form->getValues();

        $this->userManager->add($values, $this->id);
        $this->flashMessage('Uživatel '.$values->username.' byl úspěšně přidán.');
        $this->redirect('this');
    }

    protected function createComponentRoleForm(){
        $form = new Form();

        $row = $this->userManager->findIdCompanyId($this->id);
        $users = $this->userManager->findAllUsersInCompany($row->spolecnost_idspolecnost);
        foreach($users as $key => $user){
            if($key == $this->id) {
                unset($users[$key]);
                break;
            }
        }

        $form->addSelect('users', NULL, $users)
            ->setAttribute('class', 'u-full-width');

        $form->addSubmit('send', 'Odeslat')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete prosím tento formulář znovu.');

        $form->onSuccess[] = $this->roleFormSucceeded;

        return $form;
    }

    public function roleFormSucceeded($form){
        $values = $form->getValues();
        $this->userManager->changeRole($values, $this->id);
        $username = $this->userManager->findUserName($values->users);
        $this->flashMessage('Vaše role byla změněna, uživatel '.$username->jmeno.' je nyní správce.');
        $this->redirect('Sign:out');
    }

    protected function createComponentAddAdminForm(){
        $form = new Form();

        $row = $this->userManager->findIdCompanyId($this->id);
        $users = $this->userManager->findAllUsersInCompany($row->spolecnost_idspolecnost);
        foreach($users as $key => $user){
            if($key == $this->id) {
                unset($users[$key]);
                break;
            }
        }

        $form->addSelect('users', NULL, $users)
            ->setAttribute('class', 'u-full-width');

        $form->addSubmit('send', 'Odeslat')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete prosím tento formulář znovu.');

        $form->onSuccess[] = $this->addAdminFormSucceeded;

        return $form;
    }

    public function addAdminFormSucceeded($form){
        $values = $form->getValues();
        $this->userManager->changeRole($values, NULL);
        $username = $this->userManager->findUserName($values->users);
        $this->flashMessage('Uživatel '.$username->jmeno.' je nyní správce.');
        $this->redirect('this');
    }

    protected function createComponentGiveUpForm(){
        $form = new Form();

        $form->addSubmit('send', 'Vzdát se')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->onSuccess[] = $this->giveUpFormSucceeded;

        $form->addProtection('Vypršel časový limit, odešlete prosím tento formulář znovu.');

        return $form;
    }

    public function giveUpFormSucceeded(){
        $this->userManager->giveUp($this->id);
        $this->flashMessage('Již nejste správce společnosti.');
        $this->redirect('Sign:out');
    }

    protected function createComponentRenameCompanyForm(){
        $form = new Form();

        $form->addText('com_name')
            ->setAttribute('class', 'u-full-width')
            ->setRequired('Jméno společnosti je povinná položka.')
            ->addRule(Form::MIN_LENGTH, 'Název společnosti musí mít alespoň %d znaky.', 3)
            ->addRule($this->validateComName, 'Toto jméno společnosti je již použito, zadejte prosím jiné.');

        $form->addSubmit('send', 'Odeslat')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete prosím tento formulář znovu.');

        $form->onSuccess[] = $this->renameCompanyFormSucceeded;

        return $form;
    }

    public function renameCompanyFormSucceeded($form){
        $values = $form->getValues();
        $this->userManager->renameCompany($values, $this->user_data['spolecnost_idspolecnost']);
        $this->flashMessage('Společnost byla úspěšně přejmenována na: '.$values->com_name);
        $this->redirect('this');
    }

    protected function createComponentChangeUserPasswordForm(){
        $form = new Form();

        $row = $this->userManager->findIdCompanyId($this->id);
        $users = $this->userManager->findAllUsersInCompany($row->spolecnost_idspolecnost);
        foreach($users as $key => $user){
            if($key == $this->id) {
                unset($users[$key]);
                break;
            }
        }

        $form->addSelect('users', NULL, $users)
            ->setAttribute('class', 'u-full-width');

        $form->addPassword('new_passw')
            ->setRequired('Prosím, zadej nové heslo uživatele.')
            ->setAttribute('class', 'u-full-width')
            ->setAttribute('placeholder', 'Nové heslo')
            ->addRule(Form::MIN_LENGTH, 'Tvé nové heslo musí být alespoň %d znaků dlouhé.', 8);

        $form->addPassword('passwordVerify')
            ->setAttribute('class', 'u-full-width')
            ->setAttribute('placeholder', 'Ověření nového hesla')
            ->setRequired('Prosím, zadej nové heslo uživatele znovu.')
            ->addRule(Form::MIN_LENGTH, 'Tvé nové heslo musí být alespoň %d znaků dlouhé.', 8)
            ->addRule(Form::EQUAL, 'Tvá hesla se neshodují.', $form['new_passw']);

        $form->addSubmit('send', 'Odeslat')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete prosím tento formulář znovu.');

        $form->onSuccess[] = $this->changeUserPasswordFormSucceeded;

        return $form;
    }

    public function changeUserPasswordFormSucceeded($form){
        $values = $form->getValues();
        $this->userManager->changeUserPassword($values);
        $username = $this->userManager->findUserName($values->users);
        $this->flashMessage("Uživatel ".$username->jmeno." má nové heslo.");
        $this->redirect('this');
    }

    protected function createComponentDeleteUserAccountForm(){
        $form = new Form();

        $row = $this->userManager->findIdCompanyId($this->id);
        $users = $this->userManager->findAllUsersInCompany($row->spolecnost_idspolecnost);
        foreach($users as $key => $user){
            if($key == $this->id) {
                unset($users[$key]);
                break;
            }
        }

        $form->addSelect('users', NULL, $users)
            ->setAttribute('class', 'u-full-width');

        $form->addSubmit('send', 'Smazat')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete prosím tento formulář znovu.');

        $form->onSuccess[] = $this->deleteUserAccountFormSucceeded;

        return $form;
    }

    public function deleteUserAccountFormSucceeded($form){
        $values = $form->getValues();
        $username = $this->userManager->findUserName($values->users);
        $this->userManager->deleteUserByAdmin($values);
        $this->flashMessage("Uživatel '".$username->jmeno."' byl smazán.");
        $this->redirect('this');
    }

    protected function createComponentDeleteAccountForm(){
        $form = new Form();

        $form->addSubmit('delete', 'Smazat')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->onSuccess[] = $this->deleteAccountFormSucceeded;

        return $form;
    }

    public function deleteAccountFormSucceeded(){
        if($this->userManager->deleteUser($this->id, $this->user_data['spolecnost_idspolecnost'])) {
            $this->flashMessage('Váš účet byl úspěšně smazán.');
            $this->redirect('Sign:out');
        }else {
            $this->flashMessage('Nemužete si smazat účet, pokud jste jedinný správce společnosti s více uživateli.','error');
        }
    }

    protected function createComponentChangeUsersWorkHoursForm(){
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
            ->setAttribute('class', 'u-full-width')
            ->setDefaultValue($default_start)
            ->setRequired('Toto je povinná položka');

        $form->addSelect('end', 'Konec: ', $hours)
            ->setAttribute('class', 'u-full-width')
            ->setDefaultValue($default_end)
            ->setRequired('Toto je povinná položka');

        $form->addSubmit('submit', 'Změnit')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addProtection('Vypršel časový limit, odešlete prosím tento formulář znovu.');

        $form->onValidate[] = array($this, 'validateHours');

        $form->onSuccess[] = $this->changeUsersWorkHoursFormSucceeded;

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

    public function changeUsersWorkHoursFormSucceeded($form){
        $values = $form->getValues();
        $values->start = str_pad($values->start, 2, '0', STR_PAD_LEFT);
        $values->end = str_pad($values->end, 2, '0', STR_PAD_LEFT);
        $this->userManager->updateWorkHoursByAdmin($values, $this->user_data['spolecnost_idspolecnost']);
        $this->flashMessage('Všem uživatelům byly pracovní hodiny změněny na: start '.$values->start.':00, konec '.$values->end.':00');
        $this->redirect('this');
    }

    protected function createComponentAddCompanyVacationForm(){
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
            ->setAttribute('class', 'u-full-width')
            ->setOption('id', 'toggle_date_from')
            ->setRequired("Prosím, zadej datum své dovolené.")
            ->setDefaultValue($from);

        $form->addDatePicker('date_to', '', 10, 10)
            ->setAttribute('class', 'u-full-width')
            ->setOption('id', 'toggle_date_to')
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

        $form->onSuccess[] = $this->addCompanyVacationFormSucceeded;
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
                $this->flashMessage('Tato kombinace dat není možná.','error');
                $form->addError('Tato kombinace dat není možná.');
                return false;
            }else{
                return true;
            }
        }
    }

    public function addCompanyVacationFormSucceeded($form){
        if ((int) $this->getParameter('id_vacation') and (!$this->com))
            throw new BadRequestException;

        $values = $form->getValues();
        if ($values->choice == '1')
            $values->date_to = NULL;

        if($this->com) {
            $this->userManager->updateVacation($values, $this->com);
            $this->flashMessage('Dovolená byla upravena.');
            $this->redirect('default');
        }else {
            $this->userManager->addCompanyVacation($values, $this->id, $this->user_data['spolecnost_idspolecnost']);
            $this->flashMessage('Dovolená byla přidána.');
            $this->redirect('default');
        }
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
        $this->redirect('default');
    }

    public function formCancelled()
    {
        $this->redirect('default');
    }

}