<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AssistantResponseClientPlugin;
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
