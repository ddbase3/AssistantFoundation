<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AiProviderFileReference;
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
