<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation defines reusable contracts for AI assistants and agents.
 * It provides DTOs, models, and interfaces for retrieval, speech and tools.
 * Implementations reside in independent BASE3 runtime plugins.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/assistantfoundation
 * https://github.com/ddbase3/AssistantFoundation
 **********************************************************************/

namespace Base3\AssistantFoundation\Test\Exception;

use Base3\AssistantFoundation\Exception\AiProviderRequestException;
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
