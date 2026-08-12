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

final class RetrievalSearchRequest {

	public const MODE_AUTO = 'auto';
	public const MODE_HYBRID = 'hybrid';
	public const MODE_SEMANTIC = 'semantic';
	public const MODE_LEXICAL = 'lexical';
	public const MODE_PHONETIC = 'phonetic';
	public const MODE_EXACT = 'exact';

	/**
	 * @param array<float> $denseVector
	 * @param array<string,mixed>|null $filterSpec
	 * @param string[] $phrases
	 * @param string[] $phoneticPhrases
	 * @param string[] $requiredTerms
	 * @param string[] $excludedTerms
	 */
	public function __construct(
		public readonly string $collectionKey,
		public readonly string $query,
		public readonly string $mode = self::MODE_AUTO,
		public readonly array $denseVector = [],
		public readonly ?array $filterSpec = null,
		public readonly array $phrases = [],
		public readonly array $phoneticPhrases = [],
		public readonly array $requiredTerms = [],
		public readonly array $excludedTerms = [],
		public readonly string $phoneticText = '',
		public readonly int $limit = 5,
		public readonly int $candidateLimit = 20,
		public readonly ?float $denseMinScore = null
	) {}
}
