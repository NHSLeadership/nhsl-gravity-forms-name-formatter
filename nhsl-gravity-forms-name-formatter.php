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
				$result['message']  = $result['message'] . 'Your First Name doesn\'t look quite right. Your name should start with a capital letter followed by lower case letters and only contain letters, hyphens, and apostrophes.<br />';

			} // End of If - First Name validation

		// If the middle name is not empty and not hidden then validate the input
		if ( ! empty( $middle ) && ! $field->get_input_property( '4', 'isHidden' ) && ! validate_string( $middle ) ) {

				// Set the result array
				$result['is_valid'] = false;
				$result['message']  = $result['message'] . 'Your Middle Name doesn\'t look quite right. Your name should start with a capital letter followed by lower case letters and only conrain letters, hyphens, and apostrophes.<br />';

			} // End of If - Middle Name validation

		// If the last name is not empty and not hidden then validate the input
		if ( ! empty( $last ) && ! $field->get_input_property( '6', 'isHidden' ) && ! validate_string( $last ) ) {

				// Set the result array
				$result['is_valid'] = false;
				$result['message']  = $result['message'] . 'Your Last Name doesn\'t look quite right. Your name should start with a capital letter followed by lower case letters and only conrain letters, hyphens, and apostrophes.<br />';

			} // End of If - Last Name validation
		            
		} // End of If - Name fields

		// Return the result array
    	return $result;

} // End of validate_name_fields()


// Function to validate a string against a regex pattern
function validate_string( $string_to_validate ){

	// First we need to count how many letters have been entered.
	$string_length = strlen($string_to_validate);

	// Next we need to check how many capital letters are in the string
	$no_of_caps = strlen(preg_replace('/[^A-Z]+/', '', $string_to_validate));

	// Get the percentage of caps in the string
	$percentage_of_caps = ($no_of_caps/$string_length)*100;

	// Next check the string starts with a capital letter if not return false
	$first_letter_cap = preg_match("/[A-Z]/", substr($string_to_validate,0,1));

	// Regex pattern to test against (allows upper and lower case letters along with hyphens and apostrophes)
	$pattern = "/^[\s\da-zA-Z\'-]*$/";

	// Test the passed in string against the regex pattern, check if the percentage of upper case letters is less than 50%,
	// and check the first letter is uppercase
	if (preg_match($pattern, $string_to_validate) && $percentage_of_caps < 50 && $first_letter_cap) {
		
		// If string contains valid characters return true   		
		return true;
	
	} else {
		
		// If string contains invalid characters return false
		return false;
	}

} // End of validate_string()


?>