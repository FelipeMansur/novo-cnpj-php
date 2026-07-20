<?php
/**
 * Esta classe valida um CNPJ alfanumerico ou apenas numerico
 * Autor: Felipe Mansur
 * 
 * Ex de uso
 * 
 * if(NovoCNPJ::validar('ML.J2V.WCK/0001-80')){
 *	echo "CNPJ VALIDO!";
 * }
 * 
 * Para mais: https://www.gov.br/receitafederal/pt-br/centrais-de-conteudo/publicacoes/documentos-tecnicos/cnpj/manual-dv-cnpj.pdf/view
 */

class NovoCNPJ
{
	
	private static function higienizar(string $documento) : string 
	{
		return preg_replace('/[\/.-]/', '',  strtoupper($documento));
	}
	
    private static function valorCalculoDV( mixed $caractere ) : int
    {
        if (is_numeric($caractere)) {
            return $caractere;
        } else {
            $base_abc = 17;
            $a_ascii = ord("A");
            $caractere_ascii = ord($caractere); //esta funcao obtem o valor na tabela ASCII do caractere
            return $caractere > "A" ? $base_abc + ($caractere_ascii - $a_ascii) : $base_abc;
        }
    }
    
    private static function obterSoma(string $documento, int $peso) : int{
		
		$documento = str_split(substr($documento, 0, $peso == 5 ? 12 : 13));
		$soma = 0;
        
        foreach($documento as $elemento){

        	$soma += (self::valorCalculoDV($elemento) * $peso); 
        	
			if($peso <= 2)
        	  $peso = 9;
            else
        	 $peso--;

        }
        return $soma;

    }
    
    private static function obterDV(int $soma) : int {
		$resto = $soma % 11;
		return $resto <= 1 ? 0 : (11 - $resto);
    }
    
    public static function validar(string $documento) : bool {
    	
    	if(!$documento)
    	 return false;
    		
    	$documento = self::higienizar($documento);
    	
    	if(strlen($documento) < 14)
    	 return false;
    	 
    	$primeiro_digito_calculado = self::obterDV(self::obterSoma($documento, 5));
    	$segundo_digito_calculado  = self::obterDV(self::obterSoma($documento.$primeiro_digito_calculado, 6));
    	
    	$primeiro_digito_original = substr($documento, -2, 1);
    	$segundo_digito_original = substr($documento, -1, 1);
    	
        return $primeiro_digito_calculado == $primeiro_digito_original && $segundo_digito_calculado == $segundo_digito_original;    
	}
}
