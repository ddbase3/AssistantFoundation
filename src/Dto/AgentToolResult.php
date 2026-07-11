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
 * AgentToolResult
 *
 * Provider- and runtime-neutral result of one agent tool execution.
 *
 * Tool implementations may return arbitrary serializable output. The harness
 * records call identity, arguments, success or failure information, and
 * additional execution metadata in one stable value object so later stages can
 * assess, filter, compact, or otherwise transform tool observations before
 * they are added to a model context.
 */
final class AgentToolResult {

	public const STATUS_SUCCESS = 'success';
	public const STATUS_FAILURE = 'failure';

	/**
	 * @param array<string,mixed> $arguments
	 * @param array<string,mixed> $metadata
	 */
	private function __construct(
		private readonly string $callId,
		private readonly string $toolName,
		private readonly array $arguments,
		private readonly string $status,
		private readonly mixed $output = null,
		private readonly string $errorCode = '',
		private readonly string $errorMessage = '',
		private readonly array $metadata = []
	) {}

	/**
	 * @param array<string,mixed> $arguments
	 * @param array<string,mixed> $metadata
	 */
	public static function success(
		string $callId,
		string $toolName,
		array $arguments,
		mixed $output,
		array $metadata = []
	): self {
		return new self(
			$callId,
			$toolName,
			$arguments,
			self::STATUS_SUCCESS,
			$output,
			'',
			'',
			$metadata
		);
	}

	/**
	 * @param array<string,mixed> $arguments
	 * @param array<string,mixed> $metadata
	 */
	public static function failure(
		string $callId,
		string $toolName,
		array $arguments,
		string $errorCode,
		string $errorMessage,
		array $metadata = [],
		mixed $output = null
	): self {
		return new self(
			$callId,
			$toolName,
			$arguments,
			self::STATUS_FAILURE,
			$output,
			$errorCode,
			$errorMessage,
			$metadata
		);
	}

	public function getCallId(): string {
		return $this->callId;
	}

	public function getToolName(): string {
		return $this->toolName;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getArguments(): array {
		return $this->arguments;
	}

	public function getStatus(): string {
		return $this->status;
	}

	public function isSuccess(): bool {
		return $this->status === self::STATUS_SUCCESS;
	}

	public function getOutput(): mixed {
		return $this->output;
	}

	public function getErrorCode(): string {
		return $this->errorCode;
	}

	public function getErrorMessage(): string {
		return $this->errorMessage;
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMetadata(): array {
		return $this->metadata;
	}

	/**
	 * @param array<string,mixed> $data
	 */
	public static function fromArray(array $data): self {
		$status = trim((string)($data['status'] ?? ''));
		$arguments = is_array($data['arguments'] ?? null) ? $data['arguments'] : [];
		$metadata = is_array($data['metadata'] ?? null) ? $data['metadata'] : [];

		if ($status === self::STATUS_SUCCESS) {
			return self::success(
				trim((string)($data['call_id'] ?? '')),
				trim((string)($data['tool'] ?? '')),
				$arguments,
				$data['output'] ?? null,
				$metadata
			);
		}

		if ($status !== self::STATUS_FAILURE) {
			throw new \InvalidArgumentException('Unsupported agent tool result status: ' . $status);
		}

		return self::failure(
			trim((string)($data['call_id'] ?? '')),
			trim((string)($data['tool'] ?? '')),
			$arguments,
			trim((string)($data['error_code'] ?? '')),
			trim((string)($data['error_message'] ?? '')),
			$metadata,
			$data['output'] ?? null
		);
	}

	/**
	 * @return array<string,mixed>
	 */
	public function toArray(): array {
		return [
			'call_id' => $this->callId,
			'tool' => $this->toolName,
			'arguments' => $this->arguments,
			'status' => $this->status,
			'output' => $this->output,
			'error_code' => $this->errorCode,
			'error_message' => $this->errorMessage,
			'metadata' => $this->metadata
		];
	}
}
