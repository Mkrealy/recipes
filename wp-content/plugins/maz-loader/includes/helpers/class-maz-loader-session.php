<?php

/**
 * Session
 *
 * @link       https://www.feataholic.com
 * @since      1.4.1 Free
 *
 * @package    MZLDR
 * @subpackage MZLDR/includes/helpers
 */

/**
 * Session
 *
 * @since      1.4.1 Free
 * @package    MZLDR
 * @subpackage MZLDR/includes/helpers
 * @author     Stergos Zamagias <stergosz1@gmail.com>
 */

class MZLDR_Session
{
    /**
     * The session id
     * 
     * @var  string
     */
    private $session_id;

	/**
	 * Get Session ID
	 * 
	 * @return  string
	 */
    public function getSessionID()
    {
        if (!$this->session_id)
        {
            $this->setSessionID();
        }
        
		return $this->session_id;
    }

	/**
	 * Determines if we should start sessions
	 *
	 * @return bool
	 */
	public static function should_start_session() {

		$start_session = true;

		if( ! empty( $_SERVER[ 'REQUEST_URI' ] ) ) {

			$blacklist = self::get_blacklist();
			$uri       = ltrim( $_SERVER[ 'REQUEST_URI' ], '/' );
			$uri       = untrailingslashit( $uri );

			if( in_array( $uri, $blacklist ) ) {
				$start_session = false;
			}

			if( false !== strpos( $uri, 'feed=' ) ) {
				$start_session = false;
			}

			if( is_admin() && false === strpos( $uri, 'wp-admin/admin-ajax.php' ) ) {
				// We do not want to start sessions in the admin unless we're processing an ajax request
				$start_session = false;
			}

			if( false !== strpos( $uri, 'wp_scrape_key' ) ) {
				// Starting sessions while saving the file editor can break the save process, so don't start
				$start_session = false;
			}

		}

		return $start_session;

    }
    
	/**
	 * Retrieve the URI blacklist
	 *
	 * These are the URIs where we never start sessions
	 *
	 * @return array
	 */
	public static function get_blacklist() {

		$blacklist = array(
			'feed',
			'feed/rss',
			'feed/rss2',
			'feed/rdf',
			'feed/atom',
			'comments/feed'
		);

		// Look to see if WordPress is in a sub folder or this is a network site that uses sub folders
		$folder = str_replace( network_home_url(), '', get_site_url() );

		if( ! empty( $folder ) ) {
			foreach( $blacklist as $path ) {
				$blacklist[] = $folder . '/' . $path;
			}
		}

		return $blacklist;
    }
    
    /**
     * Sets the session ID
     * 
     * @param   string  $session_id
     * 
     * @return  void
     */
    public function setSessionID($session_id = null)
    {
        if (!$session_id)
        {
            $this->session_id = session_id();
            return;
        }

        $this->session_id = $session_id;
    }
}