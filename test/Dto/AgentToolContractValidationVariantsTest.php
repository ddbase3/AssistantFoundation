<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentToolContractValidation;
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
