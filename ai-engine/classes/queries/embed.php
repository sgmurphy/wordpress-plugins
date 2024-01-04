<?php

class Meow_MWAI_Query_Embed extends Meow_MWAI_Query_Base {
  
  public function __construct( $messageOrQuery = null, ?string $model = 'text-embedding-ada-002' ) {
		if ( is_a( $messageOrQuery, 'Meow_MWAI_Query_Text' ) || is_a( $messageOrQuery, 'Meow_MWAI_Query_Assistant' ) ) {
			$lastMessage = $messageOrQuery->get_message();
			if ( !empty( $lastMessage ) ) {
				$this->set_message( $lastMessage );
			}
			$this->set_model( $model );
			$this->mode = 'embedding';
			$this->session = $messageOrQuery->session;
			$this->scope = $messageOrQuery->scope;
			$this->apiKey = $messageOrQuery->apiKey;
			$this->botId = $messageOrQuery->botId;
			$this->envId = $messageOrQuery->envId;
		}
		else {
			parent::__construct( $messageOrQuery ? $messageOrQuery : '' );
    	$this->set_model( $model );
			$this->mode = 'embedding';
		}
  }
}