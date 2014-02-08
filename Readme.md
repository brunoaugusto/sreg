## Módulo de validação das Inscrições Estaduais

Este módulo permite validar as Inscrições Estaduais, os registros dos
contribuintes no cadastro do ICMS mantido pela Receita Estadual através do qual
a empresa passa a ter registro formal de seu negócio, de acordo com os algoritmos
disponibilizados pelo [SINTEGRA][sintegra] - Sistema Integrado de Informações
sobre Operações Interestaduais com Mercadorias e Serviços.

O módulo é flexível o suficiente para permitir que seja utilizado completo ou
individual por Estado e, por isso, apesar de alguns Estados possuírem o mesmo
algoritmo ou algoritmos bastante similares (cenário no qual caberia reaproveitar
a lógica), tal procedimento foi ignorado.

## Instalação

O módulo de validação foi criado utilizando o recurso de *namespaces* do PHP
portanto qualquer implementação de *autoloading* capaz de permitir que os arquivos
dos algoritmos no diretório definido possam ser localizados, será suficiente.

Caso você precise de uma implementação de *autoloading*, a descrita abaixo,
também presente no arquivo **index.php**, pode ser usada.

```php
spl_autoload_register( function( $classname ) {

	$classname = stream_resolve_include_path(

        str_replace( '\\', DIRECTORY_SEPARATOR, $classname ) . '.php'
    );

    if( $classname !== FALSE ) {

        include $classname;
    }
});
```

## Utilização

Foi adicionado ao módulo de validação uma classe que simplifica o uso do módulo
completo, com suporte a verificação de todos os Estados.

Para utilizar essa classe, basta instanciá-la como qualquer outro objeto e
informar o número no formato pré-definido `XX12345678`, onde **XX** é a sigla
de duas letras do Estado brasileiro desejado:

```php
<?php

$sr = new StateRegistration( 'XX12345678' );

echo ( $sr -> isValid() ? 'Valid' : 'Invalid' );

?>
```

> Nota: A omissão do *autoloading* assume que este já esteja em funcionamento
seja pelo código da seção **Instalação** ou por outro de sua autoria ou preferência.

Por utilizar essa classe você não precisa se preocupar com as tarefas de limpeza
básicas ou remoção de caracteres de pontuação pois isso é feito por você.

A validação propriamente dita da Inscrição Estadual informada se dá através do
método público `StateRegistration::isValid()`, o qual através das informações
obtidas a partir da análise da Inscrição Estadual, determina qual algoritmo,
de qual Estado será utilizado.

Caso, porém, você prefira utilizar os módulos individualmente, basta invocar o
método de interface `validate()` que todas classe de algoritmo implementam
informando apenas os números da Inscrição Estadual limpa, sem espaços e,
principalmente, **sem pontuação**:

```php
<?php

echo ( Algos\MG::validate( '062.307.904/0081' ) ? 'Valid' : 'Invalid' );

?>
```

> Nota: Inscrições Estaduais de Produtores Rurais do Estado de São Paulo possuem
um caractere 'P' no início da inscrição ficando esta como única ressalva ao
termo *apenas os números* feita acima.

Assim, caso haja a necessidade de integrar os algoritmos de
## Suporte

Qualquer problema que encontrar fique à vontade para criar uma nova *[issue][issue]*.

Mas pesquise antes, não dói nada. ;-)

## Licença & Agradecimentos

Todos os algoritmos podem ser encontrados no site do [SINTEGRA][sintegra] para consulta no
menu **Serviços**, opção **Inscrições Estaduais**.

Todos os algoritmos implementados estão licenciados sob a Licença
*Creative Commons Attribution 3.0 Unported* que lhe permite usar, adaptar e
compartilhar desde que mantenha os devidos créditos

Um agradecimento especial ao Paulo Ricardo F. Santos pela contribuição
involuntária com a Expressão Regular, por mim aprimorada, para validação das
Unidades Federativas Brasileiras

[sintegra]: http://www.sintegra.gov.br
[issue]: https://github.com/brunoaugusto/sreg/issues