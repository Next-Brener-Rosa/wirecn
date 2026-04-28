---
name: conventional-commits-workflow
description: >-
  Plans and executes a sequence of local git commits from modified files using
  Conventional Commits in English; never runs git push. States where to bump the
  package version in composer.json. Use when the user asks for commit batches,
  commit chronology, conventional commits, release commits, or uses the Portuguese
  workflow prompt about modified files and commits without push.
---

# Conventional commits workflow

## Onde ajustar a versão do pacote

- **Pacote PHP (Composer):** ficheiro `composer.json` na raiz do repositório, propriedade **`"version"`** (semver, por exemplo `1.0.0`).
- Se existir `CHANGELOG.md` ou tags Git alinhadas com releases, mantém a versão **coerente** entre `composer.json`, changelog e tag (sem criar tag nem push salvo pedido explícito).

Atualiza `"version"` apenas quando o conjunto de alterações corresponde a um **release** ou bump de versão acordado; num commit dedicado (por exemplo `chore(release): bump version to x.y.z`) ou integrado na política do projeto, mas **sempre** com mensagem em inglês no formato abaixo.

## Instrução do utilizador (texto literal)

Quando o utilizador pedir o fluxo nestes termos, segue-os (incluindo não fazer push):

Com base os arquivos modificados, crie uma cronologia de commits, mas sem realizar o push.

Os commits deverão ser em inglês e seguir o padrão de conventional commits:

type(scope): description

## Regras

1. **Analisar** `git status` e `git diff` (e `git diff --cached` se houver staged).
2. **Propor** uma cronologia: vários commits pequenos e coerentes, cada um com um propósito único (agrupar por domínio: código vs docs vs config vs versão).
3. **Executar** os commits localmente nessa ordem: `git add` seletivo por commit, depois `git commit -m "..."`.
4. **Mensagens:** apenas inglês; cabeçalho `type(scope): description` (scope recomendado quando fizer sentido; `description` imperativo, curta, sem ponto final no título).
5. **Tipos usuais:** `feat`, `fix`, `docs`, `style`, `refactor`, `perf`, `test`, `build`, `ci`, `chore`, `revert`.
6. **Nunca** executar `git push` (nem `--force`) salvo instrução explícita posterior do utilizador.

## Exemplo de cabeçalhos

- `feat(blade): add wirecn button component`
- `fix(merge): handle arbitrary class order in cn()`
- `chore(composer): bump version to 0.2.0`

## Notas

- Não incluir alterações de `vendor/` se estiverem ignoradas; respeitar o `.gitignore` do projeto.
- Se não houver alterações, explicar e não criar commits vazios.
