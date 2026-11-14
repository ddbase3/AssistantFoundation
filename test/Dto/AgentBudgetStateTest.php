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

use Base3\AssistantFoundation\Dto\AgentBudgetState;
use PHPUnit\Framework\TestCase;

final class AgentBudgetStateTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$budget = \Base3\AssistantFoundation\Dto\AgentBudget::unlimited();
		$dto = new AgentBudgetState($budget, [$budget, 'raw']);
		$this->assertSame($budget, $dto->getBudget());
		$this->assertSame([$budget, 'raw'], $dto->getAssessments());
		$this->assertSame($budget->toArray(), $dto->toArray()['budget']);
		$this->assertSame([$budget->toArray(), 'raw'], $dto->toArray()['assessments']);
		$this->assertSame(['budget' => null, 'assessments' => []], (new AgentBudgetState())->toArray());
	}
}
