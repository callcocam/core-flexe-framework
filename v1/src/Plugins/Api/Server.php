<?php

namespace Flexe\Plugins\Api;


use Flexe\Db\Extras\Structure;
use Flexe\Model\AbstractModel;

class Server extends AbstractModel {

    public function __construct(Structure $structure = null){

        $this->consumerKey = config('nfe.consumer_key');
        $this->consumerSecret = config('nfe.consumer_secret');
        $this->accessToken = config('nfe.oauth_access_token');
        $this->accessTokenSecret = config('nfe.oauth_access_token_secret');

    }

    public function statusSefaz( $data = null ){

        $data = array();
        $response = self::connectWebmaniaBR( 'GET', 'http://localhost:8585/api/brand/', $data );
         return $response;

    }

    public function validadeCertificado( $data = null ){

        $data = array();
        $response = self::connectWebmaniaBR( 'GET', 'https://webmaniabr.com/api/1/nfe/certificado/', $data );
        if (isset($response->error)) return $response;
        return $response->expiration;

    }

    public function emissaoNotaFiscal( array $data ){

        $response = self::connectWebmaniaBR( 'POST', 'https://webmaniabr.com/api/1/nfe/emissao/', $data );
        return $response;

    }

    public function consultaNotaFiscal( $chave, $ambiente ){

        $data = array();
        $data['chave'] = $chave;
        $data['ambiente'] = $ambiente;
        $response = self::connectWebmaniaBR( 'GET', 'https://webmaniabr.com/api/1/nfe/consulta/', $data );
        return $response;

    }

    public function cancelarNotaFiscal( $chave, $motivo, $ambiente ){

        $data = array();
        $data['chave'] = $chave;
        $data['motivo'] = $motivo;
        $data['ambiente'] = $ambiente;
        $response = self::connectWebmaniaBR( 'PUT', 'https://webmaniabr.com/api/1/nfe/cancelar/', $data );
        return $response;

    }

    public function inutilizarNumeracao( $sequencia, $motivo, $ambiente ){

        $data = array();
        $data['sequencia'] = $sequencia;
        $data['motivo'] = $motivo;
        $data['ambiente'] = $ambiente;
        $response = self::connectWebmaniaBR( 'PUT', 'https://webmaniabr.com/api/1/nfe/inutilizar/', $data );
        return $response;

    }

    public function cartaCorrecao( $chave, $correcao, $ambiente ){

        $data = array();
        $data['chave'] = $chave;
        $data['correcao'] = $correcao;
        $data['ambiente'] = $ambiente;
        $response = self::connectWebmaniaBR( 'POST', 'https://webmaniabr.com/api/1/nfe/cartacorrecao/', $data );
        return $response;

    }

    public function devolucaoNotaFiscal( $chave, $natureza_operacao, $ambiente, $codigo_cfop = null, $classe_imposto = null, $produtos = null ){

        $data = array();
        $data['chave'] = $chave;
        $data['natureza_operacao'] = $natureza_operacao;
        $data['ambiente'] = $ambiente;
        $data['codigo_cfop'] = $codigo_cfop;
        $data['classe_imposto'] = $classe_imposto;
        $data['produtos'] = $produtos;
        $response = self::connectWebmaniaBR( 'POST', 'https://webmaniabr.com/api/1/nfe/devolucao/', $data );
        return $response;

    }

    private function connectWebmaniaBR( $request, $endpoint, $data ){

        @set_time_limit( 300 );
        ini_set('max_execution_time', 300);
        ini_set('max_input_time', 300);
        ini_set('memory_limit', '256M');

        $headers = array(
          'Cache-Control: no-cache',
          'Content-Type:application/json',
          'X-Consumer-Key: '.$this->consumerKey,
            'X-Consumer-Secret: '.$this->consumerSecret,
            'X-Access-Token: '.$this->accessToken,
          'X-Access-Token-Secret: '.$this->accessTokenSecret
        );

        $rest = curl_init();
        curl_setopt($rest, CURLOPT_CONNECTTIMEOUT , 300);
        curl_setopt($rest, CURLOPT_TIMEOUT, 300);
        curl_setopt($rest, CURLOPT_URL, $endpoint.'?time='.time());
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($rest, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($rest, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($rest, CURLOPT_CUSTOMREQUEST, $request);
        curl_setopt($rest, CURLOPT_POSTFIELDS, json_encode( $data ));
        curl_setopt($rest, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($rest, CURLOPT_FRESH_CONNECT, true);
        $response = curl_exec($rest);
        curl_close($rest);

        return json_decode($response);

    }

}