<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AiUsage;
use PHPUnit\Framework\TestCase;

final class AiUsageTest extends TestCase {

	public function testNoneKeepsUnknownMeasurementsNull(): void {
		$usage = AiUsage::none();
		$this->assertNull($usage->getInputTokens());
		$this->assertNull($usage->getOutputTokens());
		$this->assertNull($usage->getTotalTokens());
		$this->assertNull($usage->getCachedInputTokens());
		$this->assertNull($usage->getReasoningTokens());
		$this->assertSame([], $usage->getMetrics());
		$this->assertSame([], $usage->getDetails());
		$this->assertSame($usage->toArray(), AiUsage::fromArray($usage->toArray())->toArray());
	}

	public function testParsingRejectsGuessedCountersAndBadMetricTypes(): void {
		$usage = AiUsage::fromArray([
			'input_tokens' => ' 4', 'output_tokens' => '7', 'total_tokens' => 11.0,
			'cached_input_tokens' => '-2', 'reasoning_tokens' => true,
			'metrics' => ['cost' => 0.01, 'requests' => 2, 'bad' => '3', 2 => 5],
			'details' => 'bad'
		]);
		$this->assertNull($usage->getInputTokens());
		$this->assertSame(7, $usage->getOutputTokens());
		$this->assertNull($usage->getTotalTokens());
		$this->assertSame(-2, $usage->getCachedInputTokens());
		$this->assertNull($usage->getReasoningTokens());
		$this->assertSame(['cost' => 0.01, 'requests' => 2], $usage->getMetrics());
		$this->assertSame([], $usage->getDetails());
	}

	public function testMergingPreservesUnknownCountersAndAddsKnownMetrics(): void {
		$left = new AiUsage(10, null, 10, null, null, ['requests' => 1, 'cost' => 0.02], ['provider' => 'old']);
		$right = new AiUsage(null, 5, 5, 2, null, ['requests' => 2, 'images' => 1], ['provider' => 'new']);
		$merged = $left->merge($right);
		$this->assertSame(10, $merged->getInputTokens());
		$this->assertSame(5, $merged->getOutputTokens());
		$this->assertSame(15, $merged->getTotalTokens());
		$this->assertSame(2, $merged->getCachedInputTokens());
		$this->assertNull($merged->getReasoningTokens());
		$this->assertSame(['requests' => 3, 'cost' => 0.02, 'images' => 1], $merged->getMetrics());
		$this->assertSame(['provider' => 'new'], $merged->getDetails());
		$this->assertSame(10, $left->getInputTokens());
		$this->assertNull($left->getOutputTokens());
	}

	public function testMalformedMetricContainersAndUnparsableIntsDefaultSafely(): void {
		$usage = AiUsage::fromArray(['input_tokens' => '+5', 'metrics' => null, 'details' => ['nested' => ['v' => 1]]]);
		$this->assertNull($usage->getInputTokens());
		$this->assertSame([], $usage->getMetrics());
		$this->assertSame(['nested' => ['v' => 1]], $usage->getDetails());
	}
}
