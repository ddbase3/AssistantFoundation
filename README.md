# AssistantFoundation Plugin

The **AssistantFoundation Plugin** provides the foundational API layer for all MissionBay and BASE3 components related to AI, chatbots, and agent-based systems. It defines a clean set of interfaces that act as contracts between different parts of the framework, ensuring modularity, stability, and consistent integration across plugins.

---

## Purpose

In complex agent-driven systems, a clear separation between **API definitions** and their **implementations** is essential.
The AssistantFoundation Plugin serves exactly this purpose:

* Central place for all **interfaces** related to AI assistants, chatbots, and MissionBay workflows
* Guarantees consistent **contracts** for developers implementing or extending functionality
* Improves **maintainability** by avoiding circular dependencies between plugins
* Provides a **stable surface** that other plugins or external systems can rely on

---

## Scope

This plugin is focused solely on **interfaces**.
It does not contain implementations, storage logic, or UI elements. Instead, it defines the contracts for the following areas:

* **Agents** – lifecycle, execution, and orchestration of assistant nodes
* **Contexts** – passing dynamic variables and optional typed run state across nodes and flows
* **Memories & Context** – storing conversation history and contributing typed run-local instruction/context blocks
* **Nodes** – defining input/output structure and execution contracts
* **Resources** – external services or tools connected to the agent system
* **Capabilities & Modules** – configured provider bundles, module activation, bounded tool selection, and run-local stage mounts
* **Config & Value Resolution** – consistent way to inject runtime configuration

---

## Integration

The AssistantFoundation Plugin is designed to be imported by other MissionBay/BASE3 plugins, such as:

* **Chatbot** (Services)
* **MissionBay** (execution engine and node definitions)

By depending only on the interfaces in AssistantFoundation, these plugins remain decoupled from specific implementations.

---

## Benefits

* **Clear contracts**: Every service or node knows exactly what to expect
* **Extensibility**: New nodes and resources can be added without breaking existing code
* **Reusability**: Interfaces can be shared across multiple plugins or projects
* **Future-proofing**: Stable API surface makes upgrades and refactoring easier

---

## Example Structure

```
AssistantFoundation/
 └─ src/
     └─ Api/
         ├─ IAgent.php
         ├─ IAgentContext.php
         ├─ IAgentMemory.php
         ├─ IAgentConversationMemory.php
         ├─ IAgentContextContributor.php
         ├─ IAgentNode.php
         ├─ IAgentResource.php
         ├─ IAgentConfigValueResolver.php
         ├─ IAgentCapabilityProvider.php
         ├─ IAgentModule.php
         └─ ...
     └─ Dto/
         ├─ AgentCapabilitySourceConfig.php
         ├─ AgentInstructionBlock.php
         ├─ AgentState.php
         ├─ AgentResult.php
         ├─ AgentModuleActivation.php
         ├─ AgentStageMount.php
         └─ ...
```

---

## Conversation memory and context contribution

`IAgentMemory` remains the compatible chat-history API. Two explicit contracts clarify how implementations are used:

* `IAgentConversationMemory` marks a memory that loads and receives visible dialog messages.
* `IAgentContextContributor` returns typed `AgentInstructionBlock` values for a new agent turn and does not define chat-history writes.

A configured component may implement other roles at the same time. For example, a user-preference component can implement `IAgentTool` and `IAgentContextContributor` while sharing one configuration and storage implementation.

## Typed agent state and result

AssistantFoundation provides transport-neutral state and result DTOs divided into task, plan, knowledge, execution, memory, context-window, budget, suspension, and result sections. Runtime-specific context extensions remain in the plugin that owns their lifecycle.

`AgentResult` is transport-neutral and can represent completed, failed, partial, and suspended runs.

## License

AssistantFoundation is licensed under the GPL 3.0 license

