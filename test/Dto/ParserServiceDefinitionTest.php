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

use Base3\AssistantFoundation\Dto\ParserServiceDefinition;
use PHPUnit\Framework\TestCase;

final class ParserServiceDefinitionTest extends TestCase {

	public function testServiceMetadataAndSupportedMimesAreExplicitlyControlled(): void {
		$service = new ParserServiceDefinition('parser-1', 'Document Parser', 'libreoffice', 12, ['application/pdf', 'text/plain'], ['pdf', 'txt']);
		$this->assertSame('parser-1', $service->getId());
		$this->assertSame('Document Parser', $service->getName());
		$this->assertSame('libreoffice', $service->getDriver());
		$this->assertSame(12, $service->getPriority());
		$this->assertSame(['application/pdf', 'text/plain'], $service->getSupportedTypes());
		$this->assertSame(['pdf', 'txt'], $service->getSupportedExtensions());
		$this->assertTrue($service->supportsType(' APPLICATION/PDF '));
		$this->assertFalse($service->supportsType('application/json'));
		$this->assertFalse($service->supportsType(''));
	}

	public function testEmptyParserSupportDoesNotClaimAnyMimes(): void {
		$service = new ParserServiceDefinition('id', 'name', 'driver');
		$this->assertSame(50, $service->getPriority());
		$this->assertFalse($service->supportsType('application/pdf'));
	}
}
