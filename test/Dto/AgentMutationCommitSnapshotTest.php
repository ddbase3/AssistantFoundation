<?php declare(strict_types=1);

namespace AssistantFoundation\Test\Dto;

use AssistantFoundation\Dto\AgentMutationCommitSnapshot;
use PHPUnit\Framework\TestCase;

final class AgentMutationCommitSnapshotTest extends TestCase {

	public function testSnapshotRoundTripsAuthorizationAndVersions(): void {
		$snapshot = new AgentMutationCommitSnapshot(
			'action-1',
			'fingerprint-1',
			['subject' => 'user-7'],
			['record:42' => 'version-3'],
			'2026-07-11T12:00:00+00:00',
			['source' => 'test']
		);

		$restored = AgentMutationCommitSnapshot::fromArray($snapshot->toArray());

		$this->assertSame('action-1', $restored->getActionId());
		$this->assertSame('user-7', $restored->getAuthorization()['subject']);
		$this->assertSame('version-3', $restored->getResourceVersions()['record:42']);
		$this->assertSame('2026-07-11T12:00:00+00:00', $restored->getCapturedAt());
		$this->assertSame('test', $restored->getMetadata()['source']);
	}

	public function testEmptyFingerprintIsRejected(): void {
		$this->expectException(\InvalidArgumentException::class);

		new AgentMutationCommitSnapshot('action-1', '');
	}
}
