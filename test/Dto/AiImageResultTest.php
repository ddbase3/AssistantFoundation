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

use Base3\AssistantFoundation\Dto\AiImageResult;
use PHPUnit\Framework\TestCase;

final class AiImageResultTest extends TestCase {

	public function testConstructedValuePreservesItsTransportData(): void {
		$metadata = new \Base3\AssistantFoundation\Dto\AiResultMetadata('image', 'provider', 'model');
		$dto = new AiImageResult([['url' => 'http://example.test/image.png']], $metadata, ['generated' => 1]);
		$this->assertSame([['url' => 'http://example.test/image.png']], $dto->getImages());
		$this->assertSame($metadata, $dto->getMetadata());
		$this->assertSame(['generated' => 1], $dto->getRaw());
		$this->assertSame([['url' => 'http://example.test/image.png']], $dto->toArray()['images']);
		$this->assertSame(false, array_key_exists('raw', $dto->toArray()));
		$this->assertSame(['generated' => 1], $dto->toArray(true)['raw']);
	}
}
