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

use Base3\AssistantFoundation\Dto\AiModelConfiguration;
use PHPUnit\Framework\TestCase;

final class AiModelConfigurationTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new AiModelConfiguration('test', 'Test model', 'api', 'mistral', 'https://example.test/model', 'secret-token', ['temperature' => 0.4]);
		$this->assertSame('test', $dto->getId());
		$this->assertSame('Test model', $dto->getLabel());
		$this->assertSame('api', $dto->getDriver());
		$this->assertSame('mistral', $dto->getModel());
		$this->assertSame('https://example.test/model', $dto->getEndpoint());
		$this->assertSame('secret-token', $dto->getApiKey());
		$this->assertSame(['temperature' => 0.4], $dto->getOptions());
	}
}
