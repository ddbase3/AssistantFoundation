<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AiToolCall;
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
