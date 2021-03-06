<?php
/*
Plugin Name:  Gravity Forms Name Formatter
Description:  Applies camel case to the first name of the person 
filling out the form so that their received emails look more friendly. 
The formatting gets applied on form submission and the changes are 
persisted in the database. 
The formatting is applied to just the first name on form 16 
on the site where the plugin is active.
Version:      1.0.1
Author:       John Applin, Andrew Blane
*/
/**
 * Features:
 *  + Formats the first name of the person completing the form to upper case 
 *  first letter followed by lower case subsequent letters before being stored
 *  in the database.
 *  + Works on form 16 whilst the plugin is active.
 *
 * Uses:
 *  + Use if you want the users first name to appear more friendly in the 
 *  automated responses by applying camel case.
 *
 * Possible upgrades:
 *	+ Formatting of the users surname but this would need to take into account
 *  surname variances such as McDonald and de'Ath etc.
 *
 * @version   1.0.1
 * @author    John Applin (john.applin@hee.nhs.uk), Andrew Blane (ajblane@gmail.com)
 * @license   GPL-2.0+
 * @link      
 */

// Add the action just before the form data is saved in the database
add_action( 'gform_pre_submission_16', 'pre_submission_handler' );

// Perform the first name formatting
function pre_submission_handler( $form ) {
        
    // Capitalise the first name (if found in field 1.3)
    if (isset($_POST['input_1_3'])) {
      $_POST['input_1_3'] = capitalise_string( $_POST['input_1_3'] );
    }

}

// Function to apply camel case to a string
function capitalise_string( $string_to_capitalise ) {

    // Capitalise the passed in string
    $capitalised_string = ucfirst(strtolower($string_to_capitalise));

    // Return the newly capitalised string
    return $capitalised_string;
}


?>