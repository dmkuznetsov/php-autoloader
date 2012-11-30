<?php
/**
 * @author Dmitry Kuznetsov 2012
 * @url https://github.com/dmkuznetsov/php-class-map
 */
abstract class ClassMap_Log
{
	/**
	 * @var bool
	 */
	protected $_verboseMode;

	/**
	 * (PHP 4, PHP 5)<br/>
	 * Return a formatted string
	 * @link http://php.net/manual/en/function.sprintf.php
	 * @param string $format <p>
	 * The format string is composed of zero or more directives:
	 * ordinary characters (excluding %) that are
	 * copied directly to the result, and conversion
	 * specifications, each of which results in fetching its
	 * own parameter. This applies to both sprintf
	 * and printf.
	 * </p>
	 * <p>
	 * Each conversion specification consists of a percent sign
	 * (%), followed by one or more of these
	 * elements, in order:
	 * An optional sign specifier that forces a sign
	 * (- or +) to be used on a number. By default, only the - sign is used
	 * on a number if it's negative. This specifier forces positive numbers
	 * to have the + sign attached as well, and was added in PHP 4.3.0.
	 * @param mixed $args [optional] <p>
	 * </p>
	 * @param mixed $_ [optional]
	 * @return string a string produced according to the formatting string
	 * format.
	 */
	abstract public function log();

	/**
	 * @param string $name
	 * @throws Exception
	 * @return self
	 */
	public static function get( $name = 'None' )
	{
		$files = glob( dirname( __FILE__ ) . '/Log/*.php' );
		foreach ( $files as $filePath )
		{
			$fileName = pathinfo( $filePath, PATHINFO_FILENAME );
			if ( strcasecmp( $name, $fileName ) == 0 )
			{
				$className = sprintf( 'ClassMap_Log_%s', $name );
				require $filePath;
				return new $className();
			}
		}
		throw new Exception( 'Not found ClassMap_Log_' . $name );
	}

	public function setVerbose( $verbose )
	{
		$this->_verboseMode = $verbose ? true : false;
	}
}