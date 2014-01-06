<?php

/**
 * Description of Injector
 *
 * @author Ing Yoelvys Martinez Hidalgo
 */
include_once 'Constant.php';
class Injector {
    
    /**
     * @var int Plasma injection capacity
     */
    private $plasma;
    
    /**
     * @var int Extra plasma injection capacity
     */
    private $extraPlasma;
    
    /**
     * @var int Porcentage of damage
     */
    private $damage;
    
    /**
     * @var int Plasma injected
     */
    private $injection;
    
    /**
     * @param int $damage Porcentage of damage. The value will be between 0% and 100%.
     * @throws Exception
     */
    function __construct($damage) {
        if ($damage >= 0 && $damage <= 100) {
            $this->plasma = 100;
            $this->extraPlasma = 99;
            $this->damage = $damage;
            $this->injection = 0;
        } 
        else 
            throw new Exception('The porcentage of damage will be between 0% and 100%', 1);
        if(!$this->isExtraPlasmaCorrect(null))
            throw new Exception('Extra plasma * time factor must be less than the operating time',1);
    }
    /**
     * @see Constant.php
     * @param int $extraPlasma 
     * @return bool TRUE if extra plasma * time factor must be less than the operating time, FALSE otherwise
     */
    function isExtraPlasmaCorrect($extraPlasma)
    {
        
        if(is_null($extraPlasma))
            $extraPlasma = $this->extraPlasma;
        return $extraPlasma * Constant::timeFactor < Constant::operationTime;
    }
    
    /**
     * Set plasma value
     * 
     * @param int $plasma Amount of plasma greater than 0.
     * @throws Exception
     */
    function setPlasma($plasma)
    {
        if($plasma > 0)
            $this->plasma = $plasma;
        else
           throw new Exception('Injection capacity must be greater than 0',1);
    }
    
    /**
     * Set extra plasma value
     * 
     * @param int $plasma Amount of extra plasma greater or equal 0
     * @throws Exception
     */
    function setExtraPlasma($extraPlasma)
    {  
        if($this->isExtraPlasmaCorrect($extraPlasma) && $extraPlasma >= 0)
            $this->extraPlasma = $extraPlasma;
        else if($extraPlasma < 0)
           throw new Exception('The amount of extra plasma must be greater or equal to 0',1);     
        else 
            throw new Exception('Extra plasma * time factor must be less than the operating time',1);
    }
    /**
     * Set damage value
     * 
     * @param int $damage Percent of damage between 0% and 100%
     * @throws Exception
     */
    function setDamage($damage)
    {
       if ($damage >= 0 && $damage <= 100)
            $this->damage = $damage;
       else 
            throw new Exception('Percent of damage must be between 0% and 100%', 1);
    }
    
    function setInjection($injection)
    {
        $this->injection = $injection;
    }
    function calculatePlasmaUsed($plasma,$totalPlasma)
    {
      if($plasma + $this->injection > $totalPlasma)
      {
          $plasmaUsed =  $totalPlasma - $this->injection; 
          $this->injection = $totalPlasma;
          return $plasmaUsed;
      }
      else
      {
          $this->injection += $plasma;
          return $plasma;
      }
    }
    function addPlasma($plasma,$isExtraPlasma)
    {
        if(!$isExtraPlasma)
            return $this->calculatePlasmaUsed($plasma, $this->normalInjection());
        else
          return $this->calculatePlasmaUsed($plasma, $this->maximunInjection());  
    }
    function getInjection()
    {
        return $this->injection;
    }
    
    function isEnabled()
    {
        return $this->damage < 100;
    }
    
    function normalInjection()
    {
        return intval($this->plasma - $this->damage * $this->plasma / 100, 10);
    }
    function maximunInjection()
    {
        if($this->damage == 100)
            return 0;
        return $this->normalInjection() + $this->extraPlasma;
    }
    function remainingOperationTime()
    {
        $usedExtraPlasma = $this->injection - $this->normalInjection();
        if($usedExtraPlasma <= 0)
            return Constant::operationTime;
        return Constant::operationTime - ($usedExtraPlasma * Constant::timeFactor);
    }
    
}
