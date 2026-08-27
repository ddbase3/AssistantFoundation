# AssistantFoundation API Reference

## Purpose

This reference is derived from the public interfaces present in the current package. The thematic documents explain ownership and intended use; this file provides a compact signature inventory.

## Interfaces

### `IAgentActionPolicy`

Source: `src/Api/IAgentActionPolicy.php`.

Declaration: `IAgentActionPolicy extends IComponent`

* `name() : string`
* `getDescription() : string`
* `getAiUsage() : string`
* `evaluate(AgentAction $action, IAgentContext $context) : AgentActionDecision`

### `IAgentCapabilityProvider`

Source: `src/Api/IAgentCapabilityProvider.php`.

Declaration: `IAgentCapabilityProvider extends IComponent`

* `name() : string`
* `tools(IAgentContext $context) : iterable`
* `resourceProviders(IAgentContext $context) : iterable`
* `promptProviders(IAgentContext $context) : iterable`

### `IAgentCapabilitySelector`

Source: `src/Api/IAgentCapabilitySelector.php`.

* `select(AgentCapabilityCatalog $catalog, AgentCapabilitySelectionRequest $request) : AgentCapabilitySelection`

### `IAgentConfigFormService`

Source: `src/Api/IAgentConfigFormService.php`.

* `getDefaultSettings() : array`
* `normalizeSettings(array $settings) : array`
* `getPostedSettings(array &$errors, ?string $runtimeId = null) : array`
* `getPostedViewValues(?string $runtimeId = null) : array`
* `settingsToViewValues(array $settings) : array`
* `assignViewData(IMvcView $view, array $settings, array $options = []) : void`

### `IAgentConfirmableToolSet`

Source: `src/Api/IAgentConfirmableToolSet.php`.

Declaration: `IAgentConfirmableToolSet extends IAgentToolSet`

* `prepareSuspension(string $callId, string $toolName, array $arguments, array $metadata = []) : ?AgentSuspension`
* `resumeSuspension(AgentSuspension $suspension, AgentInteractionResponse $response, array $metadata = []) : AgentToolResult`

### `IAgentContext`

Source: `src/Api/IAgentContext.php`.

Declaration: `IAgentContext extends IBase`

* `getMemory() : IAgentMemory`
* `setMemory(IAgentMemory $memory) : void`
* `setVar(string $key, mixed $value) : void`
* `getVar(string $key) : mixed`
* `forgetVar(string $key) : void`
* `listVars() : array`

### `IAgentContextContributor`

Source: `src/Api/IAgentContextContributor.php`.

Declaration: `IAgentContextContributor extends IComponent`

* `contribute(IAgentContext $context) : iterable`
* `getPriority() : int`

### `IAgentContextProfileProvider`

Source: `src/Api/IAgentContextProfileProvider.php`.

Declaration: `IAgentContextProfileProvider extends IBase`

* `static getProviderId() : string`
* `getOptions() : array`
* `hasProfile(string $profileId) : bool`
* `build(string $profileId, AgentExecutionRequest $request) : AgentContextProfileResult`

### `IAgentContextProfileService`

Source: `src/Api/IAgentContextProfileService.php`.

Declaration: `IAgentContextProfileService extends IBase`

* `getOptions() : array`
* `hasProfile(string $profileId) : bool`
* `build(string $profileId, AgentExecutionRequest $request) : AgentContextProfileResult`

### `IAgentConversationMemory`

Source: `src/Api/IAgentConversationMemory.php`.

Declaration: `IAgentConversationMemory extends IAgentMemory`

* `bindConversationScope(AgentConversationScope $scope) : void`
* `listConversations() : array`
* `getConversation(string $conversationId) : ?AgentConversation`
* `getActiveConversation() : ?AgentConversation`
* `createConversation(?string $conversationId = null, string $title = '', string $titleSource = AgentConversation::TITLE_SOURCE_TEMPORARY, string $openingMessage = '') : AgentConversation`
* `activateConversation(string $conversationId) : AgentConversation`
* `renameConversation(string $conversationId, string $title, string $titleSource = AgentConversation::TITLE_SOURCE_MANUAL) : AgentConversation`
* `deleteConversation(string $conversationId) : void`
* `touchConversation(string $conversationId) : AgentConversation`

### `IAgentConversationRuntimeService`

Source: `src/Api/IAgentConversationRuntimeService.php`.

Declaration: `IAgentConversationRuntimeService extends IAgentConversationService`

* `static getRuntimeId() : string`

### `IAgentConversationService`

Source: `src/Api/IAgentConversationService.php`.

Declaration: `IAgentConversationService extends IBase`

* `getState(AgentConversationRequest $request, string $conversationId = '') : AgentConversationState`
* `createConversation(AgentConversationRequest $request, ?string $conversationId = null, string $title = '', string $titleSource = AgentConversation::TITLE_SOURCE_TEMPORARY, string $openingMessage = '') : AgentConversationState`
* `activateConversation(AgentConversationRequest $request, string $conversationId) : AgentConversationState`
* `renameConversation(AgentConversationRequest $request, string $conversationId, string $title, string $titleSource = AgentConversation::TITLE_SOURCE_MANUAL) : AgentConversationState`
* `deleteConversation(AgentConversationRequest $request, string $conversationId) : AgentConversationState`
* `appendMessage(AgentConversationRequest $request, string $conversationId, array $message) : AgentConversationState`
* `touchConversation(AgentConversationRequest $request, string $conversationId) : AgentConversationState`

### `IAgentEventSink`

Source: `src/Api/IAgentEventSink.php`.

* `emit(AgentExecutionEvent $event) : void`
* `isCancelled() : bool`

### `IAgentExecutionService`

Source: `src/Api/IAgentExecutionService.php`.

Declaration: `IAgentExecutionService extends IBase`

* `execute(AgentExecutionRequest $request, ?IAgentEventSink $eventSink = null) : AgentExecutionResult`

### `IAgentMemory`

Source: `src/Api/IAgentMemory.php`.

Declaration: `IAgentMemory extends IBase`

* `loadNodeHistory(string $nodeId) : array`
* `appendNodeHistory(string $nodeId, array $message) : void`
* `setFeedback(string $nodeId, string $messageId, ?string $feedback) : bool`
* `resetNodeHistory(string $nodeId) : void`
* `getPriority() : int`

### `IAgentModule`

Source: `src/Api/IAgentModule.php`.

Declaration: `IAgentModule extends IComponent`

* `manifest() : AgentModuleManifest`
* `activate(IAgentContext $context) : AgentModuleActivation`

### `IAgentRuntimeConfigFormService`

Source: `src/Api/IAgentRuntimeConfigFormService.php`.

Declaration: `IAgentRuntimeConfigFormService extends IBase`

* `static getRuntimeId() : string`
* `getDefaultSettings() : array`
* `normalizeSettings(array $settings) : array`
* `getPostedSettings(array &$errors) : array`
* `getPostedViewValues() : array`
* `settingsToViewValues(array $settings) : array`
* `getConfigurationSummary(array $settings) : array`
* `getTemplate() : string`
* `getTemplateData(array $values, array $options = []) : array`

### `IAgentRuntimeRegistry`

Source: `src/Api/IAgentRuntimeRegistry.php`.

Declaration: `IAgentRuntimeRegistry extends IBase`

* `getRuntimeIds() : array`
* `getRuntimeOptions() : array`
* `hasRuntime(string $runtimeId) : bool`
* `getExecutionService(string $runtimeId) : IAgentRuntimeService`
* `getConfigFormService(string $runtimeId) : IAgentRuntimeConfigFormService`
* `getConversationService(string $runtimeId) : IAgentConversationRuntimeService`
* `getTextTaskService(string $runtimeId) : IAgentTextTaskRuntimeService`

### `IAgentRuntimeSelector`

Source: `src/Api/IAgentRuntimeSelector.php`.

Declaration: `IAgentRuntimeSelector extends IBase`

* `selectRuntimeId(array $agentConfiguration) : string`
* `getDefaultRuntimeId() : string`

### `IAgentRuntimeService`

Source: `src/Api/IAgentRuntimeService.php`.

Declaration: `IAgentRuntimeService extends IAgentExecutionService`

* `static getRuntimeId() : string`
* `static getRuntimeLabel() : string`
* `static getRuntimeDescription() : string`
* `static getDefaultPriority() : int`

### `IAgentStage`

Source: `src/Api/IAgentStage.php`.

Declaration: `IAgentStage extends IComponent`

* `name() : string`
* `getDescription() : string`
* `getAiUsage() : string`
* `supports(IAgentContext $context) : bool`
* `process(IAgentContext $context) : AgentStageResult`

### `IAgentSuspensionRepository`

Source: `src/Api/IAgentSuspensionRepository.php`.

* `create(AgentSuspension $suspension, int $ttlSeconds) : string`
* `findPending(string $scopeId) : ?AgentSuspensionState`
* `findAll(string $scopeId) : array`
* `claim(string $resumeHandle) : AgentSuspensionClaim`
* `release(AgentSuspensionClaim $claim) : void`
* `consume(AgentSuspensionClaim $claim, ?AgentSuspensionResolution $resolution = null) : void`

### `IAgentTextTaskRuntimeService`

Source: `src/Api/IAgentTextTaskRuntimeService.php`.

Declaration: `IAgentTextTaskRuntimeService extends IAgentTextTaskService`

* `static getRuntimeId() : string`

### `IAgentTextTaskService`

Source: `src/Api/IAgentTextTaskService.php`.

Declaration: `IAgentTextTaskService extends IBase`

* `executeTextTask(AgentTextTaskRequest $request) : AgentTextTaskResult`

### `IAgentToolProfileProvider`

Source: `src/Api/IAgentToolProfileProvider.php`.

Declaration: `IAgentToolProfileProvider extends IBase`

* `static getProviderId() : string`
* `getOptions() : array`
* `hasProfile(string $profileId) : bool`
* `resolve(array $profileIds, AgentExecutionRequest $request) : IAgentToolSet`

### `IAgentToolProfileService`

Source: `src/Api/IAgentToolProfileService.php`.

Declaration: `IAgentToolProfileService extends IBase`

* `getOptions() : array`
* `hasProfile(string $profileId) : bool`
* `resolve(array $profileIds, AgentExecutionRequest $request) : IAgentToolSet`

### `IAgentToolResultCache`

Source: `src/Api/IAgentToolResultCache.php`.

* `isAvailable() : bool`
* `get(string $key) : ?AgentToolCacheEntry`
* `put(string $key, AgentToolCacheEntry $entry, int $ttlSeconds) : void`
* `delete(string $key) : bool`

### `IAgentToolSet`

Source: `src/Api/IAgentToolSet.php`.

* `getCatalog() : AgentCapabilityCatalog`
* `getWarnings() : array`
* `execute(string $callId, string $toolName, array $arguments, array $metadata = []) : AgentToolResult`

### `IAiChatModel`

Source: `src/Api/IAiChatModel.php`.

* `complete(array $messages, array $tools = []) : AiChatResult`
* `chat(array $messages) : string`
* `raw(array $messages, array $tools = []) : mixed`
* `streamResult(array $messages, array $tools, callable $onData, callable $onMeta = null) : AiChatResult`
* `stream(array $messages, array $tools, callable $onData, callable $onMeta = null) : void`
* `setOptions(array $options) : void`
* `getOptions() : array`

### `IAiEmbeddingModel`

Source: `src/Api/IAiEmbeddingModel.php`.

* `embedResult(array $texts) : AiEmbeddingResult`
* `embed(array $texts) : array`
* `setOptions(array $options) : void`
* `getOptions() : array`

### `IAiModelConfigurationProvider`

Source: `src/Api/IAiModelConfigurationProvider.php`.

Declaration: `IAiModelConfigurationProvider extends IBase`

* `getOptions() : array`
* `has(string $id) : bool`
* `get(string $id) : AiModelConfiguration`

### `IAiProvider`

Source: `src/Api/IAiProvider.php`.

Declaration: `IAiProvider extends IBase`

* `setOptions(array $options) : void`
* `getOptions() : array`
* `request(string $path, array $payload, array $options = []) : array`
* `stream(string $path, array $payload, callable $onChunk, array $options = []) : void`

### `IAiResult`

Source: `src/Api/IAiResult.php`.

* `getMetadata() : AiResultMetadata`
* `getRaw() : mixed`
* `toArray(bool $includeRaw = false) : array`

### `IAiServiceTester`

Source: `src/Api/IAiServiceTester.php`.

* `static getType() : string`
* `test(array $config) : array`

### `IAssistantResponseExtension`

Source: `src/Api/IAssistantResponseExtension.php`.

Declaration: `IAssistantResponseExtension extends IComponent`

* `id() : string`
* `getLabel() : string`
* `getDescription() : string`
* `getPriority() : int`
* `isEnabledByDefault() : bool`
* `getRequirements() : array`
* `getSystemPrompt(array $context) : string`
* `getClientPlugin(array $context) : ?AssistantResponseClientPlugin`
* `getClientPluginOptions(array $context) : array`

### `IAssistantResponseExtensionExamples`

Source: `src/Api/IAssistantResponseExtensionExamples.php`.

* `getExamplePrompts() : array`

### `IConfigurableVectorSearch`

Source: `src/Api/IConfigurableVectorSearch.php`.

Declaration: `IConfigurableVectorSearch extends IVectorSearch`

* `setOptions(array $options) : void`
* `getOptions() : array`

### `IConnectionDriverDefinition`

Source: `src/Api/IConnectionDriverDefinition.php`.

Declaration: `IConnectionDriverDefinition extends IBase`

* `getDriver() : string`
* `getLabel() : string`
* `getConnectionType() : string`
* `getConfigSchema() : array`
* `getDefaultConfig() : array`
* `getHealthCheckSchema() : array`

### `IFileParserService`

Source: `src/Api/IFileParserService.php`.

Declaration: `IFileParserService extends IBase`

* `setOptions(array $options) : void`
* `getOptions() : array`
* `getPriority() : int`
* `supportsFile(ParserFileRequest $request) : bool`
* `parseFile(ParserFileRequest $request) : ParserServiceResult`

### `IImageGenerationModel`

Source: `src/Api/IImageGenerationModel.php`.

Declaration: `IImageGenerationModel extends IBase`

* `generateResult(string $prompt, array $options = []) : AiImageResult`
* `setOptions(array $options) : void`
* `getOptions() : array`
* `generate(string $prompt, array $options = []) : array`

### `IPhoneticEncoder`

Source: `src/Api/IPhoneticEncoder.php`.

Declaration: `IPhoneticEncoder extends IBase`

* `getAlgorithm() : string`
* `getVersion() : string`
* `encode(string $token) : string`

### `IRealtimeSpeechToTextSessionService`

Source: `src/Api/IRealtimeSpeechToTextSessionService.php`.

* `createSession(RealtimeSpeechToTextSessionRequest $request) : RealtimeSpeechToTextSession`

### `IRetrievalCollectionDefinition`

Source: `src/Api/IRetrievalCollectionDefinition.php`.

* `getCollectionKeys() : array`
* `getBackendCollectionName(string $collectionKey) : string`
* `getIndexSchema(string $collectionKey) : array`
* `getPayloadSchema(string $collectionKey) : array`
* `getAgentFilterSchema(string $collectionKey) : array`
* `getAgentContextFields(string $collectionKey) : array`
* `getContextSchema(string $collectionKey) : array`
* `getPhoneticEncoderNames(string $collectionKey, array $context = []) : array`
* `validate(RetrievalIndexItem $item) : void`
* `buildPayload(RetrievalIndexItem $item) : array`
* `projectPayload(string $collectionKey, array $payload) : array`

### `IRetrievalFilterProvider`

Source: `src/Api/IRetrievalFilterProvider.php`.

* `getRetrievalFilter() : ?array`

### `IRetrievalIndex`

Source: `src/Api/IRetrievalIndex.php`.

* `upsert(RetrievalIndexItem $item) : void`
* `existsByHash(string $collectionKey, string $hash) : bool`
* `existsByFilter(string $collectionKey, array $filter) : bool`
* `deleteByFilter(string $collectionKey, array $filter) : int`
* `search(RetrievalSearchRequest $request) : RetrievalSearchResult`
* `context(string $collectionKey, string $pointId, int $before = 1, int $after = 1, ?array $filterSpec = null) : RetrievalSearchResult`
* `createCollection(string $collectionKey) : void`
* `deleteCollection(string $collectionKey) : void`
* `getInfo(string $collectionKey) : array`

### `IRetrievalIndexInspector`

Source: `src/Api/IRetrievalIndexInspector.php`.

* `inspectPoints(string $collectionKey, int $limit = 10, ?array $filterSpec = null, string|int|null $offset = null, bool $withVectorSummary = false) : array`

### `IServiceDriverDefinition`

Source: `src/Api/IServiceDriverDefinition.php`.

Declaration: `IServiceDriverDefinition extends IBase`

* `getDriver() : string`
* `getServiceType() : string`
* `getLabel() : string`
* `requiresConnection() : bool`
* `getSupportedConnectionTypes() : array`
* `getImplementationInterface() : string`
* `getImplementationName() : string`
* `getConfigSchema() : array`
* `getDefaultConfig() : array`

### `ISpeechToTextService`

Source: `src/Api/ISpeechToTextService.php`.

* `transcribe(SpeechToTextRequest $request) : SpeechToTextResult`

### `ITextToSpeechService`

Source: `src/Api/ITextToSpeechService.php`.

* `synthesize(TextToSpeechRequest $request) : TextToSpeechResult`
* `stream(TextToSpeechRequest $request, ITextToSpeechStream $stream) : TextToSpeechResult`

### `ITextToSpeechStream`

Source: `src/Api/ITextToSpeechStream.php`.

* `start(string $mimeType, array $metadata = []) : void`
* `write(string $audio) : void`
* `isCancelled() : bool`

### `IVectorSearch`

Source: `src/Api/IVectorSearch.php`.

* `search(array $vector, int $limit = 3, ?float $minScore = null) : array`

## Shared DTOs

The current package contains the following shared DTO files:

* `AgentAction`
* `AgentActionDecision`
* `AgentActionReview`
* `AgentBudget`
* `AgentBudgetAssessment`
* `AgentBudgetState`
* `AgentCapability`
* `AgentCapabilityCatalog`
* `AgentCapabilitySelection`
* `AgentCapabilitySelectionConfig`
* `AgentCapabilitySelectionRequest`
* `AgentCapabilitySourceConfig`
* `AgentContextAssessment`
* `AgentContextCompaction`
* `AgentContextProfileResult`
* `AgentContextWindowState`
* `AgentContinuationDecision`
* `AgentConversation`
* `AgentConversationRequest`
* `AgentConversationScope`
* `AgentConversationState`
* `AgentExecutionEvent`
* `AgentExecutionRequest`
* `AgentExecutionResult`
* `AgentExecutionState`
* `AgentExecutionStatus`
* `AgentInstructionBlock`
* `AgentInteractionRequest`
* `AgentInteractionResponse`
* `AgentKnowledgeState`
* `AgentMemoryState`
* `AgentModuleActivation`
* `AgentModuleManifest`
* `AgentMutationCommitDecision`
* `AgentMutationCommitSnapshot`
* `AgentPlanState`
* `AgentProgressAssessment`
* `AgentResult`
* `AgentResultState`
* `AgentResultVerification`
* `AgentResume`
* `AgentStageMount`
* `AgentStageResult`
* `AgentStageSlot`
* `AgentStageTraceEntry`
* `AgentState`
* `AgentSuspension`
* `AgentSuspensionClaim`
* `AgentSuspensionScope`
* `AgentSuspensionState`
* `AgentTaskState`
* `AgentTextTaskRequest`
* `AgentTextTaskResult`
* `AgentToolCacheConfig`
* `AgentToolCacheEntry`
* `AgentToolCacheRecord`
* `AgentToolCacheRule`
* `AgentToolContractValidation`
* `AgentToolResult`
* `AiChatResult`
* `AiEmbeddingResult`
* `AiImageResult`
* `AiModelConfiguration`
* `AiResultMetadata`
* `AiSearchResult`
* `AiToolCall`
* `AiUsage`
* `AssistantResponseClientPlugin`
* `ParsedDocument`
* `ParsedDocumentBlock`
* `ParserFileRequest`
* `ParserServiceDefinition`
* `ParserServiceResult`
* `RealtimeSpeechToTextSession`
* `RealtimeSpeechToTextSessionRequest`
* `RetrievalHit`
* `RetrievalIndexItem`
* `RetrievalSearchRequest`
* `RetrievalSearchResult`
* `SpeechToTextRequest`
* `SpeechToTextResult`
* `TextToSpeechRequest`
* `TextToSpeechResult`

## Events and exceptions

* `AiProviderRequestCompletedEvent` provides normalized provider-request completion data for event consumers.
* `AgentSuspensionRepositoryException` is the shared suspension repository failure category.
