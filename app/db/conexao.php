<?php

    function get_conexao(){

            date_default_timezone_set('America/Sao_Paulo');


            return new PDO('mysql:host=localhost;port=3306;dbname=suabase;', 'seuusuario', 'suasenha',array(
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                          ));
    }



    function sql_debug($sql_string, array $params) {

      if (!empty($params)) {

          $indexed = $params == array_values($params);

          foreach($params as $k=>$v) {

              if (is_object($v)) {

                  if ($v instanceof DateTime) $v = $v->format('Y-m-d H:i:s');

                  else continue;

              }

              elseif (is_string($v)) $v="'$v'";

              elseif ($v === null) $v='NULL';

              elseif (is_array($v)) $v = implode(',', $v);



              if ($indexed) $sql_string = preg_replace('/\?/', $v, $sql_string, 1);

              else $sql_string = str_replace(":$k",$v,$sql_string);

          }

      }

      return $sql_string;

    }



?>