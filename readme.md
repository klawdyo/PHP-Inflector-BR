## Exemplos

### Instalação
```sh
composer require klawdyo/inflector-br
```


### Como usar
```php
/**
 * Usando inflexões de palavras em português brasileiro
 */

use Inflector\Inflector;

//Transformando a palavra para o plural
echo Inflector::pluralize('mês');
//Retorna "meses"


//Transformando a palavra para o singular
echo Inflector::singularize('meses');
//Retorna "mês"
```
