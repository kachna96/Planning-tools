<?php

namespace App\Presenters;

use Nette,
	App\Model,
    Nette\Application\UI\Form;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{
	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new Form();

		$form->addText('username')
            ->setAttribute('placeholder', 'Uživatelské jméno / Email')
            ->setAttribute('class', 'u-full-width')
            ->addRule(Form::MIN_LENGTH, 'Tvé jméno musí mít alespoň %d znaky.', 4)
            ->addRule(Form::MAX_LENGTH, 'Tvé jméno je příliš dlouhé, maximální počet znaků je %d.', 95)
			->setRequired('Prosím, zadej své uživatelské jméno či email.');

		$form->addPassword('password')
            ->setAttribute('placeholder', 'Heslo')
            ->setAttribute('class', 'u-full-width')
            ->addRule(Form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků.', 8)
			->setRequired('Prosím, zadejte své heslo.');

		$form->addSubmit('send', 'Přihlásit')
            ->setAttribute('class', 'login login-submit u-full-width');

        $form->addCheckbox('remember', ' Zůstat přihlášený');

		$form->onSuccess[] = $this->signInFormSucceeded;

		return $form;
	}


	public function signInFormSucceeded($form, $values)
	{
        if ($values->remember) {
            $this->getUser()->setExpiration('14 days', FALSE);
        } else {
            $this->getUser()->setExpiration('20 minutes', TRUE);
        }

		try {
			$this->getUser()->login($values->username, $values->password);
			$this->redirect('Homepage:');

		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}


    public function actionOut()
    {
        $this->getUser()->logout();
        $this->flashMessage('Byl jste úspěšně odhlášen.');
        $this->redirect('Sign:in');
    }

}
