<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentActionDecision;
use PHPUnit\Framework\TestCase;

final class AgentActionDecisionTest extends TestCase {

	public function testAllowDecisionIsReportedAsAllowed(): void {
		$decision = AgentActionDecision::allow('call-1', 'Allowed by test policy.');

		$this->assertTrue($decision->isAllowed());
		$this->assertSame(AgentActionDecision::DECISION_ALLOW, $decision->getDecision());
		$this->assertSame('call-1', $decision->getActionId());
	}

	public function testInvalidDecisionIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);

		new AgentActionDecision('call-1', 'unknown');
	}
}
