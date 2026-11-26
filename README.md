# Boleto Kit

Biblioteca PHP para **validar** e **converter** código de barras e linha digitável de boletos bancários e de convênio (arrecadação), seguindo os padrões da FEBRABAN.

## Recursos

- Validação de código de barras e linha digitável pelos dígitos verificadores (módulo 10 e módulo 11)
- Conversão de **código de barras → linha digitável** e de **linha digitável → código de barras**
- Suporte a **boleto bancário** (cobrança) e **boleto de convênio** (contas de consumo, tributos etc.)
- Suporte a boleto bancário no formato **ISPB** (código de barras iniciado por `988`)
- Detecção automática do tipo de boleto
- Aceita valores formatados (com pontos, espaços e hífens)
- Sem dependências de runtime (apenas PHP)

## Requisitos

- PHP 8.1 ou superior (`^8.1`, conforme `composer.json`)

## Instalação

Instale via [Composer](https://getcomposer.org):

```bash
composer require lucasferro0/boleto-kit
```

## Uso

Todos os recursos ficam disponíveis pela classe `BoletoKit\BoletoKit`.

### Detecção automática

Quando você não sabe se o boleto é bancário ou de convênio, use os métodos estáticos da própria `BoletoKit`. A lib identifica o tipo e aplica a regra correta.

```php
<?php

require 'vendor/autoload.php';

use BoletoKit\BoletoKit;

// Validação (aceita código de barras ou linha digitável)
BoletoKit::isValid('26099264400002000002547643928578012461618527');      // true
BoletoKit::isValid('26092547644392857801224616185278926440000200000');   // true
BoletoKit::isValid('83670000000150000101234567890123456789012345');      // true (convênio)
BoletoKit::isValid('12345');                                             // false

// Código de barras -> linha digitável
BoletoKit::toWritableLine('26099264400002000002547643928578012461618527');
// "26092547644392857801224616185278926440000200000"

// Linha digitável -> código de barras
BoletoKit::toBarcode('26092547644392857801224616185278926440000200000');
// "26099264400002000002547643928578012461618527"
```

### Boleto bancário

```php
use BoletoKit\BoletoKit;

$boleto = BoletoKit::boletoBancario();

// Validação
$boleto->isValid('26099264400002000002547643928578012461618527');                // true (código de barras ou linha digitável)
$boleto->isValidBarcode('26099264400002000002547643928578012461618527');         // true
$boleto->isValidWritableLine('26092547644392857801224616185278926440000200000'); // true

// Conversão
$boleto->toWritableLine('26099264400002000002547643928578012461618527');
// "26092547644392857801224616185278926440000200000"

$boleto->toBarcode('26092547644392857801224616185278926440000200000');
// "26099264400002000002547643928578012461618527"

// Formato ISPB (código de barras iniciado por 988) usa os mesmos métodos
$boleto->toWritableLine('98801000000182361207094244618305890485822017');
// "98807094244461830589804858220173100000018236120"

$boleto->toBarcode('98807094244461830589804858220173100000018236120');
// "98801000000182361207094244618305890485822017"
```

### Boleto de convênio

```php
use BoletoKit\BoletoKit;

$convenio = BoletoKit::boletoConvenio();

// Validação
$convenio->isValid('83670000000150000101234567890123456789012345');                    // true
$convenio->isValidBarcode('83670000000150000101234567890123456789012345');             // true
$convenio->isValidWritableLine('836700000000150000101231456789012345567890123456');    // true

// Conversão
$convenio->toWritableLine('83670000000150000101234567890123456789012345');
// "836700000000150000101231456789012345567890123456"

$convenio->toBarcode('836700000000150000101231456789012345567890123456');
// "83670000000150000101234567890123456789012345"
```

### Valores formatados

Pontos, espaços, hífens e qualquer outro caractere não numérico são ignorados, então você pode passar a linha digitável exatamente como aparece no boleto:

```php
BoletoKit::isValid('26092.54764 43928.578012 24616.185278 9 26440000200000'); // true

BoletoKit::toBarcode('26092.54764 43928.578012 24616.185278 9 26440000200000');
// "26099264400002000002547643928578012461618527"
```

### Tratamento de erros

Os métodos `isValid*` nunca lançam exceção — apenas retornam `true` ou `false`.
Já os métodos de conversão (`toBarcode` e `toWritableLine`) lançam uma exceção quando o valor informado é inválido:

```php
use BoletoKit\BoletoKit;
use BoletoKit\Exceptions\BoletoKitInvalidBoletoBancarioWritableLineException;

try {
    BoletoKit::boletoBancario()->toBarcode('123');
} catch (BoletoKitInvalidBoletoBancarioWritableLineException $e) {
    echo $e->getMessage(); // "Linha digitável de boleto bancário inválida."
}
```

Exceções disponíveis em `BoletoKit\Exceptions` (todas estendem `\Exception`):

| Exceção | Lançada por | Mensagem |
| --- | --- | --- |
| `BoletoKitInvalidBoletoBancarioBarcodeException` | `boletoBancario()->toWritableLine()` | `Código de barra de boleto bancário inválido.` |
| `BoletoKitInvalidBoletoBancarioWritableLineException` | `boletoBancario()->toBarcode()` | `Linha digitável de boleto bancário inválida.` |
| `BoletoKitInvalidBoletoConvenioBarcodeException` | `boletoConvenio()->toWritableLine()` | `Código de barra de boleto de convênio inválido.` |
| `BoletoKitInvalidBoletoConvenioWritableLineException` | `boletoConvenio()->toBarcode()` | `Linha digitável de boleto de convênio inválida.` |

> **Atenção:** nos métodos de detecção automática (`BoletoKit::toBarcode` e `BoletoKit::toWritableLine`), quando o valor não é um boleto bancário válido a lib tenta tratá-lo como convênio. Por isso, um valor inválido resulta em uma exceção **de convênio**. Se precisar diferenciar, valide antes com `BoletoKit::isValid()` ou capture `\Exception`.

## Referência da API

### `BoletoKit` (estático)

| Método | Retorno | Descrição |
| --- | --- | --- |
| `isValid(string $barcodeOrWritableLine)` | `bool` | Valida código de barras ou linha digitável de qualquer tipo de boleto |
| `toBarcode(string $writableLine)` | `string` | Converte linha digitável em código de barras (detecção automática) |
| `toWritableLine(string $barcode)` | `string` | Converte código de barras em linha digitável (detecção automática) |
| `boletoBancario()` | `BoletoBancarioManager` | Operações específicas de boleto bancário |
| `boletoConvenio()` | `BoletoConvenioManager` | Operações específicas de boleto de convênio |

### `BoletoBancarioManager` / `BoletoConvenioManager`

| Método | Retorno | Descrição |
| --- | --- | --- |
| `isValid(string $barcodeOrWritableLine)` | `bool` | Valida código de barras ou linha digitável |
| `isValidBarcode(string $barcode)` | `bool` | Valida apenas código de barras |
| `isValidWritableLine(string $writableLine)` | `bool` | Valida apenas linha digitável |
| `toBarcode(string $writableLine)` | `string` | Converte linha digitável em código de barras |
| `toWritableLine(string $barcode)` | `string` | Converte código de barras em linha digitável |

## Boleto bancário x boleto de convênio

| | Boleto bancário | Boleto de convênio |
| --- | --- | --- |
| Uso típico | Cobrança emitida por bancos | Contas de consumo (água, luz, telefone), tributos e taxas |
| Código de barras | 44 dígitos (formato ISPB começa com `988`) | 44 dígitos, sempre começando com `8` |
| Linha digitável | 47 dígitos (5 campos) | 48 dígitos (4 blocos de 11 + DV) |
| Dígitos verificadores | Módulo 10 (campos) e módulo 11 (geral) | Conforme o identificador de valor (3º dígito): `6` ou `7` → módulo 10; `8` ou `9` → módulo 11 |

## Testes

```bash
composer install
vendor/bin/phpunit
```

O `phpunit.xml` na raiz executa as suítes `tests/Unit` e `tests/Feature`.

## Referências

- [Padrão boleto bancário — código de barras e linha digitável (FEBRABAN)](https://portal.febraban.org.br/pagina/3150/1094/pt-br/servicos-novo-plataforma-boletos)
- [Layout do código de barras de arrecadação/convênio — módulo 10 e módulo 11 (FEBRABAN)](https://cmsarquivos.febraban.org.br/Arquivos/documentos/PDF/Layout%20-%20C%C3%B3digo%20de%20Barras%20-%20Vers%C3%A3o%208%20-%2011_05_2026.pdf)
- [Gerador de boletos para testes](https://geradorbrasil.com/gerador-de-boleto)

## Contribuindo

Contribuições são bem-vindas!

1. Faça um fork do projeto
2. Crie uma branch para sua feature ou correção (`git checkout -b feature/minha-feature develop`)
3. Adicione testes cobrindo a alteração
4. Garanta que todos os testes passam (`vendor/bin/phpunit`)
5. Abra um Pull Request

## Licença

Distribuída sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.
