<?php
/**
 * @package		solo
 * @copyright	2014-2016 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license		GNU GPL version 3 or later
 */

namespace Solo\Pythia\Oracle;

use Solo\Pythia\AbstractOracle;

class Mautic extends AbstractOracle
{
	/**
	 * The name of this oracle class
	 *
	 * @var  string
	 */
	protected $oracleName = 'mautic';

	/**
	 * Does this class recognises the CMS type as Joomla?
	 *
	 * @return  boolean
	 */
	public function isRecognised()
	{
		if (!@file_exists($this->path . '/app/config/local.php'))
		{
			return false;
		}

		if (!@is_dir($this->path . '/addons'))
		{
			return false;
		}

		return true;
	}

	/**
	 * Return the database connection information for this CMS / script
	 *
	 * @return  array
	 */
	public function getDbInformation()
	{
		$ret = array(
			'driver'	=> 'mysqli',
			'host'		=> '',
			'port'		=> '',
			'username'	=> '',
			'password'	=> '',
			'name'		=> '',
			'prefix'	=> '',
		);

		// The config file is a PHP file, but users should not modify it, so it should be safe to directly include it
        @include $this->path . '/app/config/local.php';

        /** @var $parameters array() */

        // Special case when we're using the PDO MYSQL driver
        if($parameters['db_driver'] == 'pdo_mysql')
        {
            $ret['driver'] = 'Pdomysql';
        }
        else
        {
            $ret['driver']   = $parameters['db_driver'];
        }

        $ret['host']     = $parameters['db_host'];
        $ret['port']     = $parameters['db_port'];
        $ret['username'] = $parameters['db_user'];
        $ret['password'] = $parameters['db_password'];
        $ret['name']     = $parameters['db_name'];
        $ret['prefix']   = $parameters['db_table_prefix'];

		return $ret;
	}

}