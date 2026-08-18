# AssistantFoundation

## Purpose

AssistantFoundation is the shared contract package for assistant, agent, AI service, retrieval, parser, speech, and response-extension integrations in BASE3.

The package deliberately contains stable interfaces and provider-neutral data transfer objects. It does not select final providers and it does not own MissionBay orchestration internals.

The architectural rule is:

```text
consumer plugin
    -> AssistantFoundation contract
    -> runtime or implementation plugin
```

A reusable consumer should not need to import a concrete MissionBay, OpenAI, Mistral, Qdrant, parser, or speech implementation merely to express what it needs.

## Package boundary

AssistantFoundation is the correct home when a type is intended to cross plugin boundaries and one or more of the following are true:

* another runtime may implement the same behavior;
* a consumer should depend on a stable interface rather than an implementation plugin;
* a discoverable extension point must be shared by several plugins;
* a DTO is exchanged between runtime routers, agent implementations, UIs, jobs, or integrations;
* a provider-neutral AI, retrieval, parser, or speech result needs a common representation.

MissionBay-specific factories, flow nodes, resource factories, profile repositories, orchestration helpers, and internal state access remain in `MissionBay\Api` or MissionBay implementation namespaces.

Shared concrete routing and runtime composition belongs in AssistantRuntime.

## Directory structure

```text
AssistantFoundation/
├── docs/
├── src/
│   ├── Api/
│   ├── Dto/
│   ├── Event/
│   ├── Exception/
│   └── AssistantFoundationPlugin.php
├── test/
├── tpl/
└── VERSION
```

`AssistantFoundationPlugin` only registers the plugin object as a replaceable shared service. It intentionally does not perform runtime composition.

## Contract families

### Agent execution and runtime routing

The runtime-neutral execution surface is built around:

* `IAgentExecutionService`
* `IAgentRuntimeService`
* `IAgentRuntimeRegistry`
* `IAgentRuntimeSelector`
* `IAgentConversationService`
* `IAgentConversationRuntimeService`
* `IAgentTextTaskService`
* `IAgentTextTaskRuntimeService`
* `IAgentConfigFormService`
* `IAgentRuntimeConfigFormService`
* `IAgentEventSink`

These contracts allow a host such as Chatbot or a scheduled job to execute an agent without importing the concrete runtime implementation.

### Agent composition and orchestration extensions

MissionBay and other runtimes can expose discoverable components through:

* `IAgentStage`
* `IAgentActionPolicy`
* `IAgentCapabilityProvider`
* `IAgentCapabilitySelector`
* `IAgentModule`
* `IAgentContextContributor`
* `IAgentContextProfileProvider`
* `IAgentContextProfileService`
* `IAgentToolProfileProvider`
* `IAgentToolProfileService`
* `IAgentToolSet`
* `IAgentConfirmableToolSet`
* `IAgentSuspensionRepository`
* `IAgentToolResultCache`

The corresponding DTOs carry typed execution state, capability catalogs, action decisions, suspension data, tool results, validation records, budgets, and context-window assessments.

### AI model and provider adapters

Provider-neutral AI contracts include:

* `IAiChatModel`
* `IAiEmbeddingModel`
* `IImageGenerationModel`
* `IAiProvider`
* `IAiResult`
* `IAiModelConfigurationProvider`
* `IAiServiceTester`

Model implementations return typed result DTOs such as `AiChatResult`, `AiEmbeddingResult`, `AiImageResult`, `AiResultMetadata`, `AiUsage`, and `AiToolCall`.

### Configured service drivers

Service and connection discovery is expressed by:

* `IServiceDriverDefinition`
* `IConnectionDriverDefinition`

The definitions describe service types, implementation interfaces, implementation names, configuration schemas, defaults, supported connection types, and health-check metadata. They do not themselves choose active runtime records.

### Retrieval

The retrieval boundary consists of:

* `IRetrievalIndex`
* `IRetrievalCollectionDefinition`
* `IRetrievalFilterProvider`
* `IRetrievalIndexInspector`
* `IVectorSearch`
* `IConfigurableVectorSearch`
* `IPhoneticEncoder`

A domain-owned collection definition controls physical collection mapping, index schema, payload schema, agent-filter allowlists, context projection, validation, and optional phonetic representation selection.

### Parsing

`IFileParserService` is the provider-neutral configured parser-service contract. Parser requests and results use `ParserFileRequest`, `ParserServiceDefinition`, `ParserServiceResult`, `ParsedDocument`, and `ParsedDocumentBlock`.

### Speech

Speech integrations use:

* `ISpeechToTextService`
* `IRealtimeSpeechToTextSessionService`
* `ITextToSpeechService`
* `ITextToSpeechStream`

Complete STT and TTS operations are intentionally separate from realtime-session creation and TTS chunk streaming.

### Assistant response extensions

`IAssistantResponseExtension` allows a configured component to contribute runtime instructions plus an optional client plugin description without tying the host UI to one implementation plugin.

`IAssistantResponseExtensionExamples` may provide example prompts for UIs or diagnostics.

## DTO design

DTOs in `src/Dto` are provider-neutral values. Most are immutable and expose explicit getters plus `toArray()` and, where useful, `fromArray()`.

Important groups include:

* execution request and result DTOs;
* conversation and conversation-scope DTOs;
* typed agent state sections;
* capability catalog and selection DTOs;
* action review, approval, and resume DTOs;
* suspension DTOs;
* tool result, cache, and contract-validation DTOs;
* AI result and usage DTOs;
* parser DTOs;
* retrieval DTOs;
* speech DTOs;
* assistant response client-plugin DTOs.

Consumers should prefer these DTOs over undocumented arrays when the data crosses plugin boundaries.

## Runtime composition

AssistantFoundation does not wire the active runtime. `AssistantRuntime` provides the default shared registry, selector, routers, profile aggregation, suspension repository, and form composition. Runtime implementations such as MissionBay register named runtime services discoverable through the class map.

```mermaid
flowchart LR
    C[Consumer] --> E[IAgentExecutionService]
    E --> AR[AssistantRuntime router]
    AR --> R[Named runtime]
    R --> AF[AssistantFoundation DTOs and contracts]
```

## Documentation

Start with:

* [overview](docs/overview.md)
* [architecture and boundary](docs/architecture-and-boundary.md)
* [agent runtime contracts](docs/agent-runtime-contracts.md)
* [agent state and DTOs](docs/agent-state-and-dtos.md)
* [AI model and provider contracts](docs/ai-model-and-provider-contracts.md)
* [retrieval contracts](docs/retrieval-contracts.md)
* [parser and speech contracts](docs/parser-and-speech-contracts.md)
* [assistant response extensions](docs/response-extensions.md)
* [service and connection drivers](docs/service-and-connection-drivers.md)
* [extension points](docs/extension-points.md)
* [API reference](docs/api-reference.md)
* [DTO reference](docs/dto-reference.md)

## Dependency direction

Reusable plugins should depend on AssistantFoundation interfaces and DTOs, not on MissionBay implementation classes, when replacement is expected.

Implementation plugins may depend on AssistantFoundation and implement its slots.

Project plugins or host bootstraps select final implementations.

## License

GPL-3.0.
