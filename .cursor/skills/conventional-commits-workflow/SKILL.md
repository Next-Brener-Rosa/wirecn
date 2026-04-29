---
name: conventional-commits-workflow
description: >-
  Plans and executes a sequence of local git commits from modified files using
  Conventional Commits in English; never runs git push unless the user explicitly
  asks. Covers SemVer (MAJOR/MINOR/PATCH), CHANGELOG/tags, and composer.json
  version policy. Use for commit batches, releases, conventional commits, or the
  Portuguese workflow about modified files and commits.
---

# Conventional commits workflow

## SemVer: quando **MAJOR**, **MINOR** ou **PATCH**

Formato canónico: **`MAJOR.MINOR.PATCH`** ([semver.org](https://semver.org/spec/v2.0.0.html)).

| Bump | Quando usar | Exemplos |
|------|----------------|----------|
| **MAJOR** | Alterações **incompatíveis** com a API pública que consumidores já usam: renomear/remover componentes Blade publicados, mudar prefixo/namespace, remover props obrigatórias ou alterar contratos PHP que quebram código existente, mudar comportamento por defeito de forma que apps tenham de alterar código. | `x-wirecn.foo` → `x-wirecn.bar`; remover `wirecnDialogScrollLock`; alterar assinatura de helper público. |
| **MINOR** | **Novas** capacidades **retrocompatíveis**: novo componente, nova prop opcional, novo export JS, melhorias de API que não obrigam a alterar quem já integra. | Novo `x-wirecn.badge`; novo atributo opcional no dialog; novo middleware Alpine opt-in. |
| **PATCH** | **Correções** e ajustes que **não** mudam o contrato esperado: bugs, regressões, documentação, performance interna, alinhamento com docs existentes. | Corrigir scroll lock; corrigir posicionamento do select; typos no README. |

**Pré-1.0 (`0.y.z`):** `MINOR` pode incluir breaking changes menores; `PATCH` são correções. Após **1.0.0**, aplicar a tabela acima com rigor.

**Wirecn / tags Git:** este repositório usou histórico **`1.0.3.x`** (quatro segmentos), o que **não** é SemVer clássico e pode confundir Packagist/comparadores. Preferir passar a **`MAJOR.MINOR.PATCH`** nas novas tags (ex.: `1.0.4` após `1.0.3.5`) salvo decisão explícita de manter o esquema extra; alinhar **`CHANGELOG.md`** e **`composer.json`** (se voltar a existir campo `version`) com a mesma string.

## Onde ajustar a versão do pacote

- **`composer.json`:** neste pacote o campo **`"version"`** foi **removido** de propósito (evitar divergência com tags e o Packagist ignorar tags). A versão publicada segue **tags Git** (`v1.0.3.6`, etc.) e **`CHANGELOG.md`**.
- Se noutro projeto existir `"version"` no `composer.json`, deve ficar **coerente** com changelog e tag.

Atualiza versão num commit de release (por exemplo `fix(ui): dialog scroll lock improvements` + entrada no changelog na secção da versão), com mensagem em inglês no formato abaixo. **Tag** `vX.Y.Z` alinhada ao changelog. **Push** só se o utilizador o pedir explicitamente (esta skill assume **sem push** por defeito).

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
