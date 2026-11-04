<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Exception;

use AssistantFoundation\Exception\AiProviderRequestException;
use PHPUnit\Framework\TestCase;

final class AiProviderRequestExceptionTest extends TestCase {

	public function testExceptionRetainsProviderStatusAndRawErrorBody(): void {
		$exception = new AiProviderRequestException('API throttled', 429, '{"error":"rate_limit"}');
		$this->assertSame('API throttled', $exception->getMessage());
		$this->assertSame(429, $exception->getCode());
		$this->assertSame(429, $exception->getStatusCode());
		$this->assertSame('{"error":"rate_limit"}', $exception->getResponseBody());
	}

	public function testResponseBodyDefaultsToEmpty(): void {
		$this->assertSame('', (new AiProviderRequestException('unavailable', 503))->getResponseBody());
	}
}
