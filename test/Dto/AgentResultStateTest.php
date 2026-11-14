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

use Base3\AssistantFoundation\Dto\AgentProgressAssessment;
use Base3\AssistantFoundation\Dto\AgentResultState;
use PHPUnit\Framework\TestCase;

final class AgentResultStateTest extends TestCase {

	public function testFinalOutputReturnsNewStateAndUpgradesNoneToCompletedMode(): void {
		$original = new AgentResultState(finalAssistantMessage: ['role' => 'assistant', 'content' => 'draft'], resultVerifications: [['status' => 'verified']]);
		$next = $original->withFinalOutput('Revised response');
		$this->assertFalse($original->isCompleted());
		$this->assertSame('none', $original->getFinalResponseMode());
		$this->assertTrue($next->isCompleted());
		$this->assertSame('complete', $next->getFinalResponseMode());
		$this->assertSame('Revised response', $next->getFinalOutputContent());
		$this->assertSame($original->getFinalAssistantMessage(), $next->getFinalAssistantMessage());
		$this->assertSame($original->getResultVerifications(), $next->getResultVerifications());
		$this->assertSame('', $next->getFinalResponseInstruction());
	}

	public function testDraftOutputDoesNotForceCompletedModeAndFailureRemains(): void {
		$original = new AgentResultState(finalResponseMode: 'partial', continuationDecisions: [['decision' => 'continue']], failureCode: 'blocked', failureMessage: 'Access denied', failureDetail: ['resource' => 2]);
		$next = $original->withFinalOutput('Partial text', ['role' => 'assistant'], false, '  ');
		$this->assertFalse($next->isCompleted());
		$this->assertSame('partial', $next->getFinalResponseMode());
		$this->assertSame('blocked', $next->getFailureCode());
		$this->assertSame('Access denied', $next->getFailureMessage());
		$this->assertSame(['resource' => 2], $next->getFailureDetail());
		$this->assertTrue($next->hasFailure());
		$this->assertSame([['decision' => 'continue']], $next->getContinuationDecisions());
		$this->assertSame('partial', $next->toArray()['final_response_mode']);
	}

	public function testSerializedEvidenceUsesToArrayOfStructuredObjects(): void {
		$assessment = new AgentProgressAssessment(2, AgentProgressAssessment::VERDICT_PROGRESS, 0, 'changed');
		$state = new AgentResultState(resultVerifications: [$assessment], continuationDecisions: ['unchanged']);
		$this->assertSame($assessment->toArray(), $state->toArray()['result_verifications'][0]);
		$this->assertSame('unchanged', $state->toArray()['continuation_decisions'][0]);
		$this->assertFalse($state->hasFailure());
	}
}
