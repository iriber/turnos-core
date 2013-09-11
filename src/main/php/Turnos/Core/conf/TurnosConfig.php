<?php
namespace Turnos\Core\conf;

use Cose\conf\CoseConfig;
use Cose\utils\Logger;
use Cose\persistence\PersistenceConfig;

/**
 * configuración turnos core
 *  
 * @author bernardo
 *
 */
class TurnosConfig {

	/**
	 * singleton instance
	 * @var TurnosConfig
	 */
	private static $instance;
	
	
	const DB_HOST = 'localhost';
	const DB_NAME = "instituto_access";
	const DB_USER = 'root';
	const DB_PASSWORD = 'root01';
		
	const CONNECTION_DRIVER = "pdo_mysql";
	const DEFAULT_PERSISTEN_UNIT = "default";

	const PROXIES_NAMESPACE="Turnos\\Core\\Proxies";
	const PROXIES_PATH=  "/Proxies";

	private $doctrineHome;
	
	private function __construct(){

	}
	
	public static function getInstance(){
		if (  !self::$instance instanceof self ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	/**
	 * inicializamos turnos core.
	 */
	public function initialize(  ){
		
		//$this->setDoctrineHome($doctrineHome);
		
		//inicializamos el fmk Cose
		$coseConfig = CoseConfig::getInstance();
		$coseConfig->initialize();
		
		
		setlocale(LC_ALL, "es_AR.UTF-8");
		
		
		//inicializamos la persistencia.
		$this->initPersistence();
		
		//$this->initializeModules();
		
		//inicializamos los mensajes.
		//$this->initializeMessages();
	}

	/**
	 * inicializamos la configuración de la persistencia.
	 */
	public function initPersistence(){
	
		$connectionOptions = array(
						    'driver'   => self::CONNECTION_DRIVER,
						    'host'     =>  self::DB_HOST,
						    'dbname'   => self::DB_NAME,
						    'user'     => self::DB_USER,
						    'password' => self::DB_PASSWORD,
							'charset' => 'utf8',
		                	'driverOptions' => array(
		                    	    1002=>'SET NAMES utf8'
		                	)
						);
						
		$pathEntities = dirname(__DIR__) ;
		
		$proxiesPath = dirname(__DIR__) . self::PROXIES_PATH;
		
		PersistenceConfig::configure( self::DEFAULT_PERSISTEN_UNIT, self::PROXIES_NAMESPACE, $proxiesPath, $pathEntities, $connectionOptions);
		
		PersistenceConfig::setDefaultUnit(self::DEFAULT_PERSISTEN_UNIT);
	}
	
	/**
	 * se inicializa el logger
	 * @param string $xml path al archivo de configuración xml
	 */
	public function initLogger($xml){
	
		Logger::configure( $xml );
		
		Logger::log("Logger turnos core configurado!");
		
	}
	
	public static function initializeModules(){
	
		//setlocale(LC_ALL, 'Portuguese_Portugal.1252');
		
		/*
		//definimos la constante CDT_HOME apuntando al directorio que 
		//contendrá los módulos de COSE.
		define( "CDT_HOME", "/home/bernardo/workspace_php/codnet_fmk/" );
		
		//definimos el home de nuestra app y el nombre con el cual accederemos
		//desde la web.	
		define( "APP_NAME", "turnos_core" );
		
		define( "APP_HOME", "/home/bernardo/workspace_php/turnos_core/src/main/php/Turnos/Core/" );
		
		//definimos la ubicación del archivo de configuración para log4php
		define( "CDT_LOG4PHP_CONFIG_FILE", APP_HOME . "/conf/log4php.xml", true) ;
		

		
		//require APP_HOME . 'vendor/autoload.php';
		
		//se inicializan los módulos básicos .
		CoseSetup::initialize(APP_HOME, CDT_HOME);

		//especificamos los paths donde se encuentran los modelos para el mapeo.
		CoseSetup::initializeEntitiesClasspath( 
			array( //CDT_HOME . "Cose/model",
					//CDT_HOME . "Cose\Security/model",
				   APP_HOME. "/model"	) );
		*/
	}
	
	
	public static function initializeMessages(){
	
		/**
		 * se definen los mensajes del sistema en espa�ol.
		 *
		 * @author modelBuilder
		 *
		 */
		
			
		/* categoria profesional */
		define('TRN_MSG_CATEGORIA_PROFESIONAL_BASICO', 'Básico' , true);
		define('TRN_MSG_CATEGORIA_PROFESIONAL_DIFERENCIADO', 'Diferenciado' , true);
		
		/* condiciones iva */
		define('TRN_MSG_CONDICION_IVA_RM', 'Responsable Monotributo' , true);
		define('TRN_MSG_CONDICION_IVA_RI', 'Responsable Inscripto' , true);
		define('TRN_MSG_CONDICION_IVA_RNI', 'Responsable No Inscripto' , true);
		define('TRN_MSG_CONDICION_IVA_E', 'Excento' , true);
		define('TRN_MSG_CONDICION_IVA_CF', 'Consumidor Final' , true);
		
		/* tipos de documento */
		define('TRN_MSG_TIPO_DOCUMENTO_DNI', 'DNI' , true);
		define('TRN_MSG_TIPO_DOCUMENTO_LE', 'LE' , true);
		define('TRN_MSG_TIPO_DOCUMENTO_LC', 'LC' , true);
		define('TRN_MSG_TIPO_DOCUMENTO_PASAPORTE', 'Pasaporte' , true);
		define('TRN_MSG_TIPO_DOCUMENTO_CEDULA_IDENTIDAD', 'Cédula Identidad' , true);
		
		/* estado de turnos*/
		define('TRN_MSG_ESTADO_TURNO_EN_SALA', 'En sala' , true);
		define('TRN_MSG_ESTADO_TURNO_ASIGNADO', 'Asignado' , true);
		define('TRN_MSG_ESTADO_TURNO_ATENDIDO', 'Atendido' , true);
		define('TRN_MSG_ESTADO_TURNO_CANCELADO', 'Cancelado' , true);
		define('TRN_MSG_ESTADO_TURNO_EN_CURSO', 'En curso' , true);
		
		define('TRN_MSG_ESTADO_TURNO_EN_SALA_ABREVIADO', 'S' , true);
		define('TRN_MSG_ESTADO_TURNO_ASIGNADO_ABREVIADO', 'A' , true);
		define('TRN_MSG_ESTADO_TURNO_ATENDIDO_ABREVIADO', 'At' , true);
		define('TRN_MSG_ESTADO_TURNO_CANCELADO_ABREVIADO', 'C' , true);
		define('TRN_MSG_ESTADO_TURNO_EN_CURSO_ABREVIADO', 'EC' , true);
		
		/* días de la semana*/
		define('TRN_MSG_DIA_SEMANA_DOMINGO', 'Domingo' , true);
		define('TRN_MSG_DIA_SEMANA_LUNES', 'Lunes' , true);
		define('TRN_MSG_DIA_SEMANA_MARTES', 'Martes' , true);
		define('TRN_MSG_DIA_SEMANA_MIERCOLES', 'Miércoles' , true);
		define('TRN_MSG_DIA_SEMANA_JUEVES', 'Jueves' , true);
		define('TRN_MSG_DIA_SEMANA_VIERNES', 'Viernes' , true);
		define('TRN_MSG_DIA_SEMANA_SABADO', 'Sábado' , true);
		
		/* sexos */
		define('TRN_MSG_SEXO_MASCULINO', 'Masculino' , true);
		define('TRN_MSG_SEXO_FEMENINO', 'Femenino' , true);
			
	}
		

	public static function setInstance($instance)
	{
	    self::$instance = $instance;
	}



	public function getDoctrineHome()
	{
	    return $this->doctrineHome;
	}

	public function setDoctrineHome($doctrineHome)
	{
	    $this->doctrineHome = $doctrineHome;
	}
}