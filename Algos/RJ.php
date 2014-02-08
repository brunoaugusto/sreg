<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "RJ" (Rio de Janeiro)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_RJ.html
 */
class RJ {

    /**
     * Validates given "State Registration" against "Rio de Janeiro" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to "Rio de Janeiro" Algorithm
     *  and FALSE otherwise
     */
    public static function validate( $number ) {

        $number = substr( $number, 0, 8 );

        // Checking Length

        if( strlen( $number ) != 8 ) return FALSE;

        // Finding the Check Digit

        $sum = 0;

        for( $w = '2765432', $c = 0; $c < 7; $c += 1 )
            $sum += $number{ $c } * $w{ $c };

        $cd = ( $sum % 11 );

        $cd = ( $cd <= 1 ? 0 : 11 - $cd );

        // Checking if last character match the Check Digit

        return ( $number{ 7 } == $cd );
    }
}