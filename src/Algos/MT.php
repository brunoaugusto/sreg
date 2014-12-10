<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "MT" (Mato Grosso)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_MT.html
 */
class MT {

    /**
     * Validates given "State Registration" against "Mato Grosso" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to
     *  "Mato Grosso" Algorithm and FALSE otherwise
     */
    public static function validate( $number ) {

        $number = substr( $number, 0, 11 );

        // Checking Length

        if( strlen( $number ) != 11 ) return FALSE;

        // Finding the Check Digit

        $sum = 0;

        for( $w = '3298765432', $c = 0; $c < 10; $c += 1 )
            $sum += $w{ $c } * $number{ $c };

        $cd = ( $sum % 11 );

        $cd = ( $cd == 0 || $cd == 1 ? 0 : ( 11 - $cd ) );

        // Checking if last character match the Check Digit

        return ( $number{ 10 } == $cd );
    }
}