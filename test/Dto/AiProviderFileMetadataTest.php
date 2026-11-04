<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AiProviderFileMetadata;
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
