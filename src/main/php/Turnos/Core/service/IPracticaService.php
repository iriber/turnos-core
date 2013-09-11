<?php
namespace Turnos\Core\service;

use Turnos\Core\model\Cliente;

use Cose\Crud\service\ICrudService;

/**
 * interfaz para el servicio de Practica
 *  
 * @author bernardo
 *
 */
interface IPracticaService extends ICrudService {

	function getHistoriaClinica( Cliente $cliente );
}