<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Util
 *
 * @author Ing.Yoelvys Martinez Hidalgo
 */
include 'PowerManager.php';
    $power = new PowerManager(100);
    $power->addInjector(new Injector(0));
    $power->addInjector(new Injector(0));
    $power->addInjector(new Injector(0));
    $power->showResult();
    
    $power = new PowerManager(90);
    $power->addInjector(new Injector(0));
    $power->addInjector(new Injector(0));
    $power->addInjector(new Injector(0));
    $power->showResult();
    
    $power = new PowerManager(30);
    $power->addInjector(new Injector(0));
    $power->addInjector(new Injector(0));
    $power->addInjector(new Injector(0));
    $power->showResult();
    
    $power = new PowerManager(100);
    $power->addInjector(new Injector(20));
    $power->addInjector(new Injector(10));
    $power->addInjector(new Injector(0));
    $power->showResult();
    
    $power = new PowerManager(80);
    $power->addInjector(new Injector(0));
    $power->addInjector(new Injector(0));
    $power->addInjector(new Injector(100));
    $power->showResult();
    
    $power = new PowerManager(150);
    $power->addInjector(new Injector(0));
    $power->addInjector(new Injector(0));
    $power->addInjector(new Injector(0));
    $power->showResult();
    
    $power = new PowerManager(140);
    $power->addInjector(new Injector(0));
    $power->addInjector(new Injector(0));
    $power->addInjector(new Injector(30));
    $power->showResult();
   
    $power = new PowerManager(170);
    $power->addInjector(new Injector(20));
    $power->addInjector(new Injector(50));
    $power->addInjector(new Injector(40));
    $power->showResult();
     
    $power = new PowerManager(100);
    $power->addInjector(new Injector(20));
    $power->addInjector(new Injector(50));
    $power->addInjector(new Injector(40));
    $power->maximumSpeed();
    
?>
