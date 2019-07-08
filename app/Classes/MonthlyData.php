<?php


namespace App\Classes;


class MonthlyData
{
  public $month_id;
  public $data_value;

  /**
   * MonthlyData constructor.
   * @param $month_id
   * @param $data_value
   */
  public function __construct($month_id, $data_value)
  {
    $this->month_id = $month_id;
    $this->data_value = $data_value;
  }

  /**
   * @return mixed
   */
  public function getMonthId()
  {
    return $this->month_id;
  }

  /**
   * @param mixed $month_id
   * @return MonthlyData
   */
  public function setMonthId($month_id)
  {
    $this->month_id = $month_id;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getDataValue()
  {
    return $this->data_value;
  }

  /**
   * @param mixed $data_value
   * @return MonthlyData
   */
  public function setDataValue($data_value)
  {
    $this->data_value = $data_value;
    return $this;
  }




}