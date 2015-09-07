<?php

// global variable to allow registering additional commands
$GLOBALS['awwCommands'] = array();

if( file_exists( __DIR__ . '/../../autoload.php' ) ) {
    // addwiki is part of a composer installation
    require_once __DIR__ . '/../../autoload.php';
} else {
    require_once __DIR__ . '/vendor/autoload.php';
}

$awwConfig = new Mediawiki\Bot\Config\AppConfig( __DIR__  );
$awwApp = new Symfony\Component\Console\Application( 'aww - addwiki bot' );

$awwApp->addCommands( array(
	new Mediawiki\Bot\Commands\Config\Setup( $awwConfig ),
	new Mediawiki\Bot\Commands\Config\ConfigList( $awwConfig ),
	new Mediawiki\Bot\Commands\Config\SetDefaultWiki( $awwConfig ),
	new Mediawiki\Bot\Commands\Config\SetDefaultUser( $awwConfig ),
	new Mediawiki\Bot\Commands\Task\RestoreRevisions( $awwConfig ),
	new Mediawiki\Bot\Commands\Task\Purge( $awwConfig ),
) );

$awwApp->addCommands( $GLOBALS['awwCommands'] );

if( $awwConfig->isEmpty() ) {
	$awwApp->setDefaultCommand( 'config:setup' );
}

$awwApp->run();