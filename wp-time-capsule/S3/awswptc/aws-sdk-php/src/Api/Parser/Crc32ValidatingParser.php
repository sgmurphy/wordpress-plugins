<?php
namespace AwsWPTC\Api\Parser;

use AwsWPTC\Api\StructureShape;
use AwsWPTC\CommandInterface;
use AwsWPTC\Exception\AwsException;
use PsrWPTC\Http\Message\ResponseInterface;
use PsrWPTC\Http\Message\StreamInterface;
use GuzzleHttpWPTC\Psr7;

/**
 * @internal Decorates a parser and validates the x-amz-crc32 header.
 */
class Crc32ValidatingParser extends AbstractParser
{
    /**
     * @param callable $parser Parser to wrap.
     */
    public function __construct(callable $parser)
    {
        $this->parser = $parser;
    }

    public function __invoke(
        CommandInterface $command,
        ResponseInterface $response
    ) {
        if ($expected = $response->getHeaderLine('x-amz-crc32')) {
            $hash = hexdec(Psr7\Utils::hash($response->getBody(), 'crc32b'));
            if ($expected != $hash) {
                throw new AwsException(
                    "crc32 mismatch. Expected {$expected}, found {$hash}.",
                    $command,
                    [
                        'code'             => 'ClientChecksumMismatch',
                        'connection_error' => true,
                        'response'         => $response
                    ]
                );
            }
        }

        $fn = $this->parser;
        return $fn($command, $response);
    }

    public function parseMemberFromStream(
        StreamInterface $stream,
        StructureShape $member,
        $response
    ) {
        return $this->parser->parseMemberFromStream($stream, $member, $response);
    }
}
