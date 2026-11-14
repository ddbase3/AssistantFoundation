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

use Base3\AssistantFoundation\Dto\AiProviderFileReference;
use PHPUnit\Framework\TestCase;

final class AiProviderFileReferenceTest extends TestCase {

	public function testProviderFileRoundTripKeepsOpaqueIdAndNormalizesTransportFields(): void {
		$reference = AiProviderFileReference::fromArray([
			'provider' => ' storage ', 'opaque_id' => ' opaque-1 ', 'content_hash' => ' hash ',
			'filename' => ' document.txt ', 'mime_type' => ' text/plain ', 'size' => -1,
			'expires_at' => '1000'
		]);
		$this->assertNotNull($reference);
		$this->assertSame('storage', $reference->getProvider());
		$this->assertSame('opaque-1', $reference->getOpaqueId());
		$this->assertSame('hash', $reference->getContentHash());
		$this->assertSame('document.txt', $reference->getFilename());
		$this->assertSame('text/plain', $reference->getMimeType());
		$this->assertSame(0, $reference->getSize());
		$this->assertSame(1000, $reference->getExpiresAt());
		$this->assertFalse($reference->isExpired(999));
		$this->assertTrue($reference->isExpired(1000));
		$this->assertSame($reference->toArray(), AiProviderFileReference::fromArray($reference->toArray())->toArray());
	}

	public function testMissingRequiredFieldsCannotCreateProviderFileReference(): void {
		foreach (['provider', 'opaque_id', 'content_hash', 'filename'] as $missing) {
			$input = ['provider' => 'p', 'opaque_id' => 'id', 'content_hash' => 'hash', 'filename' => 'file'];
			unset($input[$missing]);
			$this->assertNull(AiProviderFileReference::fromArray($input));
		}
	}

	public function testReferenceWithNoExpiryNeverExpires(): void {
		$reference = new AiProviderFileReference('provider', 'opaque', 'hash', 'f.txt', 'text/plain', 100);
		$this->assertNull($reference->getExpiresAt());
		$this->assertFalse($reference->isExpired(PHP_INT_MAX));
	}
}
