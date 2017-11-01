<?php
/**
 * Created by PhpStorm.
 * User: kachna96
 * Date: 20.12.2014
 * Time: 18:59
 */
namespace App\Model;

use Nette,
    Tracy\Debugger;

class Calendar extends Nette\Object
{

    const
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
        TASK_COLUMN_INSERTED_BY = 'vlozil',
        TASK_COLUMN_SATURDAY = 'saturday',
        TASK_COLUMN_SUNDAY = 'sunday',
        TASK_COLUMN_COMPANY_ID = 'spolecnost_idspolecnost';

    private $month;
    private $year;

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
     * @param $id
     * @return array
     */
    public function fetchUserVacation($id){
        $today = new Nette\Utils\DateTime();
        $vacation_days = $this->database->table(self::VAC_TABLE_NAME)
            ->where(self::VAC_COLUMN_USER_ID, $id)
            ->where('datum >= ? OR do >= ?', $today, $today)
            ->order(self::VAC_COLUMN_DATE_FROM)
            ->fetchAll();

        $vacation_array = array();
        foreach($vacation_days as $day){
            $vacation_array[] = $day->datum;
            $vacation_array[] = $day->do;
        }
        return $vacation_array;
    }

    /**
     * @param $id
     * @return array|Nette\Database\Table\IRow[]
     */
    public function fetchVacationForCalendar($id){
        $first_day = new Nette\Utils\DateTime();
        $first_day->modify('first day of this month');
        return $this->database->table(self::VAC_TABLE_NAME)
            ->where(self::VAC_COLUMN_USER_ID, $id)
            ->where('(ucel = "Státní svátek") OR (datum >= ?)', $first_day)
            ->fetchAll();
    }

    public function fetchTasksForCalendar($com_id){
        $first_day = new Nette\Utils\DateTime();
        $first_day->modify('first day of this month');
        return $this->database->table(self::TASK_TABLE_NAME)
            ->where(self::TASK_COLUMN_COMPANY_ID, $com_id)
            ->where('zacatek >= ?', $first_day)
            ->fetchAll();
    }

    /**
     * @param $month
     */
    function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @param $year
     */
    function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return array
     */
    function getDays()
    {
        return array(1 => "Po", "Út", "St", "Čt", "Pá", "So", "Ne");
    }

    /**
     * @return int
     */
    function countDays()
    {
        return cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
    }

    /**
     * @return bool|int|string
     */
    function firstDay()
    {
        $eng = date("w", mktime(0, 0, 0, $this->month, 1, $this->year));
        return ($eng==0) ? 7 : $eng;
    }

    /**
     * @param $row
     * @param $column
     * @param $firstDay
     * @param $countDays
     * @return string
     */
    function cell($row, $column, $firstDay, $countDays)
    {
        $days = $this->getDays();

        if ($row == 1 ) return $days[$column];

        $value = ($row-2)*7 + $column - $firstDay+1;

        if ($value < 1 || $value > $countDays) return "&nbsp;"; else return $value;
    }

    /**
     * @return mixed
     */
    function extractCalendar($user_id, $com_id)
    {
        $tasks = $this->fetchTasksForCalendar($com_id);
        $vacation = $this->fetchVacationForCalendar($user_id);
        $extractCalendar = array();
        $colors = array();
        $this_month = new Nette\Utils\DateTime();
        $countDays = $this->countDays($this->month, $this->year);
        $firstDay = $this->firstDay($this->month, $this->year);
        $countRows = date("W", mktime(0, 0, 0, $this->month, $countDays-7, $this->year)) - date("W", mktime(0, 0, 0, $this->month, 1+7, $this->year))+4;
        for ($row = 1; $row <= $countRows; $row++)
        {
            for($column = 1; $column <= 7; $column++)
            {
                if(!isset($colors[$row][$column])) {
                    $colors[$row][$column] = NULL;
                }
                $extractCalendar[$row][$column] = $this->cell($row, $column, $firstDay, $countDays);
                foreach ($vacation as $vacation_day) {
                    $date = $vacation_day->datum;
                    if (($vacation_day->datum->format('m') == $this_month->format('m')) and ($vacation_day->datum->format('d') == $extractCalendar[$row][$column])) {
                        $colors_column = $column;
                        $colors_row = $row;
                        $colors[$colors_row][$colors_column] = 'red';
                        if ($vacation_day->do != NULL) {
                            while ($date < $vacation_day->do) {
                                if ($colors_column > 7) {
                                    $colors_column = 1;
                                    $colors_row++;
                                }
                                if ($colors_row > $countRows) {
                                    break;
                                }
                                $colors[$colors_row][$colors_column] = 'red';
                                $colors_column++;
                                $date->modify('+1 day');
                            }
                        }
                    }
                }
                foreach ($tasks as $task) {
                    $date = $task->zacatek;
                    $end = $task->konec;
                    if( ($task->zacatek->format('m') == $this_month->format('m')) and ($task->zacatek->format('d') == $extractCalendar[$row][$column]) ){
                        $colors_column = $column;
                        $colors_row = $row;
                        if((isset($colors[$colors_row][$colors_column])) and ($colors[$colors_row][$colors_column] != NULL)) {
                            while(isset($colors[$colors_row][$colors_column])) {
                                $colors_column++;
                                if ($colors_column > 7) {
                                    $colors_column = 1;
                                    $colors_row++;
                                }
                                if ($colors_row > $countRows) {
                                    break;
                                }
                            }
                            $colors[$colors_row][$colors_column] = 'blue';
                        }else{
                            $colors[$colors_row][$colors_column] = 'blue';
                        }
                        $colors_column++;
                        if($date->format('Y-m-d') < $end->format('Y-m-d')){
                            while($date->format('Y-m-d') < $end->format('Y-m-d')){
                                if($colors_column > 7){
                                    $colors_column = 1;
                                    $colors_row++;
                                }
                                if($colors_row > $countRows){
                                    break;
                                }
                                while(isset($colors[$colors_row][$colors_column])) {
                                    $colors_column++;
                                    if ($colors_column > 7) {
                                        $colors_column = 1;
                                        $colors_row++;
                                    }
                                    if ($colors_row > $countRows) {
                                        break;
                                    }
                                }
                                $colors[$colors_row][$colors_column] = 'blue';
                                $colors_column++;
                                $end->modify('-1 day');
                            }
                        }
                    }
                }
            }
        }
        return [$extractCalendar, $colors];
    }

}