<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{/*
	protected $userManagerBase;
	protected $user_data_base;

	public function __construct(Model\UserManager $userManagerBase)
	{
		$this->userManager = $userManagerBase;
	}

	public function beforeRender()
	{
		parent::beforeRender();
		if ($this->user->isLoggedIn()) {
			$this->user_data_base = $this->user->getIdentity()->getData();
			$this->template->template_com_name = $this->userManager->findCompanyId($this->user_data_base['spolecnost_idspolecnost']);
		}
	}*/
}
