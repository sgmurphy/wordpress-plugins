<?php

/**
 * League.Uri (https://uri.thephpleague.com)
 *
 * (c) Ignace Nyamagana Butera <nyamsprod@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace IAWPSCOPED\League\Uri;

use IAWPSCOPED\Psr\Http\Message\UriFactoryInterface;
use IAWPSCOPED\Psr\Http\Message\UriInterface;
/** @internal */
final class HttpFactory implements UriFactoryInterface
{
    public function createUri(string $uri = '') : UriInterface
    {
        return Http::createFromString($uri);
    }
}
