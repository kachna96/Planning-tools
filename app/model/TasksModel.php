<?php
/**
 * Created by PhpStorm.
 * User: kachna96
 * Date: 8.11.2014
 * Time: 16:12
 */

namespace App\Model;

use Nette,
    Nette\Utils\Strings,
    Nette\Security\Passwords,
    Tracy\Debugger;

class TasksModel extends Nette\Object
{
    const
        USER_TABLE_NAME = 'uzivatele',
        USER_COLUMN_ID = 'iduzivatele',
        USER_COLUMN_NAME = 'jmeno',
        USER_COLUMN_PASSWORD_HASH = 'heslo',
        USER_COLUMN_COMPANY_ID = 'spolecnost_idspolecnost',
        USER_COLUMN_ROLE = 'role',

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

        TASK_TABLE_NAME = 'ukoly',
        TASK_ID = 'idukoly',
        TASK_COLUMN_NAME = 'nazev',
        TASK_COLUMN_DESCRIPTION = 'ukol',
        TASK_COLUMN_DURATION = 'narocnost',
        TASK_COLUMN_START = 'zacatek',
        TASK_COLUMN_END = 'konec',
        TASK_COLUMN_INSERTED_BY = 'vlozil',
        TASK_COLUMN_SATURDAY = 'saturday',
        TASK_COLUMN_SUNDAY = 'sunday',
        TASK_COLUMN_COMPANY_ID = 'spolecnost_idspolecnost',

        SAT_DAY = 6,
        SUN_DAY = 7;

    /** @var Nette\Database\Context */
    private $database;
    public $today;
    public $array;
    public $arrayOfDays;
    public $arrayOfIds;
    public $arrayId;

    /**
     * @param Nette\Database\Context $database
     */
    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
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
     * @return array|Nette\Database\Table\IRow[]
     */
    public function findUserVacation($id){
        $today = date('Y-m-d');

        return $this->database->table(self::VAC_TABLE_NAME)
            ->where(self::VAC_COLUMN_USER_ID, $id)
            ->where('datum >= ?', $today)
            ->fetchAll();
    }

    /**
     * @param $values
     * @param $name
     * @param $com_id
     */
    public function insertTask($values, $name, $com_id){
        $this->database->table(self::TASK_TABLE_NAME)
            ->insert(array(
                self::TASK_COLUMN_NAME => $values->name,
                self::TASK_COLUMN_DESCRIPTION => $values->task,
                self::TASK_COLUMN_DURATION => $values->duration,
                self::TASK_COLUMN_START => $values->start,
                self::TASK_COLUMN_END => $values->end,
                self::TASK_COLUMN_INSERTED_BY => $name,
                self::TASK_COLUMN_SATURDAY => $values->checks->saturday,
                self::TASK_COLUMN_SUNDAY => $values->checks->sunday,
                self::TASK_COLUMN_COMPANY_ID => $com_id
            ));
    }

    /**
     * @param $values
     * @param $name
     * @param $com_id
     * @param $task_id
     */
    public function updateTask($values, $name, $com_id, $task_id){
        $this->database->table(self::TASK_TABLE_NAME)
            ->where(self::TASK_ID, $task_id)
            ->update(array(
                self::TASK_COLUMN_NAME => $values->name,
                self::TASK_COLUMN_DESCRIPTION => $values->task,
                self::TASK_COLUMN_DURATION => $values->duration,
                self::TASK_COLUMN_START => $values->start,
                self::TASK_COLUMN_END => $values->end,
                self::TASK_COLUMN_INSERTED_BY => $name,
                self::TASK_COLUMN_SATURDAY => $values->checks->saturday,
                self::TASK_COLUMN_SUNDAY => $values->checks->sunday,
                self::TASK_COLUMN_COMPANY_ID => $com_id
            ));
    }

    /**
     * @param $id
     * @return array|Nette\Database\Table\IRow[]
     */
    public function findComTasks($id){
        $today = date('Y-m-d');

        return $this->database->table(self::TASK_TABLE_NAME)
            ->where(self::TASK_COLUMN_COMPANY_ID, $id)
            ->where('konec > ?', $today)
            ->order('idukoly DESC')
            ->fetchAll();
    }

    /**
     * @param $com_id
     * @return array|Nette\Database\Table\IRow[]
     */
    public function findWeekTasks($com_id){
        $today = date('Y-m-d 00:00:00');
        $next_week = new Nette\Utils\DateTime();
        $next_week->modify('+7 day');
        $next_week->setTime(23,59,59);

        return $this->database->table(self::TASK_TABLE_NAME)
            ->where(self::TASK_COLUMN_COMPANY_ID, $com_id)
            ->where('konec >= ?', $today)
            ->where('zacatek <= ?', $next_week)
            ->order(self::TASK_COLUMN_START)
            ->order(self::TASK_ID)
            ->fetchAll();
    }

    /**
     * @param $com_id
     * @return array
     */
    public function findDayTasks($com_id){
        $tomorrow = new Nette\Utils\DateTime();
        $tomorrow->setTime(23,59,59);
        $today_start = date('Y-m-d 00:00:00');
        return $this->database->table(self::TASK_TABLE_NAME)
            ->where(self::TASK_COLUMN_COMPANY_ID, $com_id)
            ->where('zacatek <= ?', $tomorrow)
            ->where('konec >= ?', $today_start)
            ->order(self::TASK_COLUMN_START)
            ->order(self::TASK_ID)
            ->fetchAll();
    }

    /**
     * @return array
     */
    public function czechNames(){
        $dates = array();
        $date = new Nette\Utils\DateTime();
        for($i = 0; $i < 7; $i++){
            if($date->format('N') == 1){
                $dates[] = $date->format('j.n')." Pondělí";
                $date->modify('+1 day');
            }elseif($date->format('N') == 2){
                $dates[] = $date->format('j.n')." Úterý";
                $date->modify('+1 day');
            }elseif($date->format('N') == 3){
                $dates[] = $date->format('j.n')." Středa";
                $date->modify('+1 day');
            }elseif($date->format('N') == 4){
                $dates[] = $date->format('j.n')." Čtvrtek";
                $date->modify('+1 day');
            }elseif($date->format('N') == 5){
                $dates[] = $date->format('j.n')." Pátek";
                $date->modify('+1 day');
            }elseif($date->format('N') == 6){
                $dates[] = $date->format('j.n')." Sobota";
                $date->modify('+1 day');
            }else{
                $dates[] = $date->format('j.n')." Neděle";
                $date->modify('+1 day');
            }
        }
        return $dates;
    }

    ///////////////////////TASKS ARRAY//////////////////////

    /**
     * @param $id
     */
    public function findUserName($id){
        return $this->database->table(self::USER_TABLE_NAME)
            ->where(self::USER_COLUMN_ID, $id)
            ->fetch();
    }

    /**
     * @param $array
     * @return array
     */
    public function fillArray($array){
        if(count($array) <= 23){
            while(count($array) != 24){
                $array[] = '';
                $this->arrayId[] = '';
            }
        }
        return $array;
    }

    /**
     * @param $array
     * @return int
     */
    public function checkIfEmpty($array){
        $checker = 0;
        foreach ($array as $item) {
            if ($item != '') {
                $checker++;
            }
        }
        return $checker;
    }

    /**
     * @param $array
     * @return int
     */
    public function checkMultiArrayIfEmpty($array){
        $checker = 0;
        foreach ($array as $day) {
            foreach ($day as $item) {
                if ($item != '') {
                    $checker++;
                }
            }
        }
        return $checker;
    }

    /**
     * @param $db_hours
     * @param $work_start
     * @return bool
     */
    public function checkStartHours($db_hours, $work_start){
        if($db_hours < $work_start){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $db_hours
     * @param $work_start
     * @return bool
     */
    public function checkEndHours($db_hours, $work_start){
        if($db_hours > $work_start){
            return true;
        }else{
            return false;
        }
    }

    public function insertEmptyValue(){
        $this->array[] = '';
        $this->arrayId[] = '';
    }

    public function insertEmptyValueToMultiArray(){
        $this->array[] = '';
        $this->arrayId[] = '';
    }

    /**
     * @param $sec
     * @return string
     */
    function makeHours($sec)
    {
        $t=new Nette\Utils\DateTime("@".$sec);
        $r=new Nette\Utils\DateTime("@0");
        $i=$t->diff($r);
        $h=intval($i->format("%a"))*24+intval($i->format("%H"));
        return $h.":".$i->format("%I:%S");
    }

    /**
     * @param $counter
     */
    public function assignArray($counter){
        $this->arrayOfDays[$counter] = $this->array;
        $this->arrayOfIds[$counter] = $this->arrayId;
    }

    /////////////////////DAY//////////////////

    /**
     * @param $id
     * @param $com_id
     * @return array|null
     */
    public function makeArrayOfTasks($id, $com_id){
        $this->array = array();
        $this->arrayId = array();
        $date = date('Y-m-d');
        $dayofweek = date('w', strtotime($date));
        $id_user = $this->findUserName($id);
        $tasks = $this->findDayTasks($com_id);
        $work_start = substr($id_user->work_start, 0, 2);
        $work_end = substr($id_user->work_end, 0, 2);
        for ($i = 0; $i <= 23; $i++) {
            if($i < $work_start){
                $this->insertEmptyValue();
            }
        }
        foreach ($tasks as $task) {
            if( (($dayofweek == 6) and ($task->saturday == 0)) or (($dayofweek == 7) and ($task->sunday == 0)) ) {
            }else{
                $start_hours = $task->zacatek->format('H');
                $end_hours = $task->konec->format('H');
                $seconds = date_create('@0')->add($task->narocnost)->getTimestamp();
                $string_time = $this->makeHours($seconds);
                $time_array = explode(':', $string_time);
                if( ($time_array[0] == 0) and $time_array[1] > 0 ){
                    $time_array[0] = 1;
                }
                if($this->checkStartHours($start_hours, $work_start)){
                    $start_hours = $work_start;
                }
                if($this->checkEndHours($start_hours, $work_end)){
                    $start_hours = $work_end;
                }
                while ($time_array[0] != 0) {
                    if ($work_start > $work_end) {
                        break;
                    }
                    if($work_start >= $start_hours) {
                        array_push($this->array, $task->nazev);
                        array_push($this->arrayId, $task->idukoly);
                        $time_array[0]--;
                    }else{
                        $this->insertEmptyValue();
                    }
                    $work_start++;
                }
            }
        }
        for ($i = 0; $i <= 24; $i++) {
            if($i > $work_end){
                $this->insertEmptyValue();
            }
        }
        $this->array = $this->fillArray($this->array);
        if($this->checkIfEmpty($this->array) != 0) {
            return [$this->arrayId, $this->array];
        }else{
            return null;
        }
    }

    ////////////////WEEK//////////////////

    /**
     * @param $id
     * @param $com_id
     * @return array|null
     */
    public function makeWeekTasksArray($id, $com_id){
        $this->array = array();
        $this->arrayOfDays = array();
        $this->arrayOfIds = array();
        $this->arrayId = array();
        $weekend_array = array();
        $success = false;
        $today = new Nette\Utils\DateTime();
        $today->setTime(23,59,59);
        $day_counter = 0;
        $date = date('Y-m-d');
        $id_user = $this->findUserName($id);
        $tasks = $this->findWeekTasks($com_id);
        $vacation = $this->findUserVacation($id);
        $work_start = substr($id_user->work_start, 0, 2);
        $backup_work_start = $work_start;
        $work_end = substr($id_user->work_end, 0, 2);
        for ($j = 0; $j < 7; $j++) {
            $this->array = array();
            $this->arrayId = array();
            for ($i = 0; $i <= 23; $i++) {
                if($i < $work_start){
                    $this->insertEmptyValueToMultiArray();
                }
            }
            $this->assignArray($j);
        }
        $array_start_state = $this->array;
        $arrayId_start_state = $this->arrayId;
        foreach ($tasks as $task) {
            $dayofweek = date('N', strtotime($date));
            foreach($vacation as $vacation_day){
                if($vacation_day->datum->format('Y-m-d') == $today->format('Y-m-d')){
                    if($vacation_day->do != null){
                        while($vacation_day->datum->format('Y-m-d') <= $vacation_day->do->format('Y-m-d')){
                            $vacation_day->datum->modify('+1 day');
                            $day_counter++;
                            $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                            $today->modify('+1 day');
                            if($day_counter >= 7){
                                break;
                            }
                        }
                    }else{
                        $today->modify('+1 day');
                        $day_counter++;
                        $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                    }
                }
            }
            if($today < $task->zacatek){
                $this->assignArray($day_counter);
                $work_start = substr($id_user->work_start, 0, 2);
                while($today <= $task->zacatek) {
                    $today->modify('+1 day');
                    $this->array = $array_start_state;
                    $this->arrayId = $arrayId_start_state;
                    $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                    $dayofweek = date('N', strtotime($date));
                    $day_counter++;
                    foreach($vacation as $vacation_day){
                        if($vacation_day->datum->format('Y-m-d') == $today->format('Y-m-d')){
                            if($vacation_day->do != null){
                                while($vacation_day->datum->format('Y-m-d') <= $vacation_day->do->format('Y-m-d')){
                                    $vacation_day->datum->modify('+1 day');
                                    $day_counter++;
                                    $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                                    $today->modify('+1 day');
                                    if($day_counter >= 7){
                                        break;
                                    }
                                }
                            }else{
                                $today->modify('+1 day');
                                $day_counter++;
                                $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                            }
                        }
                    }
                }
            }
            if ( ($dayofweek == self::SAT_DAY) and ($task->saturday == 0) ) {
                $weekend_array[] = $task;
            } elseif ( ($dayofweek == self::SUN_DAY) and ($task->sunday == 0) ) {
                $weekend_array[] = $task;
            } else {
                $start_hours = $task->zacatek->format('H');
                $seconds = date_create('@0')->add($task->narocnost)->getTimestamp();
                $string_time = $this->makeHours($seconds);
                $time_array = explode(':', $string_time);
                if( ($time_array[0] == 0) and $time_array[1] > 0 ){
                    $time_array[0] = 1;
                }
                if($this->checkStartHours($start_hours, $work_start) == true){
                    $start_hours = $work_start;
                }
                if($this->checkEndHours($start_hours, $work_end)){
                    if($task->zacatek < $date){
                        $start_hours = $work_start;
                    }else{
                        $start_hours = $work_end;
                    }
                }
                if($task->zacatek->format('d') < $today->format('d')){
                    $start_hours = $work_start;
                }
                if( count($weekend_array) != 0 ){
                    foreach($weekend_array as $weekend_task){
                        if ( (($dayofweek != self::SUN_DAY) and ($weekend_task->sunday == 0)) and (($dayofweek != self::SAT_DAY) and ($weekend_task->saturday == 0)) ) {
                            $seconds_weekend = date_create('@0')->add($weekend_task->narocnost)->getTimestamp();
                            $start_hours_weekend = $backup_work_start;
                            $string_time_weekend = $this->makeHours($seconds_weekend);
                            $time_array_weekend = explode(':', $string_time_weekend);
                            while ($time_array_weekend[0] != 0) {
                                if ($work_start > $work_end) {
                                    $this->assignArray($day_counter);
                                    $today->modify('+1 day');
                                    $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                                    $dayofweek = date('N', strtotime($date));
                                    $this->array = $array_start_state;
                                    $this->arrayId = $arrayId_start_state;
                                    $work_start = substr($id_user->work_start, 0, 2);
                                    $work_end = substr($id_user->work_end, 0, 2);
                                    $start_hours_weekend = $work_start;
                                    $day_counter++;
                                    foreach($vacation as $vacation_day){
                                        if($vacation_day->datum->format('Y-m-d') == $today->format('Y-m-d')){
                                            if($vacation_day->do != null){
                                                while($vacation_day->datum->format('Y-m-d') <= $vacation_day->do->format('Y-m-d')){
                                                    $vacation_day->datum->modify('+1 day');
                                                    $day_counter++;
                                                    $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                                                    $today->modify('+1 day');
                                                    if($day_counter >= 7){
                                                        break;
                                                    }
                                                }
                                            }else{
                                                $today->modify('+1 day');
                                                $day_counter++;
                                                $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                                            }
                                        }
                                    }
                                    if ( ($dayofweek == self::SAT_DAY) and ($weekend_task->saturday == 0) ) {
                                        $weekend_array[] = $weekend_task;
                                        $past_hours[$weekend_task->idukoly] = $time_array_weekend[0];
                                        break;
                                    }
                                    if ( ($dayofweek == self::SUN_DAY) and ($weekend_task->sunday == 0) ) {
                                        $weekend_array[] = $weekend_task;
                                        $past_hours[$weekend_task->idukoly] = $time_array_weekend[0];
                                        break;
                                    }
                                }
                                if($start_hours_weekend >= $backup_work_start) {
                                    if(count($this->array) >= $start_hours_weekend) {
                                        $this->array[] = $weekend_task->nazev;
                                        $this->arrayId[] = $weekend_task->idukoly;
                                        $time_array_weekend[0]--;
                                    } else {
                                        $this->insertEmptyValue();
                                    }
                                }else{
                                    $start_hours_weekend++;
                                    $this->insertEmptyValue();
                                }
                                $work_start++;
                                if($day_counter >= 7){
                                    break;
                                }
                            }
                            $this->assignArray($day_counter);
                            $weekend_array = array();
                        }
                    }
                }
                while ($time_array[0] != 0) {
                    if ($work_start > $work_end) {
                        $this->assignArray($day_counter);
                        $today->modify('+1 day');
                        $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                        $dayofweek = date('N', strtotime($date));
                        $this->array = $array_start_state;
                        $this->arrayId = $arrayId_start_state;
                        $work_start = substr($id_user->work_start, 0, 2);
                        $work_end = substr($id_user->work_end, 0, 2);
                        $start_hours = $work_start;
                        $day_counter++;
                        foreach($vacation as $vacation_day){
                            if($vacation_day->datum->format('Y-m-d') == $today->format('Y-m-d')){
                                if($vacation_day->do != null){
                                    while($vacation_day->datum->format('Y-m-d') <= $vacation_day->do->format('Y-m-d')){
                                        $vacation_day->datum->modify('+1 day');
                                        $day_counter++;
                                        $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                                        $today->modify('+1 day');
                                        if($day_counter >= 7){
                                            break;
                                        }
                                    }
                                }else{
                                    $today->modify('+1 day');
                                    $day_counter++;
                                    $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                                }
                            }
                        }
                        if ( ($dayofweek == self::SAT_DAY) and ($task->saturday == 0) ) {
                            $weekend_array[] = $task;
                            $past_hours[$task->idukoly] = $time_array[0];
                            break;
                        }
                        if ( ($dayofweek == self::SUN_DAY) and ($task->sunday == 0) ) {
                            $weekend_array[] = $task;
                            $past_hours[$task->idukoly] = $time_array[0];
                            break;
                        }
                    }
                    if($start_hours >= $backup_work_start) {
                        if(count($this->array) >= $start_hours) {
                            $this->array[] = $task->nazev;
                            $this->arrayId[] = $task->idukoly;
                            $time_array[0]--;
                        } else {
                            $this->insertEmptyValue();
                        }
                    }else{
                        $start_hours++;
                        $this->insertEmptyValue();
                    }
                    $work_start++;
                    if($day_counter >= 7){
                        break;
                    }
                }
                $this->assignArray($day_counter);
            }
            if($day_counter >= 7){
                break;
            }
        }
        $this->assignArray($day_counter);
        while( count($weekend_array) != 0 ){
            $work_start = substr($id_user->work_start, 0, 2);
            $work_end = substr($id_user->work_end, 0, 2);
            $this->array = $array_start_state;
            $this->arrayId = $arrayId_start_state;
            foreach($weekend_array as $weekend_task){
                if ( (($dayofweek != self::SUN_DAY) and ($weekend_task->sunday == 0)) and (($dayofweek != self::SAT_DAY) and ($weekend_task->saturday == 0)) ) {
                    $success = true;
                    $seconds_weekend = date_create('@0')->add($weekend_task->narocnost)->getTimestamp();
                    $start_hours_weekend = $backup_work_start;
                    $string_time_weekend = $this->makeHours($seconds_weekend);
                    $time_array_weekend = explode(':', $string_time_weekend);
                    if(count($past_hours) != 0){
                        foreach($past_hours as $idtask => $hours){
                            if($idtask == $weekend_task->idukoly){
                                $time_array_weekend[0] = $hours;
                            }
                        }
                    }
                    while ($time_array_weekend[0] != 0) {
                        if ($work_start > $work_end) {
                            $this->assignArray($day_counter);
                            $today->modify('+1 day');
                            $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                            $dayofweek = date('N', strtotime($date));
                            $this->array = $array_start_state;
                            $this->arrayId = $arrayId_start_state;
                            $work_start = substr($id_user->work_start, 0, 2);
                            $work_end = substr($id_user->work_end, 0, 2);
                            $start_hours_weekend = $work_start;
                            $day_counter++;
                            foreach($vacation as $vacation_day){
                                if($vacation_day->datum->format('Y-m-d') == $today->format('Y-m-d')){
                                    if($vacation_day->do != null){
                                        while($vacation_day->datum->format('Y-m-d') <= $vacation_day->do->format('Y-m-d')){
                                            $vacation_day->datum->modify('+1 day');
                                            $day_counter++;
                                            $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                                            $today->modify('+1 day');
                                            if($day_counter >= 7){
                                                break;
                                            }
                                        }
                                    }else{
                                        $today->modify('+1 day');
                                        $day_counter++;
                                        $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                                    }
                                }
                            }
                            if ( ($dayofweek == self::SAT_DAY) and ($weekend_task->saturday == 0) ) {
                                $weekend_array[] = $weekend_task;
                                break;
                            }
                            if ( ($dayofweek == self::SUN_DAY) and ($weekend_task->sunday == 0) ) {
                                $weekend_array[] = $weekend_task;
                                break;
                            }
                        }
                        if($start_hours_weekend >= $backup_work_start) {
                            if(count($this->array) >= $start_hours_weekend) {
                                $this->array[] = $weekend_task->nazev;
                                $this->arrayId[] = $weekend_task->idukoly;
                                $time_array_weekend[0]--;
                            } else {
                                $this->insertEmptyValue();
                            }
                        }else{
                            $start_hours_weekend++;
                            $this->insertEmptyValue();
                        }
                        $work_start++;
                        if($day_counter >= 7){
                            break;
                        }
                    }
                    $this->assignArray($day_counter);
                } else {
                    $today->modify('+1 day');
                    $date = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
                    $dayofweek = date('N', strtotime($date));
                    $day_counter++;
                    if($day_counter >= 7){
                        break;
                    }
                }
            }
            if($success == true){
                $weekend_array = array();
            }
        }
        for ($i = 0; $i <= 23; $i++) {
            if(!array_key_exists($i, $this->array)) {
                $this->insertEmptyValueToMultiArray();
            } else {
                if ($i >= $work_end) {
                    $this->insertEmptyValueToMultiArray();
                }
            }
        }
        $fill_counter = $day_counter - 1;
        if($day_counter <= 7){
            $this->assignArray($day_counter);
            $this->array = array();
            $this->arrayId = array();
            $this->array = $this->fillArray($this->array);
            $this->arrayId = $this->fillArray($this->arrayId);
            while($day_counter != 7){
                $day_counter++;
                $this->assignArray($day_counter);
            }
        }
        for ($fill_counter; $fill_counter >= 0; $fill_counter--) {
            for ($i = 0; $i <= 23; $i++) {
                if ($i > $work_end) {
                    $this->arrayOfDays[$fill_counter][] = '';
                    $this->arrayOfIds[$fill_counter][] = '';
                }
            }
            while(count($this->arrayOfDays[$fill_counter]) <= 23){
                $this->arrayOfDays[$fill_counter][] = '';
                $this->arrayOfIds[$fill_counter][] = '';
            }
        }
        //Debugger::dump($this->arrayOfDays);
        if($this->checkMultiArrayIfEmpty($this->arrayOfDays) != 0) {
            return [$this->arrayOfDays, $this->arrayOfIds];
        }else{
            return null;
        }
    }

}