<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AiChatResult;
use AssistantFoundation\Dto\AiResultMetadata;
use AssistantFoundation\Dto\AiToolCall;
use AssistantFoundation\Dto\AiUsage;
use PHPUnit\Framework\TestCase;

final class AiChatResultTest extends TestCase {

	public function testPublicArrayShapeIsProviderNeutral(): void {
		$result = new AiChatResult(
			'Checking',
			[
				new AiToolCall('call-1', 'lookup', ['query' => 'BASE3'], ['index' => 0])
			],
			new AiResultMetadata(
				'chat',
				'provider',
				'model',
				'request-1',
				null,
				null,
				'tool_calls',
				new AiUsage(totalTokens: 12)
			),
			['provider' => 'raw']
		);

		$array = $result->toArray();

		$this->assertSame('lookup', $array['tool_calls'][0]['name']);
		$this->assertSame(['query' => 'BASE3'], $array['tool_calls'][0]['arguments']);
		$this->assertArrayNotHasKey('function', $array['tool_calls'][0]);
		$this->assertSame(12, $array['metadata']['usage']['total_tokens']);
		$this->assertArrayNotHasKey('raw', $array);
		$this->assertArrayHasKey('raw', $result->toArray(true));
	}
}
