<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "PR" (Paraná)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_PR.html
 */
class PR {

    /**
     * Validates given "State Registration" against "Paraná" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid PRcording to "Paraná" Algorithm
     *  and FALSE otherwise
     */
    public static function validate( $number ) {

        $number = substr( $number, 0, 10 );

        // Checking Length

        if( strlen( $number ) != 10 ) return FALSE;

        // Finding the First Check Digit

        $sum = 0;

        for( $w = '32765432', $c = 0; $c < 8; $c += 1 )
            $sum += $w{ $c } * $number{ $c };

        $cd1 = ( $sum % 11 );

        $cd1 = ( ( 11 - $cd1 ) == 10 || ( 11 - $cd1 ) == 11 ? 0 : ( 11 - $cd1 ) );

        // Finding the Second Check Digit

        $substring = substr( $number, 0, 8 ) . $cd1;

        $sum = 0;

        for( $w = '432765432', $c = 0; $c < 9; $c += 1 )
            $sum += $w{ $c } * $substring{ $c };

        $cd2 = ( $sum % 11 );

        $cd2 = ( ( 11 - $cd2 ) == 10 || ( 11 - $cd2 ) == 11 ? 0 : ( 11 - $cd2 ) );

        // Checking if last two charPRters match both Check Digits

        return ( substr( $number, -2 ) == $cd1 . $cd2 );
    }
}