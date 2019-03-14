<?php
/*
Plugin Name:  Gravity Forms Name Formatter
Description:  Applies camel case to the first name of the person filling out the form so that their received emails look more friendly. The formatting gets applied on form submission and the changes are persisted in the database. The formatting is applied to just the first name on all forms on the site where the plugin is active. Checks all name fields and validates that they only contain characters such as letters, hyphens, and apostrophes.
Version:      2.0.0
Author:       John Applin
*/
/**
 * Features:
 *  + Formats the first name of the person completing the form to upper case first letter followed by lower case subsequent letters before being stored in the database.
 *  + Validates that all name fields only contain letters, hyphens, and apostrophes.
 *  + Works on all forms whilst the plugin is active.
 
 *
 * Uses:
 *  + Use if you want the users first name to appear more friendly in the automated responses by applying camel case.
 *  + Use if you want all name fields to be validatied for acceptable characters.
 *
 * Possible upgrades:
 *	+ Make the plugin form specific so that the user can select which forms they would like the formatting applied to.
 *	+ Formatting of the users surname but this would need to take into account surname variances such as McDonald and de'Ath etc.
 *
 * @version   2
 * @author    John Applin (john.applin@hee.nhs.uk)
 * @license   GPL-2.0+
 * @link      
 */

// Add a filter to apply validation
add_filter( 'gform_field_validation', 'validate_name_fields' , 10, 4);

// Add the action just before the form data is saved in the database
add_action( 'gform_pre_submission', 'pre_submission_handler' );

// Perform the validation of the name fields
function validate_name_fields( $result, $value, $form, $field ) {
        
    if ( $field->type == 'name' ) {
 
        // Input values
        $first  = rgar( $value, $field->id . '.3' );
        $middle = rgar( $value, $field->id . '.4' );
        $last   = rgar( $value, $field->id . '.6' );
 
        // If the first name is not empty and not hidden then validate the input
		if ( ! empty( $first ) && ! $field->get_input_property( '3', 'isHidden' ) && ! validate_string( $first ) ) {

				// Set the result array
				$result['is_valid'] = false;
				$result['message']  = $result['message'] . 'It looks like you have entered invalid characters for your First Name. Use only letters, hyphens, and apostrophes.<br />';

			} // End of If - First Name validation

		// If the middle name is not empty and not hidden then validate the input
		if ( ! empty( $first ) && ! $field->get_input_property( '4', 'isHidden' ) && ! validate_string( $middle ) ) {

				// Set the result array
				$result['is_valid'] = false;
				$result['message']  = $result['message'] . 'It looks like you have entered invalid characters for your Middle Name. Use only letters, hyphens, and apostrophes.<br />';

			} // End of If - Middle Name validation

		// If the last name is not empty and not hidden then validate the input
		if ( ! empty( $first ) && ! $field->get_input_property( '6', 'isHidden' ) && ! validate_string( $last ) ) {

				// Set the result array
				$result['is_valid'] = false;
				$result['message']  = $result['message'] . 'It looks like you have entered invalid characters for your Last Name. Use only letters, hyphens, and apostrophes.<br />';

			} // End of If - Last Name validation
		            
		} // End of If - Name fields

		// Return the result array
    	return $result;

} // End of validate_name_fields()


// Perform the first name formatting
function pre_submission_handler( $form ) {
        
    // Capitalise the first name
    $_POST['input_1_3'] = capitalise_string( $_POST['input_1_3'] );

} // End of pre_submission_handler()


// Function to apply camel case to a string
function capitalise_string( $string_to_capitalise ) {

    // Capitalise the passed in string
    $capitalised_string = ucfirst(strtolower($string_to_capitalise));

    // Return the newly capitalised string
    return $capitalised_string;

} // End of capitalise_string()


// Function to validate a string against a regex pattern
function validate_string( $string_to_validate ){

	// Regex pattern to test against (allows upper and lower case letters along with hyphens and apostrophes)
	$pattern = "/^[\s\da-zA-Z\'-]*$/";

	// Test the passed in string against the regex pattern
	if (preg_match($pattern, $string_to_validate)) {
		
		// If string contains valid characters return true   		
		return true;
	
	} else {
		
		// If string contains invalid characters return false
		return false;
	}

} // End of validate_string()


?>