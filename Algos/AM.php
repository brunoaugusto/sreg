<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "AM" (Amazonas)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_AM.html
 */
class AM {

    /**
     * Validates given "State Registration" against "Amazonas" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to
     * "Amazonas" Algorithm and FALSE otherwise
     */
    public static function validate( $number ) {

        $number = substr( $number, 0, 9 );

        // Checking Length

        if( strlen( $number ) != 9 ) return FALSE;

        // Finding the Check Digit

        $sum = 0;

        for( $w = '98765432', $c = 0; $c < 8; $c += 1 )
            $sum += $w{ $c } * $value{ $c };

        if( $sum < 11 ) {

            $cd = ( 11 - $sum );

        } else {

            $cd = ( ( $sum % 11 ) <= 1 ? 0 : 11 - ( $sum % 11 ) );
        }

        // Checking if last character match the Check Digit

        return ( $number{ 8 } == $cd );
    }
}