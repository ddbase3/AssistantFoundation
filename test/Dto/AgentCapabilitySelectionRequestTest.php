<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentCapabilitySelectionRequest;
use PHPUnit\Framework\TestCase;

final class AgentCapabilitySelectionRequestTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$config = new \AssistantFoundation\Dto\AgentCapabilitySelectionConfig();
		$dto = new AgentCapabilitySelectionRequest(2, 'Read context', $config, ['older'], ['recent'], ['required'], null, [['role' => 'user', 'content' => 'Help']]);
		$this->assertSame(2, $dto->getIteration());
		$this->assertSame('Read context', $dto->getContextText());
		$this->assertSame($config, $dto->getConfig());
		$this->assertSame(['older'], $dto->getPreviousSelectedToolNames());
		$this->assertSame(['recent'], $dto->getRecentToolNames());
		$this->assertSame(['required'], $dto->getRequiredToolNames());
		$this->assertSame(null, $dto->getModel());
		$this->assertSame([['role' => 'user', 'content' => 'Help']], $dto->getMessages());
	}
}
