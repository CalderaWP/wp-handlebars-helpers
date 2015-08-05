<?php
/**
 * Adds a "callback" helper for running the selected context through a sanitisation callback.
 *
 * @package calderawp\helpers
 * @author    David Cramer <david@digilab.co.za>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 David Cramer
 */

namespace calderawp\helpers;

/**
 * Class callback
 *
 * @package calderawp\helpers
 */
class callback {
	/**
	 * Execute the callback Helper for Handlebars.php {{callback callback_function [args,]}}
	 *
	 * @param \Handlebars\Template $template The template instance
	 * @param \Handlebars\Context  $context  The current context
	 * @param array                $args     The arguments passed the the helper
	 * @param string               $source   The source
	 *
	 * @return mixed
	 */
	public static function helper( $template, $context, $args, $source ){
		
		$postionalArgs = $template->parseArguments($args);

		$function = array_shift( $postionalArgs );
		$args = array();
		foreach( (array) $postionalArgs as $arg ){
			$args[] = $context->get( $arg );
		}
		ob_start();
		$output = call_user_func_array( $function, $args );
		$has_output = ob_get_clean();
		if( !empty( $has_output ) && !is_bool( $has_output ) ){
			return $has_output;
		}
		return $output;

	}

} 
