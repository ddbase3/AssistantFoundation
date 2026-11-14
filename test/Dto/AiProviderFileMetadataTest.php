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

use Base3\AssistantFoundation\Dto\AiProviderFileMetadata;
use PHPUnit\Framework\TestCase;

final class AiProviderFileMetadataTest extends TestCase {

	public function testExpiryIsInclusiveAndCanBeCheckedWithoutClockDependency(): void {
		$metadata = new AiProviderFileMetadata('opaque', 'document.pdf', 42, 1200);
		$this->assertSame('opaque', $metadata->getOpaqueId());
		$this->assertSame('document.pdf', $metadata->getFilename());
		$this->assertSame(42, $metadata->getSize());
		$this->assertSame(1200, $metadata->getExpiresAt());
		$this->assertFalse($metadata->isExpired(1199));
		$this->assertTrue($metadata->isExpired(1200));
		$this->assertTrue($metadata->isExpired(1201));
	}

	public function testMissingExpiryMeansIndefiniteReferenceValidity(): void {
		$metadata = new AiProviderFileMetadata('opaque', 'document.pdf', 42);
		$this->assertNull($metadata->getExpiresAt());
		$this->assertFalse($metadata->isExpired(PHP_INT_MAX));
	}
}
