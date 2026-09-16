<?php 
/**
 * @author 		: Saravana Kumar K
 * @copyright	: Sarkware Research & Development (OPC) Pvt Ltd
 * 
 * @todo		: Wrapper module for all wccpf related Ajax request.
 * 				  All Ajax request target for wccpf will be converted to "wcff_request" object and
 * 				  made available to the context through "wcff()->request".
 * 
 */
if (!defined('ABSPATH')) { exit; }

class wcff_request {
	
	function __construct() {
		add_filter('wcff_request', array($this, 'prepare_request'));
	}
	
	function prepare_request() {
		if (isset($_REQUEST["wcff_param"])) {		    
			$payload = json_decode(str_replace('\"','"', wp_unslash($_REQUEST["wcff_param"])), true);	
			if ($payload) {
			    return array (
			        "method" 	=> isset($payload["method"]) ? sanitize_text_field($payload["method"]) : null,
			        "context" 	=> isset($payload["context"]) ? sanitize_key($payload["context"]) : null,
			        "post" 		=> isset($payload["post"]) ? absint($payload["post"]) : null,
			        "post_type" => isset($payload["post_type"]) ? sanitize_key($payload["post_type"]) : null,
			        "payload" 	=> isset($payload["payload"]) ? $payload["payload"] : null
			    );
			}
			wcff()->response = apply_filters( 'wcff_response', false, json_last_error_msg(), null );
			return false;
		} 
		wcff()->response = apply_filters( 'wcff_response', false, "wcff_param is missing.!", null );
		return false;
	}	
	
}

new wcff_request();

?>