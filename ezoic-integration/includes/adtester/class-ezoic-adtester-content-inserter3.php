<?php

namespace Ezoic_Namespace;

class Ezoic_AdTester_Content_Inserter3 extends Ezoic_AdTester_Inserter {
    public function __construct( $config ) {
        if ( explode( '.', PHP_VERSION ) >= 8 ) {
            require_once( dirname( __FILE__ ) . '/../vendor/phpQuery_8.php' );
        } else {
            require_once( dirname( __FILE__ ) . '/../vendor/phpQuery.php' );
        }

        parent::__construct( $config );
    }

    /**
     * Inserts placeholders into content
     */
    public function insert( $content ) {
        // Validation
        if ( !isset( $content ) || \ez_strlen( $content ) === 0 ) {
            return $content;
        }

        $rules = array();

        foreach ( $this->config->placeholder_config as $ph_config ) {
			if ( $ph_config->page_type == $this->page_type ) {
				$rules[ $ph_config->placeholder_id ] = $ph_config;
			}
		}

		// Stop processing if there are no rules to process for this page
		if ( \count( $rules ) === 0 ) {
			return $content;
		}

		// Sort rules based on paragraph order
		\usort( $rules, function( $a, $b ) { if ( (int) $a->display_option < (int) $b->display_option ) { return -1; } else { return 1; } } );

        // Push rules into a map indexed based on paragraph number
        $ruleMap = array();
        foreach ( $rules as $rule ) {
            if ( stripos( $rule->display, '_paragraph' ) > -1 ) {
                $index = \intval( $rule->display_option );
                $ruleMap[ $index ] = $rule;
            }
        }

        // Parse document
		\libxml_use_internal_errors( true );
		$parsed = \phpQuery::newDocumentHTML( $content );
		\libxml_use_internal_errors( false );

		// Extract all paragraph tags
        $excluder = ':not(' . \implode( ' *, ', $this->config->parent_filters ) . ' *)';
        $selector = \implode( $excluder . ', ', $this->config->paragraph_tags ) . $excluder;

        $nodes = @\pq( $selector );

        $nodeIdx = 0;
        foreach ( $nodes as $node ) {
            if ( isset( $ruleMap[ $nodeIdx ] ) ) {
                $insertion_rule = $ruleMap[ $nodeIdx ];
                $placeholder = $this->config->placeholders[ $insertion_rule->placeholder_id ];

                switch ( $insertion_rule->display ) {
					case 'before_paragraph':
                        \pq( $node )->prepend( $placeholder->embed_code( 3 ) );
						break;

					case 'after_paragraph':
                        \pq( $node )->append( $placeholder->embed_code( 3 ) );
						break;
				}
            }

            $nodeIdx++;
        }

        $result = $parsed->htmlOuter();

        return $result;
    }
}