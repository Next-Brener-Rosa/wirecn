# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2026-04-28

First **stable** release as `wirecn/laravel-wirecn` — install with `composer require wirecn/laravel-wirecn:^1.0` (no `@dev`) once Packagist or your Git remote exposes tag **`v1.0.0`**.

### Added

- Documented NPM dependencies for published `wirecn-js` (Embla, Floating UI, optional Phosphor / Recharts).

### Changed

- Package renamed from `livecn/laravel-livecn` to **`wirecn/laravel-wirecn`**; PHP namespace **`Wirecn\Laravel`**; Blade prefix **`x-wirecn.*`**; publish tags **`wirecn-views`** / **`wirecn-js`**.

## [0.1.0] - 2026-04-28

### Added

- Initial prerelease (as **livecn**): `cn()` helper, `UiIcon`, publishable Blade and JS stubs. Superseded for consumers by **[1.0.0]** under the **wirecn** vendor.
