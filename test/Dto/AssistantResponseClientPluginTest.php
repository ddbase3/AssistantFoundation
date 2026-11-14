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

use Base3\AssistantFoundation\Dto\AssistantResponseClientPlugin;
use PHPUnit\Framework\TestCase;

final class AssistantResponseClientPluginTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$dto = new AssistantResponseClientPlugin('chart', '/assets/chart.js', 'renderChart', ['theme' => 'light']);
		$this->assertSame('chart', $dto->getName());
		$this->assertSame('/assets/chart.js', $dto->getModuleUrl());
		$this->assertSame('renderChart', $dto->getExportName());
		$this->assertSame(['theme' => 'light'], $dto->getOptions());
		$this->assertSame('renderChart', $dto->toArray()['export_name']);
	}
}
