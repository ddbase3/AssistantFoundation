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

use Base3\AssistantFoundation\Dto\AgentAction;
use Base3\AssistantFoundation\Dto\AgentInteractionRequest;
use PHPUnit\Framework\TestCase;

final class AgentInteractionRequestTest extends TestCase {

	public function testAllInteractionKindsRetainExactActionFingerprintAndRoundTrip(): void {
		$action = new AgentAction('call-1', AgentAction::TYPE_TOOL_CALL, 'delete_record', ['id' => 20]);
		foreach (AgentInteractionRequest::getAllowedKinds() as $kind) {
			$request = new AgentInteractionRequest('req-1', $kind, $action, 'fingerprint123', 'Review', 'Do you agree?', ['record' => 20], 'high', ['policy' => 'manual']);
			$this->assertSame('req-1', $request->getId());
			$this->assertSame($kind, $request->getKind());
			$this->assertSame($action, $request->getAction());
			$this->assertSame('fingerprint123', $request->getActionFingerprint());
			$this->assertSame('Review', $request->getTitle());
			$this->assertSame('Do you agree?', $request->getMessage());
			$this->assertSame(['record' => 20], $request->getSummary());
			$this->assertSame('high', $request->getRisk());
			$this->assertSame(['policy' => 'manual'], $request->getMetadata());
			$this->assertSame($request->toArray(), AgentInteractionRequest::fromArray($request->toArray())->toArray());
		}
	}

	public function testUntrustedArraysAreNotCastToReviewSummaryOrMetadata(): void {
		$request = AgentInteractionRequest::fromArray([
			'id' => 'req', 'kind' => 'approval',
			'action' => (new AgentAction('c', AgentAction::TYPE_TOOL_CALL, 'lookup', []))->toArray(),
			'action_fingerprint' => 'fp', 'summary' => 'unsafe', 'metadata' => 'unsafe'
		]);
		$this->assertSame([], $request->getSummary());
		$this->assertSame([], $request->getMetadata());
		$this->assertSame('medium', $request->getRisk());
	}

	public function testMissingActionsIdentifiersAndBadKindsAreRejected(): void {
		$base = [
			'id' => 'request', 'kind' => 'approval',
			'action' => (new AgentAction('call', AgentAction::TYPE_TOOL_CALL, 'lookup', []))->toArray(),
			'action_fingerprint' => 'fingerprint'
		];
		foreach ([['action' => 'no-array'], ['id' => ''], ['action_fingerprint' => ''], ['kind' => 'approve']] as $override) {
			try {
				AgentInteractionRequest::fromArray(array_replace($base, $override));
				$this->fail('Malformed interaction request accepted.');
			} catch (\InvalidArgumentException) {
				$this->addToAssertionCount(1);
			}
		}
	}
}
