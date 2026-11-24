<!--
Obrigado por contribuir com o Boleto Kit! 🎉

Antes de abrir o PR:
- Abra o PR contra a branch `develop` (não contra `master`).
- Mantenha o PR focado em uma única alteração.
- Não inclua boletos reais com dados sensíveis em testes ou exemplos.
-->

## Motivo

<!-- Descreva o motivo de forma clara -->

## O que muda

<!-- Descreva o que mudou -->

## Issue relacionada

<!-- Use palavras-chave para fechar a issue automaticamente ao fazer merge. Ex.: Closes #123 -->

Closes #

## Tipo de alteração

<!-- Marque com um "x" as opções que se aplicam. -->

- [ ] 🐛 Correção de bug (alteração que corrige um problema sem quebrar compatibilidade)
- [ ] ✨ Nova funcionalidade (alteração que adiciona recurso sem quebrar compatibilidade)
- [ ] 💥 Breaking change (correção ou funcionalidade que altera o comportamento existente da API pública)
- [ ] ♻️ Refatoração (sem mudança de comportamento)
- [ ] 📝 Documentação
- [ ] 🔧 CI / build / dependências

## Escopo afetado

- [ ] Boleto bancário
- [ ] Boleto bancário ISPB (988)
- [ ] Boleto de convênio
- [ ] Detecção automática (`BoletoKit::isValid`, `toBarcode`, `toWritableLine`)
- [ ] Cálculo de módulo 10 / módulo 11
- [ ] Exceções
- [ ] Helpers

## Como foi testado?

<!--
Descreva os testes realizados. Inclua exemplos de entrada e saída quando fizer sentido.
Ex.: código de barras X convertido para linha digitável Y.
-->

```bash
vendor/bin/phpunit tests
```

## Checklist

- [ ] Meu código segue o estilo do projeto (PSR-12).
- [ ] Adicionei/atualizei testes que comprovam a correção ou a nova funcionalidade.
- [ ] Todos os testes passam localmente (`vendor/bin/phpunit tests`).
- [ ] O código continua compatível com PHP 7.4.
- [ ] Não adicionei dependências de runtime.
- [ ] Atualizei o `README.md` quando necessário.
- [ ] Os exemplos e testes não contêm dados reais/sensíveis.

## Informações adicionais

<!-- Referências à especificação FEBRABAN, pontos de atenção para o revisor, screenshots etc. -->
