<?php

namespace Morphism;


#[AllowDynamicProperties]
abstract class Morphism {

    protected static $registries = array();

    public static function register($type, $schema) {
            
    }

    /**
     * Source : https://stackoverflow.com/questions/5458241/php-dynamic-array-index-name
     * 
     * @static
     * @param array $array
     * @param array $indexes
     */
    protected static function getArrayValue(array $array, array $indexes)
    {
        if (count($array) == 0 || count($indexes) == 0) {
            return false;
        }

        $index = array_shift($indexes);
        if(!array_key_exists($index, $array)){
            return false;
        }

        $value = $array[$index];
        if (count($indexes) == 0) {
            return $value;
        }

        if(!is_array($value)) {
            return false;
        }

        return self::getArrayValue($value, $indexes);
    }

    /** 
     * @static
     * @param array $paths
     * @param array $object
     * @return string
     */
    protected static function agregator($paths, $object){
        return array_reduce($paths, function($delta, $path) use ($object) {
            $searchPath = $path;
            if(!is_array($path)){
                $searchPath = array($path);
            }

            return trim(sprintf("%s %s", $delta, self::getArrayValue($object, $searchPath) ));
        });
    }

    /** 
     * @static
     * @param array $object
     * @param array $schema
     * @param array $data
     * @return object
     */
    protected static function transformValuesFromObject($object, $schema, $data){
        foreach($schema as $key => $target){ // iterate on every action of the schema

            if(is_string($target)){ // Target<String>: string path => [ target: 'source' ]
                $indexes = explode(".", $target);
                $object->{$key} = self::getArrayValue($data, $indexes);

            }
            else if(is_callable($target)){
                $object->{$key} = call_user_func($target, $data); 
            }
            else if (is_array($target)){
                $object->{$key} = self::agregator($target, $data);
            }
            else if(is_object($target) ) {
                $searchPath = $target->path;
                if(is_array($target->path)){
                    $value = self::agregator($target->path, $data);
                }
                else{
                    $indexes =  explode(".", $target->path);
                    $value   =  self::getArrayValue($data, $indexes);
                }

                $object->{$key} = call_user_func($target->fn, $value);
            }
        }

        return $object;
    }

    /** 
     * @static
     * @param string $type
     * @return bool
     */
    public static function exists($type){
        return array_key_exists($type, self::$registries);
    }

    /**
     * @static
     * @param string $type
     * @return array
     */
    public static function getMapper($type){
        return self::$registries[$type];
    }

    /**
     * @static
     * @param string $type
     * @param array $schema
     */
    public static function setMapper($type, $schema){
        if (!$type) {
            throw new \Exception('type paramater is required when register a mapping');
        }
        if (!$schema) {
            throw new \Exception('schema paramater is required when register a mapping');
        }

        self::$registries[$type] = $schema;
    }

    /**
     * @static
     * @param string $type
     */
    public static function deleteMapper($type){
        unset(self::$registries[$type]);
    }

    /**
     * @static
     * @param string $type
     * @param array $data
     */
    public static function map($type, $data){
        if(!Morphism::exists($type)){
            throw new \Exception(sprintf("Mapper for %s not exist", $type));
        }

        $reflectedClass = new \ReflectionClass($type);

        if(!$reflectedClass->isInstantiable()){
            throw new \Exception($type . " is not an instantiable class.");
        }

        if(isset($data[0])){
            return array_map(function($arr) use($reflectedClass, $type){
                $instance = $reflectedClass->newInstance();
                return self::transformValuesFromObject($instance, Morphism::getMapper($type), $arr);
            }, $data);
        }
        else{
            $instance = $reflectedClass->newInstance();
            return self::transformValuesFromObject($instance, Morphism::getMapper($type), $data);
        }
    }
}