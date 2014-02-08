<?php

spl_autoload_register( function( $classname ) {

	$classname = stream_resolve_include_path(

        str_replace( '\\', DIRECTORY_SEPARATOR, $classname ) . '.php'
    );

    if( $classname !== FALSE ) {

        include $classname;
    }
});

$sr = new StateRegistration( 'GO10.987.654-7' );

var_dump( $sr -> isValid() );