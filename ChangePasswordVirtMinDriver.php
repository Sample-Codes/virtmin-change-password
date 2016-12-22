<?php

class ChangePasswordVirtMinDriver implements \RainLoop\Providers\ChangePassword\ChangePasswordInterface
{
	/**
	 * @var \MailSo\Log\Logger
	 */
	private $oLogger = null;

  
	/**
	 * @param \MailSo\Log\Logger $oLogger
	 *
	 * @return \DirectAdminChangePasswordDriver
	 */
	public function SetLogger($oLogger)
	{
		if ($oLogger instanceof \MailSo\Log\Logger)
		{
			$this->oLogger = $oLogger;
		}
		return $this;
	}

  	private function log($msg) {
    	if ($this->oLogger)
          $this->oLogger->Write('VirtMin-Change-Password : '.$msg);// Try to change password for '.$oAccount->Email());
      	return $msg;
    }
  
  /**
	 * @param \RainLoop\Account $oAccount
	 *
	 * @return bool
	 */
	public function PasswordChangePossibility($oAccount)
	{
		return $oAccount && $oAccount->Email() && strlen($oAccount->Email())>4;
//			\RainLoop\Plugins\Helper::ValidateWildcardValues($oAccount->Email(), $this->sAllowedEmails);
	}

	/**
	 * @param \RainLoop\Account $oAccount
	 * @param string $sPrevPassword
	 * @param string $sNewPassword
	 *
	 * @return bool
	 */
	public function ChangePassword(\RainLoop\Account $oAccount, $sPrevPassword, $sNewPassword)
	{
		$bResult = false;

		try
		{
          	$this->log('Trying to change password for '.$oAccount->Email());
          	$script = dirname(__FILE__)."/change-password-virtmin.sh";
            $email = $oAccount->Email();
          	$cmdline = "sudo $script $email $sPrevPassword $sNewPassword";
          	$this->log('cmdline: '.$cmdline);
	        $output = `${cmdline}`;
          	$this->log('output is :'.$output);
			$bResult = (strpos($output, 'Old password: New password: Password changed', 0) === 0);
		}
		catch (\Exception $oException)
		{
			$bResult = false;
          	$this->log("Exception: ".$e->getMessage());
		}

		return $bResult;
	}
}