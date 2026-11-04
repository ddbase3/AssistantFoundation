<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentConversationRequest;
use PHPUnit\Framework\TestCase;

final class AgentConversationRequestTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new AgentConversationRequest(['agent' => 'one'], ['actor' => 'trusted'], ' assistant ');
		$this->assertSame(['agent' => 'one'], $dto->getAgentConfiguration());
		$this->assertSame(['actor' => 'trusted'], $dto->getContext());
		$this->assertSame('assistant', $dto->getNodeId());
	}
}
