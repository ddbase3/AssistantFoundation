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

namespace Base3\AssistantFoundation\Test\Dto;

use Base3\AssistantFoundation\Dto\AiToolCall;
use PHPUnit\Framework\TestCase;

final class AiToolCallTest extends TestCase {

	public function testFunctionCallPreservesArgumentsAndMetadataAcrossRoundTrip(): void {
		$call = new AiToolCall('id-1', 'lookup', ['query' => 'BASE3'], ['source' => 'model']);
		$this->assertSame('id-1', $call->getId());
		$this->assertSame('lookup', $call->getName());
		$this->assertSame(['query' => 'BASE3'], $call->getArguments());
		$this->assertSame(['source' => 'model'], $call->getMetadata());
		$this->assertSame($call->toArray(), AiToolCall::fromArray($call->toArray())->toArray());
	}

	public function testMalformedToolArgumentsBecomeEmptyContainers(): void {
		$call = AiToolCall::fromArray(['id' => 'call', 'name' => 'lookup', 'arguments' => 'bad', 'metadata' => null]);
		$this->assertSame([], $call->getArguments());
		$this->assertSame([], $call->getMetadata());
	}
}
