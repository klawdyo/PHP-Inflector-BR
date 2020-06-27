<?php
/*
    -----------------------------------------------------------------------
        CHANGELOG
    -----------------------------------------------------------------------
    02/02/2010
        [+] pluralize() transforma palavras do singular para o plural
        [+] singularize() transforma palavras do plural para o singular
    15/04/2010
        [m] Troca do str_replace() pelo preg_replace() como função de
            substituição.
    16/04/2010
        [m] Métodos transformados em estáticos
        [m] Alterações simples nas regras
    13/02/2013
        [+] addException() adiciona uma exceção às regras
        [+] addRule() adiciona uma regra
    -----------------------------------------------------------------------
        TO DO
    -----------------------------------------------------------------------
    Precisa analisar também a questão das palavras compostas, onde, no
    português, na maioria das vezes, a pluralização ocorre no primeiro termo.
 */
 
class Inflector{
    /**
      *    Regras de singularização/pluralização
      */
    static public $rules = array(
    //singular     plural
        'ão'    => 'ões', 
        'ês'    => 'eses', 
        'm'     => 'ns', 
        'l'     => 'is', 
        'r'     => 'res', 
        'x'     => 'xes', 
        'z'     => 'zes', 
    );

    /**
      *    Exceções às regras
      */
    static public $exceptions = array(
        'cidadão' => 'cidadãos',
        'mão'     => 'mãos',
        'qualquer'=> 'quaisquer',
        'campus'  => 'campi',
        'lápis'   => 'lápis',
        'ônibus'  => 'ônibus',
    );

    /**
     *    Adiciona uma exceção às regras
     *
     *    @version
     *      1.0 13/02/2013 Initial
     *
     *    @param  string $singularWord Palavra no singular
     *    @param  string $pluralWord Palavra no plural
     *    @return bool
     */
    public static function addException($singularWord, $pluralWord){
      self::$exceptions[$singularWord] = $pluralWord;

      return true;
    }

    /**
     *    Adiciona uma regra
     *
     *    @version
     *      1.0 13/02/2013 Initial
     *
     *    @param  string $singularSufix Terminação da palavra no singular
     *    @param  string $pluralSufix Terminação da palavra no plural
     *    @return bool
     */
    public static function addRule($singularSufix, $pluralSufix){
      self::$rules[$singularSufix] = $pluralSufix;

      return true;
    }

    /**
     *    Passa uma palavra para o plural
     *
     *    @version
     *      1.0 Initial
     *      1.1 15/04/2010 Substituição do str_replace() pelo preg_replace()
     *          como função de substituição
     *
     *    @param  string $word A palavra que deseja ser passada para o plural
     *    @return string
     */
    public static function pluralize($word){
        //Pertence a alguma exceção?
        if(array_key_exists($word, self::$exceptions)){
            return self::$exceptions[$word];
        }

        //Não pertence a nenhuma exceção. Mas tem alguma regra?
        else{
            foreach(self::$rules as $singular=>$plural){
                if(preg_match("({$singular}$)", $word)){
                    return preg_replace("({$singular}$)", $plural, $word);
                }
            }
        }

        //Não pertence às exceções, nem às regras.
        //Se não terminar com "s", adiciono um.
        if(substr($word, -1) !== 's'){
            return $word . 's';
        }
        else{
          return $word;
        }
    }
    
    /**
     *    Passa uma palavra para o singular
     *    
     *    @version
     *      1.0 Initial
     *      1.1 15/04/2010 Substituição do str_replace() pelo preg_replace()
     *          como função de substituição
     *
     *    @param  string $word A palavra que deseja ser passada para o singular
     *    @return string
     */
    public static function singularize($word){
        //Pertence às exceções?
        if(in_array($word, self::$exceptions)){
            $invert = array_flip(self::$exceptions);
            return $invert[$word];
        }
        //Não é exceção.. Mas pertence a alguma regra?
        else{
            foreach(self::$rules as $singular => $plural){
                if(preg_match("({$plural}$)",$word)){
                    return preg_replace("({$plural}$)", $singular, $word);
                }
            }
        }

        //Nem é exceção, nem tem regra definida. 
        //Apaga a última somente se for um "s" no final
        if(substr($word, -1) == 's'){
            return substr($word, 0, -1);
        }
        else{
          return $word;
        }
    }
}
