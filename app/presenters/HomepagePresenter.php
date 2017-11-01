<?php

namespace App\Presenters;

use Nette,
    App\Model,
    Nette\Application\UI\Form,
    Nette\Database\Context,
    Nette\Application\BadRequestException,
    Tracy\Debugger;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

    private $id;
    private $tasksModel;
    private $user_data;
    private $record;
    private $userManager;
    private $calendar;

    protected function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn()) {
            if ($this->user->logoutReason === Nette\Security\IUserStorage::INACTIVITY) {
                $this->flashMessage('You have been signed out due to inactivity. Please sign in again.');
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

    /**
     * @param Model\TasksModel $tasksModel
     */
    public function __construct(Model\TasksModel $tasksModel)
    {
        $this->tasksModel = $tasksModel;
    }

    /**
     * @param Model\UserManager $userManager
     */
    public function injectUserManager(Model\UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param Model\Calendar $calendar
     */
    public function injectCalendar(Model\Calendar $calendar)
    {
        $this->calendar = $calendar;
    }

    public function beforeRender()
    {
        parent::beforeRender();
        $today = new Nette\Utils\DateTime();
        $today->modify('first day of this month');
        $this->template->today = $today;
        $date = new Nette\Utils\DateTime();
        $this->template->date = $date;
        $this->template->vacation = $this->userManager->fetchUserVacation($this->id);
        $this->template->template_com_name = $this->userManager->findCompanyId($this->user_data['spolecnost_idspolecnost']);
        $this->template->tasksList = $this->tasksModel->findComTasks($this->user_data['spolecnost_idspolecnost']);
        $this->template->tasks = $this->tasksModel->findWeekTasks($this->user_data['spolecnost_idspolecnost']);
        $this->template->userSettings = $this->userManager->findUserName($this->id);
        $this->calendar->setMonth(Date('n'));
        $this->calendar->setYear(Date('Y'));
        $this->template->max_days = $this->calendar->countDays();
        $this->template->calendar = $this->calendar->extractCalendar($this->id, $this->user_data['spolecnost_idspolecnost']);
        $this->template->czechDates = $this->tasksModel->czechNames();
    }

    public function actionDefault(){
        $this->record = $this->tasksModel->findCompanyId($this->user_data['spolecnost_idspolecnost']);
        if (!$this->record)
            throw new BadRequestException;
    }

    public function renderDefault(){
        /*$counter = 0;
        $today = new Nette\Utils\DateTime();
        $today->setTime(0,0,0);
        $next_week = new Nette\Utils\DateTime();
        $next_week->setTime(0,0,0);
        $next_week->modify('+7 day');
        $vacation = $this->userManager->fetchWeekVacation($this->id);
        foreach($vacation as $day){
            $today = new Nette\Utils\DateTime();
            $today->setTime(0,0,0);
            $next_week = new Nette\Utils\DateTime();
            $next_week->setTime(0,0,0);
            $next_week->modify('+7 day');
            if( (($day->datum >= $today) and ($day->do == NULL)) or ($day->do >= $today) ) {
                while ($today <= $next_week) {
                    if ($day->do == NULL) {
                        if ($day->datum == $today) {
                            $counter++;
                        }
                    } else {
                        while ($day->datum <= $day->do) {
                            $counter++;
                            $day->datum->modify('tomorrow');
                        }
                    }
                    $today->modify('tomorrow');
                }
            }
        }*/
        $this->template->weekTasks = $this->tasksModel->makeWeekTasksArray($this->id, $this->user_data['spolecnost_idspolecnost']);
    }

    public function renderDay(){
        $vacation_day = 0;
        $today = date('Y-m-d');
        $vacation = $this->userManager->fetchUserVacation($this->id);
        foreach($vacation as $day){
            if($day->do == NULL){
                if(strtotime($day->datum) == strtotime($today)) {
                    $vacation_day = 1;
                }
            }else {
                $date = new Nette\Utils\DateTime($day->datum);
                while (strtotime($date) != strtotime($day->do)) {
                    $date->modify('tomorrow');
                    if(strtotime($date) == strtotime($today)) {
                        $vacation_day = 1;
                    }
                }
            }
        }
        $this->template->vacation_day = $vacation_day;
        $this->template->dayTasks = $this->tasksModel->makeArrayOfTasks($this->id, $this->user_data['spolecnost_idspolecnost']);
    }

}
