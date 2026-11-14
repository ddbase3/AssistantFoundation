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

use Base3\AssistantFoundation\Dto\AgentToolContractValidation;
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
