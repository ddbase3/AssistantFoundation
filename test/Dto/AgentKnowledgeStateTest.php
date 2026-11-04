<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentKnowledgeState;
use PHPUnit\Framework\TestCase;

final class AgentKnowledgeStateTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$usage = new \AssistantFoundation\Dto\AiUsage(2);
		$dto = new AgentKnowledgeState([$usage], [['message' => 'confirmed'], $usage]);
		$this->assertSame([$usage], $dto->getKnowledge());
		$this->assertSame([['message' => 'confirmed'], $usage], $dto->getObservations());
		$this->assertSame([$usage->toArray()], $dto->toArray()['knowledge']);
		$this->assertSame([['message' => 'confirmed'], $usage->toArray()], $dto->toArray()['observations']);
	}
}
