<?php
/**
 * Usage:
 * php map.php --help
 * @author Dmitry Kuznetsov 2012
 * @url https://github.com/dmkuznetsov/php-class-map
 */
require_once dirname( __FILE__ ) . '/classes/ClassMap.php';
require_once dirname( __FILE__ ) . '/classes/Writer.php';
require_once dirname( __FILE__ ) . '/classes/Log.php';
require_once dirname( __FILE__ ) . '/classes/Progress.php';

$options = getopt( '', array( 'dir:', 'file:', 'verbose', 'help' ) );
if ( array_key_exists( 'help', $options ) )
{
	help();
}
checkOptions( $options );

$verbose = false;
if ( array_key_exists( 'verbose', $options ) )
{
	$verbose = true;
}

$log = ClassMap_Log::get( 'Console' );
$log->setVerbose( $verbose );

$classMap = new ClassMap( $options[ 'dir' ], $log, ClassMap_Progress::get( 'Console' ) );
$classMap->run();

$writer = new ClassMap_Writer( $classMap->getMap(), $log );
$writer->save( $options[ 'file' ] );

exit( "\n" );

/**
 * @param array $options
 */
function checkOptions( array $options )
{
	$messages = array();
	if ( !array_key_exists( 'file', $options ) )
	{
		$messages[ ] = 'Please specify file for input data.' . "\n";
	}
	if ( !array_key_exists( 'dir', $options ) )
	{
		$messages[ ] = 'Please specify dir for analyze.' . "\n";
	}
	if ( !empty( $messages ) )
	{
		array_unshift( $messages, 'ERROR!' );
		showMessage( $messages, false );
		help();
	}
}

function help()
{
	$content = file_get_contents( dirname( __FILE__ ) . '/README.md' );
	showMessage( $content );
}

function showMessage( $message, $stop = true )
{
	if ( is_array( $message ) )
	{
		$message = implode( "\n", $message );
	}
	echo $message . "\n";
	if ( $stop )
	{
		exit;
	}
}