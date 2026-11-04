# Maintenance handoff

Source review: 2026-11-04. This is a repository adapter and an open readiness record, not service acceptance or release authorization.

## Scope and source

PHP tax-calculation library consumed separately by applications. composer.json requires PHP ^8.3, bcmath and Illuminate database ^12.

Default branch reviewed: `master`. Preserve existing repository instructions, application tests and CI. Use the maintainers' currently approved contribution workflow and verify its command/plugin dependencies before execution. This file is public contributor guidance; privileged operating evidence and private workflow installation details belong in the approved private operating record.

## Checks

Read package manifests and the current CI before execution. Install dependencies only in an isolated environment after reviewing lifecycle scripts and protected dependency access. These are commands found in the source, not passing results from this review:

- `composer test`
- `composer check-style`

No deployable application service or contributor workflow adapter was found. Publishing authority, consumer release coordination, fixture safety and independent verification remain open; no tax correctness certification is implied.

## Publication and recovery

CI runs on push and pull_request with single-segment branch pattern * plus manual dispatch. Do not assume a slash-named branch receives checks. CI initializes a local PostGIS database and runs PHPUnit. Active repository hooks receive push, PR and create events; downstream publication behavior is unverified. No release/deploy workflow was found.

composer test initializes a database through init_db.php; inspect and use an isolated disposable local database before running it. Validate tax fixtures and rounding/date boundaries independently. A source merge or tag is not consumer acceptance: confirm package publication, consuming lockfile version, regression checks and each consumer release. Preserve prior package/consumer versions and migration compatibility before rollback.

## Receiving checklist

- Confirm the existing work item, approved maintenance scope and repository mapping; new products and business-policy changes need their own authorization. Do not infer approval from an assignment or elapsed time.
- Verify the existing project/team and role identities before adding a machine-consumed owner manifest. No private project ID, operating budget or privileged access has been copied here.
- Confirm the builder's actual approved command/plugin versions and every referenced dependency; exercise one authorized ticket in a feature worktree with independent review. No new dispatcher or workflow engine is introduced here.
- Record where each role obtains approved source, non-production test access and logs; verify the intended role's own access without copying credentials or customer data into this repository.
- Record acceptance criteria, synthetic fixture/role boundaries, exact revision and test evidence. A different person verifies the relevant behavior.
- Before release, identify target, branch/PR/provider triggers, migrations or dependency order, recovery artifact and release authority. Recheck the exact head and obtain the required approval before a production-triggering action.
- Confirm alert source, accountable primary and backup pickup, missing-event handling, applicable restore/recovery proof, and independent deployed-outcome verification. Track these in the existing operating record; source review alone closes none of them.

Keep new publication and service acceptance pending until the unresolved items above have evidence.
