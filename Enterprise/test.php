<?php
require_once "lite_test/LiteTestPHP.php";
require_once "PowerManager.php";
class TestCaseMyProyect extends TestCase {
	
	function test_injectorClass() {
		$injector = new Injector ( 20 );
		$this->assert_true ( $injector instanceof Injector );
	}
	
	function test_injectorClassWithNegativeDamage() {
		try {
			$injector = new Injector ( - 20 );
		} catch ( Exception $exception ) {
			if ($exception->getCode () == 1)
				$this->pass ();
		}
	}
	
	function test_injectorClassWithExtralimitedDamage() {
		try {
			$injector = new Injector ( 110 );
		} catch ( Exception $exception ) {
			if ($exception->getCode () == 1)
				$this->pass ();
		}
	}
        function test_injectorClassWithExtralimitedExtraPlasma() {
		try {
			$injector = new Injector ( 40 );
                        $injector->setExtraPlasma(400);
		} catch ( Exception $exception ) {
			if ($exception->getCode () == 1)
				$this->pass ();
		}
	}
	function test_injectorClassWithNegativeExtraPlasma() {
		try {
			$injector = new Injector ( 40 );
                        $injector->setExtraPlasma(-200);
		} catch ( Exception $exception ) {
			if ($exception->getCode () == 1)
				$this->pass ();
		}
	}
	function test_injectorClassWithNegativePlasma() {
		$injector = new Injector ( 20 );
		try{
			$injector->setPlasma(-14);
		} catch ( Exception $exception ) {
			if ($exception->getCode () == 1)
				$this->pass ();
		}
	}
        function test_injectorClassWithNegativeDamage2() {
		$injector = new Injector ( 20 );
		try{
			$injector->setDamage(-14);
		} catch ( Exception $exception ) {
			if ($exception->getCode () == 1)
				$this->pass ();
		}
	}
	
	function test_injectorNormalInjection() {
		$injector = new Injector ( 20 );
		$this->assert_true ( $injector->normalInjection() == 80 );
	}
        function test_injectorNormalInjectionWithOtherPlasmaValue() {
		$injector = new Injector ( 20 );
                $injector->setPlasma(80);
		$this->assert_true ( $injector->normalInjection() == 64 );
	}
	function test_injectorMaximumInjection() {
		$injector = new Injector ( 20 );
		$this->assert_true ( $injector->maximunInjection() == 179 );
	}
        function test_injectorMaximumInjectionWithOtherPlasmaValue() {
		$injector = new Injector ( 20 );
                $injector->setPlasma(80);
		$this->assert_true ( $injector->maximunInjection() == 163 );
	}
        function test_injectorRemainingOperationTime() {
		$injector = new Injector ( 20 );
                $injector->setInjection(120);
		$this->assert_true ( $injector->remainingOperationTime() == 60 );
	}
        function test_powerManageClass() {
		$powermanager = new PowerManager ( 20 );
		$this->assert_true ( $powermanager instanceof PowerManager );
	}
	
	function test_powerManageClassWithNegativeSpeed() {
		try {
			$powermanager = new PowerManager ( - 20 );
		} catch ( Exception $exception ) {
			if ($exception->getCode () == 1)
				$this->pass ();
		}
	} 
        function test_powerManageClassWithNegativeSpeed2() {
		try {
			$powermanager = new PowerManager (20);
                        $powermanager->setSpeed(-30);
		} catch ( Exception $exception ) {
			if ($exception->getCode () == 1)
				$this->pass ();
		}
	}
        function test_powerManageClassWithNegativePlasmaForMaxSpeed() {
		try {
			$powermanager = new PowerManager (20);
                        $powermanager->setPlasmaForMaxSpeed(-10);
		} catch ( Exception $exception ) {
			if ($exception->getCode () == 1)
				$this->pass ();
		}
	}
        function test_powerManageClassWithLowPlasmaForMaxSpeed() {
		try {
			$powermanager = new PowerManager (20);
                        $powermanager->setPlasmaForMaxSpeed(10);
		} catch ( Exception $exception ) {
			if ($exception->getCode () == 1)
				$this->pass ();
		}
	}
        function test_powerManageClassAddInjector() {
		
		$powermanager = new PowerManager (20);
                $powermanager->addInjector(new Injector(80));
                $injectors = $powermanager->getInjectorArray(); 
		$this->assert_true (isset($injectors['A']));
	}
        function test_powerManageValueInjectionAfterRunInjectionBalance() {
		
		$powermanager = new PowerManager (80);
                $powermanager->addInjector(new Injector(0));
                $powermanager->addInjector(new Injector(0));
                $powermanager->addInjector(new Injector(100));
                $powermanager->injectionBalance();
                $injectors = $powermanager->getInjectorArray(); 
		$this->assert_true ($injectors['A']->getInjection() == 120 && $injectors['B']->getInjection() == 120 && $injectors['C']->getInjection() == 0);
	}
        
        function test_powerManageValueInjectionAfterRunInjectionBalance2() {
		
		$powermanager = new PowerManager (80);
                $powermanager->setPlasmaForMaxSpeed(150);
                $powermanager->addInjector(new Injector(0));
                $powermanager->addInjector(new Injector(0));
                $powermanager->addInjector(new Injector(100));
                $powermanager->injectionBalance();
                $injectors = $powermanager->getInjectorArray(); 
		$this->assert_true ($injectors['A']->getInjection() == 60 && $injectors['B']->getInjection() == 60 && $injectors['C']->getInjection() == 0);
	}
        function test_powerManageValueInjectionAfterRunInjectionBalance3() {
		
		$powermanager = new PowerManager (80);
                $injector = new Injector(0);
                $injector->setPlasma(200);
                $powermanager->addInjector($injector);
                $powermanager->addInjector(new Injector(0));
                $powermanager->addInjector(new Injector(100));
                $powermanager->injectionBalance();
                $injectors = $powermanager->getInjectorArray(); 
		$this->assert_true ($injectors['A']->getInjection() == 140 && $injectors['B']->getInjection() == 100 && $injectors['C']->getInjection() == 0);
	}
        function test_powerManageValueInjectionAfterRunInjectionBalance4() {
		
		$powermanager = new PowerManager (100);
                $powermanager->addInjector(new Injector(20));
                $powermanager->addInjector(new Injector(10));
                $powermanager->addInjector(new Injector(0));
                $powermanager->injectionBalance();
                $injectors = $powermanager->getInjectorArray(); 
		$this->assert_true ($injectors['A']->getInjection() == 90 && $injectors['B']->getInjection() == 100 && $injectors['C']->getInjection() == 110);
	}
}

// 3. Choose a TestRunner and add your TestCase (CLI runner in this case)
$runner = new TestRunnerCLI ();
$runner->add_test_case ( new TestCaseMyProyect () );

// 4. Run your tests
$runner->print_results ();
?>