<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentContextWindowState;
use PHPUnit\Framework\TestCase;

final class AgentContextWindowStateTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$usage = new \AssistantFoundation\Dto\AiUsage(3);
		$dto = new AgentContextWindowState([$usage, 'raw'], [$usage]);
		$this->assertSame([$usage, 'raw'], $dto->getAssessments());
		$this->assertSame([$usage], $dto->getCompactions());
		$this->assertSame([$usage->toArray(), 'raw'], $dto->toArray()['assessments']);
		$this->assertSame([$usage->toArray()], $dto->toArray()['compactions']);
	}
}
