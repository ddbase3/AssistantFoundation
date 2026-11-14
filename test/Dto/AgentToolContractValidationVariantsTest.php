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

final class AgentToolContractValidationVariantsTest extends TestCase {

	public function testNotDeclaredIsNotValidatedButDoesNotReportInvalidData(): void {
		foreach (AgentToolContractValidation::getAllowedStatuses() as $status) {
			$record = new AgentToolContractValidation('call', 'tool', AgentToolContractValidation::DIRECTION_OUTPUT, $status, 'code', 'Summary', 'schema', [['path' => '$.value']], ['origin' => 'contract']);
			$this->assertSame($status === AgentToolContractValidation::STATUS_VALID, $record->isValidated());
			$this->assertSame($status !== AgentToolContractValidation::STATUS_INVALID, $record->passes());
			$this->assertSame($status !== AgentToolContractValidation::STATUS_NOT_DECLARED, $record->isDeclared());
			$this->assertSame('call', $record->getCallId());
			$this->assertSame('tool', $record->getToolName());
			$this->assertSame('output', $record->getDirection());
			$this->assertSame('code', $record->getReasonCode());
			$this->assertSame('Summary', $record->getSummary());
			$this->assertSame('schema', $record->getSchemaSource());
			$this->assertSame([['path' => '$.value']], $record->getIssues());
			$this->assertSame(['origin' => 'contract'], $record->getMetadata());
			$this->assertSame($status, $record->getStatus());
		}
	}

	public function testUnsupportedContractStatusIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);
		new AgentToolContractValidation('call', 'tool', 'input', 'unsupported', '', 'Invalid');
	}
}
