<?php
/**
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
     *    Passa uma palavra para o plural
     *
     *    @version
     *      1.0 Initial
     *      1.1 15/04/2010 Substituição do str_replace() pelo preg_replace()
     *          como função de substituição
     *    @param  string $word A palavra que deseja ser passada para o plural
     *    @return string
     */
    public static function pluralize($word){
        //Pertence a alguma exceção?
        if(array_key_exists($word, self::$exceptions)):
            return self::$exceptions[$word];
        //Não pertence a nenhuma exceção. Mas tem alguma regra?
        else:
            foreach(self::$rules as $singular=>$plural):
                if(preg_match("({$singular}$)", $word))
                    return preg_replace("({$singular}$)", $plural, $word);
            endforeach;
        endif;
        //Não pertence às exceções, nem às regras.
        //Se não terminar com "s", adiciono um.
        if(substr($word, -1) !== 's')
            return $word . 's';
        return $word;
    }
    
    /**
     *    Passa uma palavra para o singular
     *    
     *    @version
     *      1.0 Initial
     *      1.1 15/04/2010 Substituição do str_replace() pelo preg_replace()
     *          como função de substituição
     *    @param  string $word A palavra que deseja ser passada para o singular
     *    @return string
     */
    public static function singularize($word){
        //Pertence às exceções?
        if(in_array($word, self::$exceptions)):
            $invert = array_flip(self::$exceptions);
            return $invert[$word];
        //Não é exceção.. Mas pertence a alguma regra?
        else:
            foreach(self::$rules as $singular => $plural):
                if(preg_match("({$plural}$)",$word))
                    return preg_replace("({$plural}$)", $singular, $word);
            endforeach;
        endif;
        //Nem é exceção, nem tem regra definida. 
        //Apaga a última somente se for um "s" no final
        if(substr($word, -1) == 's')
            return substr($word, 0, -1);
        return $word;
    }
}
?>