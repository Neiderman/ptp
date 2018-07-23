<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use nusoap_client;

class HomeController extends Controller
{

    protected $identificador;

    protected $tranKey;

    protected $seed;
    
    protected $cliente;

    /**
    * Función constructora
    */
    public function __construct()
    {
        $this->identificador = '6dd490faf9cb87a9862245da41170ff2';
        $this->tranKey = '024h1IlD';
        $this->seed = date('c');
        $this->cliente = new nusoap_client('https://test.placetopay.com/soap/pse/?wsdl', true);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function inPago(Request $request)
    {
        $client = $this->initClient();
        $bancos = $client->call('getBankList',$this->getAuthData())['getBankListResult'];
        if ($bancos) {
            return $this->prepareForm($bancos['item']);
        } else {
            return [];
        }
    }

    private function prepareForm($bancos)
    {
        $select_bancos = $this->prepararDataSelectBancos($bancos);
        $input_name = $this->prepareInputName();
        $tipo_cuenta = $this->prepararDataSelectTCuenta();
        $dni_type = $this->prepareInputDniAndType();
        return '
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                '.$select_bancos.'
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                '.$input_name.'
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                '.$tipo_cuenta.'
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                '.$dni_type.'
            </div>
            <div class="col-md-4"></div>
        </div>
        ';
    }

    private function prepareInputName()
    {
        return '
        <div class="input-group">
            <span class="input-group-addon">Nombre(s) *</span>
            <input id="nombre_persona" type="text" class="form-control" name="nombre_persona" required autofocus>
            <span class="input-group-addon">Apellido(s) *</span>
            <input id="nombre_persona" type="text" class="form-control" name="nombre_persona" required autofocus>
        </div>';
    }

    private function prepareInputDniAndType()
    {
        return '
        <div class="input-group">
            <span class="input-group-addon">Tipo</span>
            <select id="t_dni" class="form-control"value="0">
                <option value="0" selected>Seleccione...</option>
                option value="CC">C.C. (Cédula de ciudadania colombiana)</option>
                <option value="CE">C.E. (Cédula de extranjería)</option>
                <option value="TI">T.I. (Tarjeta de identidad)</option>
                <option value="PPN">P.P.N. (Pasaporte)</option>
            </select>
            <span class="input-group-addon">DNI</span>
            <input id="s_dni" type="text" class="form-control" aria-label="...">
        </div>';
    }

    private function prepararDataSelectTCuenta()
    {
        return "
        <div class='input-group'>
            <span class='input-group-addon'>TIpo de cuenta *</span>
            <select class='form-control' name='s_banco' id='s_banco'>
                <option selected value=''>Seleccione...</option>
                <option value='0'>Persona</option>
                <option value='1'>Empresa</option>
            </select>
        </div>";
    }

    private function prepararDataSelectBancos($bancos) {

        $opciones = '';
        foreach ($bancos as $banco) {
            $cod_bank = $banco['bankCode'];
            $nam_bank = utf8_encode($banco['bankName']);
            $opciones .= "<option value='$cod_bank'>$nam_bank</option>;";
        }

        $select_banco = "
        <div class='input-group'>
            <span class='input-group-addon'>Banco * </span>
            <select class='form-control' name='s_banco' id='s_banco'>
                $opciones
            </select>
        </div>";

        return $select_banco;
    }

    public function OutPago()
    {
        $this->outClient();
    }

    private function getAuthData()
    {
        $parametros = ['login' => $this->identificador, 'tranKey' => SHA1($this->seed . $this->tranKey, false),'seed' => $this->seed, 'additional' => ['name' => 'pruebaaaa', 'value' => 'asd']];
        return ['auth' => $parametros];
    }

    private function initClient()
    {
        $this->client = new nusoap_client('https://test.placetopay.com/soap/pse/?wsdl', true);
        return $this->client;
    }

}
