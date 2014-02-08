<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "RS" (Rio Grande do Sul)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_RS.html
 */
class RS {

    /**
     * Validates given "State Registration" against "Rio Grande do Sul" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to
     * "Rio Grande do Sul" Algorithm and FALSE otherwise
     */
    public static function validate( $number ) {

        $number = substr( $number, 0, 10 );

        // Checking Length

        if( strlen( $number ) != 10 ) return FALSE;

        // Finding the Check Digit

        $sum = 0;

        for( $w = '298765432', $c = 0; $c < 9; $c += 1 )
            $sum += $w{ $c } * $number{ $c };

        $cd = ( $sum % 11 );

        $cd = ( ( 11 - $cd ) == 10 || ( 11 - $cd ) == 11 ? 0 : ( 11 - $cd ) );

        // Checking if last character match the Check Digit

        return ( $number{ 9 } == $cd );
    }
}