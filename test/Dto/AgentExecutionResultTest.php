<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentExecutionResult;
use PHPUnit\Framework\TestCase;

final class AgentExecutionResultTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$result = new \AssistantFoundation\Dto\AgentResult('completed', \AssistantFoundation\Dto\AgentState::empty());
		$dto = new AgentExecutionResult(['text' => 'Done'], ['model warning'], $result);
		$this->assertSame(['text' => 'Done'], $dto->getOutput());
		$this->assertSame(['model warning'], $dto->getWarnings());
		$this->assertSame($result, $dto->getAgentResult());
		$this->assertSame(null, (new AgentExecutionResult([]))->getAgentResult());
	}
}
