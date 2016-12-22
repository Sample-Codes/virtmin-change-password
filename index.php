<?php

class VirtminChangePasswordPlugin extends \RainLoop\Plugins\AbstractPlugin
{
	public function Init()
	{
		$this->addHook('main.fabrica', 'MainFabrica');
	}

	/**
	 * @param string $sName
	 * @param mixed $oProvider
	 */
	public function MainFabrica($sName, &$oProvider)
	{
		switch ($sName)
		{
			case 'change-password':

				include_once __DIR__.'/ChangePasswordVirtMinDriver.php';

				$oProvider = new ChangePasswordVirtMinDriver();
				$oProvider->SetLogger($this->Manager()->Actions()->Logger());
  				break;
		}
	}

	/**
	 * @return array
	 */
	public function configMapping()
	{
		return array( );
	}
}
