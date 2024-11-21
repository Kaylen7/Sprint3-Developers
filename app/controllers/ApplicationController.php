<?php

/**
 * Base controller for the application.
 * Add general things in this controller.
 */
class ApplicationController extends Controller 
{
    protected Database $database;

	public function __construct(){
        $this->database = new Database();
    }
    
	public function showModal($title, $message, $button, $redirect = false){
		return "<script>
		document.addEventListener('DOMContentLoaded', () => {
				showModal(
										" . json_encode($title) . ",
						" . json_encode($message) . ",
						" . json_encode($button) . ",
						" . json_encode($redirect) . "
				);
				});
				</script>";
	}
}
