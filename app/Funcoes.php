<?php

namespace sportcontrol;
use Route;


class Funcoes {
    static function pegarprefixo(){
        $rota = Route::current()->getPrefix();
        $rota = preg_replace('/\//', '', $rota, 1);
        return $rota;
    }
    static function dinheiro($valor,$tipo) {
    	if($tipo == 'db'){
    		$valor = str_replace('.','',$valor);
    		$valor = str_replace(',','.',$valor);
    		$valor = str_replace("R$",'',$valor);
    		$valor = str_replace(" ",'',$valor);
    		return $valor;
    	}elseif($tipo == 'web'){
    		$valor = round($valor,3);
    		if(strpos($valor,'.') === false){
    			return $valor.",000";
    		}else{
    			$valor2 = explode('.',$valor);
    			if(strlen($valor2[1]) == 1)
    				return str_replace(".",',',$valor)."00";
    			elseif(strlen($valor2[1]) == 2)
    				return str_replace(".",',',$valor)."0";
    			else
    				return str_replace(".",',',$valor);
    		}
    	}
    }
    static function parcentagem($valor,$tipo) {
    	if($tipo == 'db'){
    		$valor = str_replace('.','',$valor);
    		$valor = str_replace(',','.',$valor);
    		$valor = str_replace("%",'',$valor);
    		$valor = str_replace(" ",'',$valor);
    		return $valor;
    	}elseif($tipo == 'web'){
    		$valor = round($valor,2);
    		$valor = (string)$valor;
    		if(strpos($valor,'.') === false){
    			return $valor.",00";
    		}else{
    			$valor2 = explode('.',$valor);
    			if(strlen($valor2[1]) == 1)
    				return str_replace(".",',',$valor)."0";    			
    			else
    				return str_replace(".",',',$valor);
    		}
    	}
    }
    static function data($data,$tipo){
    	if($tipo == 'db'){
    		return implode("-",array_reverse(explode("/",$data)));
    	}elseif($tipo == 'web'){
    		return implode("/",array_reverse(explode("-",$data)));
    	}
    }

    static function subtracaoData($horainicial,$horafinal1,$retorno = 'C'){
        /*
        Retorno
        C = completo (02:23:23)
        S = Segundos (8603)
        M = Minutos (143,38)
        H = Horas (2,38)
        */
        $hora = explode(':',$horainicial);
        $final = explode(':',$horafinal1);
        $menos1 = $final[2] - $hora[2];
        if($menos1 >= 0){
            $horafinal[2] = $menos1;
            $menos1 = 0;
        }else{
            $horafinal[2] = 60 + $menos1;
            $menos1 = 1;
        }
        $menos2 = $final[1] - $hora[1];
        if($menos2 >= 0){
            $horafinal[1] = $menos2 - $menos1;
            $menos2 = 0;
        }else{
            $horafinal[1] = 60 + $menos2 - $menos1;
            $menos2 = 1;
        }
        $menos3 = $final[0] - $hora[0];
        if($menos3 >= 0){
            $horafinal[0] = $menos3 - $menos2;
        }else{
            $horafinal[0] = 24 + $menos3 - $menos2;
        }
        if($retorno == 'C')
            return $horafinal[0].":".$horafinal[1].":".$horafinal[2];
        elseif($retorno == 'S')
            return $horafinal[0] * 3600 + $horafinal[1] * 60 + $horafinal[2];
        elseif($retorno == 'M')
            return $horafinal[0] * 60 + $horafinal[1]  + $horafinal[2] / 60;
        elseif($retorno == 'H')
            return $horafinal[0] + $horafinal[1] / 60 + $horafinal[2] / 3600 ;
    }
    static function replace($string){
        return $string = str_replace("/","", str_replace("-","",str_replace(".","",$string)));
    }

    static function check_fake($string, $length){
        for($i = 0; $i <= 9; $i++) {
            $fake = str_pad("", $length, $i);
            if($string === $fake)
                return(1);
        }
    }

    static function cpf($cpf){
        $cpf = self::replace($cpf);
        $cpf = trim($cpf);
        if(empty($cpf) || strlen($cpf) != 11)
            return FALSE;
        else{
            if(self::check_fake($cpf, 11))
                return FALSE;
            else{
                $sub_cpf = substr($cpf, 0, 9);
                for($i = 0; $i <= 9; $i++) {
                    @$dv += ($sub_cpf[$i] * (10-$i));
                }
                if($dv == 0)
                    return FALSE;
                $dv = 11 - ($dv % 11);
                if($dv > 9)
                    $dv = 0;
                if($cpf[9] != $dv)
                    return FALSE;
                $dv *= 2;
                for($i = 0; $i <= 9; $i++) {
                    @$dv += ($sub_cpf[$i] * (11-$i));
                }
                $dv = 11 - ($dv % 11);
                if($dv > 9)
                    $dv = 0;
                if($cpf[10] != $dv)
                    return FALSE;
                return TRUE;
            }
        }
    }

    static function cnpj($cnpj){
        $cnpj = self::replace($cnpj);
        $cnpj = trim($cnpj);
        if(empty($cnpj) || strlen($cnpj) != 14)
            return FALSE;
        else{
            if(self::check_fake($cnpj, 14))
                return FALSE;
            else{
                $rev_cnpj = strrev(substr($cnpj, 0, 12));
                for($i = 0; $i <= 11; $i++) {
                    $i == 0 ? $multiplier = 2 : $multiplier;
                    $i == 8 ? $multiplier = 2 : $multiplier;
                    $multiply = ($rev_cnpj[$i] * $multiplier);
                    @$sum = $sum + $multiply;
                    $multiplier++;
                }
                $rest = $sum % 11;
                if($rest == 0 || $rest == 1)
                    $dv1 = 0;
                else
                    $dv1 = 11 - $rest;
                $sub_cnpj = substr($cnpj, 0, 12);
                $rev_cnpj = strrev($sub_cnpj.$dv1);
                unset($sum);
                for($i = 0; $i <= 12; $i++) {
                    $i == 0 ? $multiplier = 2 : $multiplier;
                    $i == 8 ? $multiplier = 2 : $multiplier;
                    $multiply = ($rev_cnpj[$i] * $multiplier);
                    @$sum = $sum + $multiply;
                    $multiplier++;
                }
                $rest = $sum % 11;
                if($rest == 0 || $rest == 1)
                    $dv2 = 0;
                else
                    $dv2 = 11 - $rest;
                if($dv1 == $cnpj[12] && $dv2 == $cnpj[13])
                    return TRUE;
                else
                    return FALSE;
            }
        }
    }


}
