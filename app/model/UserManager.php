<?php

namespace App\Model;

use Nette,
    Nette\Utils\Strings,
    Nette\Security\Passwords,
    Tracy\Debugger;

class UserManager extends Nette\Object implements Nette\Security\IAuthenticator
{
    const
        USER_TABLE_NAME = 'uzivatele',
        USER_COLUMN_ID = 'iduzivatele',
        USER_COLUMN_NAME = 'jmeno',
        USER_COLUMN_PASSWORD_HASH = 'heslo',
        USER_COLUMN_COMPANY_ID = 'spolecnost_idspolecnost',
        USER_COLUMN_SATURDAY = 'saturday_work',
        USER_COLUMN_SUNDAY = 'sunday_work',
        USER_COLUMN_ROLE = 'role',
        USER_COLUMN_WORK_START = 'work_start',
        USER_COLUMN_WORK_END = 'work_end',
        
        COM_TABLE_NAME = 'spolecnost',
        COM_ID = 'idspolecnost',
        COM_COMPANY_NAME = 'jmeno_spolecnosti',

        VAC_TABLE_NAME = 'volno',
        VAC_ID = 'idvolno',
        VAC_COLUMN_DATE_FROM = 'datum',
        VAC_COLUMN_DATE_TO = 'do',
        VAC_COLUMN_PURPOSE = 'ucel',
        VAC_COLUMN_DESCRIPTION = 'popis',
        VAC_COLUMN_WORK = 'prace',
        VAC_COLUMN_USER_ID = 'uzivatele_iduzivatele',
        VAC_COLUMN_COM_ID = 'com_id',

        TASK_TABLE_NAME = 'ukoly',
        TASK_ID = 'idukoly',
        TASK_COLUMN_NAME = 'nazev',
        TASK_COLUMN_DESCRIPTION = 'ukol',
        TASK_COLUMN_DURATION = 'narocnost',
        TASK_COLUMN_START = 'zacatek',
        TASK_COLUMN_END = 'konec',
        TASK_COLUMN_ISERTED_BY = 'vlozil',
        TASK_COLUMN_COMPANY_ID = 'spolecnost_idspolecnost',
        TASK_COLUMN_SATURDAY = 'saturday',
        TASK_COLUMN_SUNDAY = 'sunday',

        HOL0101 = 'Den obnovy samostatného českého státu ( 1.1. )',
        HOL0501 = 'Svátek práce ( 1.5. )',
        EASTER = 'Velikonoční pondělí ( 21.4. )',
        HOL0508 = 'Den vítězství ( 8.5. )',
        HOL0705 = 'Den slovanských věrozvěstů Cyrila a Metoděje ( 5.7. )',
        HOL0706 = 'Den upálení mistra Jana Husa ( 6.7. )',
        HOL0928 = 'Den české státnosti ( 28.9. )',
        HOL1028 = 'Den vzniku samostatného československého státu ( 28.10. )',
        HOL1117 = 'Den boje za svobodu a demokracii ( 17.11. )',
        HOL1224 = 'Štědrý den ( 24.12. )',
        HOL1225 = '1. svátek vánoční ( 25.12. )',
        HOL1226 = '2. svátek vánoční ( 26.12. )';



    /** @var Nette\Database\Context */
    private $database;

    /**
     * @param Nette\Database\Context $database
     */
    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }


    /**
     * Performs an authentication.
     * @param array
     * @return Nette\Security\Identity
     * @throws Nette\Security\AuthenticationException
     */

    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;

        $row = $this->database->table(self::USER_TABLE_NAME)->where(self::USER_COLUMN_NAME, $username)->fetch();

        if (!$row) {
            throw new Nette\Security\AuthenticationException('Zadal jsi špatně své uživatelské jméno.', self::IDENTITY_NOT_FOUND);

        } elseif (!Passwords::verify($password, $row[self::USER_COLUMN_PASSWORD_HASH])) {
            throw new Nette\Security\AuthenticationException('Zadal jsi špatně své heslo.', self::INVALID_CREDENTIAL);

        } elseif (Passwords::needsRehash($row[self::USER_COLUMN_PASSWORD_HASH])) {
            $row->update(array(
                self::USER_COLUMN_PASSWORD_HASH => Passwords::hash($password),
            ));
        }

        $arr = $row->toArray();
        unset($arr[self::USER_COLUMN_PASSWORD_HASH]);
        return new Nette\Security\Identity($row[self::USER_COLUMN_ID], $row[self::USER_COLUMN_ROLE], $arr);
    }

    /**
     * @param vacationID
     * @return Nette\Database\Table\ActiveRow
     *
     */
    public function findVacationById($id)
    {
        return $this->database->table(self::VAC_TABLE_NAME)->get($id);
    }

    /**
     * @param $id
     * @return array
     */
    public function findAllUsersInCompany($id){
        return $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_COMPANY_ID, $id)
            ->where(self::USER_COLUMN_ROLE, 'user')
            ->fetchPairs(self::USER_COLUMN_ID, self::USER_COLUMN_NAME);
    }

    /**
     * @param $id
     * @return bool|mixed|Nette\Database\Table\IRow
     */
    public function findIdCompanyId($id){
        return $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_ID, $id)
            ->fetch();
    }

    /**
     * @param $id
     * @return bool|mixed|Nette\Database\Table\IRow
     */
    public function findCompanyId($id){
        return $this->database->table(self::COM_TABLE_NAME)
            ->where(self::COM_ID, $id)
            ->fetch();
    }

    /**
     * @param $id
     * @return int
     */
    public function getUserRole($id){
        return $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_COMPANY_ID, $id)
            ->where(self::USER_COLUMN_ROLE, 'user')
            ->count('*');
    }

    /**
     * @param $id
     * @return int
     */
    public function getAdminRole($id){
        return $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_COMPANY_ID, $id)
            ->where(self::USER_COLUMN_ROLE, 'admin')
            ->count('*');
    }

    /**
     * Adds new user.
     * @param  array
     * @param id
     * @return void
     *
     */
    public function add($values, $id)
    {
        $easter = date("0000-m-d", easter_date() + 86400);

        $dates = array(
            "0000-01-01" => self::HOL0101,
            "0000-05-01" => self::HOL0501,
            $easter => self::EASTER,
            "0000-05-08" => self::HOL0508,
            "0000-07-05" => self::HOL0705,
            "0000-07-06" => self::HOL0706,
            "0000-09-28" => self::HOL0928,
            "0000-10-28" => self::HOL1028,
            "0000-11-17" => self::HOL1117,
            "0000-12-24" => self::HOL1224,
            "0000-12-25" => self::HOL1225,
            "0000-12-26" => self::HOL1226,
        );

        $admin = $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_ID, $id)
            ->count('*');

        if($admin == 1) {
            $admin = $this->database->table(self::USER_TABLE_NAME)
                ->where(self::USER_COLUMN_ID, $id)
                ->fetch();

            //Insert user
            $this->database->table(self::USER_TABLE_NAME)->insert(array(
                self::USER_COLUMN_NAME => $values->username,
                self::USER_COLUMN_PASSWORD_HASH => Passwords::hash($values->password),
                self::USER_COLUMN_COMPANY_ID => $admin->spolecnost_idspolecnost
            ));
        }else{
            //Insert company
            $row = $this->database->table(self::COM_TABLE_NAME)->insert(array(
                self::COM_COMPANY_NAME => $values->make_company,
            ));

            //Insert user
            $this->database->table(self::USER_TABLE_NAME)->insert(array(
                self::USER_COLUMN_NAME => $values->username,
                self::USER_COLUMN_PASSWORD_HASH => Passwords::hash($values->password),
                self::USER_COLUMN_ROLE => 'admin',
                self::USER_COLUMN_COMPANY_ID => $row->idspolecnost,
            ));
        }

        //User ID
        $user_id = $this->database->table(self::USER_TABLE_NAME)->where(self::USER_COLUMN_NAME, $values->username)->fetch();

        //Public Holidays
        foreach($dates as $date => $description)
        {
            $this->database->table(self::VAC_TABLE_NAME)->insert(array(
                self::VAC_COLUMN_DATE_FROM => $date,
                self::VAC_COLUMN_PURPOSE => 'Státní svátek',
                self::VAC_COLUMN_DESCRIPTION => $description,
                self::VAC_COLUMN_USER_ID => $user_id,
            ));
        }
    }

    /**
     * Password change (Settings presenter)
     * @param array
     * @param userID
     * @return true / false
     *
     */
    public function changePassword($values, $id)
    {
        $row = $this->database->table(self::USER_TABLE_NAME)->where(self::USER_COLUMN_ID, $id)->fetch();

        if(Passwords::verify($values->old_passw, $row[self::USER_COLUMN_PASSWORD_HASH]))
        {
            $this->database->table(self::USER_TABLE_NAME)
                ->where(self::USER_COLUMN_ID, $id)
                ->update(array(self::USER_COLUMN_PASSWORD_HASH => Passwords::hash($values->new_passw)));
            return true;
        }else
        {
            return false;
        }
    }

    /**
     * Add vacation
     * @param $values
     * @param $id
     * @return bool
     */
    public function addVacation($values, $id)
    {
        if($this->database->table(self::VAC_TABLE_NAME)
            ->insert(array(
            self::VAC_COLUMN_DATE_FROM => $values->date_from,
            self::VAC_COLUMN_DATE_TO => $values->date_to,
            self::VAC_COLUMN_DESCRIPTION => $values->description,
            self::VAC_COLUMN_USER_ID => $id,
        )))
            return true;
        else
            return false;
    }


    /**
     * Get current settings of public holidays of each user
     * @param $id
     * @return array
     */
    public function getHoliday($id)
    {
        $description = $this->database->table(self::VAC_TABLE_NAME)
            ->where(self::VAC_COLUMN_USER_ID, $id)
            ->where(self::VAC_COLUMN_PURPOSE, "Státní svátek")
            ->fetchPairs(self::VAC_ID, self::VAC_COLUMN_DESCRIPTION);
        $work = $this->database->table(self::VAC_TABLE_NAME)
            ->where(self::VAC_COLUMN_USER_ID, $id)
            ->where(self::VAC_COLUMN_PURPOSE, "Státní svátek")
            ->fetchPairs(self::VAC_ID, self::VAC_COLUMN_WORK);

        $combine = array_combine($description, $work);

        return $combine;
    }

    /**
     * Set public holidays
     * @param $values
     * @param $id
     */

    public function setHolidays($values, $id)
    {
        $description = $this->database->table(self::VAC_TABLE_NAME)
            ->where(self::VAC_COLUMN_USER_ID, $id)
            ->where(self::VAC_COLUMN_PURPOSE, "Státní svátek")
            ->fetchPairs(self::VAC_ID, self::VAC_COLUMN_DESCRIPTION);

        foreach($values as $work)
        {
            $this->database->table(self::VAC_TABLE_NAME)
                ->where(self::VAC_COLUMN_USER_ID, $id)
                ->where(self::VAC_COLUMN_PURPOSE, "Státní svátek")
                ->where(self::VAC_COLUMN_DESCRIPTION, current($description))
                ->update(array(self::VAC_COLUMN_WORK => $work));
            next($description);
        }
    }

    /**
     * @param $id
     * @return array|Nette\Database\Table\IRow[]
     */
    public function getVacation($id)
    {
        $today = date('Y-m-d');

        $row = $this->database->table(self::VAC_TABLE_NAME)
            ->where(self::VAC_COLUMN_USER_ID, $id)
            ->where(self::VAC_COLUMN_PURPOSE, "Dovolená")
            ->where('datum >= ? OR do >= ?', $today, $today)
            ->order(self::VAC_COLUMN_DATE_FROM)
            ->fetchAll();

        return $row;
    }

    /**
     * @param $values
     * @param $id
     */
    public function updateVacation($values, $id){
        $this->database->table(self::VAC_TABLE_NAME)
            ->where(self::VAC_ID, $id)
            ->update((array(
                self::VAC_COLUMN_DATE_FROM => $values->date_from,
                self::VAC_COLUMN_DATE_TO => $values->date_to,
                self::VAC_COLUMN_DESCRIPTION => $values->description
            )));
    }

    /**
     * @param $values
     * @param $id
     */
    public function changeRole($values, $id){
        if($id == NULL){
            $this->database->table(self::USER_TABLE_NAME)
                ->where(self::USER_COLUMN_ID, $values->users)
                ->update(array(
                    self::USER_COLUMN_ROLE => 'admin'
                ));
        }else {
            $this->database->table(self::USER_TABLE_NAME)
                ->where(self::USER_COLUMN_ID, $values->users)
                ->update(array(
                    self::USER_COLUMN_ROLE => 'admin'
                ));

            $this->database->table(self::USER_TABLE_NAME)
                ->where(self::USER_COLUMN_ID, $id)
                ->update(array(
                    self::USER_COLUMN_ROLE => 'user'
                ));
        }
    }

    /**
     * @param $id
     */
    public function giveUp($id){
        $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_ID, $id)
            ->update(array(
                self::USER_COLUMN_ROLE => 'user'
            ));
    }

    /**
     * @param $values
     * @param $id
     */
    public function renameCompany($values, $id){
        $this->database->table(self::COM_TABLE_NAME)
            ->where(self::COM_ID, $id)
            ->update(array(
                self::COM_COMPANY_NAME => $values->com_name
            ));
    }

    /**
     * @param $values
     */
    public function changeUserPassword($values){
        $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_ID, $values->users)
            ->update(array(self::USER_COLUMN_PASSWORD_HASH => Passwords::hash($values->new_passw)));
    }

    /**
     * @param $values
     * @param $id
     */
    public function changeWeekendWork($values, $id){
        $user = $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_ID, $id)
            ->fetch();

        if($values->tasks_at_weekend != 0) {
            $this->database->table(self::TASK_TABLE_NAME)
                ->where(self::TASK_COLUMN_ISERTED_BY, $user->jmeno)
                ->update(array(
                    self::TASK_COLUMN_SATURDAY => $values->saturday,
                    self::TASK_COLUMN_SUNDAY => $values->sunday
                ));
            $this->database->table(self::USER_TABLE_NAME)
                ->where(self::USER_COLUMN_ID, $id)
                ->update(array(
                    self::USER_COLUMN_SATURDAY => $values->saturday,
                    self::USER_COLUMN_SUNDAY => $values->sunday
                ));
        }else{
            $this->database->table(self::USER_TABLE_NAME)
                ->where(self::USER_COLUMN_ID, $id)
                ->update(array(
                    self::USER_COLUMN_SATURDAY => $values->saturday,
                    self::USER_COLUMN_SUNDAY => $values->sunday
                ));
        }
    }

    /**
     * @param $id
     * @return bool|mixed|Nette\Database\Table\IRow
     */
    public function findWeekendWork($id){
        return $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_ID, $id)
            ->fetch();
    }

    /**
     * @param $values
     */
    public function deleteUserByAdmin($values){
        $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_ID, $values->users)
            ->delete();
    }

    /**
     * @param $id
     */
    public function findUserName($id){
        return $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_ID, $id)
            ->fetch();
    }

    /**
     * @param $id
     * @return int
     */
    public function countAllUsersInCompany($id){
        return $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_COMPANY_ID, $id)
            ->count('*');
    }

    /**
     * @param $id
     * @param $id_com
     * @return bool
     */
    public function deleteUser($id, $id_com){
        $users_in_com = $this->countAllUsersInCompany($id_com);
        if($users_in_com == 1) {
            $user_data = $this->findIdCompanyId($id);
            $this->database->table(self::USER_TABLE_NAME)
                ->where(self::USER_COLUMN_ID, $id)
                ->delete();
            $this->database->table(self::COM_TABLE_NAME)
                ->where(self::COM_ID, $user_data->spolecnost_idspolecnost)
                ->delete();
            return true;
        }else {
            if($this->getAdminRole($id_com) == 1) {
                return false;
            }else {
                $this->database->table(self::USER_TABLE_NAME)
                    ->where(self::USER_COLUMN_ID, $id)
                    ->delete();
                return true;
            }
        }
    }

    /**
     * @param $id
     */
    public function deleteUserByHimself($id){
        $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_ID, $id)
            ->delete();
    }

    /**
     * @param $id
     * @return bool|mixed|Nette\Database\Table\IRow
     */
    public function getWorkHours($id){
        return $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_ID, $id)
            ->fetch();
    }

    /**
     * @param $values
     * @param $id
     */
    public function updateWorkHours($values, $id){
        $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_ID, $id)
            ->update(array(
                self::USER_COLUMN_WORK_START => $values->start.':00',
                self::USER_COLUMN_WORK_END => $values->end.':00',
            ));
    }

    /**
     * @param $values
     * @param $com_id
     */
    public function updateWorkHoursByAdmin($values, $com_id){
        $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_COMPANY_ID, $com_id)
            ->update(array(
                self::USER_COLUMN_WORK_START => $values->start.':00',
                self::USER_COLUMN_WORK_END => $values->end.':00',
            ));
    }

    /**
     * @param $id
     * @return array|Nette\Database\Table\IRow[]
     */
    public function getHolidayForJquery($id){
        return $this->database->table(self::VAC_TABLE_NAME)
            ->where(self::VAC_COLUMN_USER_ID, $id)
            ->where(self::VAC_COLUMN_WORK, '0')
            ->where(self::VAC_COLUMN_PURPOSE, 'Státní svátek')
            ->fetchAll();
    }

    /**
     * @param $values
     * @param $id
     * @param $com_id
     */
    public function addCompanyVacation($values, $id, $com_id){
        $this->database->table(self::VAC_TABLE_NAME)
            ->insert(array(
            self::VAC_COLUMN_DATE_FROM => $values->date_from,
            self::VAC_COLUMN_DATE_TO => $values->date_to,
            self::VAC_COLUMN_DESCRIPTION => $values->description,
            self::VAC_COLUMN_PURPOSE => 'Závodní dovolená',
            self::VAC_COLUMN_USER_ID => $id,
            self::VAC_COLUMN_COM_ID => $com_id,
        ));
    }

    /**
     * @param $com_id
     * @return array|Nette\Database\Table\IRow[]
     */
    public function getCompanyVacation($com_id){
        $today = date('Y-m-d');
        return $this->database->table(self::VAC_TABLE_NAME)
            ->where(self::VAC_COLUMN_PURPOSE, 'Závodní dovolená')
            ->where('datum >= ? OR do >= ?', $today, $today)
            ->where(self::VAC_COLUMN_COM_ID, $com_id)
            ->fetchAll();
    }

    /**
     * @param $task_id
     * @return bool|mixed|Nette\Database\Table\IRow
     */
    public function findCompanyByIdTask($task_id){
        return $this->database->table(self::TASK_TABLE_NAME)
            ->where(self::TASK_ID, $task_id)
            ->fetch();
    }

    /**
     * @param $id
     * @return array|Nette\Database\Table\IRow[]
     */
    public function fetchUserVacation($id){
        $today = date('Y-m-d');
        return $this->database->table(self::VAC_TABLE_NAME)
            ->where(self::VAC_COLUMN_USER_ID, $id)
            ->where('datum >= ? OR do >= ?', $today, $today)
            ->order(self::VAC_COLUMN_DATE_FROM)
            ->fetchAll();
    }

    /**
     * @param $id
     * @return array|Nette\Database\Table\IRow[]
     */
    public function fetchWeekVacation($id){
        $today = date('Y-m-d');
        return $this->database->table(self::VAC_TABLE_NAME)
            ->where(self::VAC_COLUMN_USER_ID, $id)
            ->fetchAll();
    }

}
