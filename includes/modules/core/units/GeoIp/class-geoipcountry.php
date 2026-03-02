<?php
/**
 * Created by PhpStorm.
 * User: sjhc1170
 * Date: 20/04/2017
 * Time: 08:55
 */

namespace Iriven;

use ZipArchive;
use SplFileObject;

/**
 * Class GeoIPCountry
 * @package Iriven\GeoIPCountry
 */
class GeoIPCountry {

	const DOWNLOAD_LINK        = 'http://software77.net/geo-ip/?DL=%s';
	const DOWNLOADED_FILE      = 'GeoIP';
	const DS                   = DIRECTORY_SEPARATOR;
	private $data_location     = null;
	private $edit_mode_enabled = false;
	private $iso_code          = null;
	private $ip_package_id     = [
		'ipv4' => '1',
		'ipv6' => '7',
	];
	private $package_location  = null;
	private $package_name      = self::DOWNLOADED_FILE;
	private $update_url        = self::DOWNLOAD_LINK;

	/**
	 * GeoIPCountry constructor.
	 */
	public function __construct() {
		$this->package_location = realpath( $this->get_storage_path() );
		$this->data_location    = realpath( $this->get_storage_path( false ) );
		$this->prepare_lookup();
	}

	/**
	 * @return $this
	 */
	public function admin() {
		$this->edit_mode_enabled = true;
		return $this;
	}

	/**
	 * @return $this
	 */
	private function download_package() {
		if ( $this->edit_mode_enabled ) {
			set_time_limit( 0 ); //prevent timeout
			try {
				foreach ( $this->ip_package_id as $ip_version => $package_id ) {
					$archive  = $this->package_location . self::DS . $this->package_name;
					$archive .= ( 'ipv6' === $ip_version ) ? '6R.csv.gz' : '.csv.gz';
					if ( ! file_exists( $archive ) ) {
						$url     = sprintf( $this->update_url, $package_id );
						$curl    = curl_init(); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_init
						$handler = fopen( $archive, 'w+' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen
						curl_setopt( $curl, CURLOPT_URL, str_replace( ' ', '%20', $url ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt
						curl_setopt( $curl, CURLOPT_FILE, $handler ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt -- auto write to file
						curl_setopt( $curl, CURLOPT_TIMEOUT, 5040 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt
						curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt
						if ( false === curl_exec( $curl ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_exec
							throw new \Exception( curl_error( $curl ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_error
						}
						curl_close( $curl ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_close
						fclose( $handler ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
					}
				}
			} catch ( \Exception $e ) {
				trigger_error( $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error,WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
		return $this;
	}

	/**
	 * If IPV6, Returns the IP in it's fullest format.
	 * @example
	 *          ::1              => 0000:0000:0000:0000:0000:0000:0000:0001
	 *          220F::127.0.0.1  => 220F:0000:0000:0000:0000:0000:7F00:0001
	 *          2F:A1::1         => 002F:00A1:0000:0000:0000:0000:0000:0001
	 * @param $ip
	 * @return mixed|string
	 */
	private function expand_ip_address( $ip ) {
		if ( false !== strpos( $ip, ':' ) ) {
			$hex = unpack( 'H*hex', inet_pton( $ip ) );
			$ip  = substr( preg_replace( '/([A-f0-9]{4})/', '$1:', $hex['hex'] ), 0, -1 );
			$ip  = strtoupper( $ip );
		}
		return $ip;
	}
	/**
	 * @param $ip
	 * @return null|string
	 */
	private function get_ip_range_provider_file( $ip ) {
		try {
			if ( ! preg_match( '/[.:]/', $ip ) ) {
				$ip = $this->long2ip( $ip, false );
			}
			if ( ! filter_var( $ip, FILTER_VALIDATE_IP, [ FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 ] ) ) {
				throw new \Exception( 'Invalid IP given' );
			}
			$delimiter = ( false === strpos( $ip, ':' ) ) ? '.' : ':';
			$db_file   = current( explode( $delimiter, $ip ) ) . '.php';
			return $db_file;
		} catch ( \Exception $e ) {
			trigger_error( $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error,WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		return null;
	}
	/**
	 * @param bool $is_archive
	 * @return string
	 */
	private function get_storage_path( $is_archive = true ) {
		$tmp = ( ini_get( 'upload_tmp_dir' ) ? ini_get( 'upload_tmp_dir' ) : sys_get_temp_dir() );
		if ( ! $is_archive ) {
			$tmp = rtrim( __DIR__, self::DS );
		}
		try {
			if ( ! is_writeable( $tmp ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_is_writeable
				throw new \Exception( sprintf( 'The required destination path is not writable: %s', $tmp ) );
			}
		} catch ( \Exception $e ) {
			trigger_error( $e->getMessage(), E_USER_ERROR ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error,WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		$tmp .= self::DS . ( $is_archive ? 'GeoIPCountry' : 'GeoIPDatas' );
		if ( ! is_dir( $tmp ) ) {
			mkdir( $tmp, '0755', true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_mkdir
		}
		return $tmp;
	}
	/**
	 * Convert both IPV4 and IPv6 address to an integer
	 * @param $ip
	 * @return mixed|string
	 */
	private function ip2long( $ip ) {
		$decimal = null;
		$ip      = $this->expand_ip_address( $ip );
		try {
			switch ( $ip ) :
				case ( false !== strpos( $ip, '.' ) ):
					if ( ! filter_var( $ip, FILTER_VALIDATE_IP, [ FILTER_FLAG_IPV4 ] ) ) {
						throw new \Exception( 'Invalid IPV4 given' );
					}
					$decimal .= ip2long( $ip );
					break;
				case ( false !== strpos( $ip, ':' ) ):
					if ( ! filter_var( $ip, FILTER_VALIDATE_IP, [ FILTER_FLAG_IPV6 ] ) ) {
						throw new \Exception( 'Invalid IPV6 given' );
					}
					$network = inet_pton( $ip );
					$parts   = unpack( 'C*', $network );
					foreach ( $parts as &$byte ) {
						$decimal .= str_pad( decbin( $byte ), 8, '0', STR_PAD_LEFT );
					}
					break;
				default:
					throw new \Exception( $ip . ' is not a valid IP address' );
			endswitch;
		} catch ( \Exception $e ) {
			trigger_error( $e->getMessage(), E_USER_ERROR ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error,WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		return $decimal;
	}
	/**
	 * Convert an IP address from decimal format to presentation format
	 *
	 * @param $decimal
	 * @param bool $compress
	 * @return mixed|string
	 */
	private function long2ip( $decimal, $compress = true ) {
		$ip = null;
		if ( preg_match( '/[.:]/', $decimal ) ) {
			return strtoupper( $decimal );
		}
		switch ( $decimal ) :
			case ( strlen( $decimal ) <= 32 ):
				$ip .= long2ip( $decimal );
				break;
			default:
				$pad = 128 - strlen( $decimal );
				for ( $i = 1; $i <= $pad; $i++ ) {
					$decimal = '0' . $decimal;
				}
				for ( $bits = 0; $bits <= 7; $bits++ ) {
					$bin_part = substr( $decimal, ( $bits * 16 ), 16 );
					$ip      .= dechex( bindec( $bin_part ) ) . ':';
				}
				$ip = inet_ntop( inet_pton( substr( $ip, 0, -1 ) ) );
				break;
		endswitch;
		$ip = strtoupper( $ip );
		return $compress ? $ip : $this->expand_ip_address( $ip );
	}
	/**
	 * @param null $ip
	 * @return bool
	 */
	public function is_reserved_ip( $ip = null ) {
		if ( $ip ) {
			$this->resolve( $ip );
		}
		return ! $this->iso_code || 0 === strcasecmp( $this->iso_code, 'ZZ' );
	}
	/**
	 * @return $this
	 */
	private function prepare_lookup() {
		$total_range_files = count( glob( $this->data_location . '/*[0-9]*.php' ) );
		if ( $total_range_files < 332 ) {
			$this->admin()->update_database();
			$this->edit_mode_enabled = false;
		}
		return $this;
	}
	/**
	 * @param null $ip
	 * @return null|string
	 */
	public function resolve( $ip = null ) {
		try {
			if ( ! $ip ) {
				$ip = $this->get_remote_ip();
			}
			if ( ! preg_match( '/[.:]/', $ip ) ) {
				$ip = $this->long2ip( $ip );
			}
			$ip = $this->expand_ip_address( $ip );
			if ( ! filter_var( $ip, FILTER_VALIDATE_IP, [ FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 ] ) ) {
				throw new \Exception( 'Invalid IP given' );
			}
			$ip_filename  = $this->get_ip_range_provider_file( $ip );
			$ip_long      = $this->ip2long( $ip );
			$ip_file_path = realpath( $this->data_location . self::DS . $ip_filename );
			if ( ! file_exists( $ip_file_path ) ) {
				throw new \Exception( 'IP Ranges provider file not found' );
			}
			$ip_ranges = include $ip_file_path;
			foreach ( $ip_ranges as $range ) :
				if ( ! is_array( $range ) || count( $range ) !== 3 ) {
					continue;
				}
				if ( preg_match( '/^[01]+$/', $ip_long ) ) {
					$range[0] = $this->ip2long( $range[0] );
					$range[1] = $this->ip2long( $range[1] );
				}
				if ( $range[1] < $ip_long ) {
					continue;
				}
				if ( ( $range[0] <= $ip_long ) ) {
					$this->iso_code = ( $range[2] ? $range[2] : 'ZZ' );
					break;
				}
			endforeach;
		} catch ( \Exception $e ) {
			trigger_error( $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error,WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		return $this->iso_code;
	}

	/**
	 * Auto Get the current visitor IP Address
	 * @return string
	 */
	private function get_remote_ip() {
		$ip             = null;
		$server_ip_keys = [
			'HTTP_X_COMING_FROM',
			'HTTP_FORWARDED',
			'HTTP_FORWARDED_FOR',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_X_FORWARDED',
			'HTTP_VIA',
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'REMOTE_ADDR',
		];
		foreach ( $server_ip_keys as $ip_key ) :
			if ( array_key_exists( $ip_key, $_SERVER ) ) {
				if ( ! strlen( $_SERVER[ $ip_key ] ) ) {
					continue;
				}
				$ip = $_SERVER[ $ip_key ];
				break;
			}
		endforeach;
		$comma_pos = strpos( $ip, ',' );
		if ( $comma_pos > 0 ) {
			$ip = substr( $ip, 0, ( $comma_pos - 1 ) );
		}
		return ( $ip ? $ip : '0.0.0.0' );
	}
	/**
	 * @return $this
	 */
	public function update_database() {
		if ( $this->edit_mode_enabled ) {
			$this->download_package()->extract_archive();
			$extracted_file_name = pathinfo( $this->package_name, PATHINFO_FILENAME );
			$extracted_files     = glob( $this->package_location . self::DS . $extracted_file_name . '*.csv' );
			if ( $extracted_files ) {
				set_time_limit( 0 ); //prevent timeout
				foreach ( $extracted_files as $extracted_file ) :
					$files = [];
					foreach ( new SplFileObject( $extracted_file ) as $line ) {
						if ( '#' === substr( $line, 0, 1 ) ) {
							continue;
						}
						$line = str_replace( '"', '', $line );
						$temp = explode( ',', $line );
						if ( count( $temp ) < 4 ) {
							continue;
						}
						$filename = null;
						$ip_min   = null;
						$ip_max   = null;
						$alpha2   = null;
						switch ( $temp[0] ) :
							case ( false !== strpos( $temp[0], '-' ) ):
								list($ip_min, $ip_max) = explode( '-', $temp[0] );
								$alpha2                = $temp[1];
								$filename              = current( explode( ':', $this->expand_ip_address( $ip_min ) ) ) . '.php';
								break;
							default:
								if ( count( $temp ) < 7 ) {
									break;
								}
								$ip_min   = (int) $temp[0];
								$ip_max   = (int) $temp[1];
								$alpha2   = $temp[4];
								$filename = current( explode( '.', $this->long2ip( $ip_min ) ) ) . '.php';
								break;
						endswitch;
						$data_file    = $this->package_location . self::DS . $filename;
						$files[]      = $filename;
						$file_content = null;
						if ( ! file_exists( $data_file ) ) {
							$file_content .= '<?php' . PHP_EOL;
							$file_content .= 'return [' . PHP_EOL;
						}
						$file_content .= '[\'' . $ip_min . '\', \'' . $ip_max . '\', \'' . $alpha2 . '\'],' . PHP_EOL;
						file_put_contents( $data_file, $file_content, FILE_APPEND | LOCK_EX ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
					}
					if ( $files ) :
						foreach ( $files as $file ) {
							$source      = $this->package_location . self::DS . $file;
							$destination = $this->data_location . self::DS . $file;
							if ( ! file_exists( $source ) ) {
								continue;
							}
							$source_content = '];';
							file_put_contents( $source, $source_content, FILE_APPEND | LOCK_EX ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
							rename( $source, $destination ); // phpcs:ignore WordPress.WP.AlternativeFunctions.rename_rename
							@chmod( $destination, 0644 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged,WordPress.WP.AlternativeFunctions.file_system_operations_chmod
						}
					endif;
					if ( file_exists( $extracted_file ) ) {
						@unlink( $extracted_file ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged,WordPress.WP.AlternativeFunctions.unlink_unlink
					}
				endforeach;
			}
			$this->edit_mode_enabled = false;
		}
		return $this;
	}

	/**
	 * @param null $file
	 * @return $this
	 */
	private function extract_archive( $file = null ) {
		if ( $this->edit_mode_enabled ) {
			if ( $file ) {
				$this->package_name = pathinfo( realpath( $file ), PATHINFO_FILENAME );
			}
			try {
				$packages = array_filter( glob( $this->package_location . self::DS . $this->package_name . '*.{gz,zip}', GLOB_BRACE ), 'is_file' );
				if ( $packages ) {
					$buffer_size = 4096;
					$package     = null;
					foreach ( $packages as $package_file ) :
						$package_ext = pathinfo( $package_file, PATHINFO_EXTENSION );
						if ( ! in_array( strtolower( $package_ext ), [ 'zip', 'gz' ], true ) ) {
							continue;
						}
						$extracted_filename = pathinfo( $package_file, PATHINFO_FILENAME ) . '.csv';
						$extracted_file     = realpath( $this->package_location ) . self::DS . $extracted_filename;
						switch ( $package_ext ) :
							case ( 0 === strcasecmp( $package_ext, 'gz' ) ):
								$file    = gzopen( $package_file, 'rb' );
								$handler = fopen( $extracted_file, 'wb' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen
								while ( ! gzeof( $file ) ) {
									fwrite( $handler, gzread( $file, $buffer_size ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fwrite
								}
								fclose( $handler ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
								gzclose( $file );
								break;
							case ( 0 === strcasecmp( $package_ext, 'zip' ) ):
								$zip = new ZipArchive();
								if ( false !== $zip->open( $package_file ) ) {
									for ( $i = 0; $i < $zip->numFiles; $i++ ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
										$filename = $zip->getNameIndex( $i );
										if ( 0 === strcasecmp( pathinfo( $filename, PATHINFO_EXTENSION ), 'csv' ) ) {
											copy( 'zip://' . $package_file . '#' . $filename, $extracted_file );
										}
									}
									$zip->close();
								}
								break;
							default:
								throw new \Exception( 'The Downloaded package must be a zip or gz file: "' . $package_ext . '" file given' );
						endswitch;
						if ( file_exists( $package_file ) ) {
							@unlink( $package_file ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged,WordPress.WP.AlternativeFunctions.unlink_unlink
						}
					endforeach;
				}
			} catch ( \Exception $e ) {
				trigger_error( $e->getMessage(), E_USER_ERROR ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error,WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
		return $this;
	}
}
