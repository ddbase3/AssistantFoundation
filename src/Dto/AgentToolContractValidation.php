<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of AssistantFoundation for BASE3 Framework.
 *
 * AssistantFoundation extends the BASE3 framework with a unified API
 * foundation for assistants, chatbots, and agent-based systems.
 * It provides shared interfaces for modular AI integration.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/assistantfoundation
 * https://github.com/ddbase3/AssistantFoundation
 **********************************************************************/

namespace AssistantFoundation\Dto;

/**
 * AgentToolContractValidation
 *
 * Provider-neutral record of one input or output contract check for a tool
 * call. The record intentionally contains schema paths and type information,
 * but not the rejected runtime values themselves.
 */
final class AgentToolContractValidation {

	public const DIRECTION_INPUT = 'input';
	public const DIRECTION_OUTPUT = 'output';

	public const STATUS_VALID = 'valid';
	public const STATUS_INVALID = 'invalid';
	public const STATUS_NOT_DECLARED = 'not_declared';

	/**
	 * @param array<int,array<string,mixed>> $issues
	 * @param array<string,mixed> $metadata
	 */
	public function __construct(
		private readonly string $callId,
		private readonly string $toolName,
		private readonly string $direction,
		private readonly string $status,
		private readonly string $reasonCode,
		private readonly string $summary,
		private readonly string $schemaSource = '',
		private readonly array $issues = [],
		private readonly array $metadata = []
	) {
		if (!in_array($direction, self::getAllowedDirections(), true)) {
			throw new \InvalidArgumentException('Unsupported tool contract validation direction: ' . $direction);
		}

		if (!in_array($status, self::getAllowedStatuses(), true)) {
			throw new \InvalidArgumentException('Unsupported tool contract validation status: ' . $status);
		}
	}

	public function getCallId(): string {
		return $this->callId;
	}

	public function getToolName(): string {
		return $this->toolName;
	}

	public function getDirection(): string {
		return $this->direction;
	}

	public function getStatus(): string {
		return $this->status;
	}

	public function getReasonCode(): string {
		return $this->reasonCode;
	}

	public function getSummary(): string {
		return $this->summary;
	}

	public function getSchemaSource(): string {
		return $this->schemaSource;
	}

	/**
	 * @return array<int,array<string,mixed>>
	 */
	public function getIssues(): array {
		return $this->issues;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	public function passes(): bool {
		return $this->status !== self::STATUS_INVALID;
	}

	public function isValidated(): bool {
		return $this->status === self::STATUS_VALID;
	}

	public function isDeclared(): bool {
		return $this->status !== self::STATUS_NOT_DECLARED;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'call_id' => $this->callId,
			'tool' => $this->toolName,
			'direction' => $this->direction,
			'status' => $this->status,
			'reason_code' => $this->reasonCode,
			'summary' => $this->summary,
			'schema_source' => $this->schemaSource,
			'issues' => $this->issues,
			'metadata' => $this->metadata
		];
	}

	/**
	 * @return array<int,string>
	 */
	public static function getAllowedDirections(): array {
		return [
			self::DIRECTION_INPUT,
			self::DIRECTION_OUTPUT
		];
	}

	/**
	 * @return array<int,string>
	 */
	public static function getAllowedStatuses(): array {
		return [
			self::STATUS_VALID,
			self::STATUS_INVALID,
			self::STATUS_NOT_DECLARED
		];
	}
}
