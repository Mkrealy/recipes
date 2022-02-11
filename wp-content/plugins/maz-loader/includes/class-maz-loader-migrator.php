<?php

/**
 * Migrator
 *
 * @link       https://www.feataholic.com
 * @since      1.4.1 Free
 *
 * @package    MZLDR
 * @subpackage MZLDR/includes
 */

/**
 * Migrator.
 *
 * @since      1.4.1 Free
 * @package    MZLDR
 * @subpackage MZLDR/includes
 * @author     Stergos Zamagias <stergosz1@gmail.com>
 */
class MZLDR_Migrator
{
	private $installed_version;

	public function __construct($installed_version)
	{
		$this->installed_version = $installed_version;
	}

	public function start()
	{
		$this->addSessionIdToImpressions();
		$this->updateLoadersDataColumnType();
	}
	
	/**
	 * If current version is 1.2.0 or lower, then add session_id to mzldr_impressions table.
	 * Newer versions skip this as its already included in the SQL of the created tables.
	 * 
	 * @since   1.2.1
	 * 
	 * @return  void
	 */
	private function addSessionIdToImpressions()
	{
		if (!$this->installed_version)
		{
			return;
		}
		
		if (version_compare($this->installed_version, '1.2.0', '>'))
		{
			return;
		}

		global $table_prefix, $wpdb;
		$impressions_table = $table_prefix . 'mzldr_impressions';

		// ensure the table exists
		$query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $impressions_table ) );
		if ( $wpdb->get_var( $query ) != $impressions_table ) {
			return;
		}

		// ensure the column is not present
		$sql = "SHOW COLUMNS FROM `$impressions_table` LIKE 'session_id';";
		$q = $wpdb->get_row($sql);
		if ($q)
		{
			return;
		}

		$wpdb->query("ALTER TABLE $impressions_table ADD session_id varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL AFTER user_id");
	}

	/**
	 * If current version is 1.2.3 or lower, then alter mzldr_loaders table and change data column to `mediumtext`.
	 * Newer versions skip this as its already included in the SQL of the created tables.
	 * 
	 * @since   1.2.4
	 * 
	 * @return  void
	 */
	private function updateLoadersDataColumnType()
	{
		if (!$this->installed_version)
		{
			return;
		}

		if (version_compare($this->installed_version, '1.2.3', '>'))
		{
			return;
		}

		global $table_prefix, $wpdb;
		$loaders_table = $table_prefix . 'mzldr_loaders';

		// ensure the table exists
		$query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $loaders_table ) );
		if ( $wpdb->get_var( $query ) != $loaders_table )
		{
			return;
		}

		// ensure the column is not present
		$sql = "SHOW COLUMNS FROM `$loaders_table` LIKE 'data';";
		$q = $wpdb->get_row($sql);
		if (!$q)
		{
			return;
		}

		$wpdb->query("ALTER TABLE $loaders_table MODIFY data mediumtext");
	}
}