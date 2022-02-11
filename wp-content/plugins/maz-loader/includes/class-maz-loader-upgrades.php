<?php

/**
 * Upgrades
 *
 * @link       https://www.feataholic.com
 * @since      1.4.1 Free
 *
 * @package    MZLDR
 * @subpackage MZLDR/includes
 */

/**
 * Upgrades.
 *
 * @since      1.4.1 Free
 * @package    MZLDR
 * @subpackage MZLDR/includes
 * @author     Stergos Zamagias <stergosz1@gmail.com>
 */
class MZLDR_Upgrades
{
	public static function run()
	{
		$installed_version = get_option('mzldr_version', '1.0.0');
		if (MZLDR_VERSION === $installed_version)
		{
			return;
		}

		// Start Migrator
		($migrator = new MZLDR_Migrator($installed_version))->start();

		// finally update the database version of the plugin
		update_option('mzldr_version', MZLDR_VERSION);
	}
}