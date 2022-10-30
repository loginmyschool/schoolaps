<?php
define("APPLICATION_SERVER_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
define("PATH_BACKUP", APPLICATION_SERVER_ROOT."backup_db_wtos/");


if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')|| $_SERVER['SERVER_PORT'] == 443){
    $server_virtual_path = "https://".$_SERVER["SERVER_NAME"]."/";
} else {
    $server_virtual_path = "http://".$_SERVER["SERVER_NAME"]."/";
}

define("PATH_BACKUP_VIRTUAL", $server_virtual_path."backup_db_wtos/");
define("MAX_MANUAL_BACKUP_LIMIT", 20);
define("MAX_AUTO_BACKUP_LIMIT", 30);




class dbbackupHelper{

    var $config = array(
        "host" => "localhost",
        "user" => "root",
        "port" => "3306",
        "pass" => "123",
        "path" => "",
        "limit" => ""
    );
    var $conn = null;
    public function __construct($config=null)
    {
        if(!isset($config['path'])){
            $config['path']=$this->config['path'];
        }
        if($config){
            $this->config = $config;
            $host = $config["host"];
            $port = $config["port"];
            $user = $config["user"];
            $pass = $config["pass"];
            $db = $config["db"];


            try {
                $this->conn = new PDO("mysql:host=$host:$port;", $user, $pass);
                // set the PDO error mode to exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
                echo "Connection failed: " . $e->getMessage();
            }

        }
    }

    public function backup($type='manual'){
        $host = $this->config['host'];
        $port = $this->config['port'];
        $user = $this->config['user'];
        $pass = $this->config['pass'];
        $db = $this->config['db'];
        $datetime = new DateTime();

        $path = PATH_BACKUP."".$this->config["db"];
        $file = $db.'-'.$type.'-'.$datetime->getTimestamp();;
        $file_path = $path.'/'.$file.".sql.gz";
        //create folder not exists
        if (!file_exists($path)) {
            try{
                mkdir($path, 0777, true);
            } catch (Exception $ex){
                throw $ex;
            }

        }
        /******
         * save dump
         */
        $cmd = "mysqldump -P $port -h $host -u $user -p$pass $db | gzip -c > $file_path";
        exec($cmd, $output);
        $return_file = false;
        if(file_exists($file_path)){
            $return_file = true;
        }
        return $return_file;
    }
    public function restore($file){
        $host = $this->config['host'];
        $user = $this->config['user'];
        $pass = $this->config['pass'];
        $db = $this->config['db'];

        $path = PATH_BACKUP.$db.'/';
        $dir = $path.$file;
        $cmd = "gzip -dc $dir | mysql -u $user -p$pass $db";
        exec($cmd, $out, $res);
        _d($cmd);
        return true;
    }
    public function listing($req_type=""){
        $path = PATH_BACKUP.$this->config["db"];
        $files = preg_grep('/^([^.])/',scandir($path));
        $data = [];
        foreach ($files as $file){
            list($name, $ext) = explode('.', $file);
            list($db, $type, $time) = explode('-', $name);
            $timestamp = filectime(PATH_BACKUP.$this->config['db'].'/'.$file);

            if($type==$req_type) {
                $data[$time]['file'] = $file;
                $data[$time]['date'] = date('d-m-Y', $timestamp);
                $data[$time]['time'] = date('h:i:s A', $timestamp);
                $data[$time]['type'] = $type;
                $data[$time]['href'] = PATH_BACKUP_VIRTUAL . $this->config['db'] . '/' . $file;
            } else {
                continue;
            }

        }
        ksort($data,1);
        $data = array_reverse($data);
        $c=0;
        foreach ($data as $ex){
            $c++;

            $is_continue = false;
            switch ($req_type){
                case "manual":
                    if($c>=MAX_MANUAL_BACKUP_LIMIT){
                        $filepath = $path ."/".$ex['file'];
                        if(file_exists($filepath)){
                            unlink($filepath);
                        }
                        $is_continue = true;
                    }
                    break;
                case "auto":
                    if($c>=MAX_AUTO_BACKUP_LIMIT){
                        $filepath = $path ."/".$ex['file'];
                        if(file_exists($filepath)){
                            unlink($filepath);
                        }
                        $is_continue = true;
                    }
                    break;
            }

            if ($is_continue){
                continue;
            }

        }
        return $data;

    }

}
?>
