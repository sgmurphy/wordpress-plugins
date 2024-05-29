<?php

namespace AgeGate\Integration;

use AgeGate\Common\Integration;

class Woof extends Integration
{
    public function exists()
    {
        return class_exists('WOOF');
    }

    public function init()
    {
        if ($this->exists()) {
            add_filter('age_gate/init/content', function($content) {
                $woof = new \WOOF;

                if (method_exists($woof, 'get_really_current_term') && $term = $woof->get_really_current_term()) {
                    $content = new \AgeGate\Common\Content($term, 'term');
                }

                return $content;
            });
        }
    }
}
