<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentBudgetState;
use PHPUnit\Framework\TestCase;

final class AgentBudgetStateTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$budget = \AssistantFoundation\Dto\AgentBudget::unlimited();
		$dto = new AgentBudgetState($budget, [$budget, 'raw']);
		$this->assertSame($budget, $dto->getBudget());
		$this->assertSame([$budget, 'raw'], $dto->getAssessments());
		$this->assertSame($budget->toArray(), $dto->toArray()['budget']);
		$this->assertSame([$budget->toArray(), 'raw'], $dto->toArray()['assessments']);
		$this->assertSame(['budget' => null, 'assessments' => []], (new AgentBudgetState())->toArray());
	}
}
