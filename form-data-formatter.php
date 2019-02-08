<?php
/*
Plugin Name:  Gravity Forms Name Formatter
Description:  Formats the first and last name of the person filling out the form so that their received emails look more friendly
Version:      1.0.0
Author:       John Applin
*/
/**
 * Features:
 *  + Formats the first and last name of the person completing the form to upper case first letter followed by lower case letters
 *
 * Uses:
 *  + Use if you want the users first and last name to appear more friendly in the automated responses
 *
 * @version   1
 * @author    John Applin (john.applin@hee.nhs.uk)
 * @license   GPL-2.0+
 * @link      
 */


add_action( 'gform_pre_submission', 'pre_submission_handler' );


function pre_submission_handler( $form ) {
        
        // Capitalise first name
        $_POST['input_1_3'] = capitalise_string($_POST['input_1_3']);

}
    
function capitalise_string($string_to_capitalise) {

    // Capitalise the passed in string
    $capitalised_string = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($string_to_capitalise))));

    return $capitalised_string;
}


?>