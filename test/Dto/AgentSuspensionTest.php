<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentAction;
use AssistantFoundation\Dto\AgentExecutionStatus;
use AssistantFoundation\Dto\AgentInteractionRequest;
use AssistantFoundation\Dto\AgentInteractionResponse;
use AssistantFoundation\Dto\AgentResume;
use AssistantFoundation\Dto\AgentSuspension;
use PHPUnit\Framework\TestCase;

final class AgentSuspensionTest extends TestCase {

	public function testResumeRoundTripContainsOnlyOpaqueHandleAndResponses(): void {
		$resume = new AgentResume(str_repeat('a', 43), [
			new AgentInteractionResponse('air-1', AgentInteractionResponse::DECISION_APPROVE)
		]);

		$restored = AgentResume::fromArray($resume->toArray());

		$this->assertSame($resume->toArray(), $restored->toArray());
		$this->assertSame(str_repeat('a', 43), $restored->getResumeHandle());
		$this->assertArrayNotHasKey('suspension', $restored->toArray());
	}

	public function testNaturalLanguageResumeRoundTripKeepsOpaqueHandleAndResponseText(): void {
		$resume = new AgentResume(str_repeat('b', 43), [], 'jo hau rein');

		$restored = AgentResume::fromArray($resume->toArray());

		$this->assertSame(str_repeat('b', 43), $restored->getResumeHandle());
		$this->assertSame([], $restored->getResponses());
		$this->assertSame('jo hau rein', $restored->getResponseText());
		$this->assertTrue($restored->hasResponseText());
		$this->assertArrayNotHasKey('suspension', $restored->toArray());
	}

	public function testSuspensionRejectsNonAwaitingStatus(): void {
		$this->expectException(\InvalidArgumentException::class);

		new AgentSuspension(
			'agent-susp-1',
			AgentExecutionStatus::COMPLETED,
			[],
			[],
			'2026-07-11T10:00:00+00:00'
		);
	}

	public function testSuspensionStillSerializesServerOwnedState(): void {
		$action = new AgentAction('call-1', AgentAction::TYPE_TOOL_CALL, 'update_record', ['id' => 42]);
		$request = new AgentInteractionRequest(
			'air-1',
			AgentInteractionRequest::KIND_APPROVAL,
			$action,
			str_repeat('a', 64),
			'Confirm update',
			'Review the exact mutation.'
		);
		$suspension = new AgentSuspension(
			'agent-susp-1',
			AgentExecutionStatus::AWAITING_APPROVAL,
			[$request],
			['messages' => [['role' => 'user', 'content' => 'Update record 42.']]],
			'2026-07-11T10:00:00+00:00'
		);

		$this->assertSame($suspension->toArray(), AgentSuspension::fromArray($suspension->toArray())->toArray());
	}
}
