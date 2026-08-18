# Retrieval Contracts

## Purpose

The retrieval contracts separate generic vector/index operations from domain-owned schema and security semantics.

## `IRetrievalIndex`

`IRetrievalIndex` is the main storage/retrieval boundary. It supports:

* upsert of `RetrievalIndexItem`;
* existence checks by hash and filter;
* deletion by filter;
* hybrid search through `RetrievalSearchRequest`;
* neighbor context around a point;
* collection create/delete;
* collection information.

The interface uses a logical `collectionKey`. Backend collection naming is intentionally delegated to the collection definition.

## `IRetrievalCollectionDefinition`

A domain-owned collection definition supplies:

* all available logical keys;
* logical-to-backend collection mapping;
* dense/sparse/phrase index schema;
* payload schema;
* agent-visible filter schema;
* agent-visible context fields;
* neighbor grouping/position schema;
* phonetic encoder selection;
* item validation;
* payload construction;
* payload projection.

This is the central security boundary between stored technical metadata and model-visible retrieval context.

A backend must not simply return all stored payload fields to an agent when `projectPayload()` defines a smaller projection.

## Mandatory filters

`IRetrievalFilterProvider` contributes server-side filter constraints. These filters are additive to model/user requested filters.

A consumer must not allow an agent-provided filter to remove mandatory ACL or domain restrictions.

## Diagnostics

`IRetrievalIndexInspector` exposes bounded point inspection without requiring administration code to depend on a concrete Qdrant client.

## Vector search compatibility slot

`IVectorSearch` is the smaller legacy/simple dense-vector search contract.

`IConfigurableVectorSearch` adds runtime options. New multi-representation retrieval code should prefer `IRetrievalIndex` when collection semantics, hybrid search, context expansion, or payload projection are required.

## Phonetic encoders

`IPhoneticEncoder` is a discoverable algorithm slot with algorithm and version identifiers. Collection definitions decide which encoders apply for a given collection and language context.

## DTOs

Retrieval uses:

* `RetrievalIndexItem`
* `RetrievalHit`
* `RetrievalSearchRequest`
* `RetrievalSearchResult`

These types keep backend-specific Qdrant payloads and response structures outside consumer code.
