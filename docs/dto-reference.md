# AssistantFoundation DTO Reference

## Purpose

This source-derived reference lists the current DTO and value-object classes in `src/Dto/` with their public construction and method surface. The thematic documents explain semantics and ownership.

## `AgentAction`

File: `src/Dto/AgentAction.php`

```php
class AgentAction
__construct(private readonly string $id, private readonly string $type, private readonly string $name, private readonly array $input = [], private readonly array $metadata = []);
getId() : string;
getType() : string;
getName() : string;
getInput() : array;
getMetadata() : array;
static fromArray(array $data) : self;
toArray() : array;
```

## `AgentActionDecision`

File: `src/Dto/AgentActionDecision.php`

```php
class AgentActionDecision
__construct(private readonly string $actionId, private readonly string $decision, private readonly string $reason = '', private readonly array $metadata = []);
static allow(string $actionId, string $reason = '', array $metadata = []) : self;
static deny(string $actionId, string $reason, array $metadata = []) : self;
static requireApproval(string $actionId, string $reason, array $metadata = []) : self;
static requireDryRun(string $actionId, string $reason, array $metadata = []) : self;
static requireClarification(string $actionId, string $reason, array $metadata = []) : self;
getActionId() : string;
getDecision() : string;
getReason() : string;
getMetadata() : array;
isAllowed() : bool;
static fromArray(array $data) : self;
toArray() : array;
static getAllowedDecisions() : array;
```

## `AgentActionReview`

File: `src/Dto/AgentActionReview.php`

```php
class AgentActionReview
__construct(private readonly string $title, private readonly string $message, private readonly array $summary = []);
getTitle() : string;
getMessage() : string;
getSummary() : array;
toArray() : array;
static fromArray(array $data) : self;
```

## `AgentBudget`

File: `src/Dto/AgentBudget.php`

```php
class AgentBudget
__construct(private readonly ?int $maxInputTokens = null, private readonly ?int $maxOutputTokens = null, private readonly ?int $maxTotalTokens = null, private readonly ?int $maxAiOperations = null, private readonly ?int $maxToolCalls = null, private readonly ?float $maxElapsedMs = null, private readonly array $metricLimits = [], private readonly bool $requireUsageReporting = false);
static unlimited() : self;
static fromArray(array $data) : self;
getMaxInputTokens() : ?int;
getMaxOutputTokens() : ?int;
getMaxTotalTokens() : ?int;
getMaxAiOperations() : ?int;
getMaxToolCalls() : ?int;
getMaxElapsedMs() : ?float;
getMetricLimits() : array;
requiresUsageReporting() : bool;
isUnlimited() : bool;
toArray() : array;
```

## `AgentBudgetAssessment`

File: `src/Dto/AgentBudgetAssessment.php`

```php
class AgentBudgetAssessment
__construct(private readonly int $iteration, private readonly AgentBudget $budget, private readonly AiUsage $usage, private readonly int $aiOperationCount, private readonly int $toolCallCount, private readonly float $elapsedMs, private readonly array $exceededLimits = [], private readonly array $unknownLimits = [], private readonly array $metadata = []);
getIteration() : int;
getBudget() : AgentBudget;
getUsage() : AiUsage;
getAiOperationCount() : int;
getToolCallCount() : int;
getElapsedMs() : float;
getExceededLimits() : array;
getUnknownLimits() : array;
getMetadata() : array;
hasExceededLimits() : bool;
hasUnknownLimits() : bool;
canContinue() : bool;
toArray() : array;
```

## `AgentBudgetState`

File: `src/Dto/AgentBudgetState.php`

```php
class AgentBudgetState
__construct(private readonly ?AgentBudget $budget = null, private readonly array $assessments = []);
getBudget() : ?AgentBudget;
toArray() : array;
```

## `AgentCapability`

File: `src/Dto/AgentCapability.php`

```php
class AgentCapability
__construct(private readonly string $name, private readonly string $title, private readonly string $description, private readonly string $category, private readonly array $tags, private readonly int $priority, private readonly array $definition, private readonly string $sourceId = '', private readonly string $sourceName = '', private readonly bool $alwaysAvailable = false, private readonly array $metadata = []);
getName() : string;
getTitle() : string;
getDescription() : string;
getCategory() : string;
getTags() : array;
getPriority() : int;
getDefinition() : array;
getSourceId() : string;
getSourceName() : string;
isAlwaysAvailable() : bool;
getMetadata() : array;
toArray() : array;
```

## `AgentCapabilityCatalog`

File: `src/Dto/AgentCapabilityCatalog.php`

```php
class AgentCapabilityCatalog implements Countable
__construct(array $capabilities = []);
count() : int;
has(string $name) : bool;
get(string $name) : ?AgentCapability;
all() : array;
names() : array;
getToolDefinitions() : array;
toArray() : array;
```

## `AgentCapabilitySelection`

File: `src/Dto/AgentCapabilitySelection.php`

```php
class AgentCapabilitySelection
__construct(private readonly int $iteration, private readonly string $strategy, private readonly int $catalogSize, private readonly int $eligibleSize, private readonly array $capabilities, private readonly array $scores = [], private readonly array $reasons = [], private readonly ?AiResultMetadata $modelMetadata = null);
getIteration() : int;
getStrategy() : string;
getCatalogSize() : int;
getEligibleSize() : int;
getModelMetadata() : ?AiResultMetadata;
getToolNames() : array;
has(string $toolName) : bool;
getToolDefinitions() : array;
toArray() : array;
```

## `AgentCapabilitySelectionConfig`

File: `src/Dto/AgentCapabilitySelectionConfig.php`

```php
class AgentCapabilitySelectionConfig
__construct(private readonly bool $enabled = true, private readonly string $strategy = self::STRATEGY_HYBRID, private readonly int $maxTools = 16, private readonly int $selectAllThreshold = 16, private readonly array $includeTools = [], private readonly array $excludeTools = [], private readonly array $includeTags = [], private readonly array $excludeTags = [], private readonly array $includeCategories = [], private readonly array $excludeCategories = [], private readonly array $alwaysAvailable = [], private readonly bool $sticky = true, private readonly int $semanticCandidateTools = 48, private readonly int $semanticMaxPromptCharacters = 48000, private readonly string $selectionUnit = self::SELECTION_UNIT_FUNCTION, private readonly int $maxSources = 8);
static fromArray(array $config) : self;
withAlwaysAvailable(array $toolNames) : self;
isEnabled() : bool;
getStrategy() : string;
getMaxTools() : int;
getSelectAllThreshold() : int;
isSticky() : bool;
getSemanticCandidateTools() : int;
getSemanticMaxPromptCharacters() : int;
getSelectionUnit() : string;
getMaxSources() : int;
selectsSources() : bool;
toArray() : array;
```

## `AgentCapabilitySelectionRequest`

File: `src/Dto/AgentCapabilitySelectionRequest.php`

```php
class AgentCapabilitySelectionRequest
__construct(private readonly int $iteration, private readonly string $contextText, private readonly AgentCapabilitySelectionConfig $config, private readonly array $previousSelectedToolNames = [], private readonly array $recentToolNames = [], private readonly array $requiredToolNames = [], private readonly ?IAiChatModel $model = null, private readonly array $messages = []);
getIteration() : int;
getContextText() : string;
getConfig() : AgentCapabilitySelectionConfig;
getModel() : ?IAiChatModel;
```

## `AgentCapabilitySourceConfig`

File: `src/Dto/AgentCapabilitySourceConfig.php`

```php
class AgentCapabilitySourceConfig
__construct(private array $toolIds = [], private array $providerIds = [], private array $moduleIds = [], private array $resourceProviderIds = [], private array $promptProviderIds = [], private bool $strict = true);
static fromArray(array $data) : self;
getToolIds() : array;
getProviderIds() : array;
getModuleIds() : array;
getResourceProviderIds() : array;
getPromptProviderIds() : array;
isStrict() : bool;
isEmpty() : bool;
toArray() : array;
```

## `AgentContextAssessment`

File: `src/Dto/AgentContextAssessment.php`

```php
class AgentContextAssessment
__construct(private readonly int $iteration, private readonly int $messageCount, private readonly int $messageBytes, private readonly int $toolResultCount, private readonly int $successfulToolResultCount, private readonly int $failedToolResultCount, private readonly int $toolResultBytes, private readonly ?AiUsage $usage = null, private readonly array $metadata = []);
getIteration() : int;
getMessageCount() : int;
getMessageBytes() : int;
getToolResultCount() : int;
getSuccessfulToolResultCount() : int;
getFailedToolResultCount() : int;
getToolResultBytes() : int;
getTotalMeasuredBytes() : int;
getUsage() : AiUsage;
getMetadata() : array;
toArray() : array;
```

## `AgentContextCompaction`

File: `src/Dto/AgentContextCompaction.php`

```php
class AgentContextCompaction
__construct(private readonly int $iteration, private readonly string $callId, private readonly string $toolName, private readonly bool $applied, private readonly int $originalBytes, private readonly int $compactedBytes, private readonly bool $inputTruncated, private readonly array $modelMetadata = [], private readonly string $errorMessage = '');
getIteration() : int;
getCallId() : string;
getToolName() : string;
wasApplied() : bool;
getOriginalBytes() : int;
getCompactedBytes() : int;
wasInputTruncated() : bool;
getModelMetadata() : array;
getErrorMessage() : string;
toArray() : array;
```

## `AgentContextProfileResult`

File: `src/Dto/AgentContextProfileResult.php`

```php
class AgentContextProfileResult
__construct(private readonly string $profileId, private readonly array $blocks = [], private readonly array $warnings = []);
static empty(string $profileId = '') : self;
getProfileId() : string;
getBlocks() : array;
getWarnings() : array;
getDiagnostics() : array;
```

## `AgentContextWindowState`

File: `src/Dto/AgentContextWindowState.php`

```php
class AgentContextWindowState
__construct(private readonly array $assessments = [], private readonly array $compactions = []);
toArray() : array;
```

## `AgentContinuationDecision`

File: `src/Dto/AgentContinuationDecision.php`

```php
class AgentContinuationDecision
__construct(private readonly int $iteration, private readonly string $decision, private readonly string $reason, private readonly string $source, private readonly ?float $confidence = null, private readonly array $metadata = []);
getIteration() : int;
getDecision() : string;
getReason() : string;
getSource() : string;
getConfidence() : ?float;
getMetadata() : array;
shouldContinue() : bool;
shouldAnswer() : bool;
shouldClarify() : bool;
isTerminal() : bool;
toArray() : array;
static getAllowedDecisions() : array;
```

## `AgentConversation`

File: `src/Dto/AgentConversation.php`

```php
class AgentConversation
__construct(private readonly string $id, private readonly string $title, private readonly string $titleSource, private readonly string $openingMessage, private readonly string $createdAt, private readonly string $updatedAt, private readonly string $lastActiveAt);
static fromArray(array $data) : self;
getId() : string;
getTitle() : string;
getTitleSource() : string;
getOpeningMessage() : string;
getCreatedAt() : string;
getUpdatedAt() : string;
getLastActiveAt() : string;
toArray() : array;
```

## `AgentConversationRequest`

File: `src/Dto/AgentConversationRequest.php`

```php
class AgentConversationRequest
__construct(private readonly array $agentConfiguration, private readonly array $context = [], private readonly string $nodeId = '');
getAgentConfiguration() : array;
getContext() : array;
getNodeId() : string;
```

## `AgentConversationScope`

File: `src/Dto/AgentConversationScope.php`

```php
class AgentConversationScope
__construct(private readonly string $ownerKey, private readonly string $channelId, private readonly string $conversationId = '');
getOwnerKey() : string;
getChannelId() : string;
getConversationId() : string;
hasConversationId() : bool;
withConversationId(string $conversationId) : self;
toArray() : array;
```

## `AgentConversationState`

File: `src/Dto/AgentConversationState.php`

```php
class AgentConversationState
__construct(private readonly array $conversations, private readonly ?AgentConversation $activeConversation, private readonly array $messages, private readonly string $nodeId, private readonly array $warnings = []);
getConversations() : array;
getActiveConversation() : ?AgentConversation;
getMessages() : array;
getNodeId() : string;
getWarnings() : array;
toArray() : array;
```

## `AgentExecutionEvent`

File: `src/Dto/AgentExecutionEvent.php`

```php
class AgentExecutionEvent
__construct(string $name, array $payload = []);
getName() : string;
getPayload() : array;
toArray() : array;
```

## `AgentExecutionRequest`

File: `src/Dto/AgentExecutionRequest.php`

```php
class AgentExecutionRequest
__construct(private readonly array $agentConfiguration, private readonly array $inputs = [], private readonly array $context = []);
getAgentConfiguration() : array;
getInputs() : array;
getContext() : array;
```

## `AgentExecutionResult`

File: `src/Dto/AgentExecutionResult.php`

```php
class AgentExecutionResult
__construct(private readonly array $output, private readonly array $warnings = [], private readonly ?AgentResult $agentResult = null);
getOutput() : array;
getWarnings() : array;
getAgentResult() : ?AgentResult;
```

## `AgentExecutionState`

File: `src/Dto/AgentExecutionState.php`

```php
class AgentExecutionState
__construct(private readonly string $status = AgentExecutionStatus::RUNNING, private readonly string $phase = '', private readonly int $iteration = 0, private readonly int $maxIterations = 0, private readonly int $callIndex = 0, private readonly array $actions = [], private readonly array $actionDecisions = [], private readonly array $executedToolCalls = [], private readonly array $modelResults = [], private readonly array $stageTrace = [], private readonly array $capabilitySelections = [], private readonly array $toolContractValidations = [], private readonly array $toolCacheRecords = [], private readonly array $progressAssessments = []);
getStatus() : string;
getPhase() : string;
getIteration() : int;
getMaxIterations() : int;
getCallIndex() : int;
withModelResults(array $modelResults) : self;
toArray() : array;
```

## `AgentExecutionStatus`

File: `src/Dto/AgentExecutionStatus.php`

```php
class AgentExecutionStatus
static isSuspended(string $status) : bool;
static all() : array;
```

## `AgentInstructionBlock`

File: `src/Dto/AgentInstructionBlock.php`

```php
class AgentInstructionBlock
__construct(string $id, string $content, int $priority = 0, string $source = '', array $metadata = []);
getId() : string;
getContent() : string;
getPriority() : int;
getSource() : string;
getMetadata() : array;
toArray() : array;
toDiagnosticArray() : array;
toMessage() : array;
```

## `AgentInteractionRequest`

File: `src/Dto/AgentInteractionRequest.php`

```php
class AgentInteractionRequest
__construct(private readonly string $id, private readonly string $kind, private readonly AgentAction $action, private readonly string $actionFingerprint, private readonly string $title, private readonly string $message, private readonly array $summary = [], private readonly string $risk = 'medium', private readonly array $metadata = []);
getId() : string;
getKind() : string;
getAction() : AgentAction;
getActionFingerprint() : string;
getTitle() : string;
getMessage() : string;
getSummary() : array;
getRisk() : string;
getMetadata() : array;
toArray() : array;
static fromArray(array $data) : self;
static getAllowedKinds() : array;
```

## `AgentInteractionResponse`

File: `src/Dto/AgentInteractionResponse.php`

```php
class AgentInteractionResponse
__construct(private readonly string $requestId, private readonly string $decision, private readonly array $input = [], private readonly string $note = '', private readonly array $metadata = []);
getRequestId() : string;
getDecision() : string;
getInput() : array;
getNote() : string;
getMetadata() : array;
toArray() : array;
static fromArray(array $data) : self;
static getAllowedDecisions() : array;
```

## `AgentKnowledgeState`

File: `src/Dto/AgentKnowledgeState.php`

```php
class AgentKnowledgeState
__construct(private readonly array $knowledge = [], private readonly array $observations = []);
getKnowledge() : array;
getObservations() : array;
toArray() : array;
```

## `AgentMemoryState`

File: `src/Dto/AgentMemoryState.php`

```php
class AgentMemoryState
__construct(private readonly int $conversationMemoryCount = 0, private readonly int $contextContributorCount = 0, private readonly array $contextContributions = [], private readonly array $metadata = []);
getConversationMemoryCount() : int;
getContextContributorCount() : int;
getContextContributions() : array;
getMetadata() : array;
toArray() : array;
```

## `AgentModuleActivation`

File: `src/Dto/AgentModuleActivation.php`

```php
class AgentModuleActivation
__construct(private array $instructions = [], private array $tools = [], private array $resourceProviders = [], private array $promptProviders = [], private array $stages = []);
getInstructions() : array;
getTools() : array;
getResourceProviders() : array;
getPromptProviders() : array;
getStages() : array;
```

## `AgentModuleManifest`

File: `src/Dto/AgentModuleManifest.php`

```php
class AgentModuleManifest
__construct(private string $name, private string $title = '', private string $description = '', private array $tags = [], private array $metadata = []);
getName() : string;
getTitle() : string;
getDescription() : string;
getTags() : array;
getMetadata() : array;
toArray() : array;
```

## `AgentMutationCommitDecision`

File: `src/Dto/AgentMutationCommitDecision.php`

```php
class AgentMutationCommitDecision
__construct(private readonly bool $allowed, private readonly string $code, private readonly string $reason = '', private readonly array $metadata = []);
static allow(string $reason = '', array $metadata = []) : self;
static deny(string $code, string $reason, array $metadata = []) : self;
isAllowed() : bool;
getCode() : string;
getReason() : string;
getMetadata() : array;
toArray() : array;
static fromArray(array $data) : self;
```

## `AgentMutationCommitSnapshot`

File: `src/Dto/AgentMutationCommitSnapshot.php`

```php
class AgentMutationCommitSnapshot
__construct(private readonly string $actionId, private readonly string $actionFingerprint, private readonly array $authorization = [], private readonly array $resourceVersions = [], string $capturedAt = '', private readonly array $metadata = []);
getActionId() : string;
getActionFingerprint() : string;
getAuthorization() : array;
getResourceVersions() : array;
getCapturedAt() : string;
getMetadata() : array;
toArray() : array;
static fromArray(array $data) : self;
```

## `AgentPlanState`

File: `src/Dto/AgentPlanState.php`

```php
class AgentPlanState
__construct(private readonly array $steps = [], private readonly ?int $currentStepIndex = null, private readonly string $status = 'none', private readonly array $metadata = []);
getSteps() : array;
getCurrentStepIndex() : ?int;
getStatus() : string;
getMetadata() : array;
toArray() : array;
```

## `AgentProgressAssessment`

File: `src/Dto/AgentProgressAssessment.php`

```php
class AgentProgressAssessment
__construct(private readonly int $iteration, private readonly string $verdict, private readonly int $consecutiveStalledIterations, private readonly string $reason, private readonly array $currentSignatures = [], private readonly array $repeatedSignatures = [], private readonly array $metadata = []);
getIteration() : int;
getVerdict() : string;
getConsecutiveStalledIterations() : int;
getReason() : string;
getCurrentSignatures() : array;
getRepeatedSignatures() : array;
getMetadata() : array;
hasProgress() : bool;
isStalled() : bool;
toArray() : array;
static getAllowedVerdicts() : array;
```

## `AgentResult`

File: `src/Dto/AgentResult.php`

```php
class AgentResult
__construct(private readonly string $status, private readonly AgentState $state, private readonly array $output = [], private readonly array $metadata = []);
getStatus() : string;
getState() : AgentState;
isCompleted() : bool;
isSuspended() : bool;
isPartial() : bool;
hasFailure() : bool;
toArray() : array;
```

## `AgentResultState`

File: `src/Dto/AgentResultState.php`

```php
class AgentResultState
__construct(private readonly bool $completed = false, private readonly ?array $finalAssistantMessage = null, private readonly string $finalOutputContent = '', private readonly string $finalResponseMode = 'none', private readonly array $resultVerifications = [], private readonly array $continuationDecisions = [], private readonly string $finalResponseInstruction = '', private readonly string $failureCode = '', private readonly string $failureMessage = '', private readonly array $failureDetail = []);
isCompleted() : bool;
getFinalOutputContent() : string;
getFinalResponseMode() : string;
getFinalResponseInstruction() : string;
getFailureCode() : string;
getFailureMessage() : string;
hasFailure() : bool;
withFinalOutput(string $content, ?array $finalAssistantMessage = null, bool $completed = true, ?string $finalResponseMode = null) : self;
toArray() : array;
```

## `AgentResultVerification`

File: `src/Dto/AgentResultVerification.php`

```php
class AgentResultVerification
__construct(private readonly int $iteration, private readonly string $verifier, private readonly string $verdict, private readonly string $summary, private readonly array $issues = [], private readonly array $metadata = []);
getIteration() : int;
getVerifier() : string;
getVerdict() : string;
getSummary() : string;
getIssues() : array;
getMetadata() : array;
isVerified() : bool;
toArray() : array;
static getAllowedVerdicts() : array;
```

## `AgentResume`

File: `src/Dto/AgentResume.php`

```php
class AgentResume
__construct(private readonly string $resumeHandle, private readonly array $responses = [], private readonly string $responseText = '');
getResumeHandle() : string;
getResponses() : array;
getResponseText() : string;
hasExplicitResponses() : bool;
hasResponseText() : bool;
toArray() : array;
static fromArray(array $data) : self;
```

## `AgentStageMount`

File: `src/Dto/AgentStageMount.php`

```php
class AgentStageMount
__construct(private string $slot, private IAgentStage $stage, private int $order = 0);
getSlot() : string;
getStage() : IAgentStage;
getOrder() : int;
```

## `AgentStageResult`

File: `src/Dto/AgentStageResult.php`

```php
class AgentStageResult
static none(array $metadata = []) : self;
static patch(array $patch, array $metadata = []) : self;
getPatch() : array;
getMetadata() : array;
isEmpty() : bool;
```

## `AgentStageSlot`

File: `src/Dto/AgentStageSlot.php`

```php
class AgentStageSlot
static all() : array;
static assert(string $slot) : string;
```

## `AgentStageTraceEntry`

File: `src/Dto/AgentStageTraceEntry.php`

```php
class AgentStageTraceEntry
__construct(private readonly string $stageId, private readonly string $stageName, private readonly string $implementationName, private readonly string $description, private readonly string $aiUsage, private readonly int $iteration, private readonly string $phaseBefore, private readonly string $phaseAfter, private readonly string $status, private readonly ?float $durationMs = null, private readonly array $metadata = []);
getStageId() : string;
getStageName() : string;
getImplementationName() : string;
getDescription() : string;
getAiUsage() : string;
getIteration() : int;
getPhaseBefore() : string;
getPhaseAfter() : string;
getStatus() : string;
getDurationMs() : ?float;
getMetadata() : array;
toArray() : array;
```

## `AgentState`

File: `src/Dto/AgentState.php`

```php
class AgentState
__construct(private readonly ?AgentTaskState $task = null, private readonly ?AgentPlanState $plan = null, private readonly ?AgentKnowledgeState $knowledge = null, private readonly ?AgentExecutionState $execution = null, private readonly ?AgentMemoryState $memory = null, private readonly ?AgentContextWindowState $contextWindow = null, private readonly ?AgentBudgetState $budget = null, private readonly ?AgentSuspensionState $suspension = null, private readonly ?AgentResultState $result = null);
static empty() : self;
getTask() : ?AgentTaskState;
getPlan() : ?AgentPlanState;
getKnowledge() : ?AgentKnowledgeState;
getExecution() : ?AgentExecutionState;
getMemory() : ?AgentMemoryState;
getContextWindow() : ?AgentContextWindowState;
getBudget() : ?AgentBudgetState;
getSuspension() : ?AgentSuspensionState;
getResult() : ?AgentResultState;
withTask(?AgentTaskState $task) : self;
withPlan(?AgentPlanState $plan) : self;
withKnowledge(?AgentKnowledgeState $knowledge) : self;
withExecution(?AgentExecutionState $execution) : self;
withMemory(?AgentMemoryState $memory) : self;
withContextWindow(?AgentContextWindowState $contextWindow) : self;
withBudget(?AgentBudgetState $budget) : self;
withSuspension(?AgentSuspensionState $suspension) : self;
withResult(?AgentResultState $result) : self;
toArray() : array;
```

## `AgentSuspension`

File: `src/Dto/AgentSuspension.php`

```php
class AgentSuspension
__construct(private readonly string $id, private readonly string $status, private readonly array $requests, private readonly array $state, private readonly string $createdAt, private readonly array $metadata = [], private readonly string $scopeId = '');
getId() : string;
getStatus() : string;
getRequests() : array;
getState() : array;
getCreatedAt() : string;
getMetadata() : array;
getScopeId() : string;
toArray() : array;
static fromArray(array $data) : self;
```

## `AgentSuspensionClaim`

File: `src/Dto/AgentSuspensionClaim.php`

```php
class AgentSuspensionClaim
__construct(private readonly string $resumeHandle, private readonly string $claimToken, private readonly AgentSuspension $suspension);
getResumeHandle() : string;
getClaimToken() : string;
getSuspension() : AgentSuspension;
```

## `AgentSuspensionScope`

File: `src/Dto/AgentSuspensionScope.php`

```php
class AgentSuspensionScope
static forConversation(string $channelId, string $conversationId) : string;
```

## `AgentSuspensionState`

File: `src/Dto/AgentSuspensionState.php`

```php
class AgentSuspensionState
__construct(private readonly bool $suspended = false, private readonly string $status = AgentExecutionStatus::RUNNING, private readonly array $interactionRequests = [], private readonly string $resumeHandle = '');
isSuspended() : bool;
getStatus() : string;
getResumeHandle() : string;
toArray() : array;
```

## `AgentTaskState`

File: `src/Dto/AgentTaskState.php`

```php
class AgentTaskState
__construct(private readonly string $id = '', private readonly string $description = '', private readonly array $input = [], private readonly array $metadata = []);
getId() : string;
getDescription() : string;
getInput() : array;
getMetadata() : array;
toArray() : array;
```

## `AgentTextTaskRequest`

File: `src/Dto/AgentTextTaskRequest.php`

```php
class AgentTextTaskRequest
__construct(private readonly array $agentConfiguration, private readonly string $taskName, private readonly string $systemPrompt, private readonly string $prompt, private readonly array $context = [], private readonly bool $includeContextProfile = false, private readonly bool $includeToolProfile = false);
getAgentConfiguration() : array;
getTaskName() : string;
getSystemPrompt() : string;
getPrompt() : string;
getContext() : array;
shouldIncludeContextProfile() : bool;
shouldIncludeToolProfile() : bool;
```

## `AgentTextTaskResult`

File: `src/Dto/AgentTextTaskResult.php`

```php
class AgentTextTaskResult
__construct(private readonly string $content, private readonly array $warnings = [], private readonly array $metadata = []);
getContent() : string;
getWarnings() : array;
getMetadata() : array;
toArray() : array;
```

## `AgentToolCacheConfig`

File: `src/Dto/AgentToolCacheConfig.php`

```php
class AgentToolCacheConfig
__construct(private readonly bool $enabled = false, private readonly string $scope = self::SCOPE_CONFIGURATION, private readonly string $scopeKey = '', private readonly string $keyNamespace = 'default', private readonly int $maxEntryBytes = 262144, private readonly array $rules = []);
static disabled() : self;
static fromArray(array $data) : self;
isEnabled() : bool;
getScope() : string;
getScopeKey() : string;
getKeyNamespace() : string;
getMaxEntryBytes() : int;
getRules() : array;
findRule(string $toolName, string $resourceId, string $implementationName) : ?AgentToolCacheRule;
static getAllowedScopes() : array;
```

## `AgentToolCacheEntry`

File: `src/Dto/AgentToolCacheEntry.php`

```php
class AgentToolCacheEntry
__construct(private readonly string $toolIdentity, private readonly string $toolName, private readonly string $argumentsHash, private readonly string $scope, private readonly mixed $output, private readonly string $createdAt, private readonly string $expiresAt, private readonly array $metadata = []);
static fromArray(array $data) : self;
getToolIdentity() : string;
getToolName() : string;
getArgumentsHash() : string;
getScope() : string;
getOutput() : mixed;
getCreatedAt() : string;
getExpiresAt() : string;
getMetadata() : array;
toArray() : array;
```

## `AgentToolCacheRecord`

File: `src/Dto/AgentToolCacheRecord.php`

```php
class AgentToolCacheRecord
__construct(private readonly int $iteration, private readonly string $callId, private readonly string $toolName, private readonly string $toolIdentity, private readonly string $status, private readonly string $cacheKey = '', private readonly string $scope = '', private readonly int $ttlSeconds = 0, private readonly string $reason = '', private readonly array $metadata = []);
getStatus() : string;
toArray() : array;
static getAllowedStatuses() : array;
```

## `AgentToolCacheRule`

File: `src/Dto/AgentToolCacheRule.php`

```php
class AgentToolCacheRule
__construct(private readonly string $toolName, private readonly int $ttlSeconds, private readonly string $resourceId = '', private readonly string $implementationName = '', private readonly string $variant = '', private readonly array $metadata = []);
static fromArray(array $data) : self;
matches(string $toolName, string $resourceId, string $implementationName) : bool;
getToolName() : string;
getTtlSeconds() : int;
getResourceId() : string;
getImplementationName() : string;
getVariant() : string;
getMetadata() : array;
toArray() : array;
```

## `AgentToolContractValidation`

File: `src/Dto/AgentToolContractValidation.php`

```php
class AgentToolContractValidation
__construct(private readonly string $callId, private readonly string $toolName, private readonly string $direction, private readonly string $status, private readonly string $reasonCode, private readonly string $summary, private readonly string $schemaSource = '', private readonly array $issues = [], private readonly array $metadata = []);
getCallId() : string;
getToolName() : string;
getDirection() : string;
getStatus() : string;
getReasonCode() : string;
getSummary() : string;
getSchemaSource() : string;
getIssues() : array;
getMetadata() : array;
passes() : bool;
isValidated() : bool;
isDeclared() : bool;
toArray() : array;
static getAllowedDirections() : array;
static getAllowedStatuses() : array;
```

## `AgentToolResult`

File: `src/Dto/AgentToolResult.php`

```php
class AgentToolResult
static success(string $callId, string $toolName, array $arguments, mixed $output, array $metadata = []) : self;
static failure(string $callId, string $toolName, array $arguments, string $errorCode, string $errorMessage, array $metadata = [], mixed $output = null) : self;
getCallId() : string;
getToolName() : string;
getArguments() : array;
getStatus() : string;
isSuccess() : bool;
getOutput() : mixed;
getErrorCode() : string;
getErrorMessage() : string;
getMetadata() : array;
static fromArray(array $data) : self;
toArray() : array;
```

## `AiChatResult`

File: `src/Dto/AiChatResult.php`

```php
class AiChatResult implements IAiResult
__construct(private readonly string $content, private readonly array $toolCalls, private readonly AiResultMetadata $metadata, private readonly mixed $raw = null);
getContent() : string;
getToolCalls() : array;
hasToolCalls() : bool;
getMetadata() : AiResultMetadata;
getRaw() : mixed;
toArray(bool $includeRaw = false) : array;
```

## `AiEmbeddingResult`

File: `src/Dto/AiEmbeddingResult.php`

```php
class AiEmbeddingResult implements IAiResult
__construct(private readonly array $embeddings, private readonly AiResultMetadata $metadata, private readonly mixed $raw = null);
getEmbeddings() : array;
getMetadata() : AiResultMetadata;
getRaw() : mixed;
toArray(bool $includeRaw = false) : array;
```

## `AiImageResult`

File: `src/Dto/AiImageResult.php`

```php
class AiImageResult implements IAiResult
__construct(private readonly array $images, private readonly AiResultMetadata $metadata, private readonly mixed $raw = null);
getImages() : array;
getMetadata() : AiResultMetadata;
getRaw() : mixed;
toArray(bool $includeRaw = false) : array;
```

## `AiModelConfiguration`

File: `src/Dto/AiModelConfiguration.php`

```php
class AiModelConfiguration
__construct(private readonly string $id, private readonly string $label, private readonly string $driver, private readonly string $model, private readonly string $endpoint, private readonly string $apiKey, private readonly array $options = []);
getId() : string;
getLabel() : string;
getDriver() : string;
getModel() : string;
getEndpoint() : string;
getApiKey() : string;
```

## `AiResultMetadata`

File: `src/Dto/AiResultMetadata.php`

```php
class AiResultMetadata
__construct(private readonly string $operation, private readonly string $provider = '', private readonly string $model = '', private readonly string $requestId = '', private readonly ?int $createdAt = null, private readonly ?float $durationMs = null, private readonly ?string $finishReason = null, private readonly ?AiUsage $usage = null, private readonly array $extra = []);
getOperation() : string;
getProvider() : string;
getModel() : string;
getRequestId() : string;
getCreatedAt() : ?int;
getDurationMs() : ?float;
getFinishReason() : ?string;
getUsage() : AiUsage;
getExtra() : array;
toArray() : array;
```

## `AiSearchResult`

File: `src/Dto/AiSearchResult.php`

```php
class AiSearchResult implements IAiResult
__construct(private readonly string $query, private readonly string $answer, private readonly array $results, private readonly array $citations, private readonly AiResultMetadata $metadata, private readonly mixed $raw = null);
getQuery() : string;
getAnswer() : string;
getResults() : array;
getCitations() : array;
getMetadata() : AiResultMetadata;
getRaw() : mixed;
toArray(bool $includeRaw = false) : array;
```

## `AiToolCall`

File: `src/Dto/AiToolCall.php`

```php
class AiToolCall
__construct(private readonly string $id, private readonly string $name, private readonly array $arguments = [], private readonly array $metadata = []);
getId() : string;
getName() : string;
getArguments() : array;
getMetadata() : array;
static fromArray(array $data) : self;
toArray() : array;
```

## `AiUsage`

File: `src/Dto/AiUsage.php`

```php
class AiUsage
__construct(private readonly ?int $inputTokens = null, private readonly ?int $outputTokens = null, private readonly ?int $totalTokens = null, private readonly ?int $cachedInputTokens = null, private readonly ?int $reasoningTokens = null, private readonly array $metrics = [], private readonly array $details = []);
static none() : self;
static fromArray(array $data) : self;
getInputTokens() : ?int;
getOutputTokens() : ?int;
getTotalTokens() : ?int;
getCachedInputTokens() : ?int;
getReasoningTokens() : ?int;
getMetrics() : array;
getDetails() : array;
merge(self $usage) : self;
toArray() : array;
```

## `AssistantResponseClientPlugin`

File: `src/Dto/AssistantResponseClientPlugin.php`

```php
class AssistantResponseClientPlugin
__construct(private readonly string $name, private readonly string $moduleUrl, private readonly string $exportName, private readonly array $options = []);
getName() : string;
getModuleUrl() : string;
getExportName() : string;
getOptions() : array;
toArray() : array;
```

## `ParsedDocument`

File: `src/Dto/ParsedDocument.php`

```php
class ParsedDocument
__construct(private readonly string $title, private readonly array $blocks, private readonly array $metadata = []);
getTitle() : string;
getBlocks() : array;
getMetadata() : array;
getText() : string;
```

## `ParsedDocumentBlock`

File: `src/Dto/ParsedDocumentBlock.php`

```php
class ParsedDocumentBlock
__construct(private readonly string $type, private readonly string $text, private readonly int $level = 0, private readonly ?int $page = null, private readonly array $metadata = []);
getType() : string;
getText() : string;
getLevel() : int;
getPage() : ?int;
getMetadata() : array;
```

## `ParserFileRequest`

File: `src/Dto/ParserFileRequest.php`

```php
class ParserFileRequest
__construct(private readonly string $path, private readonly string $filename = '', private readonly array $metadata = []);
getPath() : string;
getFilename() : string;
getExtension() : string;
getMetadata() : array;
```

## `ParserServiceDefinition`

File: `src/Dto/ParserServiceDefinition.php`

```php
class ParserServiceDefinition
__construct(private readonly string $id, private readonly string $name, private readonly string $driver, private readonly int $priority = 50, private readonly array $supportedTypes = [], private readonly array $supportedExtensions = []);
getId() : string;
getName() : string;
getDriver() : string;
getPriority() : int;
getSupportedTypes() : array;
getSupportedExtensions() : array;
supportsType(string $type) : bool;
```

## `ParserServiceResult`

File: `src/Dto/ParserServiceResult.php`

```php
class ParserServiceResult
__construct(private readonly string $text, private readonly mixed $structured = null, private readonly array $metadata = [], private readonly array $attachments = [], private readonly mixed $raw = null);
getText() : string;
getStructured() : mixed;
getMetadata() : array;
getAttachments() : array;
getRaw() : mixed;
```

## `RealtimeSpeechToTextSession`

File: `src/Dto/RealtimeSpeechToTextSession.php`

```php
class RealtimeSpeechToTextSession
__construct(private readonly string $provider, private readonly string $transport, private readonly string $endpoint, private readonly string $clientToken, private readonly string $expiresAt, private readonly string $model, private readonly string $audioEncoding, private readonly int $sampleRate, private readonly array $options = []);
getProvider() : string;
getTransport() : string;
getEndpoint() : string;
getClientToken() : string;
getExpiresAt() : string;
getModel() : string;
getAudioEncoding() : string;
getSampleRate() : int;
getOptions() : array;
toArray() : array;
```

## `RealtimeSpeechToTextSessionRequest`

File: `src/Dto/RealtimeSpeechToTextSessionRequest.php`

```php
class RealtimeSpeechToTextSessionRequest
__construct(private readonly string $serviceId, private readonly string $language = '', private readonly array $options = []);
getServiceId() : string;
getLanguage() : string;
getOptions() : array;
```

## `RetrievalHit`

File: `src/Dto/RetrievalHit.php`

```php
class RetrievalHit
__construct(public readonly string $id, public readonly ?float $score, public readonly array $payload);
toArray() : array;
```

## `RetrievalIndexItem`

File: `src/Dto/RetrievalIndexItem.php`

```php
class RetrievalIndexItem
__construct(public string $collectionKey, public int $chunkIndex, public string $text, public string $hash, public array $metadata = [], array $denseVector = [], array $representations = []);
hasDenseVector() : bool;
getRepresentation(string $name) : string;
```

## `RetrievalSearchRequest`

File: `src/Dto/RetrievalSearchRequest.php`

```php
class RetrievalSearchRequest
__construct(public readonly string $collectionKey, public readonly string $query, public readonly string $mode = self::MODE_AUTO, public readonly array $denseVector = [], public readonly ?array $filterSpec = null, public readonly array $phrases = [], public readonly array $phoneticPhrases = [], public readonly array $requiredTerms = [], public readonly array $excludedTerms = [], public readonly string $phoneticText = '', public readonly int $limit = 5, public readonly int $candidateLimit = 20, public readonly ?float $denseMinScore = null);
```

## `RetrievalSearchResult`

File: `src/Dto/RetrievalSearchResult.php`

```php
class RetrievalSearchResult
__construct(private readonly array $hits, private readonly array $channels = [], private readonly array $metadata = []);
getHits() : array;
getChannels() : array;
getMetadata() : array;
toArray() : array;
```

## `SpeechToTextRequest`

File: `src/Dto/SpeechToTextRequest.php`

```php
class SpeechToTextRequest
__construct(private readonly string $serviceId, private readonly string $audio, private readonly string $mimeType = 'audio/wav', private readonly string $language = '', private readonly array $options = []);
getServiceId() : string;
getAudio() : string;
getMimeType() : string;
getLanguage() : string;
getOptions() : array;
```

## `SpeechToTextResult`

File: `src/Dto/SpeechToTextResult.php`

```php
class SpeechToTextResult
__construct(private readonly string $text, private readonly string $language = '', private readonly array $metadata = [], private readonly mixed $raw = null);
getText() : string;
getLanguage() : string;
getMetadata() : array;
getRaw() : mixed;
toArray(bool $includeRaw = false) : array;
```

## `TextToSpeechRequest`

File: `src/Dto/TextToSpeechRequest.php`

```php
class TextToSpeechRequest
__construct(private readonly string $serviceId, private readonly string $text, private readonly string $language = '', private readonly array $options = []);
getServiceId() : string;
getText() : string;
getLanguage() : string;
getOptions() : array;
```

## `TextToSpeechResult`

File: `src/Dto/TextToSpeechResult.php`

```php
class TextToSpeechResult
__construct(private readonly string $mimeType, private readonly ?IAudioMedia $audio = null, private readonly array $metadata = [], private readonly mixed $raw = null);
getMimeType() : string;
getAudio() : ?IAudioMedia;
hasAudio() : bool;
getMetadata() : array;
getRaw() : mixed;
```
