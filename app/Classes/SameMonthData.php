<?php


namespace App\Classes;


class SameMonthData{
public $monthId;
public $monthValues;

  /**
   * SameMonthData constructor.
   * @param $monthId
   * @param $monthValues
   */
  public function __construct($monthId, array $monthValues)
  {
    $this->monthId = $monthId;
    $this->monthValues = $monthValues;
  }

  /**
   * @return mixed
   */
  public function getMonthId()
  {
    return $this->monthId;
  }

  /**
   * @param mixed $monthId
   * @return SameMonthData
   */
  public function setMonthId($monthId)
  {
    $this->monthId = $monthId;
    return $this;
  }

  /**
   * @return array
   */
  public function getMonthValues(): array
  {
    return $this->monthValues;
  }

  /**
   * @param array $monthValues
   * @return SameMonthData
   */
  public function setMonthValues(array $monthValues): SameMonthData
  {
    $this->monthValues = $monthValues;
    return $this;
  }




}