<?php
/**
 * Description of PowerManager
 *
 * @author Ing. Yoelvys Martinez Hidalgo
 */
include_once 'Injector.php';
class PowerManager {
    /**
     * @var int $speed Required speed
     */
    private $speed;
    /**
     * @var int $plasmaForMaxSpeed Plasma needed to reach 100% of the speed of ligth
     */
    private $plasmaForMaxSpeed;
    /**
     * @var array $injectorArray inyectors Starship
     */
    private $injectorArray;
    /**
     * @var char $index index of the array $injectorArray
     */
    private $index;
    /**
     * @var bool $completeBalance TRUE if complete successfully the balance, FALSE otherwise.
     */
    private $completeBalance;
    /**
     * @var int $injectorCount count of injectors.
     */
    private $injectorCount;
    /**
     * @var int $necesaryPlasma Amount of required plasma to reach the required speed.
     */
    private $necesaryPlasma;
    /**
     * @param int $speed Required speed.The speed must be greater than 0
     * @throws Exception
     */
    function __construct($speed) {
        if($speed > 0)
        {
            $this->speed = $speed;
            $this->plasmaForMaxSpeed = 300;
            $this->injectorArray = array();
            $this->index = 65;
            $this->completeBalance = false;
            $this->injectorCount = 0;
        }
        else
          throw new Exception('The speed must be greater than 0',1);
    }
    /**
     * Set speed value
     * 
     * @param int $speed value of speed, greater than 0.
     * @throws Exception
     */
    function setSpeed($speed)
    {
        if($speed > 0)
            $this->speed = $speed;
        else
          throw new Exception('The speed must be greater than 0',1);
    }
    /**
     * Set plasma for maximum speed 
     * @param int $plasmaForMaxSpeed Plasma needed to reach 100% of the speed of ligth.
     * @throws Exception
     */        
    function setPlasmaForMaxSpeed($plasmaForMaxSpeed)
    {
       if(intval($this->plasmaForMaxSpeed * $this->speed / 100, 10) > 0)
            $this->plasmaForMaxSpeed = $plasmaForMaxSpeed;
        else
          throw new Exception('Plasma necessary to reach 100% of the speed of light, very low',1); 
    }
    /**
     * Add new injector. 
     * @param Injector $injector New injector.
     */
    function addInjector(Injector $injector)
    {
        $this->injectorArray[chr($this->index)] = $injector;
        $this->index += 1;
        $this->injectorCount++;
    }
    /**
     * Return the injector array. 
     * @return array Injector array.
     */
    function getInjectorArray()
    {
        return $this->injectorArray;
    }
    /**
     * Distributed equally the necessary plasma
     */
    function injectionBalance()
    {
        
        $normalInyection = 0;
        $maximumInyection = 0;
        $this->necesaryPlasma = intval($this->plasmaForMaxSpeed * $this->speed / 100, 10);
        $this->completeBalance = true;
        foreach ($this->injectorArray as $injector)
        {   
           $normalInyection += $injector->normalInjection();
           $maximumInyection += $injector->maximunInjection();    
        } 
        if($normalInyection >= $this->necesaryPlasma)
        {    
            while($this->necesaryPlasma >= $this->injectorCount)
            {
                $tempPlasma = intval($this->necesaryPlasma/$this->injectorCount,10);
                $this->addPlasma($tempPlasma,false);
            }
            
            while($this->necesaryPlasma != 0)
            {
                $this->addPlasma(1,false); 
            }
        }
        else if($maximumInyection >= $this->necesaryPlasma)
        {
           foreach ($this->injectorArray as $injector)
            {
               $injector->setInjection($injector->normalInjection());
               $this->necesaryPlasma -= $injector->normalInjection();
            }
            while($this->necesaryPlasma >= $this->injectorCount)
            {
                $tempPlasma = intval($this->necesaryPlasma/$this->injectorCount,10);
                $this->addPlasma($tempPlasma,true);
            }
            
            while($this->necesaryPlasma != 0)
            {
                $this->addPlasma(1,true); 
            }
        }
        else
           $this->completeBalance = false; 
    }
    function addPlasma($plasma,$isExtraPlasma)
    {
       foreach ($this->injectorArray as $injector)
       {
           $this->necesaryPlasma -= $injector->addPlasma($plasma, $isExtraPlasma);
           if($this->necesaryPlasma == 0)
               break;
       } 
    }
    /**
     * Show resume of injectors and operation time remaining.  
     */
    function showResult()
    {
        if($this->injectorCount > 0)
        {   
            $this->injectionBalance();
            $remainingOperationTime = 9999999;
            if($this->completeBalance)
            {
                $result = "";
                foreach ($this->injectorArray as $index => $injector)
                {
                   $aux = $injector->remainingOperationTime(); 
                   $result .= $index.": ".$injector->getInjection()." mg/s,";
                   if($remainingOperationTime > $aux)
                       $remainingOperationTime = $aux;
                }
                echo substr($result,0,-1)."\n";
                if($remainingOperationTime == Constant::operationTime)
                    echo "Tiempo de funcionamiento: Infinito\n";
                else
                    echo "Tiempo de funcionamiento: ".$remainingOperationTime." minutos\n";
            }
            else {
                echo "Unable to comply\n";
                echo "Tiempo de funcionamiento: 0\n";
            }
        }
        else
            throw new Exception('No injectors',1);
    }
    
    function maximumSpeed()
    {
        $normalInyection = 0;
        foreach ($this->injectorArray as $injector) 
           $normalInyection += $injector->normalInjection();
        echo "El la velocidad maxima a la que puede viajar de forma infinita es: ".intval($normalInyection*100/$this->plasmaForMaxSpeed, 10)." %.";
    }
}
