<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentTaskState;
use PHPUnit\Framework\TestCase;

final class AgentTaskStateTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new AgentTaskState('task-2', 'Review access', ['request' => 1], ['priority' => 'high']);
		$this->assertSame('task-2', $dto->getId());
		$this->assertSame('Review access', $dto->getDescription());
		$this->assertSame(['request' => 1], $dto->getInput());
		$this->assertSame(['priority' => 'high'], $dto->getMetadata());
		$this->assertSame(['request' => 1], $dto->toArray()['input']);
	}
}
