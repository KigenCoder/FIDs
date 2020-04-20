<?php


namespace App\Classes;


class AnalysisData{
public $year;
public $marketPrices;

  /**
   * AnalysisData constructor.
   * @param $year
   * @param $marketPrices
   */
  public function __construct($year,  array $marketPrices){
    $this->year = $year;
    $this->marketPrices = $marketPrices;
  }

  /**
   * @return mixed
   */
  public function getYear()
  {
    return $this->year;
  }

  /**
   * @param mixed $year
   * @return AnalysisData
   */
  public function setYear($year)
  {
    $this->year = $year;
    return $this;
  }

  /**
   * @return array
   */
  public function getMarketPrices(): array
  {
    return $this->marketPrices;
  }

  /**
   * @param array $marketPrices
   * @return AnalysisData
   */
  public function setMarketPrices(array $marketPrices): AnalysisData
  {
    $this->marketPrices = $marketPrices;
    return $this;
  }





}