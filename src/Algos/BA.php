<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "BA" (Bahia)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_BA.html
 *
 * @version : 1.2
 * @author Mangierre Martins <mangierre@gmail.com>
 */
class BA {

    /**
     * Validates given "State Registration" against "Bahia" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to "Bahia" Algorithm
     *  and FALSE otherwise
     */
    public static function validate( $number ) {
 
         /**
         * "Bahia" now has two different Algorithms based on "State Registration"
         * length.
         */
        if( ! self::useEightDigits( $number ) ) {

            return self::useNineDigits( $number );
        }

        return TRUE;
    }

    private static function useEightDigits( $number ) {

        $number = substr( $number, 0, 8 );

        // Checking Length

        if( strlen( $number ) != 8) return FALSE;

        // Algorithm Rule: Defining the Modulus according to First Digit

        $modulus = ( in_array( $number{0}, array( 0, 1, 2, 3, 4, 5, 8 ) ) ? 10 : 11 );

        // Finding the Second Check Digit

        $sum = 0;

        for( $w = '765432', $c = 0; $c < 6; $c += 1 )
            $sum += $w{ $c } * $number{ $c };

        $cd2  = ( $sum % $modulus );

        $cd2  = ( $cd2 == 0 ? 0 : ( $modulus - $cd2 ) );

        // Finding the First Check Digit

        $sum = 0;

        /**
         * Algorithm Rule: Apply weights to first 5 digits and the last one:
         *
         * _ _ _ _ _ - X _
         *
         * This "jump" is done after the loop and its weight is 2
         */
        for( $w = '876543', $c = 0; $c < 6; $c += 1 )
            $sum  +=  $w{ $c } * $number{ $c };

        $sum = ( $sum + ( $number{ 7 } * 2 ) );

        $cd1 = ( $sum % $modulus );

        $cd1 = ( $modulus - ( $sum % $modulus ) );

        // Checking if last two characters match both Check Digits

        return ( substr( $number, -2 ) == $cd1 . $cd2 );
    }

    private static function useNineDigits( $number ) {

        $number = substr( $number, 0, 9 );

        if( strlen( $number ) != 9) return FALSE;
        
        // Algorithm Rule: Defining the Modulus according to Second Digit

        $modulus = ( in_array( $number{0}, array( 0, 1, 2, 3, 4, 5, 8 ) ) ? 10 : 11 );

        // Finding the Second Check Digit

        $sum = 0;

        for( $w = '8765432', $c = 0; $c < 7; $c += 1 )
            $sum += $w{ $c } * $number{ $c };

        $cd2  = ( $sum % $modulus );

        $cd2  = ( $cd2 == 0 ? 0 : ( $modulus - $cd2 ) );

        // Finding the First Check Digit

        $sum = 0;

        /**
         * Algorithm Rule: Apply weights to first 5 digits and the last one:
         *
         * _ _ _ _ _ - X _
         *
         * This "jump" is done after the loop and its weight is 2
         */

        for( $w = '9876543', $c = 0; $c < 7; $c += 1 )
            $sum  +=  $w{ $c } * $number{ $c };

        $sum += ( $number{ 8 } * 2 );

        $cd1 = ( $sum % $modulus );

        $cd1  = ( $cd1 == 0 || $cd1 == 1 ? 0 : ( $modulus - $cd1 ));

        // Checking if last two characters match both Check Digits

        return ( substr( $number, -2 ) == $cd1 . $cd2 );
    }
}