<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//@trigger_error('The Twig_SupTwgDtgs_Test class is deprecated since version 1.12 and will be removed in 2.0. Use Twig_SupTwgDtgs_SimpleTest instead.', E_USER_DEPRECATED);

/**
 * Represents a template test.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @deprecated since 1.12 (to be removed in 2.0)
 */
abstract class Twig_SupTwgDtgs_Test implements Twig_SupTwgDtgs_TestInterface, Twig_SupTwgDtgs_TestCallableInterface
{
    protected $options;
    protected $arguments = array();

    public function __construct(array $options = array())
    {
        $this->options = array_merge(array(
            'callable' => null,
        ), $options);
    }

    public function getCallable()
    {
        return $this->options['callable'];
    }
}
