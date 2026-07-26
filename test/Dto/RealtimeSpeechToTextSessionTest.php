<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\RealtimeSpeechToTextSession;
use PHPUnit\Framework\TestCase;

final class RealtimeSpeechToTextSessionTest extends TestCase {

	public function testSessionSerializesBrowserTransportData(): void {
		$session = new RealtimeSpeechToTextSession(
			'mistral',
			'websocket',
			'wss://api.mistral.ai/v1/audio/transcriptions/realtime?model=test',
			'rt_test',
			'2026-07-26T12:00:00Z',
			'test',
			'pcm_s16le',
			16000,
			['silenceDurationMs' => 900]
		);

		$this->assertSame('mistral', $session->getProvider());
		$this->assertSame('websocket', $session->getTransport());
		$this->assertSame(16000, $session->getSampleRate());
		$this->assertSame('rt_test', $session->toArray()['clientToken']);
		$this->assertSame(900, $session->toArray()['options']['silenceDurationMs']);
	}
}
