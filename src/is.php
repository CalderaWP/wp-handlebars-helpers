<?php

/**
 * Adds a "is" helper for conditional checks.
 *
 * @package calderawp\helpers
 * @author    David Cramer <david@digilab.co.za>
 * @license   GPL-2.0+
 * @link
 * @copyright 2014 David Cramer
 */

namespace calderawp\helpers;

/**
 * Class is
 *
 * @package calderawp\helpers
 */
class is {
	/**
	 * Execute the is Helper for Handlebars.php {{#is variable value}} code {{else}} alt code {{/is}}
	 * based off the IfHelper
	 *
	 * @param \Handlebars\Template $template The template instance
	 * @param \Handlebars\Context  $context  The current context
	 * @param array                $args     The arguments passed the the helper
	 * @param string               $source   The source
	 *
	 * @return mixed
	 */
	public static function helper( $template, $context, $args, $source ){

		$parts = explode(' ', $args);
		$args = $parts[0];
		$value = $parts[1];

		if ( is_string( $args ) && in_array( $args, self::if_checks() ) ) {
			if ( call_user_func( $args ) ) {
				return $source;
			}else{
				return null;
			}

		}

		if (is_numeric($args)) {
			$tmp = $args;
		} else {
			$tmp = $context->get($args);
		}

		$context->push($context->last());
		if ($tmp === $value) {
			$template->setStopToken('else');
			$buffer = $template->render($context);
			$template->setStopToken(false);
			$template->discard($context);
		} else {
			$template->setStopToken('else');
			$template->discard($context);
			$template->setStopToken(false);
			$buffer = $template->render($context);
		}
		$context->pop();

		return $buffer;

	}

	/**
	 * Conditional checks to use with if
	 *
	 * @since 0.2.0
	 *
	 * @return array
	 */
	protected static function if_checks() {
		return array(
			'is_user_logged_in',
			'is_single',
			'is_singular',
			'is_post_type_archive',
			'is_page',
			'is_front_page',
			'is_home',
			'is_tax'
		);


	}
} 
