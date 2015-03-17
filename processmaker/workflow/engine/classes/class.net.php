<?php

/**
 * LastModification 30/05/2008
 */

/**
 *
 * @package workflow.engine.classes
 */

class NET
{
    public $hostname;
    public $ip;

    private $db_user;
    private $db_passwd;
    private $db_sourcename;
    private $db_port;
    private $db_instance;

    /*errors handle*/
    public $error;
    public $errno;
    public $errstr;

    public function __construct()
    {
        $a = func_get_args();
        $f = "__construct" . func_num_args();

        if (method_exists($this, $f)) {
            call_user_func_array(array($this, $f), $a);
        }
    }

    /**
     * This function is the constructor of the class net
     *
     * return void
     */
    public function __construct0()
    {
        $this->errno = 0;
        $this->error = "";
    }

    /**
     * This function is the constructor of the class net
     *
     * @param string $pHost
     * @return void
     */
    public function __construct1($pHost)
    {
        $this->errno = 0;
        $this->errstr = "";
        $this->db_instance = "";

        unset( $this->db_user );
        unset( $this->db_passwd );
        unset( $this->db_sourcename );

        #verifing valid param
        if ($pHost == "") {
            $this->errno = 1000;
            $this->errstr = "NET::You must specify a host";
            //$this->showMsg();
        }
        $this->resolv( $pHost );
    }

    /**
     * This function puts a host
     *
     * @param string $pHost
     * @return void
     */
    public function resolv ($pHost)
    {
        $aHost = explode( "\\", $pHost );
        if (count( $aHost ) > 1) {
            $ipHost = $aHost[0];
            $this->db_instance = $aHost[1];
        } else {
            $ipHost = $pHost;
        }
        if ($this->is_ipaddress( $ipHost )) {
            $this->ip = $ipHost;
            if (! $this->hostname = @gethostbyaddr( $ipHost )) {
                $this->errno = 2000;
                $this->errstr = "NET::Host down";
                $this->error = "Destination Host Unreachable";
            }
        } else {
            $ip = @gethostbyname( $ipHost );
            $long = ip2long( $ip );
            if ($long == - 1 || $long === false) {
                $this->errno = 2000;
                $this->errstr = "NET::Host down";
                $this->error = "Destination Host Unreachable";
            } else {
                $this->ip = @gethostbyname( $ipHost );
                $this->hostname = $pHost;
            }
        }
    }

    /**
     * This function resolves IP from Hostname returns hostname on failure
     *
     * @param string $pPort
     * @return true
     */
    public function scannPort ($pPort)
    {
        define( 'TIMEOUT', 5 );
        $hostip = @gethostbyname( $host ); // resloves IP from Hostname returns hostname on failure
        // attempt to connect
        if (@fsockopen( $this->ip, $pPort, $this->errno, $this->errstr, TIMEOUT )) {
            return true;
            @fclose( $x ); //close connection (i dont know if this is needed or not).
        } else {
            $this->errno = 9999;
            $this->errstr = "NET::Port Host Unreachable";
            $this->error = "Destination Port Unreachable";
            return false;
        }
    }

    /**
     * This function checks if it is a ip address
     *
     * @param string $pHost
     * @return true
     */
    public function is_ipaddress ($pHost)
    {
        $key = true;
        #verifing if is a ip address
        $tmp = explode( ".", $pHost );
        #if have a ip address format
        if (count( $tmp ) == 4) {
            #if a correct ip address
            for ($i = 0; $i < count( $tmp ); $i ++) {
                if (! is_int( $tmp[$i] )) {
                    $key = false;
                    break;
                }
            }
        } else {
            $key = false;
        }
        return $key;
    }

    /**
     * This function executes pin -w time IP
     *
     * @param string $pHost
     * @return true
     */
    public function ping ($pTTL = 3000)
    {
        $cmd = "ping -w $pTTL $this->ip";
        $output = exec( $cmd, $a, $a1 );
        $this->errstr = "";
        for ($i = 0; $i < count( $a ); $i ++) {
            $this->errstr += $a[$i];
        }
        $this->errno = $a1;
    }

    /**
     * This function logins in db
     *
     * @param string $pUser
     * @param string $pPasswd
     * @return void
     */
    public function loginDbServer ($pUser, $pPasswd)
    {
        $this->db_user = $pUser;
        $this->db_passwd = $pPasswd;
    }

    /**
     * This function sets db
     *
     * @param string $pDb
     * @param string $pPort
     * @return void
     */
    public function setDataBase ($pDb, $pPort = '')
    {
        $this->db_sourcename = $pDb;
        $this->db_port = $pPort;
    }

    /**
     * This function tries to connect to server
     *
     * @param string $pDbDriver
     * @param array  $arrayServerData
     *
     * @return void
     */
    public function tryConnectServer($pDbDriver, array $arrayServerData = array())
    {
        if ($this->errno != 0) {
            return 0;
        }
        $stat = new Stat();

        $flagTns = (isset($arrayServerData["connectionType"]) && $arrayServerData["connectionType"] == "TNS")? 1 : 0;

        if (isset($this->db_user) && (isset($this->db_passwd) || $this->db_passwd == "") && (isset($this->db_sourcename) || $flagTns == 1)) {
            switch ($pDbDriver) {
                case 'mysql':
                    if ($this->db_passwd == '') {
                        $link = @mysql_connect( $this->ip . (($this->db_port != '') && ($this->db_port != 0) ? ':' . $this->db_port : ''), $this->db_user );
                    } else {
                        $link = @mysql_connect( $this->ip . (($this->db_port != '') && ($this->db_port != 0) ? ':' . $this->db_port : ''), $this->db_user, $this->db_passwd );
                    }
                    if ($link) {
                        if (@mysql_ping( $link )) {
                            $stat->status = 'SUCCESS';
                            $this->errstr = "";
                            $this->errno = 0;
                        } else {
                            $this->error = "Lost MySql Connection";
                            $this->errstr = "NET::MYSQL->Lost Connection";
                            $this->errno = 10010;
                        }
                    } else {
                        $this->error = "MySql connection refused!";
                        $this->errstr = "NET::MYSQL->The connection was refused";
                        $this->errno = 10001;
                    }
                    break;
                case 'pgsql':
                    $this->db_port = ($this->db_port == "") ? "5432" : $this->db_port;
                    $link = @pg_connect( "host='$this->ip' port='$this->db_port' user='$this->db_user' password='$this->db_passwd' dbname='$this->db_sourcename'" );
                    if ($link) {
                        $stat->status = 'SUCCESS';
                        $this->errstr = "";
                        $this->errno = 0;
                    } else {
                        $this->error = "PostgreSql connection refused!";
                        $this->errstr = "NET::POSTGRES->The connection was refused";
                        $this->errno = 20001;
                    }
                    break;
                case 'mssql':
                    if ($this->db_instance != "") {
                        $str_port = "";
                        $link = @mssql_connect( $this->ip . "\\" . $this->db_instance, $this->db_user, $this->db_passwd );
                    } else {
                        $str_port = (($this->db_port == "") || ($this->db_port == 0) || ($this->db_port == 1433)) ? "" : ":" . $this->db_port;
                        $link = @mssql_connect( $this->ip . $str_port, $this->db_user, $this->db_passwd );
                    }

                    if ($link) {
                        $stat->status = 'SUCCESS';
                        $this->errstr = "";
                        $this->errno = 0;
                    } else {
                        $this->error = "MS-SQL Server connection refused";
                        $this->errstr = "NET::MSSQL->The connection was refused";
                        $this->errno = 30001;
                    }
                    break;
                case 'oracle':
                    try {
                        if ($flagTns == 0) {
                            $this->db_port = ($this->db_port == "" || $this->db_port == 0)? "1521" : $this->db_port;

                            $cnn = @oci_connect($this->db_user, $this->db_passwd, "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP) (HOST=$this->ip) (PORT=$this->db_port) )) (CONNECT_DATA=(SERVICE_NAME=$this->db_sourcename)))");
                        } else {
                            $cnn = @oci_connect($this->db_user, $this->db_passwd, $arrayServerData["tns"]);
                        }

                        if ($cnn) {
                            $stat->status = "SUCCESS";
                            $this->errstr = "";
                            $this->errno = 0;
                        } else {
                            $this->error = "Oracle connection refused";
                            $this->errstr = "NET::ORACLE->The connection was refused";
                            $this->errno = 30001;
                        }
                    } catch (Exception $e) {
                        throw new Exception( "[erik] Couldn't connect to Oracle Server! - " . $e->getMessage() );
                    }
                    break;
                case 'informix':
                    break;
                case 'sqlite':
                    break;
            }
        } else {
            throw new Exception( "CLASS::NET::ERROR: No connections param." );
        }

        return $stat;
    }

    /**
     * This function tries to open to the DB
     *
     * @param string $pDbDriver
     * @param array  $arrayServerData
     *
     * @return void
     */
    public function tryOpenDataBase($pDbDriver, array $arrayServerData = array())
    {
        if ($this->errno != 0) {
            return 0;
        }

        set_time_limit( 0 );
        $stat = new Stat();

        $flagTns = (isset($arrayServerData["connectionType"]) && $arrayServerData["connectionType"] == "TNS")? 1 : 0;

        if (isset($this->db_user) && (isset($this->db_passwd) || $this->db_passwd == "") && (isset($this->db_sourcename) || $flagTns == 1)) {
            switch ($pDbDriver) {
                case 'mysql':
                    $link = @mysql_connect( $this->ip . (($this->db_port != '') && ($this->db_port != 0) ? ':' . $this->db_port : ''), $this->db_user, $this->db_passwd );
                    $db = @mysql_select_db( $this->db_sourcename );
                    if ($link) {
                        if ($db) {
                            $result = @mysql_query( "show tables;" );
                            if ($result) {
                                $stat->status = 'SUCCESS';
                                $this->errstr = "";
                                $this->errno = 0;
                                @mysql_free_result( $result );
                            } else {
                                $this->error = "the user $this->db_user doesn't have privileges to run queries!";
                                $this->errstr = "NET::MYSQL->Test query failed";
                                $this->errno = 10100;
                            }
                        } else {
                            $this->error = "The $this->db_sourcename data base does'n exist!";
                            $this->errstr = "NET::MYSQL->Select data base failed";
                            $this->errno = 10011;
                        }
                    } else {
                        $this->error = "MySql connection refused!";
                        $this->errstr = "NET::MYSQL->The connection was refused";
                        $this->errno = 10001;
                    }
                    break;
                case 'pgsql':
                    $this->db_port = (($this->db_port == "") || ($this->db_port == 0)) ? "5432" : $this->db_port;
                    $link = @pg_connect( "host='$this->ip' port='$this->db_port' user='$this->db_user' password='$this->db_passwd' dbname='$this->db_sourcename'" );
                    if ($link) {
                        if (@pg_ping( $link )) {
                            $stat->status = 'SUCCESS';
                            $this->errstr = "";
                            $this->errno = 0;
                        } else {
                            $this->error = "PostgreSql Connection to $this->ip is  unreachable!";
                            $this->errstr = "NET::POSTGRES->Lost Connection";
                            $this->errno = 20010;
                        }
                    } else {
                        $this->error = "PostgrSql connection refused";
                        $this->errstr = "NET::POSTGRES->The connection was refused";
                        $this->errno = 20001;
                    }
                    break;
                case 'mssql':
                    //          $str_port = (($this->db_port == "")  || ($this->db_port == 0) || ($this->db_port == 1433)) ? "" : ":".$this->db_port;
                    //          $link = @mssql_connect($this->ip . $str_port, $this->db_user, $this->db_passwd);
                    if ($this->db_instance != "") {
                        $str_port = "";
                        $link = @mssql_connect( $this->ip . "\\" . $this->db_instance, $this->db_user, $this->db_passwd );
                    } else {
                        $str_port = (($this->db_port == "") || ($this->db_port == 0) || ($this->db_port == 1433)) ? "" : ":" . $this->db_port;
                        $link = @mssql_connect( $this->ip . $str_port, $this->db_user, $this->db_passwd );
                    }
                    if ($link) {
                        $db = @mssql_select_db( $this->db_sourcename, $link );
                        if ($db) {
                            $stat->status = 'SUCCESS';
                            $this->errstr = "";
                            $this->errno = 0;
                        } else {
                            $this->error = "The $this->db_sourcename data base does'n exist!";
                            $this->errstr = "NET::MSSQL->Select data base failed";
                            $this->errno = 30010;
                        }
                    } else {
                        $this->error = "MS-SQL Server connection refused!";
                        $this->errstr = "NET::MSSQL->The connection was refused";
                        $this->errno = 30001;
                    }
                    break;
                case 'oracle':
                    if ($flagTns == 0) {
                        $this->db_port = ($this->db_port == "" || $this->db_port == 0)? "1521" : $this->db_port;

                        $cnn = @oci_connect($this->db_user, $this->db_passwd, "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP) (HOST=$this->ip) (PORT=$this->db_port) )) (CONNECT_DATA=(SERVICE_NAME=$this->db_sourcename)))");
                    } else {
                        $cnn = @oci_connect($this->db_user, $this->db_passwd, $arrayServerData["tns"]);
                    }

                    if ($cnn) {
                        $stid = @oci_parse($cnn, 'select AUTHENTICATION_TYPE from v$session_connect_info');
                        $result = @oci_execute( $stid, OCI_DEFAULT );
                        if ($result) {
                            $stat->status = 'SUCCESS';
                            $this->errstr = "";
                            $this->errno = 0;
                            @oci_close($cnn);
                        } else {
                            $this->error = "the user $this->db_user doesn't have privileges to run queries!";
                            $this->errstr = "NET::ORACLE->Couldn't execute any query on this server!";
                            $this->errno = 40010;
                        }
                    } else {
                        $this->error = "Oracle connection refused!";
                        $this->errstr = "NET::ORACLE->The connection was refused";
                        $this->errno = 40001;
                    }
                    break;
                case 'informix':
                    break;
                case 'sqlite':
                    break;
            }
        } else {
            throw new Exception( "CLASS::NET::ERROR: No connections param." );
        }
        return $stat;
    }

    /**
     * This function gets DB-s version
     *
     * @param string $driver
     * @return void
     */
    public function getDbServerVersion ($driver)
    {
        if (! isset( $this->ip )) {
            $this->ip = getenv( 'HTTP_CLIENT_IP' );
        }

        if (isset( $this->ip ) && isset( $this->db_user ) && isset( $this->db_passwd )) {
            try {
                if (! isset( $this->db_sourcename )) {
                    $this->db_sourcename = DB_NAME;
                }
                $value = 'none';
                $sDataBase = 'database_' . strtolower( DB_ADAPTER );
                if (G::LoadSystemExist( $sDataBase )) {
                    G::LoadSystem( $sDataBase );
                    $oDataBase = new database();
                    $value = $oDataBase->getServerVersion( $driver, $this->ip, $this->db_port, $this->db_user, $this->db_passwd, $this->db_sourcename );
                }
                return $value;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        } else {
            throw new Exception( 'NET::Error->No params for Data Base Server!' );
        }
    }

    /**
     * This function reurns DB name
     *
     * @param string $pAdapter
     * @return void
     */
    public function dbName ($pAdapter)
    {
        switch ($pAdapter) {
            case 'mysql':
                return 'MySql';
                break;
            case 'pgsql':
                return 'PostgreSQL';
                break;
            case 'mssql':
                return 'Microsoft SQL Server';
                break;
            case 'oracle':
                return 'Oracle';
                break;
            case 'informix':
                return 'Informix';
                break;
            case 'sqlite':
                return 'SQLite';
                break;
        }
    }

    /**
     * If there is an error then it shows
     *
     * @param string $pAdapter
     * @return void
     */
    public function showMsg ()
    {
        if ($this->errno != 0) {
            $msg = "
    <center>
    <fieldset style='width:90%'><legend>Class NET</legend>
      <div align=left>
      <font color='red'>
        <b>NET::ERROR NO -> $this->errno<br/>
        NET::ERROR MSG -> $this->errstr</b>
      </font>
      </div>
    </fieldset>
    <center>";
            print ($msg) ;
        }
    }

    /**
     * This function gets an error
     * param
     *
     * @return string
     */
    public function getErrno ()
    {
        return $this->errno;
    }

    /**
     * This function gets an error message
     * param
     *
     * @return string
     */
    public function getErrmsg ()
    {
        return $this->errstr;
    }
}

/**
 *
 * @package workflow.engine.classes
 */
class Stat
{
    public $stutus;

    public function __construct ()
    {
        $this->status = false;
    }
}

