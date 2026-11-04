<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\RetrievalIndexItem;
use PHPUnit\Framework\TestCase;

final class RetrievalIndexItemTest extends TestCase {

	public function testChunkKeepsDenseAndLexicalRepresentationsDistinct(): void {
		$item = new RetrievalIndexItem('collection', 3, 'Content', 'hash', ['lang' => 'en'], [0.4, -0.2], ['lexical' => ' Title ', 'phonetic' => '470']);
		$this->assertSame('collection', $item->collectionKey);
		$this->assertSame(3, $item->chunkIndex);
		$this->assertSame('Content', $item->text);
		$this->assertSame('hash', $item->hash);
		$this->assertSame(['lang' => 'en'], $item->metadata);
		$this->assertTrue($item->hasDenseVector());
		$this->assertSame([0.4, -0.2], $item->denseVector);
		$this->assertSame('Title', $item->getRepresentation('lexical'));
		$this->assertSame('470', $item->getRepresentation('phonetic'));
		$this->assertSame('', $item->getRepresentation('missing'));
	}

	public function testMissingDenseVectorAndNonStringRepresentationStayEmpty(): void {
		$item = new RetrievalIndexItem('collection', 0, '', 'hash', representations: ['lexical' => '  ', 'broken' => 123]);
		$this->assertFalse($item->hasDenseVector());
		$this->assertSame('', $item->getRepresentation('broken'));
	}
}
