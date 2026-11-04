<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentTextTaskResult;
use PHPUnit\Framework\TestCase;

final class AgentTextTaskResultTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new AgentTextTaskResult('Summary', ['short context'], ['model' => 'test']);
		$this->assertSame('Summary', $dto->getContent());
		$this->assertSame(['short context'], $dto->getWarnings());
		$this->assertSame(['model' => 'test'], $dto->getMetadata());
		$this->assertSame('Summary', $dto->toArray()['content']);
	}
}
