<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentToolContractValidation;
use PHPUnit\Framework\TestCase;

final class AgentToolContractValidationTest extends TestCase {

	public function testInvalidContractExposesStableRepresentation(): void {
		$validation = new AgentToolContractValidation(
			callId: 'call-1',
			toolName: 'lookup',
			direction: AgentToolContractValidation::DIRECTION_INPUT,
			status: AgentToolContractValidation::STATUS_INVALID,
			reasonCode: 'tool_input_contract_violation',
			summary: 'Input contract failed.',
			schemaSource: 'function.parameters',
			issues: [[
				'path' => '$.query',
				'keyword' => 'type',
				'code' => 'type_mismatch',
				'message' => 'Expected string.'
			]]
		);

		$this->assertFalse($validation->passes());
		$this->assertTrue($validation->isDeclared());
		$this->assertSame('call-1', $validation->getCallId());
		$this->assertSame('tool_input_contract_violation', $validation->getReasonCode());
		$this->assertSame('invalid', $validation->toArray()['status']);
	}

	public function testUnknownDirectionIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);

		new AgentToolContractValidation('call-1', 'lookup', 'sideways', 'valid', '', 'Ok.');
	}
}
