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

use Base3\AssistantFoundation\Dto\AgentCapabilitySelectionRequest;
use PHPUnit\Framework\TestCase;

final class AgentCapabilitySelectionRequestTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$config = new \Base3\AssistantFoundation\Dto\AgentCapabilitySelectionConfig();
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
