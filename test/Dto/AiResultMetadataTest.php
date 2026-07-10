<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AiResultMetadata;
use AssistantFoundation\Dto\AiUsage;
use PHPUnit\Framework\TestCase;

final class AiResultMetadataTest extends TestCase {

	public function testUsageCanAggregateDifferentOperations(): void {
		$usage = new AiUsage(
			inputTokens: 10,
			outputTokens: 2,
			totalTokens: 12,
			metrics: ['requests' => 1]
		);
		$merged = $usage->merge(new AiUsage(
			inputTokens: 3,
			outputTokens: 1,
			totalTokens: 4,
			metrics: ['requests' => 1, 'output_images' => 2]
		));

		$this->assertSame(13, $merged->getInputTokens());
		$this->assertSame(3, $merged->getOutputTokens());
		$this->assertSame(16, $merged->getTotalTokens());
		$this->assertSame(2, $merged->getMetrics()['requests']);
		$this->assertSame(2, $merged->getMetrics()['output_images']);
	}

	public function testMetadataHasOneSharedShape(): void {
		$metadata = new AiResultMetadata(
			'chat',
			'provider',
			'model',
			'request-1',
			123,
			12.5,
			'stop',
			new AiUsage(totalTokens: 7),
			['adapter' => 'test']
		);

		$array = $metadata->toArray();

		$this->assertSame('chat', $array['operation']);
		$this->assertSame(7, $array['usage']['total_tokens']);
		$this->assertSame('test', $array['extra']['adapter']);
	}
}
