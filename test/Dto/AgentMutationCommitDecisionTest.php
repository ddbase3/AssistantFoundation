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

use Base3\AssistantFoundation\Dto\AgentMutationCommitDecision;
use PHPUnit\Framework\TestCase;

final class AgentMutationCommitDecisionTest extends TestCase {

	public function testAllowedDecisionHasStableRepresentation(): void {
		$decision = AgentMutationCommitDecision::allow(
			'Authorization and version are current.',
			['checked' => true]
		);

		$this->assertTrue($decision->isAllowed());
		$this->assertSame(AgentMutationCommitDecision::CODE_ALLOWED, $decision->getCode());
		$this->assertTrue($decision->toArray()['metadata']['checked']);
	}

	public function testDeniedDecisionRoundTrips(): void {
		$decision = AgentMutationCommitDecision::deny(
			AgentMutationCommitDecision::CODE_STALE,
			'Resource version changed.',
			['current' => 'v2']
		);
		$restored = AgentMutationCommitDecision::fromArray($decision->toArray());

		$this->assertFalse($restored->isAllowed());
		$this->assertSame(AgentMutationCommitDecision::CODE_STALE, $restored->getCode());
		$this->assertSame('v2', $restored->getMetadata()['current']);
	}
}
