<?php

$exec_dir = str_replace('modules/eicaptcha', '', trim(shell_exec('pwd')));
include_once $exec_dir . 'config/config.inc.php';

class EiCaptchaTest extends PHPUnit_Framework_TestCase {
    
    //Nom du module
    protected $_moduleName = 'eicaptcha';
    
    /**
     * Vérification que le module est installé (via la méthode prestashop)
     * @group eicaptcha_install
     */
    public function testModuleIsInstalled() {
        $this->assertTrue(Module::isInstalled($this->_moduleName));
    }
    
    /**
     * Vérification que le module est bien greffé sur les hooks
     * @group eicaptcha_install
     */
    public function testModuleIsHooked() {
        
        $moduleInstance = Module::getInstanceByName($this->_moduleName);
        $modulesHooks = array('header','displayCustomerAccountForm');
        
        foreach ( $modulesHooks as $hook) {
            $this->assertNotFalse($moduleInstance->isRegisteredInHook($hook));
        }
    }
    
    /**
     * Test de la configuration du module
     * @group eicaptcha_install
     */
    public function testModuleConfiguration(){
        
        //On vérifie que les configurations existent
        $this->assertNotFalse(Configuration::get('CAPTCHA_PUBLIC_KEY'));
        $this->assertNotFalse(Configuration::get('CAPTCHA_PRIVATE_KEY'));
	$this->assertNotFalse(Configuration::get('CAPTCHA_ENABLE_ACCOUNT'));
	$this->assertNotFalse(Configuration::get('CAPTCHA_ENABLE_CONTACT'));
	$this->assertNotFalse(Configuration::get('CAPTCHA_THEME'));
		    
        //Et qu'elles ne sont pas vides
        $this->assertNotEmpty(Configuration::get('CAPTCHA_PUBLIC_KEY'));
        $this->assertNotEmpty(Configuration::get('CAPTCHA_PRIVATE_KEY'));
        // La valeur par défaut 0 est considérée comme vide par Phpunit, on ne peut donc pas la vérifier
        // via assertNotEmpty
    }

}
