<?php 
interface OutputInterface {
    public function load($array);
}

class JsonOutput implements OutputInterface {
    public function load($array) {
        return json_encode($array);
    }
}

class ArrayOutput implements OutputInterface {
    public function load($array) {
        return $array;
    }
}

class Produtos {
    private $array;
    private $output;

    public function getLista() {
        //Requisição SQL...

        $this->array = array (
            array('nome'=>'Deny', 'id'=>'1'),
            array('nome'=>'Deise', 'id'=>'2')
        );
    }

    public function setOutput(OutputInterface $outputType) {
        $this->output = $outputType;
    }

    public function getOutput() {
        return $this->output->load($this->array);
    }
}