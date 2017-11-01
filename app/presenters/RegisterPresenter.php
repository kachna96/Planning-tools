<?php

namespace App\Presenters;

use Nette,
    App\Model,
    Nette\Application\UI\Form,
    Nette\Database\Context;

/**
 * Sign in/out presenters.
 */
class RegisterPresenter extends BasePresenter
{
    public $userManager, $database;

    /**
     * @param Context $database
     */
    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    /**
     * @param Model\UserManager $userManager
     */
    public function injectUserManager(Model\UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param $input
     * @return bool
     */
    public function validateUsername($input){
        return !$this->database->table('uzivatele')->where(array('jmeno' => $input->value))->fetch();
    }

    /**
     * @param $input
     * @return bool
     */
    public function validateComName($input){
        return !$this->database->table('spolecnost')->where(array('jmeno_spolecnosti' => $input->value))->fetch();
    }

    /**
     * Register form factory.
     * @return Nette\Application\UI\Form
     */

    /**
     * @return Form
     */
    protected function createComponentRegisterForm()
    {
        $form = new Form;
        
        $form->addText('username')
            ->setRequired('Prosím, zadej své uživatelské jméno či email.')
            ->setAttribute('class', 'u-full-width')
            ->setAttribute('placeholder', 'Uživatelské jméno / Email')
            ->addRule(Form::MIN_LENGTH, 'Tvé jméno musí mít alespoň %d znaky.', 4)
            ->addRule(Form::MAX_LENGTH, 'Tvé jméno je příliš dlouhé, maximální počet znaků je %d.', 95)
            ->addRule($this->validateUsername, 'Uzivatelské jméno je již použito, zadejte prosím nové.');

        $form->addPassword('password')
            ->setRequired('Prosím, zadejte své heslo.')
            ->setAttribute('class', 'u-full-width')
            ->setAttribute('placeholder', 'Heslo')
            ->addRule(Form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků.', 8)
            ->addRule(Form::MAX_LENGTH, 'Tvé heslo je příliš dlouhé, maximální počet znaků je %d.', 250);

        $form->addPassword('passwordVerify')
            ->setAttribute('class', 'u-full-width')
            ->setAttribute('placeholder','Ověření hesla')
            ->setRequired('Prosím, zadejte své heslo.')
            ->addRule(Form::EQUAL, 'Hesla se neshodují.', $form['password']);

        $form->addText('make_company')
            ->setAttribute('class', 'u-full-width')
            ->setAttribute('placeholder', 'Název společnosti')
            ->setRequired('Prosím, zadejte název vaší společnosti.')
            ->addRule(Form::MIN_LENGTH, 'Název společnosti musí mít alespoň %d znaky.', 3)
            ->addRule(Form::MAX_LENGTH, 'Název společnosti je příliš dlouhý.', 145)
            ->addRule($this->validateComName, 'Toto jméno společnosti je již použito, zadejte prosím nové.');

        $form->addSubmit('send', 'Registrovat')
            ->setAttribute('class', 'login login-submit u-full-width');
        
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        //call method registerFormSucceeded() on success
        $form->onSuccess[] = $this->registerFormSucceeded;
        return $form;
    }

    /**
     * @param $form
     */
    public function registerFormSucceeded($form)
    {
        $values = $form->getValues();
        $this->userManager->add($values, NULL);
        $this->flashMessage('Byl jste úspěšně zaregistrován.');
        $this->redirect('Sign:in');
    }

}