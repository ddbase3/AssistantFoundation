<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentInteractionResponse;
use AssistantFoundation\Dto\AgentSuspensionResolution;
use PHPUnit\Framework\TestCase;

final class AgentSuspensionResolutionTest extends TestCase {

	public function testEmptyAndConsistentDecisionsDetermineTerminalOutcomes(): void {
		$this->assertSame(AgentSuspensionResolution::OUTCOME_RESOLVED, (new AgentSuspensionResolution([]))->getOutcome());
		foreach ([
			AgentInteractionResponse::DECISION_APPROVE => AgentSuspensionResolution::OUTCOME_APPROVED,
			AgentInteractionResponse::DECISION_DENY => AgentSuspensionResolution::OUTCOME_DENIED,
			AgentInteractionResponse::DECISION_SUBMIT => AgentSuspensionResolution::OUTCOME_SUBMITTED
		] as $decision => $expected) {
			$resolved = new AgentSuspensionResolution([new AgentInteractionResponse('a', $decision), new AgentInteractionResponse('b', $decision)], ' interactive ', ' 2026-10-01 ');
			$this->assertSame($expected, $resolved->getOutcome());
			$this->assertSame('interactive', $resolved->getSource());
			$this->assertSame('2026-10-01', $resolved->getResolvedAt());
			$this->assertSame($resolved->toArray(), AgentSuspensionResolution::fromArray($resolved->toArray())->toArray());
		}
		$mixed = new AgentSuspensionResolution([new AgentInteractionResponse('a', 'approve'), new AgentInteractionResponse('b', 'deny')]);
		$this->assertSame(AgentSuspensionResolution::OUTCOME_MIXED, $mixed->getOutcome());
	}

	public function testInvalidResponseTypesAreRejectedAtConstructionAndParsing(): void {
		try {
			new AgentSuspensionResolution(['wrong']);
			$this->fail('Foreign response instance accepted.');
		} catch (\InvalidArgumentException) {
			$this->addToAssertionCount(1);
		}
		$this->expectException(\InvalidArgumentException::class);
		AgentSuspensionResolution::fromArray(['responses' => ['wrong']]);
	}
}
