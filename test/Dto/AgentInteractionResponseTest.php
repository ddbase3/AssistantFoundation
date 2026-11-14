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

use Base3\AssistantFoundation\Dto\AgentInteractionResponse;
use PHPUnit\Framework\TestCase;

final class AgentInteractionResponseTest extends TestCase {

	public function testCanonicalResponseRoundTripPreservesDecisionInputsAndMetadata(): void {
		foreach (AgentInteractionResponse::getAllowedDecisions() as $decision) {
			$response = new AgentInteractionResponse('request-1', $decision, ['record' => 12], 'Reviewed', ['source' => 'ui']);
			$this->assertSame($decision, $response->getDecision());
			$this->assertSame('request-1', $response->getRequestId());
			$this->assertSame(['record' => 12], $response->getInput());
			$this->assertSame('Reviewed', $response->getNote());
			$this->assertSame(['source' => 'ui'], $response->getMetadata());
			$this->assertSame($response->toArray(), AgentInteractionResponse::fromArray($response->toArray())->toArray());
		}
	}

	public function testLegacyIdAndCaseInsensitiveInputNormalizeWithoutInventingAnswers(): void {
		$response = AgentInteractionResponse::fromArray(['id' => ' approval-1 ', 'decision' => ' APPROVE ', 'input' => 'invalid', 'metadata' => false, 'note' => ' yes ']);
		$this->assertSame('approval-1', $response->getRequestId());
		$this->assertSame('approve', $response->getDecision());
		$this->assertSame([], $response->getInput());
		$this->assertSame([], $response->getMetadata());
		$this->assertSame('yes', $response->getNote());
	}

	public function testEmptyRequestOrUnsupportedDecisionIsRejected(): void {
		foreach ([['', 'approve'], ['any', 'allow'], ['any', '']] as [$request, $decision]) {
			try {
				new AgentInteractionResponse($request, $decision);
				$this->fail('Invalid interaction response accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
